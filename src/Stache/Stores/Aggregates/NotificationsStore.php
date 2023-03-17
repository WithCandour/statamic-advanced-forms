<?php

namespace WithCandour\StatamicAdvancedForms\Stache\Stores\Aggregates;

use Statamic\Stache\Stores\AggregateStore;
use Statamic\Support\Str;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form as FormModel;
use WithCandour\StatamicAdvancedForms\Facades\Form;
use WithCandour\StatamicAdvancedForms\Stache\Stores\FormNotificationsStore;

class NotificationsStore extends AggregateStore
{
    protected $childStore = FormNotificationsStore::class;

    public function key()
    {
        return 'advanced-forms.notifications';
    }

    public function discoverStores()
    {
        return Form::all()
            ->map(fn(FormModel $form) => $this->store($form->handle()));
    }

    public function childDirectory($child)
    {
        return $this->directory . Str::removeLeft($child->childKey(), 'notifications::') . '/notifications';
    }
}
