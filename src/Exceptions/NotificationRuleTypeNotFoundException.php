<?php

namespace WithCandour\StatamicAdvancedForms\Exceptions;

use Exception;

class NotificationRuleTypeNotFoundException extends Exception
{
    /**
     * @var string
     */
    protected string $type;

    public function __construct(string $type)
    {
        parent::__construct("Notification Rule Type [$type] not found");

        $this->type = $type;
    }
}
