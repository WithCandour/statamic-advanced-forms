<?php

namespace WithCandour\StatamicAdvancedForms\Tags;

use WithCandour\StatamicAdvancedForms\Tags\AdvancedFormBaseTags;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;

class AdvancedFormMetaTags extends AdvancedFormBaseTags
{
    protected static $handle = 'advanced_form_meta';

    protected ?Form $form = null;

    public $params;

    /**
     * The {{ advanced_form_meta:confirmation }} tag.
     */
    public function confirmation()
    {
        $form = $this->form();
        return $form->confirmationMessage() ?? null;
    }

    /**
     * The {{ advanced_form_meta:title }} tag.
     */
    public function title()
    {
        $form = $this->form();
        return $form->title() ?? null;
    }

    /**
     * The {{ advanced_form_meta:description }} tag.
     */
    public function description()
    {
        $form = $this->form();
        return $form->description() ?? null;
    }

    /**
     * Get first error for each field.
     *
     * @param  \Illuminate\Support\MessageBag  $messageBag
     * @return array
     */
    protected function getFirstErrorForEachField($messageBag)
    {
        return collect($messageBag->messages())
            ->map(function ($errors, $field) {
                return $errors[0];
            })
            ->all();
    }

}
