<?php

use WithCandour\StatamicAdvancedForms\Contracts\Stache\Stores;

return [

    'stache' => [

        'stores' => [

            'forms' => [
                'class' => Stores\FormsStore::class,
                'directory' => 'resources/advanced-forms/forms'
            ],

        ],

    ],

];
