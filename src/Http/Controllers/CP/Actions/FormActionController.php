<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP\Actions;

use Statamic\Http\Controllers\CP\Assets\ActionController;
use WithCandour\StatamicAdvancedForms\Facades\Form;

class FormActionController extends ActionController
{

    protected function getSelectedItems($items, $context)
    {
        return $items->map(function ($item) {
            return Form::find($item);
        });
    }
}
