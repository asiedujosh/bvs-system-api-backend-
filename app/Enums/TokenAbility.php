<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;

enum TokenAbility: string
{
    case ISSUE_ACCESS_TOKEN = 'issue-access-token';
    case ACCESS_API = 'access-api';
}
