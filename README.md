# Statamic Advanced Forms

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
