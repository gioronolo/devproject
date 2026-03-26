<?php
if (!defined('ABSPATH')) {
    exit;
}

class FIS_Helper {

    public static function sanitize_decimal($value) {
        return number_format((float) $value, 2, '.', '');
    }

    public static function sanitize_int($value) {
        return absint($value);
    }

    public static function get_profit_split($profit) {
        $profit = (float) $profit;

        if ($profit <= 0) {
            return [
                'owner_share' => 0,
                'caretaker_share' => 0,
            ];
        }

        $owner_share = ($profit / 3) * 2;
        $caretaker_share = ($profit / 3);

        return [
            'owner_share' => round($owner_share, 2),
            'caretaker_share' => round($caretaker_share, 2),
        ];
    }

    public static function compute_summary($records) {
        $summary = [
            'feeds_cost'       => 0,
            'vitamins_cost'    => 0,
            'other_cost'       => 0,
            'sales_amount'     => 0,
            'trays_count'      => 0,
            'sold_trays'       => 0,
            'mortality_count'  => 0,
            'egg_xs'           => 0,
            'egg_s'            => 0,
            'egg_m'            => 0,
            'egg_l'            => 0,
            'egg_jumbo'        => 0,
            'weight_xs'        => 0,
            'weight_s'         => 0,
            'weight_m'         => 0,
            'weight_l'         => 0,
            'weight_jumbo'     => 0,
        ];

        foreach ($records as $record) {
            $summary['feeds_cost']      += (float) $record['feeds_cost'];
            $summary['vitamins_cost']   += (float) $record['vitamins_cost'];
            $summary['other_cost']      += (float) $record['other_cost'];
            $summary['sales_amount']    += (float) $record['sales_amount'];
            $summary['trays_count']     += (int) $record['trays_count'];
            $summary['sold_trays']      += (int) $record['sold_trays'];
            $summary['mortality_count'] += (int) $record['mortality_count'];

            $summary['egg_xs']      += (int) $record['egg_xs'];
            $summary['egg_s']       += (int) $record['egg_s'];
            $summary['egg_m']       += (int) $record['egg_m'];
            $summary['egg_l']       += (int) $record['egg_l'];
            $summary['egg_jumbo']   += (int) $record['egg_jumbo'];

            $summary['weight_xs']     += (float) $record['weight_xs'];
            $summary['weight_s']      += (float) $record['weight_s'];
            $summary['weight_m']      += (float) $record['weight_m'];
            $summary['weight_l']      += (float) $record['weight_l'];
            $summary['weight_jumbo']  += (float) $record['weight_jumbo'];
        }

        $total_expenses = $summary['feeds_cost'] + $summary['vitamins_cost'] + $summary['other_cost'];
        $gross_profit   = $summary['sales_amount'] - $total_expenses;

        $shares = self::get_profit_split($gross_profit);

        $summary['total_expenses']   = round($total_expenses, 2);
        $summary['gross_profit']     = round($gross_profit, 2);
        $summary['owner_share']      = $shares['owner_share'];
        $summary['caretaker_share']  = $shares['caretaker_share'];

        return $summary;
    }

    public static function get_week_range($date = '') {
        $timestamp = $date ? strtotime($date) : current_time('timestamp');
        $day_of_week = (int) date('N', $timestamp);

        $start = strtotime('-' . ($day_of_week - 1) . ' days', $timestamp);
        $end   = strtotime('+6 days', $start);

        return [
            'start' => date('Y-m-d', $start),
            'end'   => date('Y-m-d', $end),
        ];
    }

    public static function get_month_range($date = '') {
        $timestamp = $date ? strtotime($date) : current_time('timestamp');

        return [
            'start' => date('Y-m-01', $timestamp),
            'end'   => date('Y-m-t', $timestamp),
        ];
    }
}