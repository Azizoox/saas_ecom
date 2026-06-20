# Wildcard Subdomain Quick Reference

## Quick Start

### Development (Path-Based)
```env
TENANT_DOMAIN=localhost
# Access: http://localhost:8000/shop/pro
```

### Production (Wildcard Subdomains)
```env
TENANT_DOMAIN=example.com
# Access: http://pro.example.com
```

## Helper Functions

### Available Functions

| Function | Usage | Returns |
|----------|-------|---------|
| `shop_url($subdomain)` | `shop_url('pro')` | Full shop URL |
| `shop_url($subdomain, $path)` | `shop_url('pro', 'products')` | Shop URL with path |
| `subdomain_route($route, $params)` | `subdomain_route('shop.index', ['subdomain' => $sd])` | Route URL |
| `current_subdomain()` | `current_subdomain()` | Current shop's subdomain |
| `subdomain_enabled()` | `subdomain_enabled()` | Boolean - wildcards active? |

## Common Blade Template Patterns

### Link to Shop Home Page
```blade
<a href="{{ shop_url($shop->subdomain) }}">Visit Shop</a>
```

### Link to Product
```blade
<a href="{{ shop_url($shop->subdomain, 'product/' . $product->id) }}">
    {{ $product->name }}
</a>
```

### Cart Add Form
```blade
<form action="{{ subdomain_route('shop.cart.add', ['subdomain' => $shop->subdomain]) }}" method="POST">
    @csrf
    <button>Add to Cart</button>
</form>
```

### Cart Count via Fetch
```javascript
fetch('{{ subdomain_route("shop.cart.count", ["subdomain" => $shop->subdomain]) }}')
    .then(r => r.json())
    .then(data => console.log(data.count));
```

## DNS & Web Server Setup

### DNS (Production)
```
*.example.com    A    123.456.789.000
```

### Nginx Config
```nginx
server_name ~^(?<subdomain>.+)\.example\.com$ example.com;
root /var/www/shoopino/public;
```

### Apache Config
```apache
ServerName example.com
ServerAlias *.example.com
DocumentRoot /var/www/shoopino/public
```

## Testing

```bash
# Test locally with path-based routing
curl http://localhost:8000/shop/pro

# Test with Valet domain
curl http://pro.shoopino.test

# Debug current config
php artisan tinker
> config('app.tenant_domain')
```

## Middleware Details

The `HandleTenancy` middleware automatically:
1. Extracts subdomain from route parameter OR
2. Extracts subdomain from host header
3. Loads the Shop model
4. Makes it available via `app('shop')`

No configuration needed - choose either approach!

## File Structure Reference

```
app/
├── Helpers/
│   ├── SubdomainHelper.php    ← Core logic
│   └── helpers.php            ← Global functions
├── Http/Middleware/
│   └── HandleTenancy.php      ← Auto-extracts subdomain
└── Providers/
    └── AppServiceProvider.php ← Loads helpers

config/
└── app.php                    ← Reads TENANT_DOMAIN env

routes/
└── web.php                    ← Both routing approaches

.env.example                   ← Configuration template
WILDCARD_SUBDOMAIN_SETUP.md    ← Full documentation
```

## Troubleshooting Checklist

- [ ] `TENANT_DOMAIN` set correctly in `.env`
- [ ] DNS wildcard record created (production)
- [ ] Web server routing all subdomains to Laravel
- [ ] SSL certificate valid for `*.example.com` (production)
- [ ] Using helper functions in Blade templates
- [ ] Database has shops with correct subdomains
- [ ] `HandleTenancy` middleware loaded on shop routes
