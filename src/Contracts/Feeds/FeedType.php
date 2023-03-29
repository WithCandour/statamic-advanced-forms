<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Feeds;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;

interface FeedType
{
    /**
     * Get the handle for this feed type.
     * @see https://github.com/statamic/cms/blob/3.4/src/Extend/HasHandle.php
     *
     * @return string
     */
    public static function handle();

    /**
     * Get the title for this feed type.
     *
     * @return string
     */
    public static function title(): string;

    /**
     * Get whether this feed type is selectable in the CMS.
     *
     * @return bool
     */
    public static function selectable(): bool;

    /**
     * Get the config sections for use in this feed type.
     *
     * @param \WithCandour\StatamicAdvancedForms\Contracts\Models\Form $form
     * @return array|null
     */
    public function configSections(Form $form): ?array;

    /**
     * Process a submission for this feed type.
     *
     * @param \WithCandour\StatamicAdvancedForms\Contracts\Models\Submission $submission
     * @param \WithCandour\StatamicAdvancedForms\Contracts\Models\Feed $feed
     * @return void
     */
    public function processSubmission(Submission $submission, Feed $feed): void;

    /**
     * Return a snippet of text to be used when creating the feed.
     *
     * @return string
     */
    public function createTitle(): string;

    /**
     * Return a snippet of intrpductory text to be used when creating the feed.
     *
     * @return string
     */
    public function createIntroduction(): string;
}
