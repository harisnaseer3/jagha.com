@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection

@section('json-ld')
    <?php echo $localBusiness->toScript()  ?>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection
@section('content')

    @include('website.includes.nav')
    <!-- Banner start -->
    <div class="container-fluid">
    @include('website.includes.index-page-banner')
    <!-- Search Section start -->
    @include('website.includes.search2')
     <!-- Featured properties start -->
     @include('website.includes.property_counter')
    <!-- Featured properties start -->
    @include('website.includes.featured_properties')
    <!-- featured agencies -->
    @include('website.includes.partner')
    <!-- Key agencies -->
    @include('website.includes.featured_agencies')

    <!-- Most popular places start -->
    @include('website.includes.popular_places_listing')
        <div class="clearfix"></div>
        <!-- Blog start -->
    @include('website.includes.recent_blogs')
    </div>
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
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="http://malsup.github.io/jquery.cycle2.js"></script>
    <script src="http://malsup.github.io/jquery.cycle2.carousel.js"></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('website/js/rangeslider.js')}}"></script>



    <script>
        $.fn.cycle.defaults.autoSelector = '#agency-slider';
        $.fn.cycle.defaults.autoSelector = '#featured-agency-slider';
        (function ($) {
	$.fn.countTo = function (options) {
		options = options || {};

		return $(this).each(function () {
			// set options for current element
			var settings = $.extend({}, $.fn.countTo.defaults, {
				from:            $(this).data('from'),
				to:              $(this).data('to'),
				speed:           $(this).data('speed'),
				refreshInterval: $(this).data('refresh-interval'),
				decimals:        $(this).data('decimals')
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

				if (typeof(settings.onUpdate) == 'function') {
					settings.onUpdate.call(self, value);
				}

				if (loopCount >= loops) {
					// remove the interval
					$self.removeData('countTo');
					clearInterval(data.interval);
					value = settings.to;

					if (typeof(settings.onComplete) == 'function') {
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
}(jQuery));

jQuery(function ($) {
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
});
    </script>
    <script>
        (function ($) {
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
                var paused = false,

                    agency_interval = setInterval(function () {
                        (!paused) && $('#agency-next').trigger('click');
                        $('#middle-agency-name').html($("#agency-slider .slick-center .slick-slide-item .agency-name").text() + ' (' + $("#agency-slider .slick-center .slick-slide-item .agency-city").text() + ')');
                        $('#sale-count').html($("#agency-slider .slick-center .slick-slide-item .sale-count").text() + ' Total Properties');
                        $('#agency-phone').html($("#agency-slider .slick-center .slick-slide-item .agency-phone").text());
                    }, 3000);

                interval = setInterval(function () {
                    (!paused) && $('#featured-agency-next').trigger('click');
                }, 4000);

                $('#agency-slider, .controls').click(function () {
                    $('#middle-agency-name').html($("#agency-slider .slick-center .slick-slide-item .agency-name").text() + ' (' + $("#agency-slider .slick-center .slick-slide-item .agency-city").text() + ')');
                    $('#sale-count').html($("#agency-slider .slick-center .slick-slide-item .sale-count").text() + ' Total Properties');
                });

                $('#featured-agency-slider .slick-slide-item').hover(function (ev) {
                    clearInterval(interval);
                }, function (ev) {
                    interval = setInterval(function () {
                        (!paused) && $('#featured-agency-next').trigger('click');
                    }, 4000);
                });
                $('#agency-slider .slick-slide-item').hover(function (ev) {
                    clearInterval(agency_interval);
                }, function (ev) {
                    agency_interval = setInterval(function () {
                        (!paused) && $('#agency-next').trigger('click');
                        $('#middle-agency-name').html($("#agency-slider .slick-center .slick-slide-item .agency-name").text() + ' (' + $("#agency-slider .slick-center .slick-slide-item .agency-city").text() + ')');
                        $('#sale-count').html($("#agency-slider .slick-center .slick-slide-item .sale-count").text() + ' Total Properties');
                        $('#agency-phone').html($("#agency-slider .slick-center .slick-slide-item .agency-phone").text());
                    }, 3000);

                });

                $('.select2').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                });
                $('.select2bs4').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                    theme: 'bootstrap4',
                });
                let form = $('#sign-in-card');
                form.validate({
                    rules: {
                        email: {
                            required: true,
                        },
                        password: {
                            required: true,
                        }
                    },
                    messages: {},
                    errorElement: 'small',
                    errorClass: 'help-block text-red',
                    submitHandler: function (form) {
                        event.preventDefault();
                    },
                    invalidHandler: function (event, validator) {
                        // 'this' refers to the form
                        const errors = validator.numberOfInvalids();
                        if (errors) {
                            let error_tag = $('div.error.text-red');
                            error_tag.hide();
                            const message = errors === 1
                                ? 'You missed 1 field. It has been highlighted'
                                : 'You missed ' + errors + ' fields. They have been highlighted';
                            $('div.error.text-red span').html(message);
                            error_tag.show();
                        } else {
                            $('div.error.text-red').hide();

                        }
                    }
                });

                $('#sign-in-btn').click(function (event) {
                    if (form.valid()) {
                        event.preventDefault();
                        jQuery.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        event.preventDefault();
                        jQuery.ajax({
                            type: 'post',
                            url: window.location.origin + '/property' + '/login',
                            data: form.serialize(),
                            dataType: 'json',
                            success: function (data) {
                                console.log(data);
                                if (data.data) {
                                    console.log(data.user);
                                    $('.error-tag').hide();
                                    $('#exampleModalCenter').modal('hide');
                                    let user_dropdown = $('.user-dropdown')
                                    user_dropdown.html('');
                                    let user_name = data.user.name;
                                    let user_id = data.user.id;
                                    let html =
                                        '            <div class="dropdown">' +
                                        '                <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="javascript:void(0);" id="dropdownMenuButton" aria-haspopup="true"' +
                                        '                    aria-expanded="false">' +
                                        '                      <i class="fas fa-user mr-3"></i>';
                                    html += 'Logged in as' + user_name;
                                    html += '</a>' +
                                        '                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                                    html += '<a class="dropdown-item" href=" ' + window.location.origin + '/property' + '/dashboard/accounts/users/' + user_id + '/edit"><i class="far fa-user-cog mr-2"></i>Manage Profile</a>' +
                                        '                     <div class="dropdown-divider"></div>' +
                                        '                          <a class="dropdown-item" href="{{route("accounts.logout")}}"><i class="far fa-sign-out mr-2"></i>Logout</a>';
                                    html += '</div>' + '</div>';

                                    user_dropdown.html(html);
                                    // window.location.reload(true);
                                } else if (data.error) {
                                    $('div.help-block small').html(data.error.password);
                                    $('.error-tag').show();
                                }
                            },
                            error: function (xhr, status, error) {
                                event.preventDefault();

                                console.log(error);
                                console.log(status);
                                console.log(xhr);
                            },
                            complete: function (url, options) {
                            }
                        });
                    }
                });
            });
        })(jQuery);
    </script>
    <script src="{{asset('website/js/popper.min.js')}}"></script>
    <script src="{{asset('website/js/script-custom.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.bundle.min.js')}}"></script>

@endsection
