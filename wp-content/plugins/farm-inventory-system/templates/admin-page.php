<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap fis-wrap">
    <h1>Farm Inventory System</h1>

    <div class="fis-grid">
        <div class="fis-card">
            <h2>Inventory Type</h2>

            <div class="fis-row">
                <div class="fis-field">
                    <label for="fis_inventory_type">Choose Inventory</label>
                    <select id="fis_inventory_type"></select>
                </div>

                <div class="fis-field fis-field-inline">
                    <label for="fis_new_type">Add New Type</label>
                    <div class="fis-inline">
                        <input type="text" id="fis_new_type" placeholder="e.g. Duck, Goat">
                        <button type="button" class="button button-secondary" id="fis_add_type_btn">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="fis-card">
            <h2>Daily Entry</h2>

            <div class="fis-form-grid">
                <div class="fis-field">
                    <label for="fis_record_date">Date</label>
                    <input type="date" id="fis_record_date">
                </div>

                <div class="fis-field">
                    <label for="fis_feeds_cost">Feeds Cost</label>
                    <input type="number" step="0.01" id="fis_feeds_cost" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_vitamins_cost">Vitamins Cost</label>
                    <input type="number" step="0.01" id="fis_vitamins_cost" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_other_cost">Other Cost</label>
                    <input type="number" step="0.01" id="fis_other_cost" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_trays_count">Trays Produced</label>
                    <input type="number" id="fis_trays_count" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_sold_trays">Trays Sold</label>
                    <input type="number" id="fis_sold_trays" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_sales_amount">Sales Amount</label>
                    <input type="number" step="0.01" id="fis_sales_amount" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_mortality_count">Mortality</label>
                    <input type="number" id="fis_mortality_count" value="0">
                </div>
            </div>

            <h3>Egg Count per Size</h3>
            <div class="fis-form-grid">
                <div class="fis-field">
                    <label for="fis_egg_xs">XS</label>
                    <input type="number" id="fis_egg_xs" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_egg_s">S</label>
                    <input type="number" id="fis_egg_s" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_egg_m">M</label>
                    <input type="number" id="fis_egg_m" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_egg_l">L</label>
                    <input type="number" id="fis_egg_l" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_egg_jumbo">Jumbo</label>
                    <input type="number" id="fis_egg_jumbo" value="0">
                </div>
            </div>

            <h3>Weight per Size</h3>
            <div class="fis-form-grid">
                <div class="fis-field">
                    <label for="fis_weight_xs">XS Weight</label>
                    <input type="number" step="0.01" id="fis_weight_xs" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_weight_s">S Weight</label>
                    <input type="number" step="0.01" id="fis_weight_s" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_weight_m">M Weight</label>
                    <input type="number" step="0.01" id="fis_weight_m" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_weight_l">L Weight</label>
                    <input type="number" step="0.01" id="fis_weight_l" value="0">
                </div>

                <div class="fis-field">
                    <label for="fis_weight_jumbo">Jumbo Weight</label>
                    <input type="number" step="0.01" id="fis_weight_jumbo" value="0">
                </div>
            </div>

            <div class="fis-field">
                <label for="fis_notes">Notes</label>
                <textarea id="fis_notes" rows="4" placeholder="Optional notes..."></textarea>
            </div>

            <div class="fis-actions">
                <button type="button" class="button button-primary" id="fis_save_btn">Save Record</button>
                <button type="button" class="button" id="fis_clear_btn">Clear Form</button>
            </div>

            <div id="fis_message"></div>
        </div>

        <div class="fis-card">
            <h2>Reports</h2>

            <div class="fis-row">
                <div class="fis-field">
                    <label for="fis_report_range">Range</label>
                    <select id="fis_report_range">
                        <option value="week">Weekly</option>
                        <option value="month">Monthly</option>
                    </select>
                </div>

                <div class="fis-field">
                    <label for="fis_report_date">Base Date</label>
                    <input type="date" id="fis_report_date">
                </div>

                <div class="fis-field fis-field-bottom">
                    <button type="button" class="button button-secondary" id="fis_load_report_btn">Load Report</button>
                </div>
            </div>

            <div class="fis-summary" id="fis_summary_cards"></div>

            <h3>Records</h3>
            <div class="fis-table-wrap">
                <table class="widefat striped" id="fis_records_table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Feeds</th>
                            <th>Vitamins</th>
                            <th>Other</th>
                            <th>Produced Trays</th>
                            <th>Sold Trays</th>
                            <th>Sales</th>
                            <th>Mortality</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8">No records loaded yet.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>