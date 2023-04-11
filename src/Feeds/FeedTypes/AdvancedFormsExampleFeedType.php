<?php

namespace WithCandour\StatamicAdvancedForms\Feeds\FeedTypes;

use Illuminate\Support\Facades\Http;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Feeds\FeedType;
use WithCandour\StatamicAdvancedForms\Models\NoteType;

class AdvancedFormsExampleFeedType extends FeedType
{
    /**
     * @inheritDoc
     */
    public function processSubmission(Submission $submission, Feed $feed): void
    {
        $emailAddressField = $feed->get('email_address_field');

        if (!$emailAddressField) {
            $submission->makeNoteForFeed($feed)
                ->setNoteType(NoteType::ERROR)
                ->setNote('Email address field not set.')
                ->save();

            return;
        }

        $emailAddress = $submission->values()->get($emailAddressField);

        if (!$emailAddress) {
            $submission->makeNoteForFeed($feed)
                ->setNoteType(NoteType::ERROR)
                ->setNote('Email address value not found in submission')
                ->save();

            return;
        }

        try {
            $response = Http::patch('https://jsonplaceholder.typicode.com/posts/1', [
                'body' => [
                    'email_address' => $emailAddress,
                ]
            ]);

            ray($response)->green();

            $responseNote = <<<STRING
            **Added email address as post body!**

            Response:
            ```
            {$response->body()}
            ```
            STRING;

            $submission
                ->makeNoteForFeed($feed)
                ->setNoteType(NoteType::SUCCESS)
                ->setNote($responseNote)
                ->save();

        } catch (\Exception $e) {
            $submission->makeNoteForFeed($feed)
                ->setNoteType(NoteType::ERROR)
                ->setNote('There was an error with the API call.')
                ->save();
        }

    }

    /**
     * @inheritDoc
     */
    public function configSections(Form $form): ?array
    {
        return [
            'mapped_fields' => [
                'display' => 'Mapped fields',
                'fields' => [
                    'email_address_field' => [
                        'display' => 'Email Address Field',
                        'type' => 'advanced_forms_field_select',
                        'form' => $form->id(),
                        'max_items' => 1,
                        'validate' => 'required',
                    ],
                ]
            ],
        ];
    }
}
