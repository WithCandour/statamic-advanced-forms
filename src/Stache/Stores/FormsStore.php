<?php

namespace WithCandour\StatamicAdvancedForms\Stache\Stores;

use Illuminate\Support\Facades\App;
use SplFileInfo;
use Statamic\Facades\Path;
use Statamic\Stache\Stores\BasicStore;
use WithCandour\StatamicAdvancedForms\Contracts\Repositories\FormsRepository;
use WithCandour\StatamicAdvancedForms\Contracts\Stache\Stores\FormsStore as Contract;

class FormsStore extends BasicStore implements Contract
{
        /**
     * @var FormsRepository|null
     */
    protected ?FormsRepository $repository = null;

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

        $form = $this->repository()
            ->make($handle)
            ->title($data['title'] ?? null);

        return $form;
    }

    /**
     * Get an instance of the forms repository.
     *
     * @return FormsRepository
     */
    protected function repository(): FormsRepository
    {
        if (!$this->repository) {
            $this->repository = App::make(FormsRepository::class);
        }

        return $this->repository;
    }
}
