import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function(event) {
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.js-remove-message-flash')) return;
        event.target.closest('.flash-message').remove();
    }, false);
});
