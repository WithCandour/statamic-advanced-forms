<?php

namespace WithCandour\StatamicAdvancedForms\Contracts\Models;

interface Notification
{
    /**
     * Get or set the notification ID
     *
     * @param string|null $id
     * @return string
     */
    public function id(?string $id = null);

    /**
     * Get or set the notification title.
     *
     * @return string
     */
    public function title();

    /**
     * Get whether this notification is enabled
     *
     * @return bool
     */
    public function enabled(): bool;

    /**
     * Get or set the form for this notification.
     *
     * @param Form|null
     * @return Form|void
     */
    public function form(?Form $form = null);

    /**
     * Get the edit url of the notification.
     *
     * @return string
     */
    public function editUrl(): string;

    /**
     * Get the delete url of the notification.
     *
     * @return string
     */
    public function deleteUrl(): string;

    /**
     * Save the notification.
     *
     * @return void
     */
    public function save(): self;

    /**
     * Set a data key for this notification.
     *
     * @return self
     */
    public function set($key, $value);

    /**
     * Get a data key for this notification.
     *
     * @return mixed
     */
    public function get($key, $fallback = null);

    /**
     * Send the notification.
     *
     * @param Submission $submission
     * @return void
     */
    public function send(Submission $submission): void;
}
