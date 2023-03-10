<?php

namespace WithCandour\StatamicAdvancedForms\Stache\Stores;

use SplFileInfo;
use Statamic\Facades\Path;
use Statamic\Stache\Stores\BasicStore;
use WithCandour\StatamicAdvancedForms\Contracts\Stache\Stores\FormsStore as Contract;
use WithCandour\StatamicAdvancedForms\Facades\Form as FormFacade;

class FormsStore extends BasicStore implements Contract
{
    /**
     * @inheritDoc
     */
    public function key()
    {
        return 'advanced-forms.forms';
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
        $handle = str_before($relative, '.yaml');

        $form = FormFacade::make($handle)
            ->title($data['title'] ?? null);

        return $form;
    }

}
