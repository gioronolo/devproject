<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class GHL_API {

    private $api_key;
    private $location_id;
    private $base_url = 'https://services.leadconnectorhq.com';

    public function __construct( $api_key, $location_id = '' ) {
        $this->api_key     = $api_key;
        $this->location_id = ! empty( $location_id ) ? $location_id
                           : ( substr( $api_key, 0, 3 ) === 'eyJ' ? $this->extract_location_id_from_jwt( $api_key ) : '' );
    }

    private function extract_location_id_from_jwt( $token ) {
        $parts = explode( '.', $token );
        if ( count( $parts ) !== 3 ) return '';
        $payload = str_replace( array( '-', '_' ), array( '+', '/' ), $parts[1] );
        $payload .= str_repeat( '=', ( 4 - strlen( $payload ) % 4 ) % 4 );
        $decoded  = base64_decode( $payload, true );
        if ( ! $decoded ) return '';
        $data = json_decode( $decoded, true );
        return isset( $data['location_id'] ) ? $data['location_id'] : '';
    }

    private function get_headers() {
        return array(
            'Authorization' => 'Bearer ' . $this->api_key,
            'Content-Type'  => 'application/json',
            'Version'       => '2021-07-28',
        );
    }

    private function do_get( $endpoint, $params = array() ) {
        $url = trailingslashit( $this->base_url ) . ltrim( $endpoint, '/' );
        if ( ! empty( $params ) ) $url = add_query_arg( $params, $url );
        $response = wp_remote_get( $url, array( 'headers' => $this->get_headers(), 'timeout' => 30 ) );
        return $this->handle_response( $response );
    }

    private function handle_response( $response ) {
        if ( is_wp_error( $response ) ) return $response;
        $code = wp_remote_retrieve_response_code( $response );
        $body = json_decode( wp_remote_retrieve_body( $response ), true );
        if ( $code < 200 || $code >= 300 ) {
            $msg = isset( $body['message'] ) ? $body['message']
                 : ( isset( $body['msg'] ) ? $body['msg'] : 'GHL API error (HTTP ' . $code . ')' );
            return new WP_Error( 'ghl_api_error', $msg, array( 'status' => $code ) );
        }
        return is_array( $body ) ? $body : array();
    }

    private function check_location_id() {
        if ( empty( $this->location_id ) )
            return new WP_Error( 'ghl_no_location', 'Location ID is missing. Please enter your Location ID in settings.' );
        return true;
    }

    public function validate_credentials() {
        $check = $this->check_location_id();
        if ( is_wp_error( $check ) ) return $check;
        $result = $this->do_get( '/locations/' . $this->location_id );
        if ( is_wp_error( $result ) ) return $result;
        $loc = isset( $result['location'] ) ? $result['location'] : $result;
        return isset( $loc['name'] ) ? $loc['name'] : 'Location';
    }

    public function get_contacts( $limit = 20, $skip = 0 ) {
        $check = $this->check_location_id();
        if ( is_wp_error( $check ) ) return $check;
        return $this->do_get( '/contacts/', array(
            'locationId' => $this->location_id,
            'limit'      => $limit,
            'skip'       => $skip,
        ) );
    }

    public function get_forms() {
        $check = $this->check_location_id();
        if ( is_wp_error( $check ) ) return $check;
        $result = $this->do_get( '/forms/', array( 'locationId' => $this->location_id ) );
        if ( is_wp_error( $result ) ) return $result;
        return isset( $result['forms'] ) ? $result['forms'] : array();
    }

    public function get_location_id() { return $this->location_id; }
}
