<?php

namespace WithCandour\StatamicAdvancedForms\Events;

use Statamic\Contracts\Git\ProvidesCommitMessage;
use Statamic\Events\Event;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;

class AdvancedFormsFeedSaved extends Event implements ProvidesCommitMessage
{
    /**
     * @param Feed
     */
    public function __construct(
        public Feed $feed
    ) {}

    /**
     * @inheritDoc
     */
    public function commitMessage()
    {
        return 'Advanced Form feed saved';
    }
}
