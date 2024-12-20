<?php

namespace App\Support\Enums;

use Filament\Support\Contracts\HasLabel;

enum ConnectionProvider: string implements HasLabel
{
    case Todoist = 'todoist';
    case Notion = 'notion';
    case Google = 'google';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Google => 'fab fa-google',
            default => null,
        };
    }
}
