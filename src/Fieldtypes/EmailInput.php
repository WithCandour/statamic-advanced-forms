<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fields\Fieldtype;

class EmailInput extends Fieldtype
{
    protected $categories = ['special'];

    public function configFieldItems(): array
    {
        return [
            [
                'display' => __('Input Behavior'),
                'fields' => [
                    'label' => [
                        'display' => __('Label'),
                        'instructions' => __('statamic::fieldtypes.text.config.placeholder'),
                        'type' => 'text',
                    ],
                    'label_type' => [
                        'display' => __('Label Type'),
                        'instructions' => __('statamic::fieldtypes.text.config.placeholder'),
                        'type' => 'select',
                        'options' => [
                            'label' => 'Default Label (Above Field)',
                            'label_below' => 'Label (Below Field)',
                            'placeholder' => 'Placeholder'
                        ],
                        'default' => 'label',
                    ],
                    'default' => [
                        'display' => __('Default Value'),
                        'instructions' => __('statamic::messages.fields_default_instructions'),
                        'type' => 'text',
                    ],
                    'character_limit' => [
                        'display' => __('Character Limit'),
                        'instructions' => __('statamic::fieldtypes.text.config.character_limit'),
                        'type' => 'integer',
                    ],
                ],
            ],
            [
                'display' => __('Advanced Form Builder'),
                'fields' => [
                    'allow_url_prefill' => [
                        'display' => 'Allow URL Prefill',
                        'instructions' => 'When active, the field will pull the value from a GET parameter in a URL of the same name as the field handle.',
                        'type' => 'toggle',
                        'default' => false
                    ],
                    'submissions_unique' => [
                        'display' => 'Unique Field',
                        'instructions' => 'This is useful if you want to limit submissions to one per email address, for example.',
                        'type' => 'toggle',
                        'default' => false
                    ]
                ]
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function selectable() : bool
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function selectableInForms() : bool
    {
        return 1;
    }
    
    public function view()
    {
        $default = 'statamic-advanced-forms::fieldtypes.email_field';

        return view()->exists($default)
            ? $default
            : 'statamic::forms.fields.default';
    }
}
