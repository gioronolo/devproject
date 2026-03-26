jQuery(function ($) {
    const app = {
        init() {
            this.cacheDom();
            this.populateTypes();
            this.bindEvents();
            this.setDefaults();
            this.loadReport();
        },

        cacheDom() {
            this.$type = $('#fis_inventory_type');
            this.$newType = $('#fis_new_type');
            this.$recordDate = $('#fis_record_date');
            this.$reportDate = $('#fis_report_date');
            this.$reportRange = $('#fis_report_range');
            this.$message = $('#fis_message');
            this.$summaryCards = $('#fis_summary_cards');
            this.$recordsTableBody = $('#fis_records_table tbody');
        },

        bindEvents() {
            $('#fis_add_type_btn').on('click', () => this.addType());
            $('#fis_save_btn').on('click', () => this.saveRecord());
            $('#fis_clear_btn').on('click', () => this.clearForm());
            $('#fis_load_report_btn').on('click', () => this.loadReport());
            this.$type.on('change', () => this.loadReport());
        },

        setDefaults() {
            this.$recordDate.val(fisAdmin.today);
            this.$reportDate.val(fisAdmin.today);
        },

        populateTypes() {
            this.$type.empty();

            if (!fisAdmin.types || !fisAdmin.types.length) {
                this.$type.append('<option value="">No inventory types found</option>');
                return;
            }

            fisAdmin.types.forEach(type => {
                this.$type.append(`<option value="${type.id}">${type.name}</option>`);
            });
        },

        getFormData() {
            return {
                inventory_type_id: this.$type.val(),
                record_date: $('#fis_record_date').val(),
                feeds_cost: $('#fis_feeds_cost').val(),
                vitamins_cost: $('#fis_vitamins_cost').val(),
                other_cost: $('#fis_other_cost').val(),
                trays_count: $('#fis_trays_count').val(),
                sold_trays: $('#fis_sold_trays').val(),
                sales_amount: $('#fis_sales_amount').val(),
                mortality_count: $('#fis_mortality_count').val(),
                egg_xs: $('#fis_egg_xs').val(),
                egg_s: $('#fis_egg_s').val(),
                egg_m: $('#fis_egg_m').val(),
                egg_l: $('#fis_egg_l').val(),
                egg_jumbo: $('#fis_egg_jumbo').val(),
                weight_xs: $('#fis_weight_xs').val(),
                weight_s: $('#fis_weight_s').val(),
                weight_m: $('#fis_weight_m').val(),
                weight_l: $('#fis_weight_l').val(),
                weight_jumbo: $('#fis_weight_jumbo').val(),
                notes: $('#fis_notes').val()
            };
        },

        saveRecord() {
            const data = this.getFormData();

            $.ajax({
                url: fisAdmin.ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'fis_save_record',
                    nonce: fisAdmin.nonce,
                    ...data
                },
                beforeSend: () => {
                    this.showMessage('Saving record...', 'info');
                },
                success: (response) => {
                    if (response.success) {
                        this.showMessage(response.data.message, 'success');
                        this.loadReport();
                    } else {
                        this.showMessage(response.data.message || 'Something went wrong.', 'error');
                    }
                },
                error: () => {
                    this.showMessage('Failed to save record.', 'error');
                }
            });
        },

        loadReport() {
            const inventoryTypeId = this.$type.val();
            const range = this.$reportRange.val();
            const date = this.$reportDate.val();

            if (!inventoryTypeId) {
                return;
            }

            this.loadSummary(inventoryTypeId, range, date);
            this.loadRecords(inventoryTypeId, range, date);
        },

        loadSummary(inventoryTypeId, range, date) {
            $.ajax({
                url: fisAdmin.ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'fis_get_summary',
                    nonce: fisAdmin.nonce,
                    inventory_type_id: inventoryTypeId,
                    range: range,
                    date: date
                },
                success: (response) => {
                    if (response.success) {
                        this.renderSummary(response.data.summary, response.data.range);
                    } else {
                        this.$summaryCards.html('<p>Unable to load summary.</p>');
                    }
                },
                error: () => {
                    this.$summaryCards.html('<p>Unable to load summary.</p>');
                }
            });
        },

        loadRecords(inventoryTypeId, range, date) {
            $.ajax({
                url: fisAdmin.ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'fis_get_records',
                    nonce: fisAdmin.nonce,
                    inventory_type_id: inventoryTypeId,
                    range: range,
                    date: date
                },
                success: (response) => {
                    if (response.success) {
                        this.renderRecords(response.data.records);
                    } else {
                        this.renderNoRecords();
                    }
                },
                error: () => {
                    this.renderNoRecords();
                }
            });
        },

        renderSummary(summary, range) {
            const html = `
                <div class="fis-summary-range">
                    <strong>Range:</strong> ${range.start} to ${range.end}
                </div>

                <div class="fis-summary-grid">
                    <div class="fis-summary-card"><span>Total Sales</span><strong>${this.money(summary.sales_amount)}</strong></div>
                    <div class="fis-summary-card"><span>Total Expenses</span><strong>${this.money(summary.total_expenses)}</strong></div>
                    <div class="fis-summary-card"><span>Gross Profit</span><strong>${this.money(summary.gross_profit)}</strong></div>
                    <div class="fis-summary-card"><span>Owner Share</span><strong>${this.money(summary.owner_share)}</strong></div>
                    <div class="fis-summary-card"><span>Caretaker Share</span><strong>${this.money(summary.caretaker_share)}</strong></div>
                    <div class="fis-summary-card"><span>Produced Trays</span><strong>${summary.trays_count}</strong></div>
                    <div class="fis-summary-card"><span>Sold Trays</span><strong>${summary.sold_trays}</strong></div>
                    <div class="fis-summary-card"><span>Mortality</span><strong>${summary.mortality_count}</strong></div>
                    <div class="fis-summary-card"><span>XS Eggs</span><strong>${summary.egg_xs}</strong></div>
                    <div class="fis-summary-card"><span>S Eggs</span><strong>${summary.egg_s}</strong></div>
                    <div class="fis-summary-card"><span>M Eggs</span><strong>${summary.egg_m}</strong></div>
                    <div class="fis-summary-card"><span>L Eggs</span><strong>${summary.egg_l}</strong></div>
                    <div class="fis-summary-card"><span>Jumbo Eggs</span><strong>${summary.egg_jumbo}</strong></div>
                </div>
            `;

            this.$summaryCards.html(html);
        },

        renderRecords(records) {
            if (!records.length) {
                this.renderNoRecords();
                return;
            }

            let html = '';

            records.forEach(record => {
                html += `
                    <tr>
                        <td>${record.record_date}</td>
                        <td>${this.money(record.feeds_cost)}</td>
                        <td>${this.money(record.vitamins_cost)}</td>
                        <td>${this.money(record.other_cost)}</td>
                        <td>${record.trays_count}</td>
                        <td>${record.sold_trays}</td>
                        <td>${this.money(record.sales_amount)}</td>
                        <td>${record.mortality_count}</td>
                    </tr>
                `;
            });

            this.$recordsTableBody.html(html);
        },

        renderNoRecords() {
            this.$recordsTableBody.html('<tr><td colspan="8">No records found for this range.</td></tr>');
        },

        addType() {
            const name = this.$newType.val().trim();

            if (!name) {
                this.showMessage('Please enter a new inventory type.', 'error');
                return;
            }

            $.ajax({
                url: fisAdmin.ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'fis_add_type',
                    nonce: fisAdmin.nonce,
                    name: name
                },
                success: (response) => {
                    if (response.success) {
                        fisAdmin.types.push(response.data.type);
                        this.populateTypes();
                        this.$type.val(response.data.type.id);
                        this.$newType.val('');
                        this.showMessage(response.data.message, 'success');
                        this.loadReport();
                    } else {
                        this.showMessage(response.data.message || 'Unable to add type.', 'error');
                    }
                },
                error: () => {
                    this.showMessage('Unable to add inventory type.', 'error');
                }
            });
        },

        clearForm() {
            $('#fis_feeds_cost, #fis_vitamins_cost, #fis_other_cost, #fis_trays_count, #fis_sold_trays, #fis_sales_amount, #fis_mortality_count, #fis_egg_xs, #fis_egg_s, #fis_egg_m, #fis_egg_l, #fis_egg_jumbo, #fis_weight_xs, #fis_weight_s, #fis_weight_m, #fis_weight_l, #fis_weight_jumbo').val(0);
            $('#fis_notes').val('');
            $('#fis_record_date').val(fisAdmin.today);
            this.showMessage('Form cleared.', 'info');
        },

        showMessage(message, type) {
            this.$message
                .removeClass('fis-success fis-error fis-info')
                .addClass(`fis-${type}`)
                .text(message);
        },

        money(value) {
            const number = parseFloat(value || 0);
            return number.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    };

    app.init();
});