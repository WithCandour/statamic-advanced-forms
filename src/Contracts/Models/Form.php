<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

use Illuminate\Support\Collection;
use Statamic\Fields\Blueprint;

interface Form
{
    /**
     * Get the form ID
     *
     * @return string
     */
    public function id(): string;

    /**
     * Get or set the form handle.
     *
     * @param string|null $handle
     * @return string|void
     */
    public function handle(?string $handle = null);

    /**
     * Get or set the form title.
     *
     * @param string|null $title
     * @return string|void
     */
    public function title(?string $title = null);

    /**
     * Get or set the form description.
     *
     * @param string|null $description
     * @return string|void
     */
    public function description(?string $description = null);

    /**
     * Get the form fields blueprint.
     *
     * @return \Statamic\Fields\Blueprint
     */
    public function blueprint(): Blueprint;

    /**
     * Get a list of notifications for this form.
     *
     * @return \WithCandour\StatamicAdvancedForms\Contracts\Models\Notification[]
     */
    public function notifications(): array;

    /**
     * Get a list of feeds for this form.
     *
     * @return \WithCandour\StatamicAdvancedForms\Contracts\Models\Feed[]
     */
    public function feeds(): array;

    /**
     * Get or set whether the fields are paginated for this form.
     *
     * @param bool|null $value
     * @return bool|void
     */
    public function paginatedFields(?bool $value = null);

    /**
     * Determine whether this form contains file fields.
     *
     * @return bool
     */
    public function hasFiles(): bool;

    /**
     * Get the submissions for this form.
     *
     * @return \WithCandour\StatamicAdvancedForms\Contracts\Models\Submission[]
     */
    public function submissions(): Collection;

    /**
     * Create a submission for this form.
     *
     * @return Submission
     */
    public function makeSubmission(): Submission;

    /**
     * Get the show url of the form.
     *
     * @return string
     */
    public function showUrl(): string;

    /**
     * Get the delete url of the form.
     *
     * @return string
     */
    public function deleteUrl(): string;

    /**
     * Get the action url of the form.
     *
     * @return string
     */
    public function actionUrl(): string;

    /**
     * Get the submissions url for this form.
     *
     * @return string
     */
    public function submissionsUrl(): string;

    /**
     * Save the form.
     *
     * @return void
     */
    public function save(): self;
}
