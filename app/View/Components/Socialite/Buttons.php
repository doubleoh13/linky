<?php

namespace App\View\Components\Socialite;

use Illuminate\Support\MessageBag;
use Illuminate\View\Component;
use Illuminate\View\View;

class Buttons extends Component
{
    public function __construct(public bool $showDivider = true) {}

    public function render(): View
    {
        $messageBag = new MessageBag;

        if (session()->has('socialite-login-error')) {
            $messageBag->add('error', session()->pull('socialite-login-error'));
        }

        return view('components.socialite.buttons', compact('messageBag'));
    }
}
