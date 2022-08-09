/**
 * This file is not currently in use.
 */

function ActionNavBar() {
    let button_states = {};
    let container = '';

    const edit_event = new Event('edit');
    const delete_event = new Event('delete');
    const add_event = new Event('add');
    const cancel_event = new Event('cancel');
    const navigate_event = new Event('navigate');

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
                this.container.dispatchEvent(edit_event);
                break;
            case 'cancel':
                this.container.dispatchEvent(cancel_event);
                break;
            case 'add':
                this.container.dispatchEvent(add_event);
                break;
            case 'delete':
                this.container.dispatchEvent(delete_event);
                break;
            case 'first':
            case 'previous':
            case 'next':
            case 'last':
                this.container.dispatchEvent(navigate_event);
                break;
            default:
                console.log('Unknown action: ' + action);
                this.container.dispatchEvent(cancel_event);

        }
    };

    this.update_button_states = (action, fn) => {
        // disable all siblings
        let siblings = this.container.find('button:not([data-action="edit"])');
        siblings.attr('disabled', 'disabled');

        // get the button with the correct action
        let button = this.container.find('button[data-action="edit"]');

        // change its state as requested
        fn(button);
    };

    this.reset_button_states = () => {
        // reset the button states to the previous state
    };
}
