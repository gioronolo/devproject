jQuery(function ($) {

    let user = localStorage.getItem('fis_user');

    if (!user) {
        showLogin();
    } else {
        initApp(user);
    }

    function showLogin() {
        $('#fis-app').html(`
            <div class="fis-login">
                <h2>Farm Inventory</h2>
                <input type="text" id="fis_name" placeholder="Enter your name / farm">
                <button id="fis_start">Start</button>
            </div>
        `);
    }

    $(document).on('click', '#fis_start', function () {
        let name = $('#fis_name').val();

        if (!name) {
            alert('Enter name');
            return;
        }

        localStorage.setItem('fis_user', name);
        initApp(name);
    });

    function initApp(user) {

        $('#fis-app').html(`
            <h2>Welcome ${user}</h2>

            <div class="fis-form">
                <input type="date" id="date">

                <h3>Feeds</h3>
                <input type="number" id="feeds" placeholder="Feeds cost">

                <h3>Eggs</h3>
                <input type="number" id="tray" placeholder="Tray per day">

                <input type="number" id="s" placeholder="S">
                <input type="number" id="m" placeholder="M">
                <input type="number" id="l" placeholder="L">
                <input type="number" id="jumbo" placeholder="Jumbo">

                <h3>Others</h3>
                <input type="number" id="dead" placeholder="Mortality">
                <input type="number" id="sales" placeholder="Sales amount">

                <button id="save">Save</button>
                <button id="load">Load Weekly</button>
                <button id="logout">Logout</button>
            </div>

            <div id="result"></div>
        `);

        $('#date').val(new Date().toISOString().split('T')[0]);
    }

    $(document).on('click', '#logout', function () {
        localStorage.removeItem('fis_user');
        location.reload();
    });

    // SAVE
    $(document).on('click', '#save', function () {

        let user = localStorage.getItem('fis_user');

        $.post(fis_ajax.ajax_url, {
            action: 'fis_save_record',
            owner_name: user,
            record_date: $('#date').val(),
            feeds_cost: $('#feeds').val(),
            trays_count: $('#tray').val(),
            egg_s: $('#s').val(),
            egg_m: $('#m').val(),
            egg_l: $('#l').val(),
            egg_jumbo: $('#jumbo').val(),
            mortality_count: $('#dead').val(),
            sales_amount: $('#sales').val()
        }, function (res) {
            alert(res.data.message);
        });

    });

    // LOAD WEEKLY
    $(document).on('click', '#load', function () {

        let user = localStorage.getItem('fis_user');

        $.post(fis_ajax.ajax_url, {
            action: 'fis_get_summary',
            owner_name: user,
            date: $('#date').val()
        }, function (res) {

            let s = res.data.summary;

            $('#result').html(`
                <h3>Weekly Summary</h3>
                <p>Total Sales: ${s.sales_amount}</p>
                <p>Total Expenses: ${s.total_expenses}</p>
                <p>Profit: ${s.gross_profit}</p>
                <p>Owner: ${s.owner_share}</p>
                <p>Caretaker: ${s.caretaker_share}</p>
            `);

        });

    });

});