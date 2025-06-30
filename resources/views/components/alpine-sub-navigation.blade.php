{{-- Alpine.js Sub Navigation Component --}}
@props([
'navId' => '',
'items' => [],
'label' => '',
'icon' => null,
'url' => '#',
'badge' => '▼'
])

<div x-data="subNavigation('{{ $navId }}', @js($items))" x-init="init()" class="fi-sidebar-item"
    style="position: relative;" @mouseenter="showDropdown()" @mouseleave="hideDropdown()">
    <a href="{{ $url }}"
        class="flex relative gap-x-3 justify-center items-center px-2 py-2 rounded-lg transition duration-75 outline-none fi-sidebar-item-button hover:bg-gray-100 focus-visible:bg-gray-100 dark:hover:bg-white/5 dark:focus-visible:bg-white/5">
        @if($icon)
        <x-dynamic-component :component="$icon" class="w-6 h-6 fi-sidebar-item-icon" />
        @endif

        <span class="fi-sidebar-item-label">{{ $label }}</span>

        <span
            class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 min-w-[theme(spacing.6)] py-1 fi-color-primary bg-primary-50 text-primary-600 ring-primary-600/10 dark:bg-primary-400/10 dark:text-primary-400 dark:ring-primary-400/30"
            style="transition: transform 0.2s ease;"
            :style="isOpen ? 'transform: rotate(180deg);' : 'transform: rotate(0deg);'">
            {{ $badge }}
        </span>
    </a>

    <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2" @mouseenter="keepDropdownOpen()"
        @mouseleave="hideDropdown()"
        class="sub-nav-dropdown absolute top-full left-0 right-0 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg z-50 min-w-[200px] max-w-[300px] overflow-hidden"
        style="display: none;" x-cloak>
        <template x-for="(item, index) in items" :key="index">
            <a :href="item.url"
                class="flex items-center px-4 py-3 text-gray-700 border-b border-gray-100 transition-colors duration-150 sub-nav-item dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 dark:border-gray-600 last:border-b-0">
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium sub-nav-item-label" x-text="item.label"></div>
                    <div x-show="item.description"
                        class="mt-1 text-xs text-gray-500 sub-nav-item-description dark:text-gray-400"
                        x-text="item.description"></div>
                </div>
            </a>
        </template>
    </div>
</div>