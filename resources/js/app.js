import './bootstrap';

import Alpine from 'alpinejs';
import 'lazysizes';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form[data-auth-form]');

    forms.forEach(form => {
        form.addEventListener('submit', () => {
            const gradient = form.querySelector('.auth-gradient-bar');
            if (gradient) {
                gradient.classList.remove('opacity-0');
                gradient.classList.add('animate-gradient');
            }
        });
    });
});

