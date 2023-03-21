<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP;

use Illuminate\Http\Request;
use Statamic\CP\Breadcrumbs;
use Statamic\CP\Column;
use Statamic\Facades\Action;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;

class FormsController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('access advanced forms');

        $columns = [
            Column::make('title')->label(__('Title')),
        ];

        $forms = FormFacade::all()
            ->map(function (Form $form) {
                return [
                    'id' => $form->id(),
                    'handle' => $form->handle(),
                    'title' => $form->title(),
                    'show_url' => $form->showUrl(),
                    'actions' => Action::for($form),
                ];
            })
            ->values();

        if ($request->wantsJson()) {
            return [
                'meta' => [
                    'columns' => $columns,
                ],
                'data' => $forms,
            ];
        }

        return view(
            'advanced-forms::cp.forms.index',
            [
                'forms' => $forms,
                'initialColumns' => $columns,
                'actionUrl' => cp_route('advanced-forms.actions.run'),
            ]
        );
    }

    public function create()
    {
        $this->authorize('create advanced forms');

        return view('advanced-forms::cp.forms.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create advanced forms');

        $data = $request->validate([
            'title' => 'required',
            'handle' => 'required|alpha_dash',
        ]);

        $form = FormFacade::make($data['handle']);
        $form->title($data['title']);

        $form->save();

        session()->flash('message', __('advanced-forms::forms.created'));

        return [
            'redirect' => $form->showUrl(),
        ];
    }

    public function show($id)
    {
        $this->authorize('access advanced forms');

        if (!$form = FormFacade::find($id)) {
            return $this->pageNotFound();
        }

        $notifications = $form->notifications();

        $breadcrumb = Breadcrumbs::make([
            [
                'text' => __('advanced-forms::messages.title'),
                'url' => cp_route('advanced-forms.index'),
            ]
        ]);

        return view('advanced-forms::cp.forms.show', [
            'title' => $form->title(),
            'form' => $form,
            'notifications' => \collect($notifications),
            'notifications_initial_columns' => [
                Column::make('title')->label(__('Title')),
            ],
            'notifications_action_url' => cp_route('advanced-forms.notifications.actions.run'),
            'fields_page_count' => $form->blueprint()->sections()->count(),
            'fields_field_count' => $form->blueprint()->fields()->all()->count(),
            'breadcrumb' => $breadcrumb,
        ]);
    }

    public function edit($id)
    {
        $this->authorize('edit advanced forms');

        if (!$form = FormFacade::find($id)) {
            return $this->pageNotFound();
        }

        $breadcrumb = Breadcrumbs::make([
            [
                'text' => __('advanced-forms::messages.title'),
                'url' => cp_route('advanced-forms.index'),
            ],
            [
                'text' => $form->title(),
                'url' => $form->showUrl(),
            ]
        ]);

        return view('advanced-forms::cp.forms.edit', [
            'title' => __('advanced-forms::forms.edit'),
            'form' => $form,
            'breadcrumb' => $breadcrumb,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit advanced forms');

        if (!$form = FormFacade::find($id)) {
            return $this->pageNotFound();
        }

        $data = $request->validate([
            'title' => 'required',
        ]);

        $form->title($data['title']);

        $form->save();

        session()->flash('message', __('advanced-forms::forms.updated'));

        return [
            'redirect' => $form->showUrl(),
        ];
    }
}
