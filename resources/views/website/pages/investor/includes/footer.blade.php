<footer id="foot-wrap-investor" class="left relative">
    <div id="foot-top-wrap" class="left relative">
        <div class="body-main-out relative">
            <div class="body-main-in">
                <div id="foot-widget-wrap" class="left relative" style="display: flex; justify-content: space-between;">
                    <!-- Column 1: Logo and Info -->
                    <div class="foot-widget left relative">
                        <div class="foot-logo left relative">
                            <a href="https://www.jagha.com">
                                <img src="{{asset('img/logo/new-white-logo.png')}}" alt="Jagha" data-rjs="2" />
                            </a>
                        </div>
                        <div class="investor-foot-info-text left relative text-white">
                            <p class="text-white">Pakistan history, culture, civilization, architecture, politics,
                                constitution, election, music, drama, film, theatre, food, natural resources and more.</p>
                        </div>
                        <div>
                            <button class="btn btn-search footer-btn transition-background green-color">Learn More <span>&rarr;</span></button>
                        </div>
                    </div>

                    <!-- Column 2: Recent Properties -->
                    <div class="foot-widget left relative">
                        <h3 class="foot-head">Recent Properties</h3>
                        <ul class="blog-widget-list left relative text-white">
                            <li>About Us</li>
                            <li style="border: none">Contact Us</li>
                            <li style="border: none">Jobs</li>
                            <li style="border: none">Blogs</li>
                            <li style="border: none">Updates</li>
                            <li style="border: none">Privacy Policy</li>
                        </ul>
                    </div>

                    <!-- Column 3: Features -->
                    <div class="foot-widget left relative">
                        <h3 class="foot-head">Features</h3>
                        <ul class="blog-widget-list left relative text-white">
                            <li style="border: none">Why Choose Us</li>
                            <li style="border: none">Vision</li>
                            <li style="border: none">Mission</li>
                            <li style="border: none">Our Partners</li>
                            <li style="border: none">Investors</li>
                        </ul>
                    </div>

                    <!-- Column 4: Contact Us -->
                    <div class="foot-widget left relative">
                        <h3 class="foot-head">Contact Us</h3>
                        <ul class="blog-widget-list left relative text-white">
                            <p><i class="fa fa-phone"></i> +92 51 4862317</p>
                            <p><i class="fa fa-mobile"></i> +92 315 5141959</p>
                            <p><i class="fa fa-envelope"></i> info@jagha.com</p>
                            <h3 class="foot-head mt-20 mb-2">Join us on Social</h3>
                            <div>
                                <a href="https://www.facebook.com/profile.php?id=61570901009233" target="_blank"><i class="fab fa-facebook-f investor-foot-icons font-24"></i></a>
{{--                                <a href="https://twitter.com/jaghapk" target="_blank"><i class="fab fa-twitter investor-foot-icons"></i></a>--}}
{{--                                <a href="https://www.linkedin.com/company/jaghapk" target="_blank"><i class="fab fa-linkedin investor-foot-icons"></i></a>--}}
{{--                                <a href="https://www.instagram.com/jaghapk/" target="_blank"><i class="fab fa-instagram investor-foot-icons"></i></a>--}}
                                <a href="https://www.youtube.com/channel/jaghapk" target="_blank"><i class="fab fa-youtube investor-foot-icons"></i></a>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="foot-bot-wrap" class="left relative">
        <div class="body-main-out relative">
            <div class="body-main-in">
                <div id="foot-bot" class="left relative">
                    <div class="foot-copy relative">
                        <p>Copyright © <span id="current-year"></span>. Jagha. All rights reserved.</p>
                        <script>
                            document.getElementById("current-year").textContent = new Date().getFullYear();
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<style>
    #foot-widget-wrap {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
    }

    .foot-widget {
        flex: 1; /* All columns take equal space */
        max-width: 22%; /* Adjust column width */
    }

    .foot-widget h3 {
        margin-bottom: 40px;
        font-size: 24px;
        color: white;
    }

    .foot-widget ul {
        list-style: none;
        padding: 0;
    }

    .foot-widget ul li, .foot-widget ul p {
        font-size: 14px;
        color: white;
        margin-bottom: 10px;
    }

    .foot-logo img {
        width: 100%;
        max-width: 150px;
    }

    @media screen and (max-width: 768px) {
        #foot-widget-wrap {
            flex-direction: column;
            align-items: center;
        }

        .foot-widget {
            max-width: 100%; /* Make columns full width on small screens */
        }
    }

</style>
