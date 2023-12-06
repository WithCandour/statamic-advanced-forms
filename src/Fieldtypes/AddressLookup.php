<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fields\Fieldtype;

class AddressLookup extends Fieldtype
{
    protected $canCreate = false;
    protected $categories = ['special'];

    public function preProcess($data)
    {
        $data['postcoder_api_key'] = env('POSTCODER_API_KEY');
        $data['loqate_api_key'] = env('LOQATE_API_KEY');
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

    /**
     * @inheritDoc
     */
    public function selectableInForms() : bool
    {
        return 1;
    }

    public function configFieldItems(): array
    {
        return [
            'autocomplete' => [
                'display' => __('advanced-forms::address-lookup.autocomplete.label'),
                'instructions' => __('advanced-forms::address-lookup.autocomplete.instructions'),
                'type' => 'toggle',
                'default' => false,
                'width' => 100
            ],
            'allow_country_select' => [
                'display' => __('advanced-forms::address-lookup.allow_country_select.label'),
                'instructions' => __('advanced-forms::address-lookup.allow_country_select.instructions'),
                'type' => 'toggle',
                'default' => false,
                'width' => 100
            ],
            'default_country_code' => [
                'display' => __('advanced-forms::address-lookup.country_code.label'),
                'instructions' => __('advanced-forms::address-lookup.country_code.instructions'),
                'type' => 'text',
                'default' => 'GB',
                'width' => 100
            ],
        ];
    }


    /**
     * @inheritDoc
     */
    public function view()
    {
        $default = 'statamic-advanced-forms::fieldtypes.address_lookup';

        return view()->exists($default)
            ? $default
            : 'statamic::forms.fields.default';
    }
}
