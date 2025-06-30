<?php

namespace HayderHatem\FilamentSubNavigation\Concerns;

use Filament\Navigation\NavigationItem;
use Illuminate\Support\HtmlString;

trait HasBadgeSubNavigation
{
    protected static array $subNavigationItems = [];

    /**
     * Create a navigation item with badge that shows sub-navigation on hover
     */
    public static function createBadgeNavigation(
        string $label,
        array $subItems = [],
        ?string $icon = null,
        ?string $badgeIcon = 'heroicon-o-chevron-down',
        ?string $url = null,
        ?string $group = null
    ): NavigationItem {
        $navigationItem = NavigationItem::make($label)
            ->icon($icon)
            ->url($url ?? static::getUrl())
            ->badge('▼');

        if ($group) {
            $navigationItem->group($group);
        }

        // Store sub-navigation items using simple ID generation to match JavaScript
        $subNavId = strtolower(preg_replace('/[^a-z0-9]/i', '', $label));
        static::$subNavigationItems[$subNavId] = $subItems;

        return $navigationItem;
    }

    /**
     * Get all sub-navigation items
     */
    public static function getSubNavigationItems(): array
    {
        return static::$subNavigationItems;
    }

    /**
     * Create a sub-navigation item
     */
    public static function createSubNavigationItem(
        string $label,
        string $url,
        ?string $icon = null,
        ?string $description = null
    ): array {
        return [
            'label' => $label,
            'url' => $url,
            'icon' => $icon,
            'description' => $description,
        ];
    }

    /**
     * Helper method to create multiple sub-navigation items
     */
    public static function createSubNavigationItems(array $items): array
    {
        return collect($items)->map(function ($item) {
            return static::createSubNavigationItem(
                $item['label'],
                $item['url'],
                $item['icon'] ?? null,
                $item['description'] ?? null
            );
        })->toArray();
    }

    /**
     * Generate JavaScript to register sub-navigation data
     */
    public static function getSubNavigationScript(): string
    {
        if (empty(static::$subNavigationItems)) {
            return '';
        }

        $scripts = [];
        foreach (static::$subNavigationItems as $id => $items) {
            $itemsJson = json_encode($items);
            $scripts[] = "window.registerSubNavigation('{$id}', {$itemsJson});";
        }

        return '<script>' . implode("\n", $scripts) . '</script>';
    }

    /**
     * Get sub-navigation items as HTML string for embedding
     */
    public static function renderSubNavigationScript(): \Illuminate\Support\HtmlString
    {
        return new \Illuminate\Support\HtmlString(static::getSubNavigationScript());
    }
}
