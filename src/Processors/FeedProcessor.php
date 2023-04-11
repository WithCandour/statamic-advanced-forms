<?php

namespace WithCandour\StatamicAdvancedForms\Processors;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Processors\FeedProcessor as Contract;

class FeedProcessor implements Contract
{
    /**
     * @inheritDoc
     */
    public function process(Submission $submission): void
    {
        $feedsForSubmission = \collect($submission->form()->feeds())
            ->filter(fn (Feed $feed) => $feed->enabled())
            ->filter(fn (Feed $feed) => !\in_array($feed->type()->handle(), \config('advanced-forms.disabled_feed_types', [])))
            ->values();

        $feedsForSubmission->each(function (Feed $feed) use ($submission) {
            $feed->process($submission);
        });
    }
}
