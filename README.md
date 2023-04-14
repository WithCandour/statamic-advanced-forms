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
Notifications are used to send emails when form submissions are created, they build on the functionality within Statamic forms in that basic emails can be created, one addition is that users can select a field in the form to use as the "Email to" address, this allows CMS users to configure submission confirmation emails that will be sent out to the user that submitted the form.

#### Notification conditions
In addition to the basic email settings, conditional logic can be applied to notifications to determine whether they should be sent or not.

Out of the box, the addon supplies 3 different types of notification condition:
- Time of day: The notification should be sent if the current time is before/after a specified time
- Day of week: The notification should be sent if the current day is/is not listed in the condition settings
- Field value: The notification should be sent if a value in the form submission is equal to a specified value

#### Custom conditions
Custom notification condition types can be registered, they should extend the `WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleType` class and have the following methods:
- `passes(Submission $submission, ConditionOperators $operator, mixed $value = null, mixed $fields = null)`: The logic that determines whether a notification with this condition should be sent.
- `fields(Form $form)`: Additional supporting fields that will provide data for this condition when it is added to a notification
- `valueFieldSettings()`: An array of blueprint field settings that should be applied to the `value` field.
- `conditionalOperators()`: An array of `WithCandour\StatamicAdvancedForms\Notifications\Rules\ConditionOperators` values that apply to this condition.

##### Example
```php
<?php

namespace WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleTypes;

use Carbon\Carbon;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Submission;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\ConditionOperators;
use WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleType;

class DayOfWeekRuleType extends RuleType
{
    protected static $title = 'Current day';

    /**
     * @inheritDoc
     */
    public function fields(Form $form): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function conditionOperators(): array
    {
        return [
            ConditionOperators::IS,
            ConditionOperators::IS_NOT
        ];
    }

    /**
     * @inheritDoc
     */
    public function valueFieldSettings(): array
    {
        return [
            'display' => 'Day(s)',
            'type' => 'select',
            'options' => [
                '0' => 'Sunday',
                '1' => 'Monday',
                '2' => 'Tuesday',
                '3' => 'Wednesday',
                '4' => 'Thursday',
                '5' => 'Friday',
                '6' => 'Saturday'
            ],
            'multiple' => true,
        ];
    }

    /**
     * @inheritDoc
     */
    public function passes(
        Submission $submission,
        ConditionOperators $operator,
        mixed $value = null,
        mixed $fields = null
    ): bool {
        $dayOfWeek = Carbon::now()->format('l');

        $value = \is_array($value) ? \array_values($value) : [];

        if ($operator === ConditionOperators::IS) {
            return \in_array($dayOfWeek, $value);
        }

        return !\in_array($dayOfWeek, $value);
    }
}

```
