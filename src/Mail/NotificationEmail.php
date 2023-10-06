<?php

namespace WithCandour\StatamicAdvancedForms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;

class NotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        protected Notification $notification,
        protected Submission $submission
    ) {}

    public function build()
    {
        $form = $this->submission->form();
        $formName = $form->title();

        $this
            ->subject($this->notification->get('email_subject', "New Advanced Forms Submission for {$formName}"))
            ->from($this->notification->get('send_from_email'))
            ->addData()
            ->addToAddress()
            ->addCcAddress()
            ->addBccAddress()
            ->addView();
    }

    /**
     * Add the data to the email.
     *
     * @return self
     */
    protected function addData(): self
    {
        $type = $this->notification->get('content_type', 'fields');

        switch($type) {
            case 'fields':
                $data = $this->getFields();
                break;
            case 'content':
                $data = $this->getContent();
        }

        return $this->with($data);
    }

    /**
     * Get the submission fields for the notification.
     *
     * @return array
     */
    protected function getFields(): array
    {
        $augmented = $this->submission->values()?->toAugmentedArray() ?? [];

        $data = [
            'fields' => $this->getRenderableFieldData($augmented),
            'date' => now(),
        ];

        return $data;
    }

    /**
     * Get the content for the notification.
     *
     * @return array
     */
    protected function getContent(): array
    {
        $data = [
            'content' => $this->notification->get('notification_content'),
            'date' => now(),
        ];

        return $data;
    }

    /**
     * Add the "to" address for this notification email.
     *
     * @return self
     */
    public function addToAddress(): self
    {
        $type = $this->notification->get('send_to_type', 'email');

        $values = $this->submission->values();

        switch($type) {
            case 'form_field':
                $this->to($values->get($this->notification->get('send_to_field')));
                break;
            case 'email':
            default:
                $this->to($this->notification->get('send_to_email'));
        }

        return $this;
    }

    /**
     * Add the "cc" address for this notification email.
     *
     * @return self
     */
    public function addCcAddress(): self
    {
        $this->cc($this->notification->get('cc_email'));

        return $this;
    }

     /**
     * Add the "bcc" address for this notification email.
     *
     * @return self
     */
    public function addBccAddress(): self
    {
        $this->bcc($this->notification->get('bcc_email'));

        return $this;
    }

    /**
     * Set the view for this email to render.
     *
     * @return self
     */
    public function addView(): self
    {
        $type = $this->notification->get('content_type', 'fields');

        switch($type) {
            case 'fields':
                $default = 'advanced-forms::email.default';
                break;
            case 'content':
                $default = 'advanced-forms::email.default_content';
        }

        $this->view($this->notification->get('html_view') ?? $default);

        return $this;
    }

    /**
     * Get a renderable form of the submission values
     *
     * @param array $values
     * @return array
     */
    protected function getRenderableFieldData($values)
    {
        return collect($values)->map(function ($value, $handle) {
            $field = $value->field();
            $display = $field->display();
            $fieldtype = $field->type();
            $config = $field->config();

            return compact('display', 'handle', 'fieldtype', 'config', 'value');
        })->values();
    }

}
