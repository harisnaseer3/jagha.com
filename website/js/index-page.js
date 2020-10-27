(function ($) {
    $.fn.countTo = function (options) {
        options = options || {};

        return $(this).each(function () {
            // set options for current element
            var settings = $.extend({}, $.fn.countTo.defaults, {
                from: $(this).data('from'),
                to: $(this).data('to'),
                speed: $(this).data('speed'),
                refreshInterval: $(this).data('refresh-interval'),
                decimals: $(this).data('decimals')
            }, options);

            // how many times to update the value, and how much to increment the value on each update
            var loops = Math.ceil(settings.speed / settings.refreshInterval),
                increment = (settings.to - settings.from) / loops;

            // references & variables that will change with each update
            var self = this,
                $self = $(this),
                loopCount = 0,
                value = settings.from,
                data = $self.data('countTo') || {};

            $self.data('countTo', data);

            // if an existing interval can be found, clear it first
            if (data.interval) {
                clearInterval(data.interval);
            }
            data.interval = setInterval(updateTimer, settings.refreshInterval);

            // initialize the element with the starting value
            render(value);

            function updateTimer() {
                value += increment;
                loopCount++;

                render(value);

                if (typeof (settings.onUpdate) == 'function') {
                    settings.onUpdate.call(self, value);
                }

                if (loopCount >= loops) {
                    // remove the interval
                    $self.removeData('countTo');
                    clearInterval(data.interval);
                    value = settings.to;

                    if (typeof (settings.onComplete) == 'function') {
                        settings.onComplete.call(self, value);
                    }
                }
            }

            function render(value) {
                var formattedValue = settings.formatter.call(self, value, settings);
                $self.html(formattedValue);
            }
        });
    };

    $.fn.countTo.defaults = {
        from: 0,               // the number the element should start at
        to: 0,                 // the number the element should end at
        speed: 1000,           // how long it should take to count between the target numbers
        refreshInterval: 100,  // how often the element should be updated
        decimals: 0,           // the number of decimal places to show
        formatter: formatter,  // handler for formatting the value before rendering
        onUpdate: null,        // callback method for every time the element is updated
        onComplete: null       // callback method for when the element finishes updating
    };

    function formatter(value, settings) {
        return value.toFixed(settings.decimals);
    }

    // custom formatting example
    $('.count-number').data('countToOptions', {
        formatter: function (value, options) {
            return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
        }
    });

    // start all the timers
    $('.timer').each(count);

    function count(options) {
        var $this = $(this);
        options = $.extend({}, options || {}, $this.data('countToOptions') || {});
        $this.countTo(options);
    }

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        var paused = false,
            agency_interval = setInterval(function () {
                (!paused) && $('#agency-next').trigger('click');
                $('#middle-agency-name').html($("#agency-slider .slick-current .slick-slide-item .agency-name").text() + ' (' + $("#agency-slider .slick-current .slick-slide-item .agency-city").text() + ')');
                $('#sale-count').html($("#agency-slider .slick-current .slick-slide-item .sale-count").text() + ' Total Properties');
                $('#agency-phone').html($("#agency-slider .slick-current .slick-slide-item .agency-phone").text());
            }, 3000);

        interval = setInterval(function () {
            (!paused) && $('#featured-agency-next').trigger('click');
        }, 4000);

        $('#agency-slider, .controls').on('click', function () {
            $('#middle-agency-name').html($("#agency-slider .slick-current .slick-slide-item .agency-name").text() + ' (' + $("#agency-slider .slick-current .slick-slide-item .agency-city").text() + ')');
            $('#sale-count').html($("#agency-slider .slick-current .slick-slide-item .sale-count").text() + ' Total Properties');
        });

        $('#featured-agency-slider .slick-slide-item').on('hover', function (ev) {
            clearInterval(interval);
        }, function (ev) {
            interval = setInterval(function () {
                (!paused) && $('#featured-agency-next').trigger('click');
            }, 4000);
        });
        $('#agency-slider .slick-slide-item').on('hover', function (ev) {
            clearInterval(agency_interval);
        }, function (ev) {
            agency_interval = setInterval(function () {
                (!paused) && $('#agency-next').trigger('click');
                $('#middle-agency-name').html($("#agency-slider .slick-current .slick-slide-item .agency-name").text() + ' (' + $("#agency-slider .slick-current .slick-slide-item .agency-city").text() + ')');
                $('#sale-count').html($("#agency-slider .slick-current .slick-slide-item .sale-count").text() + ' Total Properties');
                $('#agency-phone').html($("#agency-slider .slick-current .slick-slide-item .agency-phone").text());
            }, 3000);

        });

        $('.select2').select2({
            language: '{{app()->getLocale()}}',
            direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
        });
        $('.select2bs4').select2({
            language: '{{app()->getLocale()}}',
            direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
            theme: 'bootstrap4',
        });
    });
    $.get('/get-popular-places',  // url
        function (data, textStatus, jqXHR) {  // success callback
            $('#popular-properties-container').html(data.view);

        });
    $.get('/get-main-page-blogs',  // url
        function (data, textStatus, jqXHR) {  // success callback
            $('#main-page-blogs-container').html(data.view);

        });
    $.get('/get-featured-properties',  // url
        function (data, textStatus, jqXHR) {  // success callback
            let slider = $('#featured-properties-section');
            slider.slick('unslick');
            slider.html('');
            slider.html(data.view);
            slider.slick({arrows: false, slidesToShow: 3, responsive: [{breakpoint: 1024, settings: {slidesToShow: 2}}, {breakpoint: 768, settings: {slidesToShow: 1}}]}
            )
            $('[data-toggle="tooltip"]').tooltip();
        });
    $.get('/get-key-partners',  // url
        function (data, textStatus, jqXHR) {  // success callback
            let slider = $('#feature-agency-row-1');
            slider.slick('unslick');
            slider.html('');
            slider.html(data.view);
            slider.slick({arrows: false, slidesToShow: 5, rows: 3, responsive: [{breakpoint: 1024, settings: {slidesToShow: 3}}, {breakpoint: 768, settings: {slidesToShow: 1}}]}
            )
        });
    $.get('/get-featured-partners',  // url
        function (data, textStatus, jqXHR) {  // success callback
            let slider = $('#featured-agencies-section');
            slider.slick('unslick');
            slider.html('');
            slider.html(data.view);
            slider.slick({centerMode: true,arrows: false, slidesToShow: 5, responsive: [{breakpoint: 1024, settings: {slidesToShow: 5}}, {breakpoint: 768, settings: {slidesToShow: 3}}]}
            )
            var paused = false,
                agency_interval = setInterval(function () {
                    (!paused) && $('#agency-next').trigger('click');
                    $('#middle-agency-name').html($("#agency-slider .slick-current .slick-slide-item .agency-name").text() + ' (' + $("#agency-slider .slick-current .slick-slide-item .agency-city").text() + ')');
                    $('#sale-count').html($("#agency-slider .slick-current .slick-slide-item .sale-count").text() + ' Total Properties');
                    $('#agency-phone').html($("#agency-slider .slick-current .slick-slide-item .agency-phone").text());
                }, 3000);

            interval = setInterval(function () {
                (!paused) && $('#featured-agency-next').trigger('click');
            }, 4000);

            $('#agency-slider, .controls').on('click', function () {
                $('#middle-agency-name').html($("#agency-slider .slick-current .slick-slide-item .agency-name").text() + ' (' + $("#agency-slider .slick-current .slick-slide-item .agency-city").text() + ')');
                $('#sale-count').html($("#agency-slider .slick-current .slick-slide-item .sale-count").text() + ' Total Properties');
            });

            $('#featured-agency-slider .slick-slide-item').on('hover', function (ev) {
                clearInterval(interval);
            }, function (ev) {
                interval = setInterval(function () {
                    (!paused) && $('#featured-agency-next').trigger('click');
                }, 4000);
            });
            $('#agency-slider .slick-slide-item').on('hover', function (ev) {
                clearInterval(agency_interval);
            }, function (ev) {
                agency_interval = setInterval(function () {
                    (!paused) && $('#agency-next').trigger('click');
                    $('#middle-agency-name').html($("#agency-slider .slick-current .slick-slide-item .agency-name").text() + ' (' + $("#agency-slider .slick-current .slick-slide-item .agency-city").text() + ')');
                    $('#sale-count').html($("#agency-slider .slick-current .slick-slide-item .sale-count").text() + ' Total Properties');
                    $('#agency-phone').html($("#agency-slider .slick-current .slick-slide-item .agency-phone").text());
                }, 3000);

            });
        });

})(jQuery);
