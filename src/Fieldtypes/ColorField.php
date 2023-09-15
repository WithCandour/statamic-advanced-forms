<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fields\Fieldtype;

class ColorField extends Fieldtype
{
    protected $categories = ['special'];
    
    public function configFieldItems(): array
    {
        return [
            [
                'display' => __('Input Behavior'),
                'fields' => [
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

    /**
     * @inheritDoc
     */
    public function selectableInForms() : bool
    {
        return 1;
    }
    
    public function view()
    {
        $default = 'statamic-advanced-forms::fieldtypes.color_field';

        return view()->exists($default)
            ? $default
            : 'statamic::forms.fields.default';
    }
}