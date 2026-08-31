@php
    $slides = $content['slides'] ?? [];
    $options = $content['options'] ?? [];
    $autoplay = $options['autoplay'] ?? true;
    $interval = $options['interval'] ?? 6000;
@endphp

@if(count($slides) > 0)
<section class="hero-slider mb-5">
<div id="carousel-{{ $id }}"
     class="carousel slide hero-slider-inner"
     data-bs-ride="{{ $autoplay ? 'carousel' : 'false' }}"
     @if($autoplay) data-bs-interval="{{ $interval }}" @endif>
    @if($options['pagination'] ?? true)
    <div class="carousel-indicators">
        @foreach($slides as $index => $slide)
            <button
                type="button"
                data-bs-target="#carousel-{{ $id }}"
                data-bs-slide-to="{{ $index }}"
                class="{{ $index === 0 ? 'active' : '' }}"
                aria-label="Slide {{ $index + 1 }}">
            </button>
        @endforeach
    </div>
    @endif

    <div class="carousel-inner">
        @foreach($slides as $index => $slide)
            @if(isset($slide['image']))
            <div class="carousel-item hero-slide {{ $index === 0 ? 'active' : '' }}">
                <div class="hero-slide-bg"
                     style="background-image: url('{{ Storage::url($slide['image']) }}');">
                </div>

                <div class="hero-overlay"></div>

                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="carousel-caption hero-caption text-start">
                                @if(!empty($slide['eyebrow']))
                                    <div class="hero-eyebrow">{{ $slide['eyebrow'] }}</div>
                                @endif

                                @if(isset($slide['title']))
                                    <h2 class="hero-title">{{ $slide['title'] }}</h2>
                                @endif

                                @if(isset($slide['description']))
                                    <p class="hero-subtitle">{{ $slide['description'] }}</p>
                                @endif

                                @if(isset($slide['link']))
                                    <a href="{{ $slide['link'] }}"
                                       class="btn hero-cta">
                                        {{ $slide['button_label'] ?? 'Voir plus' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>

    @if($options['arrows'] ?? true)
    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $id }}" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $id }}" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
    @endif
</div>
</section>
@endif
