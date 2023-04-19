# Statamic Advanced Forms

## Requirements

This addon does require you to use a database with your Statamic site, the migrations provided by the addon will be copied to your project's database directory during the installation process.

## Installation

### Install via composer:
```
composer require withcandour/statamic-advanced-forms
```
Then publish the publishables from the service provider:
```
php artisan vendor:publish --provider="WithCandour\StatamicAdvancedForms\ServiceProvider"
```
After this is published, run `php please migrate` to create the database tables required for this addon.

### Config
After installing, a config file will be created at `config/advanced-forms.php`. This will give you control over a number of config options:

| Setting | Type       | Description                                                 |
| --------- | ---------- | ----------------------------------------------------------- |
| `stache.stores`      | Array  | The stache stores/directories used for storing forms, notifications and feeds |
| `disabled_feed_types` | Array  | An array of feed type handles which should not be available in the CMS       |
| `email_view_folder`   | String   | The directory where email views will be stored |

### Tags

The `{{ advanced_form }}` tags work in exactly the same way as the [Statamic form tags](https://statamic.dev/tags/form-create), the only difference being that the `{{ fields }}` array will need to be wrapped in a `{{ pages }}` tag to ensure the field structure on the page represents that set in the CMS.

## Concepts

### External Feeds
External feeds are used to submit form data to external systems when a submission is made through the form API, they will be processed once the form submission has been validated and the submission has been saved to the database.

#### Feed Types
Custom feed types can be registered with the addon, each feed type may provide it's own CMS blueprint for allowing users to configure the feed from the CMS, feed types must also define a `processSubmission` method which takes in a form submission and carries out the process for submitting the data to an external system.

The `configFields` method should return an array of blueprint fields which will be available in the CMS.

##### Example
In [this example feed](https://github.com/WithCandour/statamic-advanced-forms/blob/master/src/Feeds/FeedTypes/AdvancedFormsExampleFeedType.php) we have created a custom feed type which:
- Has an `address_field_field` config field allowing CMS users to configure which field in the submission should be used when processing the data
- When processing a submission:
    - Gets the value of the email address field from the submission
    - Creates an error note in the database if the field is blank
    - Takes the value and submits it to a test API endpoint
    - Creates a success note based on the response from the API
    - Creates an error note if the API request fails

Feed types should extend the `WithCandour\StatamicAdvancedForms\Feeds\FeedType` class and will need to be registered in your service provider using the `::register()` method.

### Notifications
Notifications are used to send emails when form submissions are created, they build on the functionality within Statamic forms in that basic emails can be created, one addition is that users can select a field in the form to use as the "Email to" address, this allows CMS users to configure submission confirmation emails that will be sent out to the user that submitted the form.

#### Notification conditions
In addition to the basic email settings, conditional logic can be applied to notifications to determine whether they should be sent or not.

Out of the box, the addon supplies 3 different rule types:
- Time of day: The notification should be sent if the current time is before/after a specified time
- Day of week: The notification should be sent if the current day is/is not listed in the condition settings
- Field value: The notification should be sent if a value in the form submission is equal to a specified value

#### Custom rule types
Custom notification rule types can be registered, they should extend the `WithCandour\StatamicAdvancedForms\Notifications\Rules\RuleType` class and have the following methods:
- `passes(Submission $submission, ConditionOperators $operator, mixed $value = null, mixed $fields = null)`: The logic that determines whether a notification with this condition should be sent.
- `fields(Form $form)`: Additional supporting fields that will provide data for this condition when it is added to a notification
- `valueFieldSettings()`: An array of blueprint field settings that should be applied to the `value` field.
- `conditionalOperators()`: An array of `WithCandour\StatamicAdvancedForms\Notifications\Rules\ConditionOperators` values that apply to this condition.

Custom rule types should be registered in your service provider using the `::register()` method.

##### Example
In [the `FieldValueRuleType`](https://github.com/WithCandour/statamic-advanced-forms/blob/master/src/Notifications/Rules/RuleTypes/FieldValueRuleType.php) we have created a notification rule type which:
- Has an additional `form_field` field which uses the `advanced_forms_field_select` fieldtype to allow users to select a field in the current form.
- Allows the selection of the `IS`, `IS_NOT`, `CONTAINS`, `GREATER_THAN` and `LESS_THAN` conditions.
- Sets the `value` field to a text field
- In the `passes` method:
    - Checks to see if the configured field is present in the submission values
    - Checks whether the submission values meets the criteria when comparing to the `value` assigned in the CMS

### Notes
Notes are used for both the external feeds and notifications to log helpful information and show it in the CMS, for example:
- Showing whether a notification was successfully sent
- Displaying data from a response received when the submission was sent to a third-party system in a configured external feed.

#### Creating a note in an external feed
Notes should be created in the `process()` method of your custom feed type, there are two methods on our `submission` class (`makeNoteForFeed` and `makeNoteForNotification`) which can be used to get a new note model, this can then be built on using `setNoteType` (indicating the status of the note) and `setNote` which will simply take in a string value.

Markdown may be used in note text, it will automatically be formatted when displayed in the CMS.

##### Example
In the example below we:
- Call the `makeNoteForFeed` method to create a new note model and automatically assign it to this feed
- Set the note type (this can be any of the enum values in the [`NoteType`](https://github.com/WithCandour/statamic-advanced-forms/blob/master/src/Models/NoteType.php) enum)
- Set a string value as our note
- Call `save` to save these values to the database

```php
$submission
    ->makeNoteForFeed($feed)
    ->setNoteType(NoteType::SUCCESS)
    ->setNote("My note text")
    ->save();
```