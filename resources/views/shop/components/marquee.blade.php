<div class="marquee-container my-4 py-2" style="background-color: {{ $bg_color }}; color: {{ $text_color }}; overflow: hidden; white-space: nowrap;">
    <div class="marquee-content d-inline-block" style="animation: marquee-{{ $speed }} {{ $speed === 'slow' ? '30s' : ($speed === 'fast' ? '10s' : '20s') }} linear infinite;">
        <span class="px-4 fw-bold text-uppercase">{{ $text }}</span>
        <span class="px-4 fw-bold text-uppercase">{{ $text }}</span>
        <span class="px-4 fw-bold text-uppercase">{{ $text }}</span>
        <span class="px-4 fw-bold text-uppercase">{{ $text }}</span>
    </div>
</div>

<style>
    @keyframes marquee-{{ $speed }} {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .marquee-content {
        display: inline-block;
        padding-left: 100%;
        animation: marquee-{{ $speed }} 20s linear infinite;
    }
    .marquee-container:hover .marquee-content {
        animation-play-state: paused;
    }
</style>
