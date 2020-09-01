@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection


@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">
@endsection

@section('content')

    @include('website.includes.nav')

    <!-- Properties section body start -->
    <div class="properties-section content-area pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12 pb-3">
                    <!-- Listing -->
                    <div class="card">
                        <div class="card-header">
                            <h1 class="all-cities-header">
                                {{$type}} for {{$purpose}} in All Cities of Pakistan</h1>
                        </div>
                        <div class="card-body">
                            @if(trim(explode('&',$type)[0]) =='Houses')<h2 class="all-cities-header">{{trim(explode('&',$type)[0])}}</h2>@endif
                            <div class="row">
                                @if(isset($cities[trim(strtolower(explode('&',$type)[0]))]))
                                    @foreach($cities[trim(strtolower(explode('&',$type)[0]))] as  $city)
                                        <div class="col-sm-3 my-2">
                                            <a href="{{route('sale.property.search', ['sub_type' => lcfirst(isset($city->property_sub_type)?$city->property_sub_type:$city->property_type),
                                                    'city' => lcfirst($city->city_name) ,
                                                    'purpose'=>lcfirst($city->property_purpose),
                                                    'sort'=>'newest',
                                                    'limit'=>15])}}"
                                               title="{{isset($city->property_sub_type)?$city->property_sub_type.'s':$city->property_type}}  in {{$city->city_name}}"
                                               class="breadcrumb-link">
                                                {{$city->city_name}} ({{$city->property_count}})
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @if(isset($cities['flats']))
                                <h2 class="all-cities-header pt-1">Flats</h2>
                                <div class="row">
                                    @foreach($cities['flats'] as  $city2)
                                        <div class="col-sm-3 my-2">
                                            <a href="{{route('sale.property.search', ['sub_type' => lcfirst($city2->property_sub_type), 'city' => lcfirst($city2->city_name) ,
                                                    'purpose'=>lcfirst($city2->property_purpose), 'sort'=>'newest','limit'=>15])}}"
                                               title="{{$city2->property_sub_type.'s'}}  in {{$city2->city_name}}"
                                               class="breadcrumb-link">
                                                {{$city2->city_name}} ({{$city2->property_count}})
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="sidebar-right mt-0">
                        <div class="sidebar widget" aria-label="Subscription form">
                            <h3 class="sidebar-title">Subscribe</h3>
                            <div class="s-border"></div>
                            <div class="m-border"></div>
                            <div class="Subscribe-box">
                                <h2 class="font-size-14 color-555" style="font-weight: 400">Be the first to hear about new properties</h2>
                                <form id="subscribe-form">
                                    <div class="mb-3">
                                        <input id="subscribe" type="email" class="form-contact" name="email" placeholder="example@example.com"
                                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" name="submitNewsletter" class="btn btn-block button-theme" value="Subscribe">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <script src="{{asset('website/js/jquery.validate.min.js')}}"></script>

    <script>
        (function ($) {
            $(document).ready(function () {


                $('.record-limit').on('change', function (e) {
                    insertParam('limit', $(this).val());
                });

                if ($('.pagination-box').length > 0) {
                    let current_search_params = window.location.search.split('&page')[0];
                    $('.page-item').each(function () {
                        let link = $(this).find('a');
                        if (link.length > 0) {
                            let fetched_link = link.attr('href');
                            let piece1 = fetched_link.split('?')[0];
                            let piece2 = fetched_link.split('?')[1];
                            link.attr('href', piece1 + current_search_params + '&' + piece2);
                        }
                    });
                }
                setInterval(function () {
                    var docHeight = $(window).height();
                    var footerHeight = $('#foot-wrap').height();
                    var footerTop = $('#foot-wrap').position().top + footerHeight;
                    var marginTop = (docHeight - footerTop);

                    if (footerTop < docHeight)
                        $('#foot-wrap').css('margin-top', marginTop + 'px'); // padding of 30 on footer
                    else
                        $('#foot-wrap').css('margin-top', '0px');
                }, 250);

                $('#subscribe-form').on('submit', function (e) {
                    e.preventDefault();
                    // console.log($('#subscribe').val());
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        type: 'post',
                        url: window.location.origin + '/property' + '/subscribe',
                        data: {
                            email: $('#subscribe').val()
                        },
                        dataType: 'json',
                        success: function (data) {
                            if (data.status === 200) {
                                let btn = '<button class="btn btn-block btn-success"><i class="far fa-check-circle"></i> SUBSCRIBED </button>'
                                $("#subscribe-form").slideUp();
                                $('.Subscribe-box').append(btn);
                            } else {
                                //
                            }
                        },
                        error: function (xhr, status, error) {
                            // console.log(error);
                        },
                        complete: function (url, options) {
                        }
                    });
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
                                // console.log(data);
                                if (data.data) {
                                    // console.log(data.user);
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
                            html += '<span class="mr-1"> Logged in as <span>'+ user_name ;
                            html += '</a>' +
                                '                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                            html += '<a class="dropdown-item" href=" ' + window.location.origin + '/property' + '/dashboard/accounts/users/' + user_id + '/edit"><i class="far fa-user-cog mr-2"></i>Manage Profile</a>' +
                                '                     <div class="dropdown-divider"></div>' +
                                '<a class="dropdown-item" href=" ' + window.location.origin + '/property/dashboard/properties/create"><i class="fa fa-building-o mr-2"></i>Property Managment </a>' +
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

                                // console.log(error);
                                // console.log(status);
                                // console.log(xhr);
                            },
                            complete: function (url, options) {
                            }
                        });
                    }
                });
                // $('.logout-btn').on('click', function () {
                //     // jQuery.ajaxSetup({
                //     //     headers: {
                //     //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     //     }
                //     // });
                //     $.ajax({
                //         type: 'POST',
                //         url: window.location.origin + '/property' + '/logout',
                //         success: function (data) {
                //             console.log(data.data);
                //             let user_dropdown = $('.user-dropdown')
                //             user_dropdown.html('');
                //             let html2 = '<a class="nav-link " data-toggle="modal" data-target="#exampleModalCenter"  href="javascript:void(0);" id="navbarDropdownMenuLink5" aria-haspopup="true" aria-expanded="false">'+
                //                 '<i class="fas fa-user mr-3"></i>' +
                //                 '</a> ';
                //             user_dropdown.html(html2);
                //         },
                //         error: function (xhr, status, error) {
                //             event.preventDefault();
                //
                //             // console.log(error);
                //             // console.log(status);
                //             // console.log(xhr);
                //         },
                //         complete: function (url, options) {
                //         }
                //     });
                // });

            });
        })(jQuery);
    </script>
@endsection
