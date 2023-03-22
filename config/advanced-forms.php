<?php

use WithCandour\StatamicAdvancedForms\Contracts\Stache\Stores;

return [

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

];
