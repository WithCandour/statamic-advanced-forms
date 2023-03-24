<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP;

use Illuminate\Http\Request;
use Statamic\CP\Breadcrumbs;
use Statamic\CP\Column;
use Statamic\Facades\Action;
use Statamic\Facades\Blueprint;
use WithCandour\StatamicAdvancedForms\Contracts\Feeds\FeedTypeRepository;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;
use WithCandour\StatamicAdvancedForms\Facades\Feed as FeedFacade;
use WithCandour\StatamicAdvancedForms\Http\Requests\CP\CreateFeedRequest;

class FeedsController extends Controller
{
    public function index(string $formId)
    {
        $this->authorize('view advanced forms feeds');

        if (!$form = FormFacade::find($formId)) {
            return $this->pageNotFound();
        }

        $columns = [
            Column::make('title')->label(__('Title')),
            Column::make('type')->label(__('advanced-forms::feeds.type')),
        ];

        $feeds = \collect($form->feeds())
            ->map(function (Feed $feed) {
                return [
                    'id' => $feed->id(),
                    'title' => $feed->title(),
                    'type' => $feed->type()->title(),
                    'enabled' => $feed->enabled(),
                    'edit_url' => $feed->editUrl(),
                    'actions' => Action::for($feed)
                ];
            })->values();


        return [
            'meta' => [
                'columns' => $columns,
            ],
            'data' => $feeds,
        ];
    }

    public function create(string $formId, Request $request)
    {
        $this->authorize('create advanced forms feeds');

        if (!$form = FormFacade::find($formId)) {
            return $this->pageNotFound();
        }

        if (!$request->has('type')) {
            return $this->pageNotFound();
        }

        /**
         * @var FeedTypeRepository
         */
        $feedTypes = app(FeedTypeRepository::class);
        $selectedType = $feedTypes->find($request->get('type'));

        return view('advanced-forms::cp.feeds.create', [
            'form' => $form,
            'title' => $selectedType->createTitle(),
            'introduction' => $selectedType->createIntroduction(),
            'type' => $selectedType->handle(),
            'type_name' => $selectedType->title(),
        ]);
    }

    public function store(string $formId, CreateFeedRequest $request)
    {
        $this->authorize('create advanced forms feeds');

        if (!$form = FormFacade::find($formId)) {
            return $this->pageNotFound();
        }

        /**
         * @var Feed
         */
        $feed = FeedFacade::make();

        $feed->set('title', $request->title);
        $feed->form($form);

        $feedType = app(FeedTypeRepository::class)->find($request->type);
        $feed->type($feedType);

        $feed->save();

        session()->flash('Feed saved');

        return [
            'redirect' => $feed->editUrl(),
        ];
    }

    public function edit(string $formId, string $feedId,Request $request)
    {
        $this->authorize('edit advanced forms feeds');

        if (!$form = FormFacade::find($formId)) {
            return $this->pageNotFound();
        }

        if (!$feed = FeedFacade::find($feedId)) {
            return $this->pageNotFound();
        }

        $initialValues = \array_merge(
            ['title' => $feed->title()],
            \collect($feed->data())->toArray(),
        );

        $fields = ($blueprint = $this->editFormBlueprint($form))
            ->fields()
            ->addValues($initialValues)
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
                'text' => $feed->title(),
                'url' => $feed->editUrl(),
            ]
        ]);

        return view('advanced-forms::cp.feeds.edit', [
            'breadcrumb' => $breadcrumb,
            'blueprint' => $blueprint->toPublishArray(),
            'values' => $fields->values(),
            'meta' => $fields->meta(),
            'feed' => $feed,
            'form' => $feed->form(),
        ]);
    }

    public function update(string $formId, string $feedId, Request $request)
    {
        if (!$form = FormFacade::find($formId)) {
            return $this->pageNotFound();
        }

        if (!$feed = FeedFacade::find($feedId)) {
            return $this->pageNotFound();
        }

        $data = $request->except(['form']);

        $fields = $this->editFormBlueprint($form)->fields()->addValues($data);

        $fields->validate();
        $values = $fields->process()->values()->all();

        $feed->form($form);
        $feed->data($values);

        $feed->save();

        session()->flash('message', __('advanced-forms::forms.updated'));

        return [
            'redirect' => $form->showUrl(),
        ];
    }

    protected function editFormBlueprint(Form $form)
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
                        'display' => __('advanced-forms::feeds.enabled'),
                        'type' => 'toggle',
                        'instructions' => __('advanced-forms::feeds.enabled_instruct'),
                        'default' => true,
                    ]
                ],
            ],
        ];

        return Blueprint::makeFromSections($sections);
    }
}
