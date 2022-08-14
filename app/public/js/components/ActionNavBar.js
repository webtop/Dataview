/**
 * This file is not currently in use.
 */

function ActionNavBar() {
    let action = undefined;
    let button_states = {};
    let container = '';

    this.init = (container) => {
        if ($(container)) {
            this.container = $(container);
            this.bindEvents();
        }
    };

    this.bindEvents = () => {
        this.container.find('button').on('click', this.handleClick);
        this.edit_event = new Event('edit');
        this.delete_event = new Event('delete');
        this.add_event = new Event('add');
        this.cancel_event = new Event('cancel');
        this.navigate_event = new CustomEvent('navigate', {action: action});
    };

    this.handleClick = (evt) => {
        let button = $(evt.target);
        let action = button.attr('data-action');
        switch (action) {
            case 'edit':
                this.container[0].dispatchEvent(this.edit_event);
                break;
            case 'cancel':
                this.container[0].dispatchEvent(this.cancel_event);
                break;
            case 'add':
                this.container[0].dispatchEvent(this.add_event);
                break;
            case 'delete':
                this.container[0].dispatchEvent(this.delete_event);
                break;
            case 'first':
            case 'previous':
            case 'next':
            case 'last':
                this.container[0].dispatchEvent(this.navigate_event);
                break;
            default:
                console.log('Unknown action: ' + action);
                this.container[0].dispatchEvent(this.cancel_event);

        }
    };

    this.update_button_states = (action, fn) => {
        // capture states and disable all siblings
        let siblings = this.container.find('button:not([data-action="' + action + '"])');
        siblings.each((idx, el) => {
            button_states[el.id] = {};
            button_states[el.id].classes = el.classList.value;
            button_states[el.id].disabled = el.disabled;
        });
        siblings.attr('disabled', 'disabled');

        // get the button with the correct action
        let button = this.container.find('button[data-action="' + action + '"]');
        button_states[button.attr('id')] = {};
        button_states[button.attr('id')].classes = button[0].classList.value;
        button_states[button.attr('id')].disabled = button[0].disabled;

        // change its state as requested
        fn(button);
    };

    this.reset_button_states = () => {
        for (let button_state in button_states) {
            let button = $('#' + button_state);
            button[0].classList.value = button_states[button_state].classes;
            if (button_states[button_state].disabled) {
                button.attr('disabled', 'disabled');
            } else {
                button.removeAttr('disabled');
            }
        }
    };
}
