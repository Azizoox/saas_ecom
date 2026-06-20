<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class SubdomainHelper
{
    /**
     * Check if wildcard subdomains are enabled.
     * Based on the tenant_domain configuration.
     */
    public static function isWildcardEnabled(): bool
    {
        $tenantDomain = config('app.tenant_domain');
        return !empty($tenantDomain) && $tenantDomain !== 'localhost';
    }

    /**
     * Generate a shop URL based on the current environment.
     * 
     * If wildcard domains are enabled, returns: pro.example.com/route
     * Otherwise, returns: localhost:8000/shop/pro/route
     */
    public static function route(string $routeName, array $parameters = []): string
    {
        $subdomain = $parameters['subdomain'] ?? null;

        if (!$subdomain) {
            return route($routeName, $parameters);
        }

        if (self::isWildcardEnabled()) {
            // Use wildcard subdomain routing
            $subdomainRouteName = str_replace('shop.', 'shop.subdomain.', $routeName);
            
            // If the subdomain route doesn't exist, fall back to path-based
            try {
                $route = Route::getRoutes()->getByName($subdomainRouteName);
                if ($route) {
                    unset($parameters['subdomain']);
                    return route($subdomainRouteName, array_merge(['subdomain' => $subdomain], $parameters));
                }
            } catch (\Exception $e) {
                // Fall through to path-based
            }
        }

        // Use path-based routing (localhost approach)
        return route($routeName, $parameters);
    }

    /**
     * Get the current shop's URL.
     */
    public static function shopUrl(?string $subdomain = null, string $path = ''): string
    {
        $subdomain = $subdomain ?? app('shop')?->subdomain;

        if (!$subdomain) {
            return url($path);
        }

        if (self::isWildcardEnabled()) {
            $tenantDomain = config('app.tenant_domain');
            $url = "{$subdomain}.{$tenantDomain}";
            
            // Add scheme
            $scheme = config('app.scheme', parse_url(config('app.url'), PHP_URL_SCHEME));
            return "{$scheme}://{$url}" . ($path ? "/{$path}" : '');
        }

        // Localhost path-based
        return url("shop/{$subdomain}" . ($path ? "/{$path}" : ''));
    }

    /**
     * Get subdomain from current request.
     */
    public static function current(): ?string
    {
        // Try to get from app instance
        $shop = app('shop');
        if ($shop) {
            return $shop->subdomain;
        }

        // Try to get from route parameter
        return request()->route('subdomain');
    }
}
