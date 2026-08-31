<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Shop;
use Symfony\Component\HttpFoundation\Response;

class HandleTenancy
{
    public function handle(Request $request, Closure $next): Response
    {
        // Try to get subdomain from route parameter (localhost approach)
        $subdomain = $request->route('subdomain');

        // If not in route, try to extract from host header (wildcard subdomain approach)
        if (empty($subdomain)) {
            $subdomain = $this->extractSubdomainFromHost($request);
        }

        if (empty($subdomain)) {
            abort(404, 'Subdomain not found');
        }

        // Clean subdomain (remove any special characters)
        $subdomain = preg_replace('/[^a-zA-Z0-9-]/', '', $subdomain);
        $subdomain = strtolower($subdomain);

        // Load the shop matching the subdomain
        $shop = Shop::where('subdomain', $subdomain)
            ->where('status', 'active')
            ->first();

        if (!$shop) {
            abort(404, 'Shop not found');
        }

        // Add shop to request context for use throughout the application
        $request->attributes->set('shop', $shop);
        app()->instance('shop', $shop);

        return $next($request);
    }

    /**
     * Extract subdomain from the request host header.
     * 
     * Handles formats like:
     * - pro.example.com
     * - coder.example.com
     * - efficace.example.com
     * - localhost (no subdomain)
     */
    private function extractSubdomainFromHost(Request $request): ?string
    {
        $host = $request->getHost();
        $appDomain = config('app.tenant_domain', null);

        // If no tenant domain configured, assume localhost
        if (!$appDomain || $host === 'localhost' || strpos($host, 'localhost:') === 0) {
            return null;
        }

        // Parse the host to extract subdomain
        $parts = explode('.', $host);

        // For single-part domains like 'localhost', return null
        if (count($parts) === 1) {
            return null;
        }

        // Get the subdomain (first part before the main domain)
        // Examples: pro.example.com → pro, coder.example.com → coder
        if (count($parts) >= 3) {
            return $parts[0]; // Return the subdomain part
        }

        return null;
    }
}
