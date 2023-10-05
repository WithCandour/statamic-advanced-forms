<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fields\Fieldtype;
use WithCandour\StatamicAdvancedForms\Fieldtypes\Settings\ConfigFields;

class TextInput extends Fieldtype
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
                    'autocomplete' => ConfigFields::enableAutocomplete(),
                    'autocomplete_attribute' => ConfigFields::autocompleteAttribute(),
                    'allow_url_prefill' => ConfigFields::enableDynamicPopulation(),
                    'submissions_unique' => ConfigFields::disableDuplicates()
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
        $default = 'statamic-advanced-forms::fieldtypes.text_field';

        return view()->exists($default)
            ? $default
            : 'statamic::forms.fields.default';
    }
}
