<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP;

use Illuminate\Http\Request;
use Statamic\CP\Breadcrumbs;
use Statamic\Http\Controllers\CP\Fields\ManagesBlueprints;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;

class FieldsController extends Controller
{
    use ManagesBlueprints;

    public function index(string $id)
    {
        $this->authorize('edit advanced forms fields');

        if (!$form = FormFacade::find($id)) {
            return $this->pageNotFound();
        }

        $blueprint = $form->blueprint();

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
                'text' => __('Fields'),
                'url' => cp_route('advanced-forms.fields.edit', [$id]),
            ]
        ]);

        return view('advanced-forms::cp.fields.index', [
            'breadcrumb' => $breadcrumb,
            'form' => $form,
            'paginated' => $form->paginatedFields(),
            'blueprint' => $blueprint,
            'blueprintVueObject' => $this->toVueObject($blueprint),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $this->authorize('edit advanced forms fields');

        $request->validate(['sections' => 'array']);

        if (!$form = FormFacade::find($id)) {
            return $this->pageNotFound();
        }

        $this->updateBlueprint($request, $form->blueprint());

        $formPaginatedFields = $form->paginatedFields();

        if ($formPaginatedFields !== $request->paginated) {
            $form->paginatedFields($request->paginated);
            $form->save();
        }
    }
}
