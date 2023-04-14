# Statamic Advanced Forms

## Requirements

This addon does required you to use a database with your Statamic site, the migrations provided by the addon will be copied to your project's database directory during the installation process.

## Installation

#### Install via composer:
```
composer require withcandour/statamic-advanced-forms
```
Then publish the publishables from the service provider:
```
php artisan vendor:publish --provider="WithCandour\StatamicAdvancedForms\ServiceProvider"
```

#### Install via CP
Or alternatively search for us in the `Tools > Addons` section of the Statamic control panel.

### Config
After installing, a config file will be created at `config/advanced-forms.php`. This will give you control over a number of config options:

| Setting | Type       | Description                                                 |
| --------- | ---------- | ----------------------------------------------------------- |
| `stache.stores`      | Array  | The stache stores/directories used for storing forms, notifications and feeds |
| `disabled_feed_types` | Array  | An array of feed type handles which should not be available in the CMS       |
| `email_view_folder`   | String   | The directory where email views will be stored |

### Tags

The `{{ advanced_form }}` tags work in exactly the same way as the [Statamic form tags](https://statamic.dev/tags/form-create). 

## Concepts

### External Feeds
External feeds are used to submit form data to external systems when a submission is made through the form API, they will be processed once the form submission has been validated and the submission has been saved to the database.

#### Feed Types
Custom feed types can be registered with the addon, each feed type may provide it's own CMS blueprint for allowing users to configure the feed from the CMS, feed types must also define a `processSubmission` method which takes in a form submission and carries out the process for submitting the data to an external system.

The `configFields` method should return an array of blueprint fields which will be available in the CMS.

##### Example
In the example we have created a custom feed type which:
- Has an `address_field_field` config field allowing CMS users to configure which field in the submission should be used when processing the data
- When processing a submission:
    - Gets the value of the email address field from the submission
    - Creates an error note in the database if the field is blank
    - Takes the value and submits it to a test API endpoint
    - Creates a success note based on the response from the API
    - Creates an error note if the API request fails

```php
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
```

Feed types should extend the `WithCandour\StatamicAdvancedForms\Feeds\FeedType` class and can be registered in your service provider (in the same way as you'd register a custo field type).

### Notifications

#### Notification conditions

### Notes