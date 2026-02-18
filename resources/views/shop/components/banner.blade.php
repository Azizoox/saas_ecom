<div class="scrolling-banner py-2 mb-5" style="background-color: {{ $content['bg_color'] ?? '#000' }}; color: #fff; overflow: hidden; white-space: nowrap;">
    <div class="d-inline-block animate-scroll" style="animation: scroll {{ $content['speed'] ?? 10 }}s linear infinite;">
        <span class="px-4 fw-bold">{{ $content['text_main'] ?? '' }}</span>
        <span class="px-4 text-light opacity-75">{{ $content['text_secondary'] ?? '' }}</span>
        <span class="px-4 fw-bold">{{ $content['text_main'] ?? '' }}</span>
        <span class="px-4 text-light opacity-75">{{ $content['text_secondary'] ?? '' }}</span>
        <span class="px-4 fw-bold">{{ $content['text_main'] ?? '' }}</span>
        <span class="px-4 text-light opacity-75">{{ $content['text_secondary'] ?? '' }}</span>
    </div>
</div>

<style>
@keyframes scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.animate-scroll {
    display: inline-block;
    padding-left: 100%;
}
</style>
