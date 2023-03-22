<?php

namespace WithCandour\StatamicAdvancedForms\FeedTypes;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;
use WithCandour\StatamicAdvancedForms\Feeds\FeedType;

class AdvancedFormsExampleFeedType extends FeedType
{
    /**
     * @inheritDoc
     */
    public function processSubmission(Submission $submission, Feed $feed): void
    {
        ray($submission)->orange();
        ray($feed)->green();
    }
}
