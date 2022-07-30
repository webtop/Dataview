$(document).ready(() => {
    let data_state;
    const PER_PAGE = 20;

    const show_error = (message) => {
        $('span', '#error_container').text(message);
        $('#db_error').addClass('show');
        setTimeout(hide_error, 7000);
    }

    const hide_error = () => {
        $('span', '#error_container').text('');
        $('#db_error').removeClass('show');
    }

    const update_state = () => {
        data_state = $('i#db_online_state').attr('data-state');
        $('#db_online_state_text').text(data_state.charAt(0).toUpperCase() + data_state.slice(1));
    }

    const build_table = (items) => {
        if (items.length > 0) {
            clear_table();
            set_table_headers(items[0]);
            set_table_content(items);
            make_actionable();
        }
    }

    const set_table_headers = (item) => {
        let row = $('<tr>');
        let thead = $('table#main_content_table thead');
        Object.keys(item).forEach((key) => {
            let cell = $('<th>');
            cell.text(key);
            row.append(cell);
        });
        thead.append(row);
    }

    const set_table_content = (items) => {
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

    const clear_table = () => {
        $('table#main_content_table thead').empty();
        $('table#main_content_table tbody').empty();
    }

    const update_position = (position, max) => {
        let current = (position + PER_PAGE > max) ? max : position + PER_PAGE;
        $('#positional_data #position').text(position + 1); // Humans!
        $('#positional_data #inc').text(current);
        $('#positional_data #max').text(max);

        update_navigation(position, max);
    }

    const update_navigation = (position, max) => {
        $('#table_nav_buttons #first').attr('disabled', position === 0);
        $('#table_nav_buttons #previous').attr('disabled', position  < PER_PAGE);
        $('#table_nav_buttons #next').attr('disabled', position + PER_PAGE >= max);
        $('#table_nav_buttons #last').attr('disabled', position + PER_PAGE >= max);
        $('#table_nav_buttons button').blur();
    }

    const make_actionable = (item) => {
        $('#table_nav_buttons').removeClass('invisible');
        $('#positional_data').removeClass('invisible');
        $('#table_action_buttons').removeClass('invisible');
    }

    const navigate_to = () => {
        $.ajax({
            url: '/data/' + $('#table_selector option:selected').val() + '/' + $('#table_nav_buttons button:focus').attr('id'),
            type: 'GET',
            success: function (response) {
                build_table(response.items);
                update_position(response.position, response.max);
            }
        });
    }

    update_state();

    $('button#test').on('click', () => {
        $('form button').attr('disabled', 'disabled');
        $.ajax({
            url: '/test_database',
            type: 'POST',
            data: {
                connection: $('form#db_connect').serialize()
            },
            success: (response) => {
                if (response.success) {
                    $('i#db_online_state').attr('data-state', 'connectable');
                } else {
                    $('i#db_online_state').attr('data-state', 'offline');
                    show_error(response.message);
                }
                $('form button').removeAttr('disabled');
                update_state();
            },
            error: (response) => {
                $('i#db_online_state').attr('data-state', 'offline');
                show_error('An error occurred while testing the database connection.');
                $('form button').removeAttr('disabled');
                update_state();
            }
        });
    });

    $('button#connect').on('click', () => {
        $.ajax({
            url: '/connect',
            type: 'POST',
            data: {
                connection: $('form#db_connect').serialize()
            },
            success: (response) => {
                $('i#db_online_state').attr('data-state', 'online');
                location.href = '/data';
            },
            error: (response) => {
                $('i#db_online_state').attr('data-state', 'offline');
                show_error('An error occurred while testing the database connection.');
                $('form button').removeAttr('disabled');
                update_state();
            }
        });
    });

    $('button#disconnect').on('click', () => {
        $.ajax({
            url: '/disconnect',
            type: 'GET',
            success: function (response) {
                $('i#db_online_state').attr('data-state', 'offline');
                location.href = '/home';
            }
        });
    });

    $('select#table_selector').on('change', () => {
        let table = $('select#table_selector').val();
        if (table !== '') {
            $.ajax({
                url: '/data/' + table,
                type: 'GET',
                success: function (response) {
                    $('select#table_selector').blur();
                    build_table(response.items);
                    update_position(response.position, response.max);
                }
            });
        }
    });

    $('#table_nav_buttons button').on('click', navigate_to);

});