<x-filament-widgets::widget>
    <x-filament::section icon="heroicon-m-sparkles">
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
                        Submit
                    </x-filament::button>

                </div>
                
            </form>

            <x-filament::section>
                <div wire:loading wire:target="submit" class="loading-indicator">
                    <x-filament::loading-indicator class="h-5 w-5" />
                </div>
                <p>{{ $response }}</p>
            </x-filament::section>

            <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
            {{ $gemini }}
            </textarea>

        </div>

    </x-filament::section>
</x-filament-widgets::widget>