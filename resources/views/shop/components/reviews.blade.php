@php
    $reviews = $content['reviews'] ?? [];
    $style = $content['style'] ?? 'slider';
@endphp

<div class="container mb-5">
    <h2 class="text-center mb-4">{{ $content['title'] ?? 'Avis Clients' }}</h2>
    
    @if($style === 'slider')
    <div id="reviews-{{ $id }}" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach(array_chunk($reviews, 1) as $index => $chunk)
                @foreach($chunk as $review)
                    @if(isset($review['text']) && !empty($review['text']))
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="card border-0 text-center">
                            <div class="card-body">
                                <div class="text-warning mb-2" style="font-size: 1.2rem;">
                                    @for($i = 0; $i < ($review['rating'] ?? 5); $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                </div>
                                <blockquote class="blockquote mb-4">
                                    <p>"{{ $review['text'] }}"</p>
                                </blockquote>
                                <figcaption class="blockquote-footer">
                                    {{ $review['name'] ?? 'Client' }}
                                </figcaption>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#reviews-{{ $id }}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#reviews-{{ $id }}" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle"></span>
        </button>
    </div>
    @else
    <div class="row">
        @foreach($reviews as $review)
            @if(isset($review['text']) && !empty($review['text']))
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="text-warning mb-2">
                            @for($i = 0; $i < ($review['rating'] ?? 5); $i++)
                                <i class="bi bi-star-fill"></i>
                            @endfor
                        </div>
                        <p class="card-text">"{{ $review['text'] }}"</p>
                        <h6 class="card-subtitle mt-2 text-muted">- {{ $review['name'] ?? 'Client' }}</h6>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
    @endif
</div>
