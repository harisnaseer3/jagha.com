<div class="banner main-page-banner" id="banner">
    <div id="bannerCarousole" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item banner-max-height active">
                <img class="d-block w-100" src="{{asset('img/banner/banner-2.webp')}}" alt="banner">
                <div class="carousel-caption banner-slider-inner d-flex h-100 text-center">
                    <div class="carousel-content container">
                        <div class="text-center">
                            <!-- Heading -->
                            <h1 class="main-page-banner-heading">Find Best Projects to Invest</h1>

                            <!-- Search Bar -->
                            <div class="inline-search-area none-992">
                                {{ Form::open(['route' => 'properties.search', 'method' => 'get', 'role' => 'form', 'class' => 'index-form']) }}
                                <div class="search-bar-container">
                                    <!-- Input Field -->
                                    <input
                                        type="search"
                                        id="search-bar"
                                        name="query"
                                        class="search-bar-input"
                                        placeholder="Search Project by city or name"
                                    />
                                    <!-- Search Button -->
                                    <button
                                        type="submit"
                                        class="search-bar-button transition-background color-green">
                                        <i class="fa fa-search color-green"></i> Find Project
                                    </button>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Embedded CSS -->
<style>
    /* Container for search bar */
    .search-bar-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px auto;
        max-width: 600px;
        border-radius: 50px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        background-color: #ffffff;
    }

    /* Input field */
    .search-bar-input {
        flex: 1;
        padding: 15px 20px;
        border: none;
        outline: none;
        font-size: 1rem;
        color: #555;
    }

    /* Button */
    .search-bar-button {
        padding: 15px 30px;
        font-size: 1rem;
        font-weight: bold;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
    }

    .search-bar-button:hover {
        background-color: #c6a700;
    }

    /* Button icon */
    .search-bar-button i {
        margin-right: 8px;
    }

    /* Banner heading */
    .main-page-banner-heading {
        font-size: 2.5rem;
        color: #ffffff;
        margin-bottom: 20px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
    }
</style>
