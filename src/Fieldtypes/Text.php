<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fieldtypes\Text as CoreText;

class Text extends CoreText
{
    public function configFieldItems(): array
    {
        return [
            [
                'display' => __('Input Behavior'),
                'fields' => [
                    'input_type' => [
                        'display' => __('Input Type'),
                        'instructions' => __('statamic::fieldtypes.text.config.input_type'),
                        'type' => 'select',
                        'default' => 'text',
                        'options' => [
                            'color',
                            'date',
                            'email',
                            'hidden',
                            'month',
                            'number',
                            'password',
                            'tel',
                            'text',
                            'time',
                            'url',
                            'week',
                        ],
                    ],
                    'placeholder' => [
                        'display' => __('Placeholder'),
                        'instructions' => __('statamic::fieldtypes.text.config.placeholder'),
                        'type' => 'text',
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
                        'default' => false,
                        'width' => 200
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
    
    public function view()
    {
        $default = 'statamic-advanced-forms::fieldtypes.text';

        return view()->exists($default)
            ? $default
            : 'statamic::forms.fields.default';
    }
}
