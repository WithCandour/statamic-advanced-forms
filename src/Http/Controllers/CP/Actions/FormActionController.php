<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\CP\Actions;

use Illuminate\Support\Facades\App;
use Statamic\Http\Controllers\CP\Assets\ActionController;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FormsRepository;

class FormActionController extends ActionController
{
    /**
     * @var FormsRepository|null
     */
    protected ?FormsRepository $repository = null;

    protected function getSelectedItems($items, $context)
    {
        return $items->map(function ($item) {
            return $this->repository()->find($item);
        });
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
