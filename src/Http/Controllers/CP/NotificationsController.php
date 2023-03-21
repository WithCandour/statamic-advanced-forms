<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP;

use Illuminate\Http\Request;
use Statamic\CP\Breadcrumbs;
use Statamic\Facades\Blueprint;
use Statamic\Facades\YAML;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Notification;
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

    public function edit(string $formId, string $notificationId,Request $request)
    {
        $this->authorize('edit advanced forms notifications');

        if (!$form = FormFacade::find($formId)) {
            return $this->pageNotFound();
        }

        if (!$notification = NotificationFacade::find($notificationId)) {
            return $this->pageNotFound();
        }


        $fields = ($blueprint = $this->editFormBlueprint())
            ->fields()
            ->addValues($notification->data()->toArray())
            ->preProcess();

        $breadcrumb = Breadcrumbs::make([
            [
                'text' => __('advanced-forms::messages.title'),
                'url' => cp_route('advanced-forms.index'),
            ],
            [
                'text' => $form->title(),
                'url' => $form->showUrl(),
            ],
            [
                'text' => $notification->title(),
                'url' => $notification->editUrl(),
            ]
        ]);

        return view('advanced-forms::cp.notifications.edit', [
            'breadcrumb' => $breadcrumb,
            'blueprint' => $blueprint->toPublishArray(),
            'values' => $fields->values(),
            'meta' => $fields->meta(),
            'notification' => $notification,
            'form' => $notification->form(),
        ]);
    }

    public function update(string $formId, string $notificationId, Request $request)
    {
        if (!$form = FormFacade::find($formId)) {
            return $this->pageNotFound();
        }

        if (!$notification = NotificationFacade::find($notificationId)) {
            return $this->pageNotFound();
        }

        $data = $request->except(['form']);

        $fields = $this->editFormBlueprint()->fields()->addValues($data);

        $fields->validate();
        $values = $fields->process()->values()->all();

        $notification->form($form);
        $notification->data($values);

        $notification->save();

        session()->flash('message', __('advanced-forms::forms.updated'));

        return [
            'redirect' => $form->showUrl(),
        ];
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
                        'validate' => 'required',
                    ],
                    'enabled' => [
                        'display' => __('advanced-forms::notifications.enabled'),
                        'type' => 'toggle',
                        'instructions' => __('advanced-forms::notifications.enabled_instruct'),
                        'default' => true,
                    ]
                ],
            ],
        ];

        return Blueprint::makeFromSections($sections);
    }
}
