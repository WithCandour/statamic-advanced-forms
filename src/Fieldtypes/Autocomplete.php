<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fields\Fieldtype;

class Autocomplete extends Fieldtype
{
    protected $categories = ['special'];
    
    protected $canCreate = false;

    public function preProcess($data)
    {
        //$data['postcoder_api_key'] = env('POSTCODER_API_KEY');

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
            'options' => [
                'display' => __('advanced-forms::autocomplete.options.label'),
                'instructions' => __('advanced-forms::autocomplete.options.instructions'),
                'type' => 'textarea',
                'default' => '',
                'width' => 100
            ],
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
