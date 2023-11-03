import './bootstrap';
import '@tabler/core/dist/js/tabler.min.js';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import mask from '@alpinejs/mask';

import 'webdatarocks/webdatarocks.css';
import 'webdatarocks/webdatarocks.toolbar.min.js';
import 'webdatarocks/webdatarocks.js';
//import 'webdatarocks/theme/lightblue/webdatarocks.min.css';

window.Alpine = Alpine;
Alpine.plugin(focus);
Alpine.plugin(mask);
Alpine.start();
