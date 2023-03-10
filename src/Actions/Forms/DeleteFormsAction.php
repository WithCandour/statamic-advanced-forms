<?php

namespace WithCandour\StatamicAdvancedForms\Actions\Forms;

use Statamic\Actions\Action;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;

class DeleteFormsAction extends Action
{
    protected $dangerous = true;

    public static function title()
    {
        return __('Delete');
    }

    public function authorize($user, $item)
    {
        return $user->can('delete advanced forms');
    }

    public function visibleTo($item)
    {
        return $item instanceof Form;
    }

    public function visibleToBulk($items)
    {
        return \collect($items)
            ->every(function ($item) {
                return $item instanceof Form;
            });
    }

    public function confirmationText()
    {
        return __('advanced-forms::forms.delete-confirm');
    }

    public function buttonText()
    {
        return __('advanced-forms::forms.delete');
    }

    public function run($items, $values)
    {
        $items
            ->filter()
            ->each(function ($form) {
                FormFacade::delete($form);
            });
    }
}
