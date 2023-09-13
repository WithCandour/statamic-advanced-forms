<?php

namespace WithCandour\StatamicAdvancedForms\Stache\Stores;

use SplFileInfo;
use Statamic\Facades\Path;
use Statamic\Facades\YAML;
use Statamic\Stache\Stores\BasicStore;
use WithCandour\StatamicAdvancedForms\Contracts\Stache\Stores\FormsStore as Contract;
use WithCandour\StatamicAdvancedForms\Facades\Form;

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

        $data = YAML::file($path)->parse($contents);

        $form = Form::make($handle)
            ->title($data['title'] ?? null);

        $form->paginatedFields($data['paginated_fields']);

        $form->expiresEntries($data['expires_entries'] ?? null);

        $form->entryLifespan($data['entry_lifespan'] ?? null);

        return $form;
    }

}
