<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fields\Fieldtype;

class Autocomplete extends Fieldtype
{
    protected $categories = ['special'];
    
    protected $canCreate = false;

    public function preProcess($data)
    {
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function process($data)
    {
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function selectable() : bool
    {
        return 0;
    }

    public function selectableInForms() : bool
    {
        return 1;
    }

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
                    'options' => [
                        'display' => __('advanced-forms::autocomplete.options.label'),
                        'instructions' => __('advanced-forms::autocomplete.options.instructions'),
                        'type' => 'textarea',
                        'default' => '',
                        'width' => 100
                    ]
                ]
            ]
        ];
    }


    /**
     * @inheritDoc
     */
    public function view()
    {
        $default = 'statamic-advanced-forms::fieldtypes.autocomplete';

        return view()->exists($default)
            ? $default
            : 'statamic::forms.fields.default';
    }
}
