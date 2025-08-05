<div x-data="{ open: false }" class="relative">
    <!-- Trigger slot -->
    <div @click="open = ! open">
        {{ $trigger ?? '' }}
    </div>
    <!-- Dropdown content -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $width ?? '' }} rounded-md shadow-lg {{ $alignmentClasses ?? '' }}"
        style="display: none;"
        @click.away="open = false"
    >
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses ?? '' }}">
            {{ $slot }}
        </div>
    </div>
</div>
