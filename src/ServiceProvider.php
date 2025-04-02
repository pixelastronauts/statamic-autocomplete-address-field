<?php

namespace Pixelastronauts\AddressField;

use Pixelastronauts\AddressField\Fieldtypes\Address;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;

class ServiceProvider extends AddonServiceProvider
{
    protected $vite = [
        'input' => [
            'resources/js/addon.js',
            'resources/css/addon.css',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    protected $fieldtypes = [
        Address::class
    ];

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/address-field.php', 'statamic.address-field');

        $this->publishes([
            __DIR__ . '/../config/address-field.php' => config_path('statamic/address-field.php'),
        ], 'statamic-address-field-config');
    }

    public function bootAddon()
    {
        $key = config('statamic.address-field.google_places_api_key');

        Statamic::externalScript('https://maps.googleapis.com/maps/api/js?key=' . $key . '&libraries=places&v=weekly');
    }
}
