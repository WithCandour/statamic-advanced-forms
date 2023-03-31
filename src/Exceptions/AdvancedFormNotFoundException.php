<?php

namespace WithCandour\StatamicAdvancedForms\Exceptions;

use Exception;

class AdvancedFormNotFoundException extends Exception
{
    /**
     * @var string
     */
    protected string $handle;

    public function __construct(string $handle)
    {
        parent::__construct("Advanced Form [$handle] not found");

        $this->handle = $handle;
    }
}
