<?php

namespace WithCandour\StatamicAdvancedForms\Http\Requests\Actions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class AnonymousAssetsDownloadRequest extends FormRequest
{
    /**
     * @var string|null
     */
    private ?string $key = null;

    /**
     * @var string|null
     */
    private ?string $fileId = null;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'key' => 'string|required',
        ];
    }

    /**
     * Get the download key from the request.
     *
     * @return string
     */
    public function key()
    {
        if (!$this->key) {
            $this->key = $this->get('key');
        }

        return $this->key;
    }

    /**
     * Convert the download key to a file ID
     *
     * @return string|null
     */
    public function fileId()
    {
        if (!$this->fileId) {
            try {
                $this->fileId = Crypt::decryptString($this->key());
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                $this->fileId = null;
            }
        }

        return $this->fileId;
    }
}
