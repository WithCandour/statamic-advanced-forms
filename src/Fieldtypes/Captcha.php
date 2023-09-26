<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fields\Fieldtype;

class Captcha extends Fieldtype
{
    protected $canCreate = false;
    protected $categories = ['special'];

    public function preProcess($data)
    {
        $data['captcha_api_key'] = env('CAPTCHA_API_KEY');

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
        return [];
    }


    /**
     * @inheritDoc
     */
    public function view()
    {
        return 'statamic-advanced-forms::fieldtypes.captcha';
    }
}
