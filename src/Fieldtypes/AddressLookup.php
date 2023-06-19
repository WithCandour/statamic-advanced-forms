<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fields\Fieldtype;

class AddressLookup extends Fieldtype
{
    protected $canCreate = false;

    public function preProcess($data)
    {
        $data['postcoder_api_key'] = env('POSTCODER_API_KEY');

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
    public function view()
    {
        $default = 'statamic-advanced-forms::fieldtypes.address_lookup';

        return view()->exists($default)
            ? $default
            : 'statamic::forms.fields.default';
    }
}
