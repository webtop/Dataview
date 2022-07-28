$(document).ready(function() {
    let data_state;

    const show_error = function(message) {
        $('span', '#error_container').text(message);
        $('#db_error').addClass('show');
        setTimeout(hide_error, 7000);
    }

    const hide_error = function() {
        $('span', '#error_container').text('');
        $('#db_error').removeClass('show');
    }

    const update_state = function() {
        data_state = $('i#db_online_state').attr('data-state');
        $('#db_online_state_text').text(data_state.charAt(0).toUpperCase() + data_state.slice(1));
    }

    const build_table = function(items) {
        if (items.length > 0) {
            clear_table();
            set_table_headers(items[0]);
            set_table_content(items);
            $('#table_nav_buttons').removeClass('invisible');
        }
    }

    const set_table_headers = function(item) {
        let row = $('<tr>');
        let thead = $('table#main_content_table thead');
        Object.keys(item).forEach(function(key) {
            let cell = $('<th>');
            cell.text(key);
            row.append(cell);
        });
        thead.append(row);
    }

    const set_table_content = function(items) {
        let tbody = $('table#main_content_table tbody');
        for (let item in items) {
            let row = $('<tr>');
            for (let key in items[item]) {
                let cell = $('<td>');
                cell.text(items[item][key]);
                row.append(cell);
            }
            tbody.append(row);
        }
    }

    const clear_table = function() {
        let thead = $('table#main_content_table thead');
        let tbody = $('table#main_content_table tbody');
        thead.empty();
        tbody.empty();
    }

    update_state();

    $('button#test').on('click', function() {
        $('form button').attr('disabled', 'disabled');
        $.ajax({
            url: '/test_database',
            type: 'POST',
            data: {
                connection: $('form#db_connect').serialize()
            },
            success: function(response) {
                if (response.success) {
                    $('i#db_online_state').attr('data-state', 'connectable');
                } else {
                    $('i#db_online_state').attr('data-state', 'offline');
                    show_error(response.message);
                }
                $('form button').removeAttr('disabled');
                update_state();
            },
            error: function(response) {
                $('i#db_online_state').attr('data-state', 'offline');
                show_error('An error occurred while testing the database connection.');
                $('form button').removeAttr('disabled');
                update_state();
            }
        });
    });

    $('button#connect').on('click', function() {
        $.ajax({
            url: '/connect',
            type: 'POST',
            data: {
                connection: $('form#db_connect').serialize()
            },
            success: function(response) {
                $('i#db_online_state').attr('data-state', 'online');
                location.href = '/data';
            },
            error: function(response) {
                $('i#db_online_state').attr('data-state', 'offline');
                show_error('An error occurred while testing the database connection.');
                $('form button').removeAttr('disabled');
                update_state();
            }
        });
    });

    $('button#disconnect').on('click', function() {
        $.ajax({
            url: '/disconnect',
            type: 'GET',
            success: function (response) {
                $('i#db_online_state').attr('data-state', 'offline');
                location.href = '/home';
            }
        });
    });

    $('select#table_selector').on('change', function() {
        let table = $('select#table_selector').val();
        if (table !== '') {
            $.ajax({
                url: '/data/' + table,
                type: 'GET',
                success: function (response) {
                    $('select#table_selector').blur();
                    build_table(response.items);
                }
            });
        }
    });
});