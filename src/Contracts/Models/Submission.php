<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

use Carbon\Carbon;

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
     * Get a submission values model for this submission.
     *
     * @return SubmissionValues
     */
    public function values(): SubmissionValues;

    /**
     * Create a notification note for this submission.
     *
     * @param Notification $notification
     * @return NotificationNote
     */
    public function createNoteForNotification(Notification $notification): NotificationNote;

    /**
     * Get all notification notes for this submission.
     *
     * @return NotificationNote[]
     */
    public function notificationNotes(): array;

    /**
     * Create a feed note for this submission.
     *
     * @param Feed $feed
     * @return FeedNote
     */
    public function createNoteForFeed(Feed $feed): FeedNote;

    /**
     * Get all feed notes for this submission.
     *
     * @return FeedNote[]
     */
    public function feedNotes(): array;

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
     * @return void
     */
    public function save(): self;

    /**
     * Delete the submission.
     *
     * @return void
     */
    public function delete(): void;
}
