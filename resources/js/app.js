import './bootstrap';
import '@tabler/core/dist/js/tabler.min.js';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import mask from '@alpinejs/mask';
import './cep';

window.Alpine = Alpine;
Alpine.plugin(focus);
Alpine.plugin(mask);
Alpine.start();
