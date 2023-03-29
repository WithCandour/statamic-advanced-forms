<?php

namespace WithCandour\StatamicAdvancedForms\Notifications\Rules;

use Statamic\Extend\HasHandle;
use Statamic\Extend\RegistersItself;
use Statamic\Support\Str;
use WithCandour\StatamicAdvancedForms\Contracts\Notifications\Rules\RuleType as Contract;

abstract class RuleType implements Contract
{
    use RegistersItself, HasHandle {
        handle as protected traitHandle;
    }

    protected static $title;
    protected static $binding = 'advanced_forms_notification_rule_types';

    /**
     * @inheritDoc
     */
    public static function title(): string
    {
        if (static::$title) {
            return static::$title;
        }

        return Str::title(Str::humanize(static::handle()));
    }

    /**
     * @inheritDoc
     */
    public static function handle()
    {
        return Str::removeRight(static::traitHandle(), '_rule_type');
    }
}
