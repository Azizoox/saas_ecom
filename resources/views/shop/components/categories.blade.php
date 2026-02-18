@php
    $style = $content['style'] ?? 'grid';
    $categoriesList = $categories ?? collect();
    
@endphp

<div class="container mb-5">
    @if(isset($content['title']))
        <h2 class="text-center mb-4">{{ $content['title'] }}</h2>
    @endif

    <div class="row {{ $style === 'slider' ? 'flex-nowrap overflow-auto pb-3' : '' }}">
        @forelse($categoriesList as $category)
            <div class="{{ $style === 'grid' ? 'col-md-3 col-6' : 'col-md-2 col-4' }} mb-4">
                <a href="{{ route('shop.index', ['subdomain' => $shop->subdomain, 'category' => $category->slug]) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm border-0 text-center hover-lift overflow-hidden position-relative">
                        <div class="card-body p-3">
                            @if($category->image)
                                <div class="rounded-circle overflow-hidden mx-auto mb-2 d-inline-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-100 h-100 object-fit-cover">
                                </div>
                            @elseif($category->icon)
                                <div class="rounded-circle overflow-hidden mx-auto mb-2 d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10" style="width: 60px; height: 60px;">
                                    <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" class="w-100 h-100 object-fit-contain p-1">
                                </div>
                            @else
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                    <i class="bi bi-tag text-primary h3 mb-0"></i>
                                </div>
                            @endif
                            <h6 class="card-title mb-0 small">{{ $category->name }}</h6>
                            
                            <!-- Product count badge -->
                            @php
                                $productCount = $category->products()->where('is_active', true)->count();
                            @endphp
                            @if($productCount > 0)
                                <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-primary mt-2 me-2">
                                    {{ $productCount }}
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-center text-muted w-100">Aucune catégorie trouvée.</p>
        @endforelse
    </div>
</div>

<style>
.hover-lift { transition: transform 0.2s; }
.hover-lift:hover { transform: translateY(-5px); }
</style>
