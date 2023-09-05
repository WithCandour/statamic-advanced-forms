<?php

namespace WithCandour\StatamicAdvancedForms\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Facades\Submission;

class ExpireNotifications
{
    use Dispatchable, SerializesModels;

    public function __construct(
        protected Form $form
    ) {}

    public function handle()
    {
        return Submission::findByForm($this->form);
        // check if form has expires entries set.

        // 
    }
}
