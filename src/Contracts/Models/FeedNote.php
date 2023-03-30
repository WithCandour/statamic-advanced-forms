<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

interface FeedNote extends Note
{
    /**
     * Get the feed for this note.
     *
     * @return Feed
     */
    public function feed(): Feed;

    /**
     * Set the feed for this note.
     *
     * @param Feed $feed
     * @return self
     */
    public function setFeed(Feed $feed): self;
}
