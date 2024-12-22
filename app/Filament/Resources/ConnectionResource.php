<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConnectionResource\Pages;
use App\Models\Connection;
use App\Support\Enums\ConnectionProvider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConnectionResource extends Resource
{
    protected static ?string $model = Connection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('provider')
                    ->disabledOn('edit')
                    ->options(
                        ConnectionProvider::getOAuthProviders()
                            ->mapWithKeys(
                                fn (ConnectionProvider $provider) => [
                                    $provider->value => $provider->getLabel(),
                                ]
                            )
                    )
                    ->unique()
                    ->validationMessages(['unique' => 'This provider is already configured'])
                    ->required()
                    ->live(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('provider')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provider_id')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('provider_avatar')
                    ->label('')
                    ->circular(),
                Tables\Columns\TextColumn::make('provider_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provider_name')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('scopes')
                    ->bulleted(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConnections::route('/'),
        ];
    }
}
