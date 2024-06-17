/**
 * When extending the control panel, be sure to uncomment the necessary code for your build process:
 * https://statamic.dev/extending/control-panel
 */

import Address from './fieldtypes/Address.vue';

Statamic.booting(() => {
    Statamic.$components.register('address-fieldtype', Address);
});