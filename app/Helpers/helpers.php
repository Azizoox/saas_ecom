<?php

use App\Helpers\SubdomainHelper;

if (!function_exists('subdomain_route')) {
    /**
     * Generate a shop route URL that works with both subdomain and path-based approaches.
     * 
     * Usage in Blade:
     *   {{ subdomain_route('shop.index', ['subdomain' => $shop->subdomain]) }}
     */
    function subdomain_route(string $routeName, array $parameters = []): string
    {
        return SubdomainHelper::route($routeName, $parameters);
    }
}

if (!function_exists('shop_url')) {
    /**
     * Get the URL for a shop, working with both subdomain and path-based approaches.
     * 
     * Usage:
     *   {{ shop_url($shop->subdomain) }}
     *   {{ shop_url($shop->subdomain, 'product/123') }}
     */
    function shop_url(?string $subdomain = null, string $path = ''): string
    {
        return SubdomainHelper::shopUrl($subdomain, $path);
    }
}

if (!function_exists('current_subdomain')) {
    /**
     * Get the current shop's subdomain from the request.
     */
    function current_subdomain(): ?string
    {
        return SubdomainHelper::current();
    }
}

if (!function_exists('subdomain_enabled')) {
    /**
     * Check if wildcard subdomains are enabled.
     */
    function subdomain_enabled(): bool
    {
        return SubdomainHelper::isWildcardEnabled();
    }
}
