<?php

namespace WithCandour\StatamicAdvancedForms\Repositories\Eloquent;

use Illuminate\Support\Collection;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;
use WithCandour\StatamicAdvancedForms\Contracts\Models\FeedNote as FeedNoteContract;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FeedNotesRepository as Contract;
use WithCandour\StatamicAdvancedForms\Models\Eloquent\FeedNote;

class FeedNotesRepository implements Contract
{
    /**
     * @inheritDoc
     */
    public function make(Submission $submission, Feed $feed): FeedNoteContract
    {
        $note = new FeedNote();
        $note->setSubmission($submission);
        $note->setFeed($feed);

        return $note;
    }

    /**
     * @inheritDoc
     */
    public function findBySubmission(Submission $submission): Collection
    {
        return FeedNote::query()
            ->where('submission_id', $submission->id())
            ->get();
    }
}
