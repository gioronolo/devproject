<?php
if (!defined('ABSPATH')) {
    exit;
}

class FIS_DB {

    public static function activate() {
        self::create_tables();
        self::seed_inventory_types();
    }

    public static function create_tables() {
        global $wpdb;

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $charset_collate = $wpdb->get_charset_collate();

        $types_table   = $wpdb->prefix . 'fis_inventory_types';
        $records_table = $wpdb->prefix . 'fis_inventory_records';

        $sql_types = "CREATE TABLE {$types_table} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            slug VARCHAR(100) NOT NULL,
            status TINYINT(1) NOT NULL DEFAULT 1,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY slug (slug)
        ) {$charset_collate};";

        $sql_records = "CREATE TABLE {$records_table} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            inventory_type_id BIGINT UNSIGNED NOT NULL,
            record_date DATE NOT NULL,

            feeds_cost DECIMAL(12,2) NOT NULL DEFAULT 0.00,
            vitamins_cost DECIMAL(12,2) NOT NULL DEFAULT 0.00,
            other_cost DECIMAL(12,2) NOT NULL DEFAULT 0.00,

            trays_count INT NOT NULL DEFAULT 0,
            egg_xs INT NOT NULL DEFAULT 0,
            egg_s INT NOT NULL DEFAULT 0,
            egg_m INT NOT NULL DEFAULT 0,
            egg_l INT NOT NULL DEFAULT 0,
            egg_jumbo INT NOT NULL DEFAULT 0,

            weight_xs DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            weight_s DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            weight_m DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            weight_l DECIMAL(10,2) NOT NULL DEFAULT 0.00,
            weight_jumbo DECIMAL(10,2) NOT NULL DEFAULT 0.00,

            sold_trays INT NOT NULL DEFAULT 0,
            sales_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
            mortality_count INT NOT NULL DEFAULT 0,

            notes TEXT NULL,

            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

            PRIMARY KEY (id),
            KEY inventory_type_id (inventory_type_id),
            KEY record_date (record_date)
        ) {$charset_collate};";

        dbDelta($sql_types);
        dbDelta($sql_records);
    }

    public static function seed_inventory_types() {
        global $wpdb;

        $table = $wpdb->prefix . 'fis_inventory_types';

        $defaults = [
            ['name' => 'Chicken', 'slug' => 'chicken'],
            ['name' => 'Hog', 'slug' => 'hog'],
            ['name' => 'Others', 'slug' => 'others'],
        ];

        foreach ($defaults as $type) {
            $exists = $wpdb->get_var(
                $wpdb->prepare("SELECT id FROM {$table} WHERE slug = %s LIMIT 1", $type['slug'])
            );

            if (!$exists) {
                $wpdb->insert(
                    $table,
                    [
                        'name' => $type['name'],
                        'slug' => $type['slug'],
                        'status' => 1,
                    ],
                    ['%s', '%s', '%d']
                );
            }
        }
    }

    public static function get_types() {
        global $wpdb;

        $table = $wpdb->prefix . 'fis_inventory_types';

        return $wpdb->get_results(
            "SELECT id, name, slug FROM {$table} WHERE status = 1 ORDER BY name ASC",
            ARRAY_A
        );
    }
}