import Alpine from 'alpinejs';
import { registerBlatUI } from './blatui-core.js';
import './portal.js';

if (! window.Alpine) {
    registerBlatUI(Alpine);
    window.Alpine = Alpine;
    Alpine.start();
}
