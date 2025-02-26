@php
    $title = $notification->getTitle();
    $body = $notification->getBody();
    $actions = $notification->getActions();
    $color = $notification->getColor();

    $colorClasses = \Illuminate\Support\Arr::toCssClasses(['flex items-center border border-transparent px-6 py-2 gap-4', 'bg-white text-gray-950 dark:bg-white/5 dark:text-white' => $color === 'gray', 'bg-custom-600 text-white dark:bg-custom-500' => $color !== 'gray']);

    $colorStyles = \Illuminate\Support\Arr::toCssStyles([
        \Filament\Support\get_color_css_variables($color, shades: [400, 500, 600]) => $color !== 'gray',
    ]);
@endphp

<div class="{{ $colorClasses }}" style="{{ $colorStyles }}">
    @if ($icon = $notification->getIcon())
        <div class="flex items-center">
            <x-filament::icon icon="{{ $icon }}" class="h-6 w-6" />
        </div>
    @endif
    <div @class([
        'w-full flex-1',
    ])>
        @if ($title && ! $body && $actions)
            <div class="flex flex-row flex-wrap items-center gap-4 leading-none">
                <h5 class="font-semibold">{{ $title }}</h5>

                <x-filament-notifications::actions
                    :actions="$actions"
                    class="flex-wrap gap-1"
                />
            </div>
        @elseif (! $title && $body && $actions)
            <div class="flex flex-row flex-wrap items-center gap-4 leading-none">
                <span class="text-sm">{{ $body }}</span>

                <x-filament-notifications::actions
                    :actions="$actions"
                    class="flex-wrap gap-1"
                />
            </div>
        @else
            <h5 class="font-semibold">{{ $title }}</h5>
            <div class="flex flex-row flex-wrap items-center gap-4 leading-none">
                <span class="text-sm">{{ $body }}</span>

                @if ($actions)
                    <x-filament-notifications::actions
                        :actions="$actions"
                        class="flex-wrap gap-1"
                    />
                @endif
            </div>
        @endif
    </div>


    @if ($notification->isClosable())
        <div class="flex items-center">
            <x-filament::icon-button icon="heroicon-o-x-mark" color="white"
                x-on:click="$dispatch('markedAnnouncementAsRead', {id: '{{ $notification->getId() }}'})" />
        </div>
    @endif
</div>
