<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FormsRepository;

class FormsController extends Controller
{
    /**
     * @var FormsRepository|null
     */
    protected ?FormsRepository $repository = null;

    public function index()
    {
        $this->authorize('access advanced forms');

        return view(
            'advanced-forms::cp.forms.index',
            [
                'forms' => \collect([]),
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
            'redirect' => $form->editUrl(),
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
