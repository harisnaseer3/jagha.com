@foreach($featured_agencies as $agency)
    <div class="slick-slide-item" aria-label="featured agency">
        @php
            $logoPath = 'thumbnails/agency_logos/' . explode('.', $agency->logo)[0] . '-100x100.webp';
            $logoExists = file_exists(public_path($logoPath));
            $logoUrl = $logoExists ? asset($logoPath) : asset('img/logo/dummy-logo.png');
        @endphp

        <a href="{{ route('agents.ads.listing', [
            'city' => strtolower(Str::slug($agency->city)),
            'slug' => \Illuminate\Support\Str::slug($agency->title),
            'agency' => $agency->id,
        ]) }}">
            <img src="{{ $logoUrl }}"
                 alt="{{ strtoupper($agency->title) }}"
                 width="50%" height="50%"
                 class="img-fluid"
                 title="{{ strtoupper($agency->title) }}"
                 onerror="this.onerror=null; this.src='{{ asset('img/logo/dummy-logo.png') }}';">
        </a>

        <h2 class="agency-name mt-3 text-transform d-none">{{ $agency->title }}</h2>
        <h2 class="agency-phone mt-3 text-transform d-none">{{ $agency->phone }}</h2>
        <h2 class="sale-count mt-3 text-transform d-none">{{ $agency->count }}</h2>
        <div class="mt-1 agency-city d-none">{{ $agency->city }}</div>
    </div>
@endforeach
