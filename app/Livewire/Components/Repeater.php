<?php

namespace App\Livewire\Components;

use Filament\Forms\Components\Field;

class Repeater extends \Filament\Forms\Components\Repeater
{
    public function getSimpleField(): ?Field
    {
        return parent::getSimpleField()?->hiddenLabel(false);
    }
}
