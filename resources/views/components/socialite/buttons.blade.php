@php use Filament\Support\Colors\Color; @endphp
<div class="flex flex-col gap-y-6">
    @if ($messageBag->isNotEmpty())
        @foreach($messageBag->all() as $value)
            <p class="fi-fo-field-wrp-error-message text-danger-600 dark:text-danger-400">{{ __($value) }}</p>
        @endforeach
    @endif

    @if($showDivider)
        <div class="relative flex items-center justify-center text-center">
            <div class="absolute border-t border-gray-200 w-full h-px"></div>
            <p class="inline-block relative bg-white text-sm p-2 rounded-full font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-100">
                Log in via
            </p>
        </div>
    @endif

    <div class="grid  gap-4">
        <x-filament::button
            :color="Color::Gray"
            :outlined="true"
            icon="fab-google"
            tag="a"
            :href="route('auth.redirect')"
            :spa-mode="false"
        >
            Google
        </x-filament::button>
    </div>
</div>
