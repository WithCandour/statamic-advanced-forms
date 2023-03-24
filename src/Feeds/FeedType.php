<?php

namespace WithCandour\StatamicAdvancedForms\Feeds;

use Statamic\Extend\HasHandle;
use Statamic\Extend\RegistersItself;
use Statamic\Fields\Blueprint;
use Statamic\Support\Str;
use WithCandour\StatamicAdvancedForms\Contracts\Feeds\FeedType as Contract;
use WithCandour\StatamicAdvancedForms\Contracts\Models\Form;

abstract class FeedType implements Contract
{
    use RegistersItself, HasHandle {
        handle as protected traitHandle;
    }

    protected static $title;
    protected static $binding = 'advanced_forms_feed_types';

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
        return Str::removeRight(static::traitHandle(), '_feed_type');
    }

    /**
     * @inheritDoc
     */
    public static function selectable(): bool
    {
        $disabledFeedTypes = \config('advanced-forms.disabled_feed_types', []);

        return !\in_array(self::handle(), $disabledFeedTypes);
    }

    /**
     * @inheritDoc
     */
    public function blueprint(Form $form): ?Blueprint
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function createTitle(): string
    {
        return __('advanced-forms::feeds.create');
    }

    /**
     * @inheritDoc
     */
    public function createIntroduction(): string
    {
        return __('advanced-forms::feeds.create_introduction');
    }
}
