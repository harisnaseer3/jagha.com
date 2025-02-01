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


{{--@foreach($featured_agencies as $agency)--}}
{{--    <div class="slick-slide-item" aria-label="featured agency">--}}
{{--        @if( $agency->user_id !== 1 && $agency->logo !== null)--}}
{{--            <a href="{{ route('agents.ads.listing', [--}}
{{--                        'city' => strtolower(Str::slug($agency->city)),--}}
{{--                        'slug' => \Illuminate\Support\Str::slug($agency->title),--}}
{{--                        'agency' => $agency->id--}}
{{--                    ]) }}">--}}
{{--                <img src="{{ asset('thumbnails/agency_logos/' . explode('.', $agency->logo)[0] . '-100x100' . '.webp') }}"--}}
{{--                     alt="{{ strtoupper($agency->title) }}"--}}
{{--                     width="50%" height="50%"--}}
{{--                     class="img-fluid"--}}
{{--                     title="{{ strtoupper($agency->title) }}"--}}
{{--                     onerror="this.onerror=null; this.src='{{ asset('img/logo/dummy-logo.png') }}';">--}}
{{--            </a>--}}
{{--        @else--}}
{{--            @php--}}
{{--                // Array of multiple dummy images--}}
{{--                $dummyImages = [--}}
{{--                    'img/logo/image 1.png',--}}
{{--                    'img/logo/image 2.png',--}}
{{--                    'img/logo/image 3.png',--}}
{{--                    'img/logo/image 4.png',--}}
{{--                    'img/logo/image 5.png',--}}
{{--                    'img/logo/image 6.png',--}}
{{--                    'img/logo/image 7.png',--}}
{{--                    'img/logo/image 8.png',--}}
{{--                    'img/logo/image 9.png',--}}
{{--                    'img/logo/image 10.png',--}}
{{--                    'img/logo/image 11.png',--}}
{{--                    'img/logo/image 12.png',--}}
{{--                    'img/logo/image 13.png',--}}
{{--                    'img/logo/image 14.png',--}}
{{--                    'img/logo/image 15.png',--}}
{{--                    'img/logo/image 16.png',--}}
{{--                    'img/logo/image 17.png',--}}
{{--                    'img/logo/image 18.png',--}}
{{--                    'img/logo/image 19.png'--}}
{{--                ];--}}
{{--                // Select a random dummy image--}}
{{--                $randomImage = asset($dummyImages[array_rand($dummyImages)]);--}}
{{--            @endphp--}}

{{--            <a href="{{ route('agents.ads.listing', [--}}
{{--                        'city' => strtolower(Str::slug($agency->city)),--}}
{{--                        'slug' => \Illuminate\Support\Str::slug($agency->title),--}}
{{--                        'agency' => $agency->id--}}
{{--                    ]) }}">--}}
{{--                <img src="{{ $randomImage }}"--}}
{{--                     alt="{{ strtoupper($agency->title) }}"--}}
{{--                     width="50%" height="50%"--}}
{{--                     class="img-fluid"--}}
{{--                     title="{{ strtoupper($agency->title) }}"--}}
{{--                     onerror="this.onerror=null; this.src='{{ asset('img/logo/dummy-logo.png') }}';">--}}
{{--            </a>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--@endforeach--}}
