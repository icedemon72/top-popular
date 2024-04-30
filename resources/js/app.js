import './bootstrap';

import collapse from '@alpinejs/collapse'
import Alpine from 'alpinejs';
import Clipboard from '@ryangjchandler/alpine-clipboard' // Import it
import qs from 'qs';

import { giveLike, handleModal, closeModal } from './utils';

window.giveLike = giveLike;
window.handleModal = handleModal;
window.closeModal = closeModal;
window.Alpine = Alpine;
window.qs = qs;

Alpine.plugin(collapse);
Alpine.plugin(Clipboard)
Alpine.start();