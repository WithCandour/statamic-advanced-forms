<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP;

use Illuminate\Http\Request;
use Statamic\CP\Breadcrumbs;
use Statamic\CP\Column;
use Statamic\Facades\Action;
use WithCandour\StatamicAdvancedForms\Contracts\Feeds\FeedTypeRepository;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use Statamic\Facades\Search;

class FormsController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('access advanced forms');

        $columns = [
            Column::make('title')->label(__('Title')),
            Column::make('submissions')->label(__('Entries')),
        ];

        $forms = FormFacade::all()
            ->map(function (Form $form) {
                return [
                    'id' => $form->id(),
                    'handle' => $form->handle(),
                    'title' => $form->title(),
                    'submissions' => collect($form->submissions())->count(),
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

    public function apiSearch(Request $request)
    {
        $this->authorize('access advanced forms');
        
        $forms = FormFacade::all()
            ->map(function (Form $form) {
                return [
                    'id' => $form->id(),
                    'handle' => $form->handle(),
                    'title' => $form->title(),
                    'show_url' => $form->showUrl(),
                    'actions' => Action::for($form),
                ];
            })->filter(function ($item) use ($request) {
                return false !== stristr($item['title'], $request['params']['q']);
            });

        return $forms;
    }

    public function create()
    {
        $this->authorize('create advanced forms');

        return view('advanced-forms::cp.forms.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create advanced forms');

        $request->validate([
            'title' => 'required',
            'handle' => 'required|alpha_dash',
        ]);

        $data = $request;

        $form = FormFacade::make($data['handle']);
        $form->title($data['title']);
        $form->description($data['description']);
        $form->confirmationMessage($data['confirmationMessage']);
        $form->expiresEntries($data['expiresEntries']);
        $form->entryLifespan($data['entryLifespan']);

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
        $feeds = $form->feeds();
        $submissions = $form->submissions();

        $breadcrumb = Breadcrumbs::make([
            [
                'text' => __('advanced-forms::messages.title'),
                'url' => cp_route('advanced-forms.index'),
            ]
        ]);


        /**
         * @var FeedTypeRepository
         */
        $feedTypes = app(FeedTypeRepository::class);
        $selectableFeedTypes = $feedTypes
            ->selectable()
            ->sortBy(fn (string $feedType) => $feedType::title())
            ->map(function (string $feedType, string $handle) {
                return [
                    'title' => $feedType::title(),
                    'handle' => $handle
                ];
            })
            ->values()
            ->toArray();

        return view('advanced-forms::cp.forms.show', [
            'title' => $form->title(),
            'form' => $form,
            'notifications' => \collect($notifications),
            'feeds' => \collect($feeds),
            'submissions' => \collect($submissions),
            'expires_entries' => $form->expiresEntries(),
            'entry_lifespan' => $form->entryLifespan(),
            'description' => $form->description(),
            'confirmation_message' => $form->confirmationMessage(),
            'notifications_initial_columns' => [
                Column::make('title')->label(__('Title')),
            ],
            'feeds_initial_columns' => [
                Column::make('title')->label(__('Title')),
            ],
            'submissions_initial_columns' => [
                Column::make('date')->label(__('Date')),
            ],
            'notifications_action_url' => cp_route('advanced-forms.notifications.actions.run'),
            'feeds_action_url' => cp_route('advanced-forms.feeds.actions.run'),
            'submissions_action_url' => cp_route('advanced-forms.submissions.actions.run'),
            'fields_page_count' => $form->blueprint()->tabs()->first()->sections()->count(),
            'fields_field_count' => $form->blueprint()->fields()->all()->count(),
            'feed_types' => $selectableFeedTypes,
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

        $request->validate([
            'title' => 'required'
        ]);

        $data = $request;

        $form->title($data['title']);
        $form->description($data['description']);
        $form->confirmationMessage($data['confirmationMessage']);
        $form->expiresEntries($data['expiresEntries']);
        $form->entryLifespan($data['entryLifespan']);

        $form->save();

        session()->flash('message', __('advanced-forms::forms.updated'));

        return [
            'redirect' => $form->showUrl(),
        ];
    }
}
