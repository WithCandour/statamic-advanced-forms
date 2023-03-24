<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

use WithCandour\StatamicAdvancedForms\Contracts\Feeds\FeedType;

interface Feed
{
    /**
     * Get or set the feed ID
     *
     * @param string|null $id
     * @return string
     */
    public function id(?string $id = null);

    /**
     * Get or set the feed title.
     *
     * @return string
     */
    public function title();

    /**
     * Get whether this feed is enabled
     *
     * @return bool
     */
    public function enabled(): bool;

    /**
     * Get or set the form for this feed.
     *
     * @param Form|null
     * @return Form|void
     */
    public function form(?Form $form = null);

    /**
     * Get or set the feed type to use for this feed.
     *
     * @param FeedType $type
     * @return FeedType|void
     */
    public function type(?FeedType $type = null);

    /**
     * Get the edit url of the feed.
     *
     * @return string
     */
    public function editUrl(): string;

    /**
     * Get the delete url of the feed.
     *
     * @return string
     */
    public function deleteUrl(): string;

    /**
     * Save the feed.
     *
     * @return void
     */
    public function save(): self;

    /**
     * Set a data key for this feed.
     *
     * @return self
     */
    public function set($key, $value);

    /**
     * Get a data key for this feed.
     *
     * @return mixed
     */
    public function get($key, $fallback = null);
}
