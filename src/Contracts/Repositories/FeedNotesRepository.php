<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Repositories;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;
use WithCandour\StatamicAdvancedForms\Contracts\Models\FeedNote;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;

interface FeedNotesRepository
{
    /**
     * Make a notifiation note for a given submission and feed.
     *
     * @param Submission $submission
     * @param Feed $feed
     * @return FeedNote
     */
    public function make(Submission $submission, Feed $feed): FeedNote;

    /**
     * Get all feed notes for a submission.
     *
     * @param Submission $submission
     * @return Collection
     */
    public function findBySubmission(Submission $submission): Collection;
}
