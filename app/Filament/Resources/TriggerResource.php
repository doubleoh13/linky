<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TriggerResource\Pages;
use App\Livewire\Components\Repeater;
use App\Models\Action;
use App\Models\Trigger;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TriggerResource extends Resource
{
    protected static ?string $model = Trigger::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('provider')->disabled()
                    ->formatStateUsing(fn (Trigger $trigger) => $trigger->provider->getLabel())
                    ->prefixIcon(fn (Trigger $trigger) => $trigger->provider->getIcon()),
                Forms\Components\TextInput::make('event')->disabled(),
                Repeater::make('actions')
                    ->relationship('actions')
                    ->deletable(false)
                    ->addable(false)
                    ->simple(
                        Forms\Components\Checkbox::make('enabled')
                            ->label(fn (Action $action) => $action->listener)
                    ),
            ])
            ->inlineLabel()
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('provider'),
                TextColumn::make('event'),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTriggers::route('/'),
        ];
    }
}
