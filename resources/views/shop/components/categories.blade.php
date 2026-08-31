@php
    $style = $content['style'] ?? 'grid';
    $categoriesList = $categories ?? collect();
@endphp

{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

<section class="cat-section">
    <div class="cat-container">

        @if(isset($content['title']))
        <div class="cat-header">
            <span class="cat-eyebrow">Explorer</span>
            <h2 class="cat-title">{{ $content['title'] }}</h2>
            <div class="cat-divider"><span></span></div>
        </div>
        @endif

        @if($style === 'slider')
            {{-- ── SLIDER MODE ── --}}
            <div class="cat-slider-wrapper">
                <button class="cat-arrow cat-arrow--prev" aria-label="Précédent">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <div class="cat-slider" id="catSlider">
                    @forelse($categoriesList as $i => $category)
                    @php $productCount = $category->products()->where('is_active', true)->count(); @endphp
                    <a href="{{ route('shop.index', ['subdomain' => $shop->subdomain, 'category' => $category->slug]) }}"
                       class="cat-slide" style="--i:{{ $i }}">
                        <div class="cat-card cat-card--slim">
                            <div class="cat-icon-wrap">
                                @if($category->image)
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="cat-img">
                                @elseif($category->icon)
                                    <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" class="cat-img cat-img--contain">
                                @else
                                    <i class="bi bi-tag cat-fallback-icon"></i>
                                @endif
                            </div>
                            <span class="cat-name">{{ $category->name }}</span>
                            @if($productCount > 0)
                                <span class="cat-count">{{ $productCount }}</span>
                            @endif
                        </div>
                    </a>
                    @empty
                        <p class="cat-empty">Aucune catégorie trouvée.</p>
                    @endforelse
                </div>
                <button class="cat-arrow cat-arrow--next" aria-label="Suivant">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>

        @else
            {{-- ── GRID MODE ── --}}
            <div class="cat-grid">
                @forelse($categoriesList as $i => $category)
                @php $productCount = $category->products()->where('is_active', true)->count(); @endphp
                <a href="{{ route('shop.index', ['subdomain' => $shop->subdomain, 'category' => $category->slug]) }}"
                   class="cat-item" style="--i:{{ $i }}">
                    <div class="cat-card">
                        <div class="cat-icon-wrap">
                            @if($category->image)
                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="cat-img">
                            @elseif($category->icon)
                                <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" class="cat-img cat-img--contain">
                            @else
                                <i class="bi bi-tag cat-fallback-icon"></i>
                            @endif
                            <div class="cat-icon-ring"></div>
                        </div>
                        <span class="cat-name">{{ $category->name }}</span>
                        @if($productCount > 0)
                            <span class="cat-count">{{ $productCount }}</span>
                        @endif
                        <div class="cat-hover-bar"></div>
                    </div>
                </a>
                @empty
                    <p class="cat-empty">Aucune catégorie trouvée.</p>
                @endforelse
            </div>
        @endif

    </div>
</section>

<style>
/* ── Variables ── */
:root {
    --cat-bg:        #faf9f7;
    --cat-card-bg:   #ffffff;
    --cat-border:    #ede9e3;
    --cat-ink:       #1a1714;
    --cat-muted:     #8a8480;
    --cat-accent:    #c8612a;
    --cat-accent-lt: #f5ede7;
    --cat-shadow:    0 2px 12px rgba(0,0,0,.07);
    --cat-shadow-hv: 0 12px 36px rgba(0,0,0,.13);
    --cat-radius:    18px;
    --cat-font-disp: 'Playfair Display', Georgia, serif;
    --cat-font-body: 'DM Sans', sans-serif;
    --cat-dur:       0.38s;
    --cat-ease:      cubic-bezier(.22,.68,0,1.2);
}

/* ── Section wrapper ── */
.cat-section {
    
    padding: 64px 0 72px;
    font-family: var(--cat-font-body);
}
.cat-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}

/* ── Header ── */
.cat-header {
    text-align: center;
    margin-bottom: 48px;
}
.cat-eyebrow {
    display: inline-block;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: .22em;
    text-transform: uppercase;
    color: var(--cat-accent);
    margin-bottom: 10px;
}
.cat-title {
    font-family: var(--cat-font-disp);
    font-size: clamp(26px, 4vw, 42px);
    font-weight: 700;
    color: var(--cat-ink);
    margin: 0 0 18px;
    line-height: 1.15;
}
.cat-divider {
    display: flex;
    justify-content: center;
}
.cat-divider span {
    display: block;
    width: 48px;
    height: 3px;
    background: linear-gradient(90deg, var(--cat-accent), #e8a47a);
    border-radius: 99px;
}

/* ── Grid ── */
.cat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 25px;
}

/* ── Item / anchor ── */
.cat-item,
.cat-slide {
    text-decoration: none;
    color: var(--cat-ink);
    display: block;
    animation: catFadeUp var(--cat-dur) both;
    animation-delay: calc(var(--i) * 60ms);
}

/* ── Card ── */
.cat-card {
    position: relative;
    background: var(--cat-card-bg);
    border: 1px solid var(--cat-border);
    border-radius: var(--cat-radius);
    padding: 28px 26px 22px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    box-shadow: var(--cat-shadow);
    transition:
        transform var(--cat-dur) var(--cat-ease),
        box-shadow var(--cat-dur) ease,
        border-color var(--cat-dur) ease;
    overflow: hidden;
    cursor: pointer;

   
}
.cat-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: var(--cat-shadow-hv);
    border-color: var(--cat-accent);
}

/* ── Hover accent bar at bottom ── */
.cat-hover-bar {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--cat-accent), #e8a47a);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform var(--cat-dur) var(--cat-ease);
    border-radius: 0 0 var(--cat-radius) var(--cat-radius);
}
.cat-card:hover .cat-hover-bar { transform: scaleX(1); }

/* ── Icon wrapper ── */
.cat-icon-wrap {
    position: relative;
    width: 72px; height: 72px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--cat-accent-lt);
    transition: background var(--cat-dur) ease;
    flex-shrink: 0;
}
.cat-card:hover .cat-icon-wrap { background: #f0ddd3; }

/* Animated ring on hover */
.cat-icon-ring {
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    border: 2px solid transparent;
    transition: border-color var(--cat-dur) ease;
}
.cat-card:hover .cat-icon-ring { border-color: var(--cat-accent); }

/* ── Images ── */
.cat-img {
    width: 100%; height: 100%;
    object-fit: cover;
    border-radius: 50%;
}
.cat-img--contain {
    object-fit: contain;
    padding: 8px;
}

/* ── Fallback icon ── */
.cat-fallback-icon {
    font-size: 28px;
    color: var(--cat-accent);
    line-height: 1;
}

/* ── Name ── */
.cat-name {
    font-size: 16px;
    font-weight: 500;
    text-align: center;
    color: var(--cat-ink);
    line-height: 1.35;
    transition: color var(--cat-dur) ease;
}
.cat-card:hover .cat-name { color: var(--cat-accent); }

/* ── Count badge ── */
.cat-count {
    position: absolute;
    top: 10px; right: 10px;
    min-width: 22px; height: 22px;
    padding: 0 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--cat-accent);
    color: #fff;
    font-size: 10px;
    font-weight: 600;
    border-radius: 99px;
    letter-spacing: .03em;
    box-shadow: 0 2px 8px rgba(200,97,42,.35);
}

/* ── Empty state ── */
.cat-empty {
    color: var(--cat-muted);
    text-align: center;
    width: 100%;
    padding: 40px 0;
    font-size: 14px;
}

/* ── Slider mode ── */
.cat-slider-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    gap: 12px;
}
.cat-slider {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    padding: 12px 4px 16px;
    flex: 1;
}
.cat-slider::-webkit-scrollbar { display: none; }
.cat-slide { scroll-snap-align: start; flex-shrink: 0; }

.cat-card--slim {
    width: 130px;
    padding: 20px 12px 16px;
    gap: 10px;
}
.cat-card--slim .cat-icon-wrap { width: 58px; height: 58px; }
.cat-card--slim .cat-name { font-size: 12px; }

/* ── Arrows ── */
.cat-arrow {
    flex-shrink: 0;
    width: 40px; height: 40px;
    border-radius: 50%;
    border: 1.5px solid var(--cat-border);
    background: var(--cat-card-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--cat-ink);
    box-shadow: var(--cat-shadow);
    transition: all .2s ease;
    z-index: 2;
}
.cat-arrow:hover {
    background: var(--cat-accent);
    border-color: var(--cat-accent);
    color: #fff;
    box-shadow: 0 4px 16px rgba(200,97,42,.3);
}

/* ── Keyframes ── */
@keyframes catFadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .cat-section { padding: 40px 0 48px; }
    .cat-grid { grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 14px; }
    .cat-card { padding: 20px 12px 16px; }
    .cat-icon-wrap { width: 60px; height: 60px; }
}
@media (max-width: 480px) {
    .cat-grid { grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .cat-icon-wrap { width: 50px; height: 50px; }
    .cat-name { font-size: 11px; }
}
</style>

<script>
(function () {
    const slider = document.getElementById('catSlider');
    if (!slider) return;

    const prev = document.querySelector('.cat-arrow--prev');
    const next = document.querySelector('.cat-arrow--next');
    const scrollBy = 160;

    prev?.addEventListener('click', () => slider.scrollBy({ left: -scrollBy * 2, behavior: 'smooth' }));
    next?.addEventListener('click', () => slider.scrollBy({ left:  scrollBy * 2, behavior: 'smooth' }));
})();
</script>