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
                       $('#middle-agency-name').html($("#agency-slider .slick-center .slick-slide-item .agency-name").text()+' ('+ $("#agency-slider .slick-center .slick-slide-item .agency-city").text()+')');
                       $('#sale-count').html($("#agency-slider .slick-center .slick-slide-item .sale-count").text()+ ' Total Properties');
                       $('#agency-phone').html($("#agency-slider .slick-center .slick-slide-item .agency-phone").text());
                    },3000);

                    interval = setInterval(function () {
                        (!paused) && $('#featured-agency-next').trigger('click');
                    },4000);
                    
                $('#agency-slider, .controls').click(function ()
                {
                    $('#middle-agency-name').html($("#agency-slider .slick-center .slick-slide-item .agency-name").text()+' ('+ $("#agency-slider .slick-center .slick-slide-item .agency-city").text()+')');
                    $('#sale-count').html($("#agency-slider .slick-center .slick-slide-item .sale-count").text()+ ' Total Properties');
                });
        
                $('#featured-agency-slider .slick-slide-item').hover(function(ev){
                    clearInterval(interval);
                }, function(ev){
                    interval = setInterval(function () {
                        (!paused) && $('#featured-agency-next').trigger('click');
                    },4000);
                });
                $('#agency-slider .slick-slide-item').hover(function(ev){
                    clearInterval(agency_interval);
                }, function(ev){
                    agency_interval = setInterval(function () {
                        (!paused) && $('#agency-next').trigger('click');
                       $('#middle-agency-name').html($("#agency-slider .slick-center .slick-slide-item .agency-name").text()+' ('+ $("#agency-slider .slick-center .slick-slide-item .agency-city").text()+')');
                       $('#sale-count').html($("#agency-slider .slick-center .slick-slide-item .sale-count").text()+ ' Total Properties');
                       $('#agency-phone').html($("#agency-slider .slick-center .slick-slide-item .agency-phone").text());
                    },3000);
                   
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

            });
        })(jQuery);
    </script>
    <script src="{{asset('website/js/popper.min.js')}}"></script>
    <script src="{{asset('website/js/script-custom.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.bundle.min.js')}}"></script>

@endsection
