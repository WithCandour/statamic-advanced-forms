<?php

namespace WithCandour\StatamicAdvancedForms\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
//use WithCandour\StatamicAdvancedForms\Models\Stache\Form;
use WithCandour\StatamicAdvancedForms\Facades\Form;
use WithCandour\StatamicAdvancedForms\Facades\Submission;
use Carbon\Carbon;

class ExpireSubmissions
{
    use Dispatchable, SerializesModels, Queueable;

    public function __construct() {}

    public function handle()
    {
        $forms = Form::all();

        $forms->each(function($form) {
            if ($form->expires_entries === true) {
                $cutoff = Carbon::now()->subDays($form->entry_lifespan)->toDateTimeString();
                $submissions = \collect($form->submissions())->where('created_at', '>=', $cutoff);
                $submissions->each->delete();
            }
            else {
                return null;
            }
        });
    }
}
