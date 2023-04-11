<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface Submission
{
    /**
     * Get the id of the submission.
     *
     * @return int
     */
    public function id(): int;

    /**
     * Get the date the submission was created.
     *
     * @return Carbon
     */
    public function date(): Carbon;

    /**
     * Get the form for this submission.
     *
     * @return Form|null
     */
    public function form(): ?Form;

    /**
     * Set the form for this submission.
     *
     * @param Form $form
     * @return self
     */
    public function setForm(Form $form): self;

    /**
     * Determine whether this submission belongs to a given form.
     *
     * @param Form $form
     * @return bool
     */
    public function belongsToForm(Form $form): bool;

    /**
     * Create a values model for this submission.
     *
     * @return SubmissionValues
     */
    public function makeValues(): SubmissionValues;

    /**
     * Get a submission values model for this submission.
     *
     * @return SubmissionValues|null
     */
    public function values(): ?SubmissionValues;

    /**
     * Upload the files for a given submission.
     *
     * @param array $files
     * @return array
     */
    public function uploadFiles($files): array;

    /**
     * Create a notification note for this submission.
     *
     * @param Notification $notification
     * @return NotificationNote
     */
    public function makeNoteForNotification(Notification $notification): NotificationNote;

    /**
     * Get all notification notes for this submission.
     *
     * @return Collection
     */
    public function notificationNotes(): Collection;

    /**
     * Create a feed note for this submission.
     *
     * @param Feed $feed
     * @return FeedNote
     */
    public function makeNoteForFeed(Feed $feed): FeedNote;

    /**
     * Get all feed notes for this submission.
     *
     * @return Collection
     */
    public function feedNotes(): Collection;

    /**
     * Get the show url of the submission.
     *
     * @return string
     */
    public function showUrl(): string;

    /**
     * Get the delete url of the submission.
     *
     * @return string
     */
    public function deleteUrl(): string;

    /**
     * Save the submission.
     *
     * @param array $options
     * @return self
     */
    public function save(array $options = []);

    /**
     * Delete the submission.
     *
     * @return void
     */
    public function delete();
}
