<?php

namespace WithCandour\StatamicAdvancedForms\Actions\Submissions;

use Statamic\Actions\Action;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;

class DeleteSubmissionsAction extends Action
{
    protected $dangerous = true;

    public static function title()
    {
        return __('Delete');
    }

    public function authorize($user, $item)
    {
        return $user->can('delete advanced forms submissions');
    }

    public function visibleTo($item)
    {
        return $item instanceof Submission;
    }

    public function visibleToBulk($items)
    {
        return \collect($items)
            ->every(function ($item) {
                return $item instanceof Submission;
            });
    }

    public function confirmationText()
    {
        return __('advanced-forms::submissions.delete-confirm');
    }

    public function buttonText()
    {
        return __('advanced-forms::submissions.delete');
    }

    public function run($items, $values)
    {
        $items
            ->filter()
            ->each(fn (Submission $submission) => $submission->delete());
    }
}
