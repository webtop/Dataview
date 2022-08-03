/**
 * This file is not currently in use.
 */

function ActionNavBar() {
    let button_states = {};
    let container = '';

    this.init = (container) => {
        if ($(container)) {
            this.container = $(container);
            this.bindEvents();
        }
    };

    this.bindEvents = () => {
        this.container.find('button')
          .on('click', this.handleClick);
    };

    this.handleClick = (evt) => {
        let button = $(evt.target);
        let action = button.attr('data-action');
        switch (action) {
            case 'edit':
                this.set_edit_mode();
                break;
            case 'cancel':
                this.cancel_edit_mode();
                break;
            case 'add':
                this.insert_row();
                break;
            case 'delete':
                this.remove_row();
                break;
            case 'first':
            case 'previous':
            case 'next':
            case 'last':
                this.nav_to(action);
                break;
            default:
          // cancel operation for any button

        }
    };

    this.set_edit_mode = () => {
        let buttons = $('.edit_buttons');
        buttons.removeClass('invisible').parent().removeClass('hidden');
        $('table#main_content_table thead tr th:first-child').text('Edit').removeClass('hidden');
        this.update_button_states('edit', (button) => {
            button.removeClass('bi-pencil')
              .addClass('bi-x-circle')
              .attr('data-action', 'cancel')
              .removeAttr('disabled');
        });
    };

    this.cancel_edit_mode = () => {
        let buttons = $('.edit_buttons');
        buttons.parent().addClass('hidden');
        $('div#floated_action_buttons').hide();
        $('table#main_content_table thead tr th:first-child').addClass('hidden');


        update_navigation(current_position, current_max);
    };

    this.insert_row = () => {

    };

    this.remove_row = () => {

    };

    this.nav_to = (direction) => {
        $.ajax({
            url: '/data/' + $('#table_selector option:selected').val() + '/' + direction,
            type: 'GET',
            success: function (response) {
                build_table(response.items);
                update_position(response.position, response.max);
            }
        });
    };

    this.update_button_states = (action, fn) => {
        // when any button is clicked, store the state of all button
        // then on cancel, all buttons can be restored to the state they were in
        // after that, put the buttons into the state they need to be in
        let siblings = this.container.find('button:not([data-action="edit"])');
        siblings.attr('disabled', 'disabled');

        // get the button with the correct action
        let button = this.container.find('button[data-action="edit"]');
        fn(button);

        // new_state.each((key, value) => {
        //     if (typeof value === 'string') {
        //         button.key(value);
        //     } else {
        //         Object.keys(value).forEach((key) => {
        //             button.key(key).val(value[key]);
        //         });
        //         button.attr(key, value);
        //     }
        // });
    };

    this.reset_button_states = () => {
        // reset the button states to the previous state
    };
}
