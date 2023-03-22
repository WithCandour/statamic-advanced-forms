<?php

namespace WithCandour\StatamicAdvancedForms\Exceptions;

use Exception;

class FeedTypeNotFoundException extends Exception
{
    /**
     * @var string
     */
    protected string $feedType;

    public function __construct(string $feedType)
    {
        parent::__construct("Feed Type [$feedType] not found");

        $this->feedType = $feedType;
    }
}
