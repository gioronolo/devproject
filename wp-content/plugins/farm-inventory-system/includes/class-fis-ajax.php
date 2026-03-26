<?php
if (!defined('ABSPATH')) {
    exit;
}

class FIS_Ajax {

    public static function init() {
        add_action('wp_ajax_fis_save_record', [__CLASS__, 'save_record']);
        add_action('wp_ajax_fis_get_records', [__CLASS__, 'get_records']);
        add_action('wp_ajax_fis_get_summary', [__CLASS__, 'get_summary']);
        add_action('wp_ajax_fis_add_type', [__CLASS__, 'add_type']);
    }

    private static function verify_request() {
        check_ajax_referer('fis_admin_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Unauthorized request.'], 403);
        }
    }

    public static function save_record() {
        self::verify_request();

        global $wpdb;

        $table = $wpdb->prefix . 'fis_inventory_records';

        $inventory_type_id = absint($_POST['inventory_type_id'] ?? 0);
        $record_date       = sanitize_text_field($_POST['record_date'] ?? '');
        $feeds_cost        = FIS_Helper::sanitize_decimal($_POST['feeds_cost'] ?? 0);
        $vitamins_cost     = FIS_Helper::sanitize_decimal($_POST['vitamins_cost'] ?? 0);
        $other_cost        = FIS_Helper::sanitize_decimal($_POST['other_cost'] ?? 0);
        $trays_count       = FIS_Helper::sanitize_int($_POST['trays_count'] ?? 0);
        $egg_xs            = FIS_Helper::sanitize_int($_POST['egg_xs'] ?? 0);
        $egg_s             = FIS_Helper::sanitize_int($_POST['egg_s'] ?? 0);
        $egg_m             = FIS_Helper::sanitize_int($_POST['egg_m'] ?? 0);
        $egg_l             = FIS_Helper::sanitize_int($_POST['egg_l'] ?? 0);
        $egg_jumbo         = FIS_Helper::sanitize_int($_POST['egg_jumbo'] ?? 0);
        $weight_xs         = FIS_Helper::sanitize_decimal($_POST['weight_xs'] ?? 0);
        $weight_s          = FIS_Helper::sanitize_decimal($_POST['weight_s'] ?? 0);
        $weight_m          = FIS_Helper::sanitize_decimal($_POST['weight_m'] ?? 0);
        $weight_l          = FIS_Helper::sanitize_decimal($_POST['weight_l'] ?? 0);
        $weight_jumbo      = FIS_Helper::sanitize_decimal($_POST['weight_jumbo'] ?? 0);
        $sold_trays        = FIS_Helper::sanitize_int($_POST['sold_trays'] ?? 0);
        $sales_amount      = FIS_Helper::sanitize_decimal($_POST['sales_amount'] ?? 0);
        $mortality_count   = FIS_Helper::sanitize_int($_POST['mortality_count'] ?? 0);
        $notes             = sanitize_textarea_field($_POST['notes'] ?? '');

        if (!$inventory_type_id || empty($record_date)) {
            wp_send_json_error(['message' => 'Inventory type and record date are required.'], 400);
        }

        $existing_id = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT id FROM {$table} WHERE inventory_type_id = %d AND record_date = %s LIMIT 1",
                $inventory_type_id,
                $record_date
            )
        );

        $data = [
            'inventory_type_id' => $inventory_type_id,
            'record_date'       => $record_date,
            'feeds_cost'        => $feeds_cost,
            'vitamins_cost'     => $vitamins_cost,
            'other_cost'        => $other_cost,
            'trays_count'       => $trays_count,
            'egg_xs'            => $egg_xs,
            'egg_s'             => $egg_s,
            'egg_m'             => $egg_m,
            'egg_l'             => $egg_l,
            'egg_jumbo'         => $egg_jumbo,
            'weight_xs'         => $weight_xs,
            'weight_s'          => $weight_s,
            'weight_m'          => $weight_m,
            'weight_l'          => $weight_l,
            'weight_jumbo'      => $weight_jumbo,
            'sold_trays'        => $sold_trays,
            'sales_amount'      => $sales_amount,
            'mortality_count'   => $mortality_count,
            'notes'             => $notes,
        ];

        $format = [
            '%d', '%s', '%f', '%f', '%f', '%d',
            '%d', '%d', '%d', '%d', '%d',
            '%f', '%f', '%f', '%f', '%f',
            '%d', '%f', '%d', '%s'
        ];

        if ($existing_id) {
            $updated = $wpdb->update(
                $table,
                $data,
                ['id' => $existing_id],
                $format,
                ['%d']
            );

            if ($updated === false) {
                wp_send_json_error(['message' => 'Failed to update record.'], 500);
            }

            wp_send_json_success(['message' => 'Record updated successfully.']);
        }

        $inserted = $wpdb->insert($table, $data, $format);

        if (!$inserted) {
            wp_send_json_error(['message' => 'Failed to save record.'], 500);
        }

        wp_send_json_success(['message' => 'Record saved successfully.']);
    }

    public static function get_records() {
        self::verify_request();

        global $wpdb;

        $table = $wpdb->prefix . 'fis_inventory_records';

        $inventory_type_id = absint($_POST['inventory_type_id'] ?? 0);
        $range             = sanitize_text_field($_POST['range'] ?? 'week');
        $date              = sanitize_text_field($_POST['date'] ?? current_time('Y-m-d'));

        if (!$inventory_type_id) {
            wp_send_json_error(['message' => 'Invalid inventory type.'], 400);
        }

        $dates = ($range === 'month')
            ? FIS_Helper::get_month_range($date)
            : FIS_Helper::get_week_range($date);

        $records = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$table}
                 WHERE inventory_type_id = %d
                 AND record_date BETWEEN %s AND %s
                 ORDER BY record_date DESC",
                $inventory_type_id,
                $dates['start'],
                $dates['end']
            ),
            ARRAY_A
        );

        wp_send_json_success([
            'records' => $records,
            'range'   => $dates,
        ]);
    }

    public static function get_summary() {
        self::verify_request();

        global $wpdb;

        $table = $wpdb->prefix . 'fis_inventory_records';

        $inventory_type_id = absint($_POST['inventory_type_id'] ?? 0);
        $range             = sanitize_text_field($_POST['range'] ?? 'week');
        $date              = sanitize_text_field($_POST['date'] ?? current_time('Y-m-d'));

        if (!$inventory_type_id) {
            wp_send_json_error(['message' => 'Invalid inventory type.'], 400);
        }

        $dates = ($range === 'month')
            ? FIS_Helper::get_month_range($date)
            : FIS_Helper::get_week_range($date);

        $records = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$table}
                 WHERE inventory_type_id = %d
                 AND record_date BETWEEN %s AND %s
                 ORDER BY record_date ASC",
                $inventory_type_id,
                $dates['start'],
                $dates['end']
            ),
            ARRAY_A
        );

        $summary = FIS_Helper::compute_summary($records);

        wp_send_json_success([
            'summary' => $summary,
            'range'   => $dates,
        ]);
    }

    public static function add_type() {
        self::verify_request();

        global $wpdb;

        $table = $wpdb->prefix . 'fis_inventory_types';

        $name = sanitize_text_field($_POST['name'] ?? '');

        if (empty($name)) {
            wp_send_json_error(['message' => 'Type name is required.'], 400);
        }

        $slug = sanitize_title($name);

        $exists = $wpdb->get_var(
            $wpdb->prepare("SELECT id FROM {$table} WHERE slug = %s LIMIT 1", $slug)
        );

        if ($exists) {
            wp_send_json_error(['message' => 'Inventory type already exists.'], 400);
        }

        $inserted = $wpdb->insert(
            $table,
            [
                'name'   => $name,
                'slug'   => $slug,
                'status' => 1,
            ],
            ['%s', '%s', '%d']
        );

        if (!$inserted) {
            wp_send_json_error(['message' => 'Failed to add inventory type.'], 500);
        }

        wp_send_json_success([
            'message' => 'Inventory type added successfully.',
            'type'    => [
                'id'   => $wpdb->insert_id,
                'name' => $name,
                'slug' => $slug,
            ]
        ]);
    }
}