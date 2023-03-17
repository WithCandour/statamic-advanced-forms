<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Statamic\CP\Breadcrumbs;
use Statamic\CP\Column;
use Statamic\Facades\Action;
use Statamic\Facades\Blueprint;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FormsRepository;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;
use WithCandour\StatamicAdvancedForms\Facades\Notification as NotificationFacade;

class NotificationsController extends Controller
{
    public function create(string $formId)
    {
        $this->authorize('create advanced forms notifications');

        if (!$form = FormFacade::find($formId)) {
            return $this->pageNotFound();
        }

        return view('advanced-forms::cp.notifications.create', [
            'form' => $form,
        ]);
    }

    public function store(string $formId, Request $request)
    {
        $this->authorize('create advanced forms notifications');

        if (!$form = FormFacade::find($formId)) {
            return $this->pageNotFound();
        }

        /**
         * @var Notification
         */
        $notification = NotificationFacade::make();

        $notification->title($request->title);
        $notification->form($form);

        $notification->save();

        session()->flash('Notification saved');

        return [
            'redirect' => $notification->editUrl(),
        ];
    }

    public function edit(string $notificationId, Request $request)
    {
        $this->authorize('edit advanced forms notifications');

        if (!$notification = NotificationFacade::find($notificationId)) {
            return $this->pageNotFound();
        }

        $values = [
            'title' => $notification->title(),
        ];

        $fields = ($blueprint = $this->editFormBlueprint())
            ->fields()
            ->addValues($values)
            ->preProcess();

        return view('advanced-forms::cp.notifications.edit', [
            'blueprint' => $blueprint->toPublishArray(),
            'values' => $fields->values(),
            'meta' => $fields->meta(),
            'notification' => $notification,
            'form' => $notification->form(),
        ]);
    }

    protected function editFormBlueprint()
    {
        $sections = [
            'name' => [
                'display' => __('Name'),
                'fields' => [
                    'title' => [
                        'display' => __('Title'),
                        'type' => 'text',
                        'validate' => 'required'
                    ],
                ],
            ],
        ];

        return Blueprint::makeFromSections($sections);
    }
}
