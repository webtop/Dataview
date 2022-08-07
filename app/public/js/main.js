$(document).ready(() => {
    let data_state = null;
    let current_edit_row = null;
    let current_position = 0;
    let current_max = 0;

    const PER_PAGE = 20;
    //const action_bar = new ActionNavBar();
    //action_bar.init('.action_nav_bar');

    if ($('form#new_record').length > 0) {
        $('form#new_record input:first').focus();
    }

    const show_error = (message) => {
        $('span', '#error_container').text(message);
        $('#db_error').show();
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
            let cell = $('<td class="hidden">');
            /**
             * These buttons get used interchangeably for edit and delete,
             * so we won't attach handlers until we need to
             */
            let edit_button = $('<button class="btn btn-sm btn-success edit_buttons bi-pencil"></button>');
            cell.append(edit_button);
            row.append(cell);
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
        current_position = position;
        current_max = max;
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
        $('#positional_data').removeClass('invisible');
        $('#main_content_table caption').removeClass('invisible');
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

    const set_edit_state = () => {
        let buttons = $('.edit_buttons');
        buttons.on('click', edit_row);
        buttons.removeClass('invisible').parent().removeClass('hidden');
        $('table#main_content_table thead tr th:first-child').text('Edit').removeClass('hidden');
        $('.action_nav_bar button').attr('disabled', 'disabled');
    }

    const cancel_edit_state = () => {
        let buttons = $('.edit_buttons');
        buttons.off('click', edit_row);
        buttons.parent().addClass('hidden');
        $('div#floated_action_buttons').hide();
        $('table#main_content_table thead tr th:first-child').addClass('hidden');
        $('table#main_content_table').removeClass('editing');
        $('.action_nav_bar button').removeAttr('disabled');

        update_navigation(current_position, current_max);
    }

    const set_delete_state = () => {
        let buttons = $('.edit_buttons');
        buttons.removeClass('bi-pencil')
          .addClass('bi-trash')
          .removeClass('invisible')
          .parent().removeClass('hidden');
        buttons.on('click', delete_row);
        $('table#main_content_table thead tr th:first-child').text('Delete').removeClass('hidden');
        $('.action_nav_bar button').attr('disabled', 'disabled');
    }

    const cancel_delete_state = () => {
        let buttons = $('.edit_buttons');
        buttons.off('click', delete_row);
        buttons.parent().addClass('hidden');
        $('div#floated_action_buttons').hide();
        $('table#main_content_table thead tr th:first-child').addClass('hidden');
        $('table#main_content_table').removeClass('deleting');
        $('.action_nav_bar button').removeAttr('disabled');

        update_navigation(current_position, current_max);
    }

    const delete_row = (evt) => {
        let row = $($(evt.target).closest('tr'));
        let id = row.find('td[data-id="customerNumber"]').attr('data-val');
        current_edit_row = row;
        if (confirm('Are you sure you want to delete this row?')) {
            $.ajax({
                url: '/data/' + $('#table_selector option:selected').val() + '/delete',
                data: {
                    id: id
                },
                type: 'POST',
                success: function (response) {
                    if (response.success) {
                        current_edit_row.remove();
                        current_edit_row = null;
                    } else {
                        show_error(response.message);
                    }

                    cancel_delete_state();
                },
                error: function (response) {
                    show_error('An error occurred while attempting to delete a record.');
                    cancel_edit();
                }
            });
        }
    }

    const edit_row = (evt) => {
        let row = $($(evt.target).closest('tr'));
        row.addClass('editing');
        current_edit_row = row;
        let cells = row[0].childNodes;
        for (let cell in cells) {
            let cell_idx = parseInt(cell); // 'cell' is actually a string
            if (isNaN(cell_idx)) break;
            if (cell_idx < 2) continue; // edit button cell
            let cell_obj = $(cells[cell_idx]);
            let input = $('<input type="text" class="form-control-sm">');
            input.val(cell_obj.attr('data-val'));
            input.attr('name', cell_obj.attr('data-id'));
            cell_obj.text('');
            cell_obj.append(input[0]);
        }

        let row_pos = get_row_offsets(current_edit_row);
        $('div#floated_action_buttons').css({
            'position': 'absolute',
            'top': row_pos.top + 'px',
            'left': row_pos.right + 'px'
        }).show();

        $('.edit_buttons').addClass('invisible');
        $('div#table_action_buttons').find('button[data-action="edit"]')
          .removeClass('bi-x-circle')
          .addClass('bi-pencil')
          .attr('data-action', 'edit')
          .attr('disabled', 'disabled');
    };

    const set_save_row = (evt) => {
        let data = {};
        let cells = current_edit_row[0].childNodes;
        for (let cell in cells) {
            let cell_idx = parseInt(cell); // 'cell' is actually a string
            if (isNaN(cell_idx)) break;
            if (cell_idx === 0) continue; // edit button cell
            let cell_obj = $(cells[cell_idx]);
            if (cell_idx === 1) { // ids are not editable...obviously!
                data[cell_obj.attr('data-id')] = cell_obj.text();
            } else {
                // only send what changed
                if (cell_obj.attr('data-val') !== cell_obj.find('input').val()) {
                    data[cell_obj.attr('data-id')] = cell_obj.find('input').val();
                }
            }
        }

        $.ajax({
            url: '/data/' + $('#table_selector option:selected').val() + '/update',
            type: 'POST',
            data: {
                update: data
            },
            success: function (response) {
                let cells = current_edit_row[0].childNodes;
                for (let cell in cells) {
                    let cell_idx = parseInt(cell);
                    if (isNaN(cell_idx)) break;
                    if (cell_idx === 0) continue; // edit button cell
                    let cell_obj = $(cells[cell_idx]);
                    if (cell_obj.find('input').length > 0) {
                        let new_val = cell_obj.find('input').val();
                        if (cell_obj.attr('data-val') !== new_val) {
                            cell_obj.attr('data-val', new_val);
                        }
                        cell_obj.text(new_val);
                    }
                }
                cancel_edit_state();
            },
            error: function (response) {
                show_error('An error occurred while attempting to add a record.');
                cancel_edit();
            }
        });
    };

    const cancel_edit = (evt) => {
        for (let cell in current_edit_row[0].childNodes) {
            let cell_idx = parseInt(cell);
            if (isNaN(cell_idx)) break;
            if (cell_idx < 2) continue; // edit button cell
            let cell_obj = $(current_edit_row[0].childNodes[cell_idx]);
            cell_obj.text(cell_obj.attr('data-val'));
        }
        cancel_edit_state();
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

    $('button#new_row_cancel').on('click', () => {
        location.href = '/data';
    });

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

    $('#table_action_buttons button').on('click', (evt) => {
        let button = $(evt.target);
        let headers = $('table#main_content_table thead tr');
        let rows = $('table#main_content_table tbody tr');
        switch (button.attr('data-action')) {
            case 'edit':
                set_edit_state();
                button.removeClass('bi-pencil')
                  .addClass('bi-x-circle')
                  .attr('data-action', 'cancel-edit')
                  .removeAttr('disabled');
                break;
            case 'add':
                location.href = '/new/' + $('#table_selector option:selected').val();
                break;
            case 'delete':
                set_delete_state();
                button.removeClass('bi-trash')
                  .addClass('bi-x-circle')
                  .attr('data-action', 'cancel-delete')
                  .removeAttr('disabled');
                break;
            case 'cancel-edit':
                cancel_edit_state();
                button.removeClass('bi-x-circle')
                  .addClass('bi-pencil')
                  .attr('data-action', 'edit')
                  .blur();
                break;
            case 'cancel-delete':
                cancel_delete_state();
                button.removeClass('bi-x-circle')
                  .addClass('bi-trash')
                  .attr('data-action', 'delete')
                  .blur();
                break;
        }
    });

    $('#table_nav_buttons button').on('click', navigate_to);
    $('button#cancel_edit').on('click', cancel_edit);
    $('button#save_edit').on('click', set_save_row);
});