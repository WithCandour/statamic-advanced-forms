<?php

namespace WithCandour\StatamicAdvancedForms\Stache\Stores;

use SplFileInfo;
use Statamic\Facades\Path;
use Statamic\Facades\YAML;
use Statamic\Stache\Stores\BasicStore;
use WithCandour\StatamicAdvancedForms\Contracts\Stache\Stores\FeedsStore as Contract;
use WithCandour\StatamicAdvancedForms\Facades\Form;
use WithCandour\StatamicAdvancedForms\Facades\Feed;
use WithCandour\StatamicAdvancedForms\Facades\FeedType;

class FeedsStore extends BasicStore implements Contract
{
    /**
     * @inheritDoc
     */
    public function key()
    {
        return 'advanced-forms.feeds';
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

        $feed = Feed::make($id);
        $feed->form(Form::find($data['form']));
        $feed->type(FeedType::find($data['type']));
        $feed->data($data);

        return $feed;
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
