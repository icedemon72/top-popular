import './bootstrap';

import collapse from '@alpinejs/collapse'
import Alpine from 'alpinejs';
import Clipboard from '@ryangjchandler/alpine-clipboard' // Import it


window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.plugin(Clipboard)
Alpine.start();