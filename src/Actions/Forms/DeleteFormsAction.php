<?php

namespace WithCandour\StatamicAdvancedForms\Actions\Forms;

use Illuminate\Support\Facades\App;
use Statamic\Actions\Action;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FormsRepository;

class DeleteFormsAction extends Action
{
        /**
     * @var FormsRepository|null
     */
    protected ?FormsRepository $repository = null;

    protected $dangerous = true;

    public static function title()
    {
        return __('Delete');
    }

    public function authorize($user, $item)
    {
        return $user->can('delete advanced forms');
    }

    public function visibleTo($item)
    {
        return $item instanceof Form;
    }

    public function visibleToBulk($items)
    {
        return \collect($items)
            ->every(function ($item) {
                return $item instanceof Form;
            });
    }

    public function confirmationText()
    {
        return __('advanced-forms::forms.delete-confirm');
    }

    public function buttonText()
    {
        return __('advanced-forms::forms.delete');
    }

    public function run($items, $values)
    {
        $items->each(function ($form) {
            $this->repository()->delete($form);
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
