<?php

use WithCandour\StatamicAdvancedForms\Contracts\Stache\Stores;

return [

    /*
    |--------------------------------------------------------------------------
    | Stache stores
    |--------------------------------------------------------------------------
    |
    | Register the stache stores required for the addon.
    |
    */

    'stache' => [

        'stores' => [

            'forms' => [
                'class' => Stores\FormsStore::class,
                'directory' => resource_path('advanced-forms'),
            ],

            'notifications' => [
                'class' => Stores\NotificationsStore::class,
                'directory' => resource_path('advanced-forms/notifications'),
            ],

            'feeds' => [
                'class' => Stores\FeedsStore::class,
                'directory' => resource_path('advanced-forms/feeds'),
            ],

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Disabled feedtypes
    |--------------------------------------------------------------------------
    |
    | This is an array of feedtype handles which should not
    | be available in the CMS.
    |
    */

    'disabled_feed_types' => [

        // 'advanced_forms_example',

    ],


    /*
    |--------------------------------------------------------------------------
    | Email View Folder
    |--------------------------------------------------------------------------
    |
    | The folder under resources/views where your email templates are found.
    |
    */

    'email_view_folder' => null,


    /*
    |--------------------------------------------------------------------------
    | Lookup API Key
    |--------------------------------------------------------------------------
    |
    | The API key for your lookup service.
    |
    */

    'postcoder_api_key' => env('POSTCODER_API_KEY'),
];
