<?php

namespace WithCandour\StatamicAdvancedForms\Http\Controllers\Actions;

use Statamic\Facades\AssetContainer;
use Statamic\Http\Controllers\Controller;
use WithCandour\StatamicAdvancedForms\Http\Requests\Actions\AnonymousAssetsDownloadRequest;

class AnonymousAssetsDownloadController extends Controller
{
    /**
     * Download an anonymized file
     */
    public function download(AnonymousAssetsDownloadRequest $request)
    {
        $this->authorize('download advanced forms anonymous assets');

        $fileId = $request->fileId();

        if (!$fileId) {
            return abort(404);
        }

        [$container_id, $path] = explode('::', $fileId);

        $parts = explode('/', $path);
        $filename = end($parts);

        /**
         * @var \Statamic\Contracts\Assets\AssetContainer|null
         */
        $container = AssetContainer::find($container_id);

        if (!$container) {
            return abort(404);
        }

        $disk = $container->disk();

        $assetExists = $disk->exists($path);

        if (!$assetExists) {
            return abort(404);
        }

        $headers = [
            'Content-type' => $disk->mimeType($path),
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return response($disk->get($path), 200, $headers);

    }
}
