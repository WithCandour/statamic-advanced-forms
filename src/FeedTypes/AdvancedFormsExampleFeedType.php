<?php

namespace WithCandour\StatamicAdvancedForms\FeedTypes;

use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Feed;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Feeds\FeedType;

class AdvancedFormsExampleFeedType extends FeedType
{
    /**
     * @inheritDoc
     */
    public function processSubmission(Submission $submission, Feed $feed): void
    {
        ray($submission)->orange();
        ray($feed)->green();
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
                    'mapped_fields' => [
                        'display' => 'Mapped Fields',
                        'type' => 'grid',
                        'fields' => [
                            [
                                'handle' => 'form_field',
                                'field' => [
                                    'display' => 'Form Field',
                                    'type' => 'advanced_forms_field_select',
                                    'form' => $form->id(),
                                ],
                            ],
                            'feed_field' => [
                                'handle' => 'feed_field',
                                'field' => [
                                    'display' => "Feed Field",
                                    'type' => 'text',
                                ],
                            ],
                        ]
                    ],
                ]
            ],
            'configuration' => [
                'display' => 'Configuration',
                'fields' => [
                    'environment' => [
                        'display' => 'Environment',
                        'type' => 'select',
                        'options' => [
                            'sandbox' => 'Sandbox',
                            'production' => 'Production',
                        ],
                        'validate' => 'required'
                    ]
                ]
            ]
        ];
    }
}
