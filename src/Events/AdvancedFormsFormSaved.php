<?php

namespace WithCandour\StatamicAdvancedForms\Events;

use Statamic\Contracts\Git\ProvidesCommitMessage;
use Statamic\Events\Event;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;

class AdvancedFormsFormSaved extends Event implements ProvidesCommitMessage
{
    /**
     * @param Form
     */
    public function __construct(
        public Form $form
    ) {}

    /**
     * @inheritDoc
     */
    public function commitMessage()
    {
        return 'Advanced Form saved';
    }
}
