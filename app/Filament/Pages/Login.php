<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Auth\Login as FilamentLogin;

class Login extends FilamentLogin
{
    public function form(Form $form): Form
    {
        return $this->makeForm();
    }

    protected function getFormActions(): array
    {
        return [];
    }
}
