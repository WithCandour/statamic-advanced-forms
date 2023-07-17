<?php

namespace WithCandour\StatamicAdvancedForms\Models;

use Statamic\Facades\Blueprint as BlueprintFacade;
use Statamic\Fields\Blueprint;
use Statamic\Fields\Field;
use Illuminate\Support\Collection;
use Statamic\Fieldtypes\Assets\Assets as AssetsFieldtype;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form as Contract;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Facades\Feed;
use WithCandour\StatamicAdvancedForms\Facades\Notification;
use WithCandour\StatamicAdvancedForms\Facades\Submission as SubmissionFacade;

abstract class AbstractForm implements Contract
{
    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * @inheritDoc
     */
    public function blueprint(): Blueprint
    {
        $blueprint = BlueprintFacade::find('advanced-forms.' . $this->handle()) ??
            Blueprint::makeFromFields([])->setHandle($this->handle())->setNamespace('advanced-forms');

        return $blueprint;
    }

    /**
     * @inheritDoc
     */
    public function notifications(): array
    {
        return Notification::findByForm($this)
            ->all();
    }

    /**
     * @inheritDoc
     */
    public function feeds(): array
    {
        return Feed::findByForm($this)
            ->all();
    }

    /**
     * @inheritDoc
     */
    public function hasFiles(): bool
    {
        return $this->blueprint()->fields()->all()->some(function (Field $field) {
            return $field->fieldtype() instanceof AssetsFieldtype;
        });
    }

    /**
     * @inheritDoc
     */
    public function submissions(): Collection
    {
        return collect(
            SubmissionFacade::findByForm($this)
            ->all()
        );
    }

    /**
     * @inheritDoc
     */
    public function makeSubmission(): Submission
    {
        return SubmissionFacade::make($this);
    }

    /**
     * @inheritDoc
     */
    public function showUrl(): string
    {
        return cp_route('advanced-forms.show', $this->id());
    }

    /**
     * @inheritDoc
     */
    public function actionUrl(): string
    {
        return route('statamic.advanced-forms.submit', $this->id());
    }

    /**
     * @inheritDoc
     */
    public function submissionsUrl(): string
    {
        return cp_route('advanced-forms.submissions.index', $this->id());
    }

    /**
     * @inheritDoc
     */
    public function deleteUrl(): string
    {
        return cp_route('advanced-forms.destroy', $this->id());
    }
}
