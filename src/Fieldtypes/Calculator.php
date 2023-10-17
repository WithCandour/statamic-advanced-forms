<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fields\Fieldtype;

class Calculator extends Fieldtype
{
    protected $canCreate = false;
    protected $categories = ['special'];

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

    /**
     * @inheritDoc
     */
    public function selectableInForms() : bool
    {
        return 0;
    }

    public function configFieldItems(): array
    {
        return [];
    }
}
