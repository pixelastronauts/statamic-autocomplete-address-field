<?php

namespace Pixelastronauts\AddressField\Fieldtypes;

use Statamic\Fields\Fieldtype;

class Address extends Fieldtype
{
    /**
     * The blank/default value.
     *
     * @return array
     */
    public function defaultValue()
    {
        return null;
    }

    /**
     * Pre-process the data before it gets sent to the publish page.
     *
     * @param mixed $data
     * @return array|mixed
     */
    public function preProcess($data)
    {
        return $data;
    }

    /**
     * Process the data before it gets saved.
     *
     * @param mixed $data
     * @return array|mixed
     */
    public function process($data)
    {
        return $data;
    }

    /**
     * Preload the fieldtype with any required data.
     *
     * @return array
     */
    public function preload()
    {
        return ['hasKey' => config('statamic.address-field.google_places_api_key') !== null];
    }

    /**
     * Configuration fields.
     *
     * @return array
     */
    protected function configFieldItems(): array
    {
        return [
            'country_code' => [
                'display' => 'Restricted to certain Country',
                'instructions' => 'If you want to restrict the address to a certain country, you can set it here.',
                'type' => 'text',
                'width' => 100
            ],
        ];
    }
}
