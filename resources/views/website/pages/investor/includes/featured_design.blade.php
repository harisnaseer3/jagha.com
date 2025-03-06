<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .containers {
        display: flex;
        flex-wrap: wrap;
        height: 70vh;
    }

    .left-content {
        flex: 1;
        background: url("../img/building/investor-benefits.jpg") no-repeat center center/cover;
        color: white;
        padding: 4rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        /*    !*height: fit-content;*!*/
        position: relative; /* Set relative position to parent element */
        height: 660px;
    }

    .left-content::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: black; /* Black overlay */
        opacity: 0.8; /* Adjust the opacity (0.1 to 1 for transparency) */
        z-index: 1; /* Ensure the overlay is on top of the background image */
    }

    .left-content * {
        position: relative; /* Ensure the child elements appear above the overlay */
        z-index: 2;
    }

    .left-content h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
        line-height: 1.2;
        color: white;
    }

    .left-content p {
        margin-bottom: 1rem;
        line-height: 1.6;
        max-width: 600px;
        color: white;
    }

    .learn-more-button {
        width: 11%;
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        text-transform: uppercase;
        font-weight: bold;
        /*width: fit-content;*/
    }

    .learn-more-button:hover {
        background-color: #ffc107;
    }

    .learn-more-button span {
        margin-left: 0.5rem;
        font-size: 1.2rem;
    }

    .right-content {
        flex: 1;
        background: url("../img/building/mall.png") no-repeat center center/cover;
        width: 40%;
        position: absolute;
        height: 690px;
        align-self: end;
        margin-top: 120px;
    }

    @media (max-width: 1024px) {
        .containers {
            flex-direction: column;
            height: auto;
        }

        .left-content, .right-content {
            flex: 1 0 auto;
            height: 50vh;
        }

        .left-content {
            padding: 2rem;
        }

        .left-content h1 {
            font-size: 2rem;
        }

        .left-content p {
            font-size: 0.9rem;
        }

        .learn-more-button {
            font-size: 0.9rem;
            padding: 0.7rem 1.2rem;
        }

        .learn-more-button span {
            font-size: 1rem;
        }
    }
    .testimonial-card {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .testimonial-quote {
        font-size: 2rem;
        color: #d4af37;
    }
    .testimonial-name {
        font-weight: bold;
        color: #8b8000;
    }
    .testimonial-company {
        color: #707070;
        font-style: italic;
    }
</style>

<body>
<div class="containers">
    <div class="left-content">
        <div class="right-content"></div>
        <h1>Why invest with Jagha.com?</h1>
        <p>Unlock lucrative real estate opportunities with high appreciation potential and strong rental yields.
            Our carefully selected properties ensure maximum returns on your investment.</p>
        <p>We prioritize security and transparency, providing you with clear investment insights,
            legal guidance, and trusted property management services.</p>
        <button class="learn-more-button transition-background color-green">Learn More <span>&rarr;</span></button>
    </div>
</div>

{{--<div class="container mt-5">--}}
{{--    <h2 class="text-center mb-4" style="color: blue">Slider under construction</h2>--}}
{{--    <h2 class="text-center mb-4" style="color: black">What investors say about us?</h2>--}}
{{--    <div--}}
{{--        id="testimonialCarousel"--}}
{{--        class="carousel slide"--}}
{{--        data-bs-ride="carousel"--}}
{{--    >--}}
{{--        <div class="carousel-inner">--}}
{{--            <!-- First Testimonial -->--}}
{{--            <div class="carousel-item active">--}}
{{--                <div class="testimonial-card mx-auto">--}}
{{--                    <div class="testimonial-quote">“</div>--}}
{{--                    <p>--}}
{{--                        Lorem ipsum dolor sit amet consectetur. Eu a aenean vulputate--}}
{{--                        tristique tortor interdum. Vitae facilisi nunc nisl nec. Porttitor--}}
{{--                        pellentesque neque amet molestie lacus est bibendum.--}}
{{--                    </p>--}}
{{--                    <p class="testimonial-name">John Doe</p>--}}
{{--                    <p class="testimonial-company">Dream Properties Lahore</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- Second Testimonial -->--}}
{{--            <div class="carousel-item">--}}
{{--                <div class="testimonial-card mx-auto">--}}
{{--                    <div class="testimonial-quote">“</div>--}}
{{--                    <p>--}}
{{--                        Lorem ipsum dolor sit amet consectetur. Augue proin nibh risus--}}
{{--                        sapien. Porttitor pellentesque neque amet molestie lacus est--}}
{{--                        bibendum.--}}
{{--                    </p>--}}
{{--                    <p class="testimonial-name">Jane Smith</p>--}}
{{--                    <p class="testimonial-company">Prime Real Estate</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- Add more testimonials as needed -->--}}
{{--        </div>--}}
{{--        <div class="slick-btn">--}}
{{--            <div class="slick-prev slick-arrow-buton">--}}
{{--                <i class="fa fa-angle-left"></i>--}}
{{--            </div>--}}
{{--            <div class="slick-next slick-arrow-buton">--}}
{{--                <i class="fa fa-angle-right"></i>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

</body>
