<?php

return [
    /**
     * Your Google Maps api key. Make sure you have the Places API enabled.
     * https://developers.google.com/maps/documentation/javascript/get-api-key
     * 
     * Important: For best results, enable both legacy "Places API" and the new "Places API (New)"
     * in your Google Cloud project.
     * 
     * Also make sure you you've restricted the key, as this is a public key.
     * 
     * @var string
     */
    'google_places_api_key' => env('GOOGLE_PLACES_API_KEY'),
];
