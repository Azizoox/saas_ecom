<?php
    $reviews = $content['reviews'] ?? [];
    $style   = $content['style'] ?? 'slider';
    $validReviews = array_filter($reviews, fn($r) => !empty($r['text'] ?? ''));
    $avgRating = count($validReviews)
        ? round(array_sum(array_column($validReviews, 'rating')) / count($validReviews), 1)
        : 5;
?>


<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

<section class="rv-section">

    
    <div class="rv-blob rv-blob--1" aria-hidden="true"></div>
    <div class="rv-blob rv-blob--2" aria-hidden="true"></div>

    <div class="rv-container">

        
        <div class="rv-header">
            <p class="rv-eyebrow">Ce qu'ils disent</p>
            <h2 class="rv-title"><?php echo e($content['title'] ?? 'Avis Clients'); ?></h2>
            <div class="rv-meta">
                <div class="rv-stars-display">
                    <?php for($s = 1; $s <= 5; $s++): ?>
                        <svg class="rv-star-svg <?php echo e($s <= round($avgRating) ? 'rv-star-svg--filled' : ''); ?>" viewBox="0 0 24 24">
                            <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                        </svg>
                    <?php endfor; ?>
                </div>
                <span class="rv-avg"><?php echo e(number_format($avgRating, 1)); ?></span>
                <span class="rv-count">· <?php echo e(count($validReviews)); ?> avis</span>
            </div>
        </div>

        <?php if($style === 'slider'): ?>
        
        <div class="rv-slider-root" id="rvSlider-<?php echo e($id); ?>">
            <div class="rv-track-wrap">
                <div class="rv-track">
                    <?php $__currentLoopData = $validReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="rv-slide" role="group" aria-label="Avis <?php echo e($i + 1); ?>">
                        <div class="rv-card rv-card--center">
                            <span class="rv-quote-mark" aria-hidden="true">"</span>
                            <div class="rv-stars">
                                <?php for($s = 0; $s < ($review['rating'] ?? 5); $s++): ?>
                                    <svg class="rv-star-svg rv-star-svg--filled" viewBox="0 0 24 24"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                                <?php endfor; ?>
                                <?php for($s = ($review['rating'] ?? 5); $s < 5; $s++): ?>
                                    <svg class="rv-star-svg" viewBox="0 0 24 24"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                                <?php endfor; ?>
                            </div>
                            <blockquote class="rv-text"><?php echo e($review['text']); ?></blockquote>
                            <div class="rv-author">
                                <div class="rv-avatar">
                                    <?php echo e(strtoupper(substr($review['name'] ?? 'C', 0, 1))); ?>

                                </div>
                                <div>
                                    <p class="rv-author-name"><?php echo e($review['name'] ?? 'Client'); ?></p>
                                    <?php if(!empty($review['date'])): ?>
                                        <p class="rv-author-date"><?php echo e($review['date']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="rv-controls">
                <button class="rv-btn rv-btn--prev" data-slider="rvSlider-<?php echo e($id); ?>" aria-label="Précédent">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <div class="rv-dots" data-dots="rvSlider-<?php echo e($id); ?>">
                    <?php $__currentLoopData = $validReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button class="rv-dot <?php echo e($i === 0 ? 'rv-dot--active' : ''); ?>" data-index="<?php echo e($i); ?>" aria-label="Slide <?php echo e($i+1); ?>"></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <button class="rv-btn rv-btn--next" data-slider="rvSlider-<?php echo e($id); ?>" aria-label="Suivant">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
        </div>

        <?php else: ?>
        
        <div class="rv-grid">
            <?php $__currentLoopData = $validReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(!empty($review['text'])): ?>
            <div class="rv-card rv-card--grid" style="--i:<?php echo e($i); ?>">
                <div class="rv-card-top">
                    <div class="rv-stars">
                        <?php for($s = 0; $s < ($review['rating'] ?? 5); $s++): ?>
                            <svg class="rv-star-svg rv-star-svg--filled" viewBox="0 0 24 24"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                        <?php endfor; ?>
                        <?php for($s = ($review['rating'] ?? 5); $s < 5; $s++): ?>
                            <svg class="rv-star-svg" viewBox="0 0 24 24"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                        <?php endfor; ?>
                    </div>
                    <span class="rv-quote-sm" aria-hidden="true">"</span>
                </div>
                <blockquote class="rv-text rv-text--grid"><?php echo e($review['text']); ?></blockquote>
                <div class="rv-author rv-author--grid">
                    <div class="rv-avatar rv-avatar--sm">
                        <?php echo e(strtoupper(substr($review['name'] ?? 'C', 0, 1))); ?>

                    </div>
                    <div>
                        <p class="rv-author-name"><?php echo e($review['name'] ?? 'Client'); ?></p>
                        <?php if(!empty($review['date'])): ?>
                            <p class="rv-author-date"><?php echo e($review['date']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="rv-card-line"></div>
            </div>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

    </div>
</section>

<style>
/* ── Variables ── */
:root {
    --rv-bg:        #0d0f14;
    --rv-surface:   #161922;
    --rv-border:    rgba(255,255,255,.07);
    --rv-text:      #e8e6e1;
    --rv-muted:     #6b7280;
    --rv-gold:      #f0b429;
    --rv-gold-dim:  rgba(240,180,41,.18);
    --rv-accent:    #7c6ef7;
    --rv-accent-lt: rgba(124,110,247,.15);
    --rv-radius:    20px;
    --rv-shadow:    0 4px 32px rgba(0,0,0,.45);
    
    --rv-ease:      cubic-bezier(.22,.68,0,1.2);
    --rv-dur:       .4s;
}

/* ── Section ── */
.rv-section {
    position: relative;
    background: #fff;
   
    padding: 80px 0 96px;
    font-family: var(--rv-font-b);
    overflow: hidden;
}

/* ── Background blobs ── */
.rv-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(90px);
    pointer-events: none;
    opacity: .45;
}
.rv-blob--1 {
    width: 520px; height: 520px;
    /* background: radial-gradient(circle, #7c6ef755, transparent 70%); */
    top: -120px; left: -160px;
}
.rv-blob--2 {
    width: 420px; height: 420px;
    /* background: radial-gradient(circle, #f0b42922, transparent 70%); */
    bottom: -80px; right: -100px;
}

/* ── Container ── */
.rv-container {
    position: relative;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 28px;
}

/* ── Header ── */
.rv-header {
    text-align: center;
    margin-bottom: 56px;
}
.rv-eyebrow {
    font-size: 11px;
    font-weight: 500;
    letter-spacing: .25em;
    text-transform: uppercase;
    color:  #d44210;
    margin: 0 0 12px;
}
.rv-title {
    font-family: var(--rv-font-d);
    font-size: clamp(30px, 5vw, 52px);
    font-weight: 600;
    
    margin: 0 0 20px;
    line-height: 1.1;
    letter-spacing: -.01em;
}
.rv-meta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--rv-gold-dim);
    border: 1px solid rgba(240,180,41,.25);
    border-radius: 99px;
    padding: 6px 16px;
}
.rv-avg {
    font-size: 14px;
    font-weight: 600;
    color: var(--rv-gold);
}
.rv-count {
    font-size: 13px;
    color: var(--rv-muted);
}

/* ── Stars SVG shared ── */
.rv-stars { display: flex; gap: 3px; justify-content: center; }
.rv-stars-display { display: flex; gap: 2px; }
.rv-star-svg {
    width: 15px; height: 15px;
    fill: none;
    stroke: var(--rv-gold);
    stroke-width: 1.5;
}
.rv-star-svg--filled { fill: var(--rv-gold); stroke: var(--rv-gold); }

/* ── Card shared ── */
.rv-card {
    background:#ffffff;
    border: 1px solid var(--rv-border);
    border-radius: var(--rv-radius);
  
    position: relative;
    overflow: hidden;
    transition: transform var(--rv-dur) var(--rv-ease),
                box-shadow var(--rv-dur) ease,
                border-color var(--rv-dur) ease;
}

/* ── Quote mark ── */
.rv-quote-mark {
    font-family: var(--rv-font-d);
    font-size: 96px;
    line-height: .6;
    color: var(--rv-accent);
    opacity: .25;
    display: block;
    margin-bottom: -12px;
    user-select: none;
}
.rv-quote-sm {
    font-family: var(--rv-font-d);
    font-size: 52px;
    line-height: .6;
    color:     #f15a24;
    opacity: .3;
    user-select: none;
}

/* ── Review text ── */
.rv-text {
    font-family: var(--rv-font-d);
    font-size: clamp(17px, 2.2vw, 22px);
    font-style: italic;
   
    line-height: 1.65;
    margin: 16px 0 24px;
    border: none;
    padding: 0;
    color: black;
}

/* ── Author ── */
.rv-author {
    display: flex;
    align-items: center;
    gap: 12px;
    justify-content: center;
}
.rv-avatar {
    width: 44px; height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--rv-accent),rgb(237, 94, 11));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    font-weight: 600;
    color: #fff;
    flex-shrink: 0;
    box-shadow: 0 0 0 3px rgba(243, 98, 65, 0.2);
}
.rv-avatar--sm { width: 36px; height: 36px; font-size: 14px; }
.rv-author-name {
    font-size: 14px;
    font-weight: 500;
    color: var();
    margin: 0;
}
.rv-author-date {
    font-size: 12px;
    color: var(--rv-muted);
    margin: 2px 0 0;
}

/* ══════════ SLIDER ══════════ */
.rv-slider-root { position: relative; }

.rv-track-wrap {
    overflow: hidden;
    border-radius: var(--rv-radius);
}
.rv-track {
    display: flex;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
    will-change: transform;
}
.rv-slide {
    flex: 0 0 100%;
    padding: 4px;
}

.rv-card--center {
    padding: 52px 64px 44px;
    text-align: center;
}
@media (max-width: 640px) {
    .rv-card--center { padding: 36px 28px 32px; }
}

/* Controls */
.rv-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-top: 28px;
}
.rv-btn {
    width: 44px; height: 44px;
    border-radius: 50%;
    border: 1px solid var(--rv-border);
    background: var(--rv-surface);
    color: var(--rv-text);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .25s ease;
}
.rv-btn:hover {
    background: var(--rv-accent);
    border-color: var(--rv-accent);
    color: #fff;
    box-shadow: 0 4px 20px rgba(216, 58, 19, 0.4);
    transform: scale(1.08);
}
.rv-dots { display: flex; gap: 8px; align-items: center; }
.rv-dot {
    width: 8px; height: 8px;
    border-radius: 99px;
    border: none;
    background: var(--rv-muted);
    cursor: pointer;
    transition: all .3s ease;
    padding: 0;
}
.rv-dot--active {
    background: var(--rv-accent);
    width: 24px;
    box-shadow: 0 0 10px rgba(226, 82, 10, 0.5);
}

/* ══════════ GRID ══════════ */
.rv-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}
.rv-card--grid {
    padding: 28px 28px 24px;
    animation: rvFadeUp var(--rv-dur) both;
    animation-delay: calc(var(--i) * 80ms);
}
.rv-card--grid:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 60px rgba(0,0,0,.55);
    border-color: rgba(232, 118, 11, 0.3);
}
.rv-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 4px;
}
.rv-text--grid {
    font-size: 15px;
    margin: 12px 0 20px;
    
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
    display: -webkit-box;
    overflow: hidden;
}
.rv-author--grid { justify-content: flex-start; }

/* Bottom accent line */
.rv-card-line {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--rv-accent), transparent);
    opacity: 0;
    transition: opacity .3s ease;
}
.rv-card--grid:hover .rv-card-line { opacity: 1; }

/* ── Animation ── */
@keyframes rvFadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .rv-section { padding: 56px 0 64px; }
    .rv-grid { grid-template-columns: 1fr; gap: 16px; }
}
</style>

<script>
(function() {
    document.querySelectorAll('[data-slider]').forEach(function(btn) {
        const id    = btn.dataset.slider;
        const root  = document.getElementById(id);
        if (!root) return;

        const track  = root.querySelector('.rv-track');
        const slides = root.querySelectorAll('.rv-slide');
        const dots   = root.querySelectorAll('.rv-dot');
        let current  = 0;
        let autoplay;

        function goTo(n) {
            current = (n + slides.length) % slides.length;
            track.style.transform = `translateX(-${current * 100}%)`;
            dots.forEach((d, i) => d.classList.toggle('rv-dot--active', i === current));
        }

        // Arrow buttons
        document.querySelectorAll(`.rv-btn--prev[data-slider="${id}"]`).forEach(function(b) {
            b.addEventListener('click', function() { goTo(current - 1); resetAuto(); });
        });
        document.querySelectorAll(`.rv-btn--next[data-slider="${id}"]`).forEach(function(b) {
            b.addEventListener('click', function() { goTo(current + 1); resetAuto(); });
        });

        // Dot buttons
        dots.forEach(function(dot, i) {
            dot.addEventListener('click', function() { goTo(i); resetAuto(); });
        });

        // Autoplay
        function startAuto() { autoplay = setInterval(function() { goTo(current + 1); }, 5000); }
        function resetAuto()  { clearInterval(autoplay); startAuto(); }
        startAuto();

        // Touch swipe
        let tx = 0;
        track.addEventListener('touchstart', function(e) { tx = e.touches[0].clientX; }, { passive: true });
        track.addEventListener('touchend', function(e) {
            const dx = e.changedTouches[0].clientX - tx;
            if (Math.abs(dx) > 40) { goTo(dx < 0 ? current + 1 : current - 1); resetAuto(); }
        });
    });
})();
</script><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/shop/components/reviews.blade.php ENDPATH**/ ?>