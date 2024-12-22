<?php

namespace App\Support\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Collection;

enum ConnectionProvider: string implements HasIcon, HasLabel
{
    case Google = 'google';
    case Notion = 'notion';
    case Todoist = 'todoist';

    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Google => 'simpleicon-google',
            self::Notion => 'simpleicon-notion',
            self::Todoist => 'simpleicon-todoist'
        };
    }

    public function isOAuth(): bool
    {
        return $this === self::Google;
    }

    /**
     * @return Collection<int, self>
     */
    public static function getOAuthProviders(): Collection
    {
        return collect(self::cases())->filter(fn (self $provider) => $provider->isOAuth())->values();
    }
}
