<?php

namespace App\Support\Enums;

enum AuthType: string
{
    case ApiKey = 'api_key';
    case OAuth = 'oauth';
}
