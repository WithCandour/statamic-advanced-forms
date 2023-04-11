<?php

namespace WithCandour\StatamicAdvancedForms\Events;

use Statamic\Events\Event;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;

class AdvancedFormSubmitting extends Event
{
    public Form $form;

    public array $values;

    public function __construct(Form $form, array $values)
    {
        $this->form = $form;
        $this->values = $values;
    }
}
