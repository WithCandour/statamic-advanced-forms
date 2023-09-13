<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes;

use Statamic\Fields\Fieldtype;

class DividerField extends Fieldtype
{
    protected $categories = ['special'];
    
    public function configFieldItems(): array
    {
        return [];
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
        $default = 'statamic-advanced-forms::fieldtypes.divider_field';

        return view()->exists($default)
            ? $default
            : 'statamic::forms.fields.default';
    }
}
