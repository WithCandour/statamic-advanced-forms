<?php

namespace WithCandour\StatamicAdvancedForms\Notifications\Rules;

enum Conditions: string
{
    case IS = 'is';
    case IS_NOT = 'is_not';
    case CONTAINS = 'contains';
    case GREATER_THAN = 'greater_than';
    case LESS_THAN = 'less_than';
    case BEFORE = 'before';
    case AFTER = 'after';
}
