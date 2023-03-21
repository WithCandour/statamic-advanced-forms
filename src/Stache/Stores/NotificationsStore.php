<?php

namespace WithCandour\StatamicAdvancedForms\Stache\Stores;

use SplFileInfo;
use Statamic\Facades\Path;
use Statamic\Facades\YAML;
use Statamic\Stache\Stores\BasicStore;
use WithCandour\StatamicAdvancedForms\Contracts\Stache\Stores\NotificationsStore as Contract;
use WithCandour\StatamicAdvancedForms\Facades\Form;
use WithCandour\StatamicAdvancedForms\Facades\Notification;

class NotificationsStore extends BasicStore implements Contract
{
    /**
     * @inheritDoc
     */
    public function key()
    {
        return 'advanced-forms.notifications';
    }

    /**
     * @inheritDoc
     */
    public function getItemFilter(SplFileInfo $file)
    {
        $filename = str_after(Path::tidy($file->getPathName()), $this->directory);
        return substr_count($filename, '/') === 0 && $file->getExtension() === 'yaml';
    }

    /**
     * @inheritDoc
     */
    public function makeItemFromFile($path, $contents)
    {
        $relative = str_after($path, $this->directory);
        $id = str_before($relative, '.yaml');

        $data = YAML::file($path)->parse($contents);

        $notification = Notification::make($id);
        $notification->form(Form::find($data['form']));
        $notification->data($data);

        return $notification;
    }

    protected function storeIndexes()
    {
        return [
            'id',
            'form',
            'enabled',
        ];
    }

}
