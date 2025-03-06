@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/intl-tel-input/css/intlTelInput.min.css')}}" async defer>
    <style>
        .call-model-btn {
            background-color: white;
        }
    </style>

@endsection

@section('content')
    <!-- Main header start -->
    @include('website.includes.nav')

    <div class="containers">
        <div class="section banner">
            <img class="d-block w-100" src="img/about-us/banner.jpg" alt="banner-img">
            <div class="overlay">
                <h1 class="color-yellow">Jagha.com</h1>
                <p>A platform where buyers and sellers can interact for their properties – interactive, smart, and easy to use portal.</p>
            </div>
        </div>

        <div class="company-overview">
            <div class="text-section">
                <h2>Company Overview</h2>
                <p>Jagha.com is a leading digital property platform in Pakistan, providing an online
                    marketplace for buying, selling, and investing in real estate. It offers a transparent and
                    secure environment for property transactions, catering to both local and overseas
                    Pakistanis. Unlike traditional real estate platforms like Zameen.com, Jagha.com
                    introduces a unique value proposition with its Investor Tab and Dealer Tab that ensure
                    easy navigation for specific user needs—whether you're looking for investment
                    opportunities or connecting with genuine dealers for verified property transactions.
                    Jagha.com stands out for its commitment to transparency, trust, and verified listings,
                    ensuring that users find genuine properties with a high level of assurance.</p>
            </div>
            <div class="image-section">
                <img src="img/about-us/video.png" alt="Jagha Logo">
                <button class="play-button">
                    <img src="img/about-us/play-btn.png" alt="Play">
                </button>
            </div>
        </div>

        <div class="vision-mission-section">
            <div class="vision-mission-content">
                <div class="card">
                    <h2>Vision</h2>
                    <p>To be the most trusted and innovative digital property platform in Pakistan, creating a seamless and transparent real estate experience for investors, dealers, and the general
                        public, both locally and globally.</p>
                </div>
                <div class="card">
                    <h2>Mission</h2>
                    <p>Our mission is to revolutionize Pakistan's real estate industry by offering a user-friendly, transparent, and secure platform for property transactions. Jagha.com strives to
                        empower investors, homebuyers, and dealers by providing verified listings, market insights, and easy access to real estate investment opportunities.</p>
                </div>
            </div>
        </div>

        <div class="who-we-are-section">
            <div class="who-we-are-container">
                <div class="image-container">
                    <img src="img/about-us/who-we-are.png" alt="Jagha Shield">
                </div>
                <div class="text-container">
                    <h2>Who We Are</h2>
                    <p>For over two decades, Aroma Real Estate has stood as a powerhouse in the real
                        estate industry, building a legacy of trust, expertise, and unmatched service. Our
                        deep specialization in selling, marketing, and leasing real estate has earned us a
                        solid reputation, while our expertise in property reselling, apartment leasing, and
                        hospitality services has set us apart as true market leaders. We ve also
                        mastered the intricacies of mall leasing, operations, and models, becoming the
                        go to name for large scale commercial spaces.</p>

                    <p>Serving over 20,000 esteemed clients locally and internationally, we ve
                        consistently delivered exceptional results and built lasting relationships. But
                        we re not stopping there—today, we re redefining the future of real estate with
                        Jagha.com. With this powerful digital platform, we re taking everything that
                        made us great and bringing it to your fingertips. As a trusted, authentic brand,
                        Jagha.com offers you access to a world of investment opportunities—from
                        homes and offices to shops and commercial spaces. We re not just offering
                        properties; we re offering the right investment solutions, tailored for your
                        success. </p>

                    <p>Get ready to experience real estate in a whole new way with Jagha.com—where
                        innovation, trust, and expertise meet.</p>
                </div>
            </div>
        </div>

        <div class="usp-section">
            <div class="usp-overlay">
                <h2>Unique Selling Proposition (USP)</h2>
                <div class="usp-container">
                    <div class="usp-item">
                        <span class="usp-number">1</span>
                        <h3>Investor Tab</h3>
                        <p>A specialized section for real estate investors, providing access to lucrative investment opportunities and insights into the market.</p>
                    </div>
                    <div class="usp-item">
                        <span class="usp-number">2</span>
                        <h3>Dealer Tab</h3>
                        <p>A separate platform designed for professional property dealers to connect with verified buyers and sellers, streamlining transactions.</p>
                    </div>
                    <div class="usp-item">
                        <span class="usp-number">3</span>
                        <h3>Verified Properties</h3>
                        <p>Every listing on Jagha.com undergoes a rigorous verification process to ensure authenticity, giving users peace of mind.</p>
                    </div>
                    <div class="usp-item">
                        <span class="usp-number">4</span>
                        <h3>REIT Tab</h3>
                        <p>Jagha.com will soon introduce access to global real estate investment trusts (REITs), redefining how investors explore opportunities.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="projects-features">
            <div class="image-container">
                <img src="img/about-us/key-features.jpg" alt="Projects and Features">
            </div>
            <div class="features-container">
                <h2>Key Projects and Features</h2>

                <div class="feature-item">
                    <img src="img/about-us/investor-icon.png" alt="Investor Icon">
                    <div>
                        <h3>Investor Tab</h3>
                        <p>A dedicated section for investors looking for profitable
                            property investments. This includes curated listings,
                            market trends, and insights into the best investment
                            opportunities across Pakistan.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <img src="img/about-us/delar-icon.png" alt="Dealer Icon">
                    <div>
                        <h3>Dealer Tab</h3>
                        <p>A separate platform for verified property dealers,
                            ensuring secure and professional transactions
                            between buyers and sellers.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <img src="img/about-us/reit.png" alt="REIT Icon">
                    <div>
                        <h3>REIT Tab (Real Estate Investment Trust)</h3>
                        <p>Jagha.com will offer a new feature, linking users to
                            global real estate investment opportunities through the
                            REIT model. This will open up property investments to
                            a wider audience, including small scale investors, by
                            offering a transparent, regulated investment model.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <img src="img/about-us/verified-listings.png" alt="Verified Icon">
                    <div>
                        <h3>Verified Listings</h3>
                        <p>Jagha.com ensures that all listed properties are verified,
                            ensuring peace of mind for buyers and sellers.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <img src="img/about-us/marketing-insight.png" alt="Market Icon">
                    <div>
                        <h3>Market Insights</h3>
                        <p>Offering the latest market trends, property evaluations, and
                            expert opinions to help users make informed decisions.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="key-partners">
            <h2>Key Partners</h2>
            <p>
                Jagha.com works with a wide network of real estate developers, property dealers, legal experts, and financial institutions to
                provide its users with a comprehensive range of verified property listings. The platform also collaborates with legal and
                financial advisors to ensure that all transactions are secure and comply with Pakistans real estate regulations.
            </p>
            <div class="partners">
                    <div class="slick-slider-area" id="agency-slider">
                        <div class="row slick-carousel" id="featured-agencies-section" data-cycle-fx="carousel" data-cycle-timeout="0" data-cycle-next="slick-next" data-cycle-prev="slick-prev"
                             data-cycle-carousel-horizontal="true"
                             data-slick='{"slidesToShow": 5, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 5}}, {"breakpoint": 768,"settings":{"slidesToShow": 3}}]}'>
                            @include('website.components.featured_agencies')
                        </div>
                        <div class="controls">
                            <div class="slick-prev slick-arrow-buton" id="agency-prev" style="left: -60px;">
                                <i class="fas fa-angle-left"></i>
                            </div>
                            <div class="slick-next slick-arrow-buton" id="agency-next" style="right: -60px;">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="view-all">
                <a href="{{route('featured-partners',['sort'=>'newest'])}}" class="btn transition-background color-green">View All →</a>
            </div>
        </div>

        <div class="testimonials">
            <h2>What investors say about us?</h2>
            <div class="testimonial-container">
                {{--                <button id="prevBtn" class="arrow left">❮</button>--}}
                <div class="testimonial-slider">
                    @foreach($testimonials as $testimonial)
                        <div class="testimonial" onclick="expandCard(this)">
                            <div class="testimonial-content">
                                <p class="testimonial-text" data-full="{{ $testimonial->review }}"></p>
                            </div>
                            <div class="testimonial-footer">
                                <h4 class="author">{{ $testimonial->name }}</h4>
                                <p class="company">{{ $testimonial->company }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{--                <button id="nextBtn" class="arrow right">❯</button>--}}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const testimonials = document.querySelectorAll(".testimonial");

            testimonials.forEach(testimonial => {
                let textElement = testimonial.querySelector(".testimonial-text");
                let fullText = textElement.dataset.full;
                let words = fullText.split(" ");

                if (words.length > 10) {
                    let shortText = `"${words.slice(0, 10).join(" ")}..."`;
                    textElement.innerText = shortText;
                } else {
                    textElement.innerText = `"${fullText}"`;
                }
            });
        });

        function expandCard(card) {
            let textElement = card.querySelector(".testimonial-text");
            let fullText = textElement.dataset.full;
            let isExpanded = card.classList.contains("expanded");

            if (isExpanded) {
                let words = fullText.split(" ");
                let shortText = `"${words.slice(0, 10).join(" ")}..."`;
                textElement.innerText = shortText;
                card.classList.remove("expanded");
            } else {
                textElement.innerText = `"${fullText}"`;
                card.classList.add("expanded");
            }
        }

        $(document).ready(function () {
            $('#agency-slider').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 3000,
                prevArrow: $('#prevBtn'),
                nextArrow: $('#nextBtn'),
                responsive: [
                    {breakpoint: 1024, settings: {slidesToShow: 3}},
                    {breakpoint: 768, settings: {slidesToShow: 2}},
                    {breakpoint: 480, settings: {slidesToShow: 1}}
                ]
            });
        });


    </script>


    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .banner {
            position: relative;
            width: 100%;
            /*height: 250px;*/
            overflow: hidden;
        }

        .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.6); /* Semi-transparent black */
            color: #fff;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
        }

        .overlay h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            /*color: #d4af37; !* Gold color *!*/
        }

        .overlay p {
            color: #fff;
            font-size: 14px;
            margin-top: 10px;
        }

        .company-overview {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            max-width: 80%;
            margin: auto;
            padding: 40px 20px;
        }

        .text-section {
            width: 60%;
        }

        .text-section h2 {
            font-size: 24px;
            font-weight: bold;
            color: #222;
        }

        .text-section p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .image-section {
            width: 40%;
            position: relative;
        }

        .image-section img {
            width: 100%;
            border-radius: 10px;
            display: block;
        }

        .play-button {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .play-button img {
            width: 50px;
            height: 50px;
        }

        .vision-mission-section {
            position: relative;
            background: url('img/about-us/mission-vision.jpg') no-repeat center center/cover;
            padding: 80px 10%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vision-mission-content {
            position: relative;
            display: flex;
            gap: 5%;
            max-width: 80%;
            width: 100%;
            justify-content: space-between;
        }

        .card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex: 1;
            max-width: 60%;
            position: relative;
            z-index: 1;
        }

        .card h2 {
            color: #05602f;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .card p {
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .vision-mission-content {
                flex-direction: column;
                align-items: center;
            }

            .card {
                max-width: 100%;
            }
        }

        .who-we-are-section {
            padding: 80px 10%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
        }

        .who-we-are-container {
            display: flex;
            align-items: center;
            gap: 40px;
            max-width: 1200px;
            width: 100%;
        }

        .image-container {
            flex: 1;
            max-width: 50%;
        }

        .image-container img {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .text-container {
            flex: 1;
            max-width: 50%;
        }

        .text-container h2 {
            font-size: 28px;
            font-weight: bold;
            color: #000;
            margin-bottom: 15px;
        }

        .text-container p {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .who-we-are-container {
                flex-direction: column;
                text-align: center;
            }

            .image-container, .text-container {
                max-width: 100%;
            }
        }

        .usp-section {
            background: url('img/about-us/usps.jpg') no-repeat center center/cover;
            position: relative;
            padding: 100px 10%;
            text-align: center;
            color: #fff;
        }

        .usp-overlay h2 {
            /*background: rgba(0, 0, 0, 0.6); !* Dark overlay *!*/
            padding: 60px 20px;
            border-radius: 12px;
            color: #fff;
        }

        .usp-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .usp-item {
            flex: 1;
            min-width: 200px;
            max-width: 22%;
            text-align: center;
        }

        .usp-number {
            font-size: 100px;
            font-weight: bold;
            color: #fbc02d; /* Yellow color for numbers */
        }

        .usp-item h3 {
            font-size: 20px;
            font-weight: bold;
            margin-top: -60px;
            color: #fff;
        }

        .usp-item p {
            font-size: 14px;
            margin-top: 25px;
            line-height: 1.6;
            color: #fff;
        }

        @media (max-width: 768px) {
            .usp-container {
                flex-direction: column;
                align-items: center;
            }

            .usp-item {
                max-width: 100%;
            }
        }

        .projects-features {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 50px 10%;
            gap: 40px;
        }

        .image-container {
            max-width: 40%;
        }

        .image-container img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .features-container {
            max-width: 50%;
        }

        .features-container h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .feature-item img {
            width: 40px;
            height: 40px;
        }

        .feature-item h3 {
            font-size: 20px;
            font-weight: bold;
        }

        .feature-item p {
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .projects-features {
                flex-direction: column;
                text-align: center;
            }

            .image-container {
                max-width: 100%;
            }

            .features-container {
                max-width: 100%;
            }

            .feature-item {
                flex-direction: column;
                align-items: center;
            }
        }

        .key-partners {
            text-align: center;
            padding: 8px 5%;
        }

        .key-partners h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .key-partners p {
            font-size: 16px;
            color: #555;
            max-width: 800px;
            margin: 0 auto 30px;
            line-height: 1.5;
        }

        .view-all {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
        }


        .testimonials {
            text-align: center;
            padding: 40px;
            position: relative;
        }

        .testimonial-slider {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            gap: 20px;
            padding: 20px;
        }

        .testimonial {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            text-align: left;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            min-width: 300px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
            overflow: hidden;
            max-height: 200px; /* Initial height */
            transition: max-height 0.3s ease-in-out;
        }

        .testimonial.expanded {
            max-height: 1000px; /* Expands to show full content */
        }

        .testimonial-footer {
            margin-top: auto;
            padding-top: 10px;
        }

        .quote {
            font-size: 24px;
            color: goldenrod;
        }

        .author {
            font-weight: bold;
            color: #d4af37;
        }

        .company {
            color: black;
        }

        /*.arrow {*/
        /*    position: absolute;*/
        /*    top: 50%;*/
        /*    background: green;*/
        /*    border: none;*/
        /*    color: white;*/
        /*    height: 35px;*/
        /*    width: 35px;*/
        /*    font-size: 20px;*/
        /*    !*padding: 10px;*!*/
        /*    border-radius: 50%;*/
        /*    cursor: pointer;*/
        /*}*/

        /*.left {*/
        /*    left: 10px;*/
        /*}*/

        /*.right {*/
        /*    right: 40px;*/
        /*}*/


    </style>
    <!-- Footer start -->
    @include('website.includes.footer')
    <div class="fly-to-top back-to-top">
        <i class="fa fa-angle-up fa-3"></i>
        <span class="to-top-text">To Top</span>
    </div><!--fly-to-top-->
    <div class="fly-fade">
    </div><!--fly-fade-->
@endsection

@section('script')
    <script src="{{asset('website/js/jquery.validate.min.js')}}" defer></script>
    <script src="{{asset('website/js/all-cities-page.js')}}" defer></script>
    <script src="{{asset('website/js/cookie.min.js')}}" defer></script>
@endsection
