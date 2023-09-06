<?php

namespace WithCandour\StatamicAdvancedForms\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use WithCandour\StatamicAdvancedForms\Models\Stache\Form;
use WithCandour\StatamicAdvancedForms\Facades\Submission;
use Carbon\Carbon;

class ExpireEntries
{
    use Dispatchable, SerializesModels;

    public function __construct(
        protected Form $form
    ) {}

    public function handle()
    {
        if ($this->form->expires_entries === true) {

            // specify the cutoff date based on the form entry lifespan.
            $cutoff = Carbon::now()->subDays($this->form->entry_lifespan)->toDateTimeString();

            // grab all submissions that fall within the entry lifespan of the form.
            $submissions = \collect($this->form->submissions())->where('created_at', '>=', $cutoff);

            // delete the submissions.
            return $submissions->each->delete();
        }
    }
}
