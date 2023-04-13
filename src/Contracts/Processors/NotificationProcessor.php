<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Processors;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;

interface NotificationProcessor
{
    /**
     * Process all notifications for a given submission.
     *
     * @param Submission $submission
     * @return void
     */
    public function process(Submission $submission): void;
}
