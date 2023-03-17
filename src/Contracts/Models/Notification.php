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
     * @param string|null $handle
     * @return string|void
     */
    public function title(?string $title = null);

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
}
