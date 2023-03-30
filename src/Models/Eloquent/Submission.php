<?php

namespace WithCandour\StatamicAdvancedForms\Models\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission as Contract;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;

class Submission extends Model implements Contract
{
    use HasTimestamps;

    const UPDATED_AT = null;

    protected $table = 'advanced_forms_submissions';

    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * @inheritDoc
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function date(): Carbon
    {
        return new Carbon($this->created_at);
    }

    /**
     * @inheritDoc
     */
    public function form(): ?Form
    {
        return FormFacade::find($this->form_id);
    }

    /**
     * @inheritDoc
     */
    public function setForm(Form $form): self
    {
        $this->form_id = $form->id();
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function showUrl(): string
    {
        return cp_route(
            'advanced-forms.submissions.show',
            [
                'advanced_form' => $this->form()->id(),
                'submission' => $this->id(),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function deleteUrl(): string
    {
        return cp_route(
            'advanced-forms.notifications.destroy',
            [
                'advanced_form' => $this->form()->id(),
                'submission' => $this->id(),
            ]
        );
    }
}
