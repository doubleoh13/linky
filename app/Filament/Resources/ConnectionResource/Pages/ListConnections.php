<?php

namespace App\Filament\Resources\ConnectionResource\Pages;

use App\Filament\Resources\ConnectionResource;
use App\Support\Enums\ConnectionProvider;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListConnections extends ListRecords
{
    protected static string $resource = ConnectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->createAnother(false)
                ->successNotification(null)
                ->using(function (array $data) {
                    $provider = ConnectionProvider::from($data['provider']);
                    if (! $provider->isOAuth()) {
                        Notification::make()
                            ->title('Not a valid OAuth provider')
                            ->danger()
                            ->send();
                    }

                    $this->redirect(route('oauth.redirect', ['service' => $provider->value]));
                }),

        ];
    }
}
