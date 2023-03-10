<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Statamic\CP\Column;
use Statamic\Facades\Action;
use Statamic\Facades\User;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FormsRepository;

class FormsController extends Controller
{
    /**
     * @var FormsRepository|null
     */
    protected ?FormsRepository $repository = null;

    public function index(Request $request)
    {
        $this->authorize('access advanced forms');

        $columns = [
            Column::make('title')->label(__('Title')),
        ];

        $forms = $this->repository()
            ->all()
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
                'data' => $forms
            ];
        }

        return view(
            'advanced-forms::cp.forms.index',
            [
                'forms' => $forms,
                'initialColumns' => $columns,
                'actionUrl' => cp_route('advanced-forms.forms.actions.run'),
            ]
        );
    }

    public function create()
    {
        return view(
            'advanced-forms::cp.forms.create',
            [

            ]
        );
    }

    public function store(Request $request)
    {
        $this->authorize('create advanced forms');

        $data = $request->validate([
            'title' => 'required',
            'handle' => 'required|alpha_dash',
        ]);

        $form = $this->repository()->make($data['handle']);
        $form->title($data['title']);

        $form->save();

        session()->flash('message', __('advanced-forms::forms.created'));

        return [
            'redirect' => $form->showUrl(),
        ];
    }

    /**
     * Get an instance of the forms repository.
     *
     * @return FormsRepository
     */
    protected function repository(): FormsRepository
    {
        if (!$this->repository) {
            $this->repository = App::make(FormsRepository::class);
        }

        return $this->repository;
    }
}
