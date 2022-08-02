$(document).ready(() => {
    let data_state = null;
    let current_edit_row = null;
    const PER_PAGE = 20;

    const show_error = (message) => {
        $('span', '#error_container').text(message);
        $('#db_error').addClass('show');
        setTimeout(hide_error, 7000);
    };

    const hide_error = () => {
        $('span', '#error_container').text('');
        $('#db_error').removeClass('show');
    };

    const update_state = () => {
        data_state = $('i#db_online_state').attr('data-state');
        $('#db_online_state_text').text(data_state.charAt(0).toUpperCase() + data_state.slice(1));
    };

    const build_table = (items) => {
        if (items.length > 0) {
            clear_table();
            set_table_headers(items[0]);
            set_table_content(items);
            unhide_table_buttons();
        }
    };

    const set_table_headers = (item) => {
        let row = $('<tr>');
        let thead = $('table#main_content_table thead');
        row.append($('<th class="hidden">'));
        Object.values(item).forEach((value) => { // value is an object representing data columns
            let cell = $('<th>');
            cell.text(value.text);
            row.append(cell);
        });
        thead.append(row);
    };

    const set_table_content = (items) => {
        let tbody = $('table#main_content_table tbody');
        for (let item in items) {
            let row = $('<tr>');
            let edit_button = $('<td class="hidden"><button class="btn btn-sm btn-success edit_buttons bi-pencil"></button></td>');
            edit_button.on('click', set_edit_row);
            row.append(edit_button);
            for (let key in items[item]) {
                let cell = $('<td data-id="' + items[item][key]['key'] + '" data-val="' + items[item][key]['value'] + '">');
                cell.text(items[item][key]['value']);
                row.append(cell);
            }
            tbody.append(row);
        }
    };

    const clear_table = () => {
        $('table#main_content_table thead').empty();
        $('table#main_content_table tbody').empty();
    };

    const update_position = (position, max) => {
        let current = (position + PER_PAGE > max) ? max : position + PER_PAGE;
        $('#positional_data #position').text(position + 1); // Humans!
        $('#positional_data #inc').text(current);
        $('#positional_data #max').text(max);

        update_navigation(position, max);
    };

    const update_navigation = (position, max) => {
        $('#table_nav_buttons #first').attr('disabled', position === 0);
        $('#table_nav_buttons #previous').attr('disabled', position  < PER_PAGE);
        $('#table_nav_buttons #next').attr('disabled', position + PER_PAGE >= max);
        $('#table_nav_buttons #last').attr('disabled', position + PER_PAGE >= max);
        $('#table_nav_buttons button').blur();
    };

    const unhide_table_buttons = (item) => {
        $('#table_nav_buttons').removeClass('invisible');
        $('#positional_data').removeClass('invisible');
        $('#table_action_buttons').removeClass('invisible');
    };

    const navigate_to = () => {
        $.ajax({
            url: '/data/' + $('#table_selector option:selected').val() + '/' + $('#table_nav_buttons button:focus').attr('id'),
            type: 'GET',
            success: function (response) {
                build_table(response.items);
                update_position(response.position, response.max);
            }
        });
    };

    const set_edit_row = (evt) => {
        let row = $($(evt.target).closest('tr'));
        current_edit_row = row;
        $('.edit_buttons').addClass('hidden');
        row.addClass('editing');
        let cells = row[0].childNodes;
        for (let cell in cells) {
            let cell_idx = parseInt(cell); // 'cell' is actually a string
            if (isNaN(cell_idx)) break;
            if (cell_idx < 2) continue; // edit button cell
            let cell_obj = $(cells[cell_idx]);
            let input = $('<input type="text" class="form-control-sm">');
            input.val(cell_obj.data('val'));
            input.attr('name', cell_obj.data('id'));
            cell_obj.text('');
            cell_obj.append(input[0]);
        }

        let row_pos = get_row_offsets(current_edit_row);
        // console.log(row_pos);
        $('div#floated_action_buttons').css({
            'position': 'absolute',
            'top': row_pos.top + 'px',
            'left': row_pos.right + 'px'
        }).show();
    };

    const set_save_row = (evt) => {

    };

    const cancel_edit = (evt) => {
        $('div#floated_action_buttons').hide();
        current_edit_row.parent().parent().find('thead :first :first').addClass('hidden'); // edit column header
        $('.edit_buttons').parent().addClass('hidden');
        for (let cell in current_edit_row[0].childNodes) {
            let cell_idx = parseInt(cell);
            if (isNaN(cell_idx)) break;
            if (cell_idx < 2) continue; // edit button cell
            let cell_obj = $(current_edit_row[0].childNodes[cell_idx]);
            cell_obj.text(cell_obj.data('val'));
        }
    };

    const get_row_offsets = ($element) => {
        function getOffsetTop (el) {
            if (el.offsetParent) return el.offsetTop + getOffsetTop(el.offsetParent)
            return el.offsetTop || 0
        }

        function getOffsetLeft (el) {
            if (el.offsetParent) return el.offsetLeft + getOffsetLeft(el.offsetParent)
            return el.offsetLeft || 0
        }

        function coordinates(el) {
            let y1 = getOffsetTop(el);
            let x1 = getOffsetLeft(el) - window.scrollX;
            let y2 = y1 + el.offsetHeight;
            let x2 = x1 + el.offsetWidth;
            return {
                left: x1, right : x2, top: y1, bottom: y2
            }
        }

        return coordinates($element[0]);
    };

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

    $('#table_action_buttons button').on('click', () => {
        let button = $('#table_action_buttons button:focus').attr('id');
        let headers = $('table#main_content_table thead tr');
        let rows = $('table#main_content_table tbody tr');
        switch (button) {
            case 'edit_row':
                let buttons = $('.edit_buttons');
                $('table#main_content_table thead tr th:first-child').text('Edit').removeClass('hidden');
                buttons.parent().removeClass('hidden');
                buttons.removeClass('hidden');
                break;
            case 'add_row':
                break;
            case 'delete_row':
                break;
        }
    });

    $('button#cancel_edit').on('click', cancel_edit);
});