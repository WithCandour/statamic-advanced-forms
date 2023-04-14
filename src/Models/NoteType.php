<?php

namespace WithCandour\StatamicAdvancedForms\Models;

enum NoteType: string
{
    case SUCCESS = 'SUCCESS';
    case ERROR = 'ERROR';
    case INFO = 'INFO';
    case WARNING = 'WARNING';
}
