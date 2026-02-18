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
        // Récupérer le sous-domaine depuis le paramètre de route
        $subdomain = $request->route('subdomain');

        if (empty($subdomain)) {
            abort(404, 'Sous-domaine manquant');
        }

        // Charger la boutique correspondante
        $shop = Shop::where('subdomain', $subdomain)
            ->where('status', 'active')
            ->first();

        if (!$shop) {
            abort(404, 'Boutique non trouvée');
        }

        // Ajouter la boutique au request pour y accéder partout
        $request->attributes->set('shop', $shop);
        app()->instance('shop', $shop);

        return $next($request);
    }
}
