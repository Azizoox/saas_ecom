@php
    $slides = $content['slides'] ?? [];
    $options = $content['options'] ?? [];
@endphp

@if(count($slides) > 0)
<div id="carousel-{{ $id }}" class="carousel slide mb-5" data-bs-ride="{{ ($options['autoplay'] ?? true) ? 'carousel' : 'false' }}">
    @if($options['pagination'] ?? true)
    <div class="carousel-indicators">
        @foreach($slides as $index => $slide)
            <button type="button" data-bs-target="#carousel-{{ $id }}" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
        @endforeach
    </div>
    @endif

    <div class="carousel-inner">
        @foreach($slides as $index => $slide)
            @if(isset($slide['image']))
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ Storage::url($slide['image']) }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="{{ $slide['title'] ?? '' }}">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                    @if(isset($slide['title']))
                        <h3>{{ $slide['title'] }}</h3>
                    @endif
                    @if(isset($slide['description']))
                        <p>{{ $slide['description'] }}</p>
                    @endif
                    @if(isset($slide['link']))
                        <a href="{{ $slide['link'] }}" class="btn btn-primary">Voir plus</a>
                    @endif
                </div>
            </div>
            @endif
        @endforeach
    </div>

    @if($options['arrows'] ?? true)
    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $id }}" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $id }}" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
    @endif
</div>
@endif
