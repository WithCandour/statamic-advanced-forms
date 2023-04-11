<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Processors;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;

interface FeedProcessor
{
    /**
     * Process all feeds for a given submission.
     *
     * @param Submission $submission
     * @return void
     */
    public function process(Submission $submission): void;
}
