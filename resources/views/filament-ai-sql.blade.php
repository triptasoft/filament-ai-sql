<x-filament-widgets::widget>
    <x-filament::section icon="heroicon-m-sparkles" collapsible>
        <x-slot name="heading">
            AI Assistant
        </x-slot>
        <x-slot name="description">
            Ask everything to AI Assistant.
        </x-slot>

        <div class="space-y-4">

            <form wire:submit.prevent="submit">

                <div class="space-y-4">

                    <x-filament::input.wrapper suffix-icon="heroicon-m-sparkles">
                        <x-filament::input
                            type="text"
                            wire:model="query" />
                    </x-filament::input.wrapper>

                    <x-filament::button icon="heroicon-m-sparkles" type="submit">
                        Ask
                    </x-filament::button>

                </div>

            </form>

            <x-filament::section>
                <x-slot name="heading">
                    <p class="float-left break-words text-xs">Answer</p>
                </x-slot>
                <x-slot name="headerEnd">
                    @if ($sql)
                    <x-filament::modal icon="heroicon-o-information-circle">
                        <x-slot name="trigger">
                            <x-filament::icon-button icon="heroicon-m-code-bracket" size="xs" tooltip="Show SQL" />
                        </x-slot>
                        <x-slot name="heading">
                            Generated SQL
                        </x-slot>
                        <p class="break-words text-sm">
                            {{ $sql }}
                        </p>
                    </x-filament::modal>
                    @endif
                </x-slot>
                <div wire:loading wire:target="submit" class="loading-indicator">
                    <x-filament::loading-indicator class="h-5 w-5" />
                </div>
                <p class="break-words text-sm">{!! $response !!}</p>

            </x-filament::section>

        </div>

    </x-filament::section>
</x-filament-widgets::widget>