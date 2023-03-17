<?php

namespace WithCandour\StatamicAdvancedForms\Stache\Stores;

use Illuminate\Support\Facades\Cache;
use SplFileInfo;
use Statamic\Facades\YAML;
use Statamic\Stache\Stores\ChildStore;
use WithCandour\StatamicAdvancedForms\Facades\Form;
use WithCandour\StatamicAdvancedForms\Facades\Notification;

class FormNotificationsStore extends ChildStore
{
    /**
     * @inheritDoc
     */
    public function getItemFilter(SplFileInfo $file)
    {
        return $file->getExtension() === 'yaml';
    }

    public function childKey()
    {
        return 'notifications::' . $this->childKey;
    }

    /**
     * @inheritDoc
     */
    public function makeItemFromFile($path, $contents)
    {
        $formId = dirname($path, 2);
        $relative = str_after($path, $formId);
        $id = str_before($relative, '.yaml');

        $data = YAML::file($path)->parse($contents);

        $form = Form::find($formId);

        $notification = Notification::make()
            ->id($id)
            ->form($form)
            ->title($data['title']);

        return $notification;
    }

    /**
     * @inheritDoc
     */
    protected function storeIndexes()
    {
        return [
            'id',
            'form',
        ];
    }
}
