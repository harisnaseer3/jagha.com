(function ($) {
    function layoutSelection() {
        if (sessionStorage.getItem("page-layout") === 'list-layout') {
            $('.page-list-layout').show();
            $('.page-grid-layout').hide();
        } else if (sessionStorage.getItem("page-layout") === 'grid-layout') {
            $('.page-list-layout').hide();
            $('.page-grid-layout').show();
            $('.grid-stars').stars();
        }
    }

    function addPaginationLinks() {
        let required_string = window.location.href;
        let current_search_params = window.location.search.split('&page')[0];

        if (required_string.indexOf('?') > 0) {
            $('.page-item').each(function () {
                let link = $(this).find('a');
                if (link.length > 0) {
                    let fetched_link = link.attr('href');
                    let piece1 = fetched_link.split('?')[0];
                    let piece2 = fetched_link.split('?')[1];
                    link.attr('href', piece1 + current_search_params + '&' + piece2);
                }
            });
        } else {
            $('.page-item').each(function () {
                let link = $(this).find('a');
                if (link.length > 0) {
                    let fetched_link = link.attr('href');
                    let piece1 = fetched_link.split('?')[0];
                    let piece2 = fetched_link.split('?')[1];
                    link.attr('href', piece1 + current_search_params + '?&' + piece2);
                }
            });
        }


    }

    function addPaginationAjaxLinks(url) {
        let data = url.split('?')[1];
        let current_search_params = data.split('&');
        let condition = '';
        $.each(current_search_params, function (index, value) {
            if (!value.includes('page'))
                condition += value + '&'

        });
        $('.page-item').each(function () {
            let link = $(this).find('a');
            if (link.length > 0) {
                let fetched_link = link.attr('href');
                let piece1 = fetched_link.split('?')[0];
                let piece2 = fetched_link.split('?')[1];
                link.attr('href', piece1 + '?' + condition + piece2);
            }
        });
    }

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover({trigger: "hover"});
        $(document).on("click", ".popover .close", function () {
            $(this).parents(".popover").popover('hide');
        });
        $('body').on('click', function (e) {
            $('[data-toggle=popover]').each(function () {
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });

        $('.tt_large').tooltip({template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner large"></div></div>'});


        $(document).on('click', '.list-layout-btn', function (e) {
            sessionStorage.setItem("page-layout", 'list-layout');
            $('.page-list-layout').show();
            $('.page-grid-layout').hide();
        });
        $(document).on('click', '.grid-layout-btn', function (e) {
            sessionStorage.setItem("page-layout", 'grid-layout');
            $('.page-list-layout').hide();
            $('.page-grid-layout').show();
            $('.grid-stars').stars();
        });
        $.fn.stars = function () {
            return $(this).each(function () {
                let rating = $(this).data("rating");
                rating = rating > 5 ? 5 : rating;
                const numStars = $(this).data("numStars");
                // const fullStar = '<i class="fas fa-star"></i>'.repeat(Math.floor(rating));
                let fullStar = '';
                for (let i = 1; i <= Math.floor(rating); i++) {
                    fullStar += '<i class="fas fa-star"></i>';
                }
                const halfStar = (rating % 1 !== 0) ? '<i class="fas fa-star-half-alt"></i>' : '';
                // const noStar = '<i class="far fa-star"></i>'.repeat(Math.floor(numStars - rating));
                let noStar = '';
                for (let j = 1; j <= Math.floor(numStars - rating); j++) {
                    noStar += '<i class="far fa-star"></i>';
                }
                $(this).html(fullStar + halfStar + noStar);
            });
        }
        $('.stars').stars();
        layoutSelection();


        function insertParam(key, value) {
            key = encodeURIComponent(key);
            value = encodeURIComponent(value);
            // kvp looks like ['key1=value1', 'key2=value2', ...]
            var kvp = document.location.search.substr(1).split('&');
            let i = 0;
            for (; i < kvp.length; i++) {
                if (kvp[i].startsWith(key + '=')) {
                    let pair = kvp[i].split('=');
                    pair[1] = value;
                    kvp[i] = pair.join('=');
                    break;
                }
            }
            if (i >= kvp.length) {
                kvp[kvp.length] = [key, value].join('=');
            }
            // can return this or...
            let params = kvp.join('&');
            // reload page with new params
            document.location.search = params;
        }

        function insertParamWithAjax(key, value) {
            key = encodeURIComponent(key);
            value = encodeURIComponent(value);
            // kvp looks like ['key1=value1', 'key2=value2', ...]
            var kvp = document.location.search.substr(1).split('&');
            let i = 0;
            for (; i < kvp.length; i++) {
                if (kvp[i].startsWith(key + '=')) {
                    let pair = kvp[i].split('=');
                    pair[1] = value;
                    kvp[i] = pair.join('=');
                    break;
                }
            }
            if (i >= kvp.length) {
                kvp[kvp.length] = [key, value].join('=');
            }
            // can return this or...
            let params = kvp.join('&');
            return window.location.origin + window.location.pathname + '?' + params;

        }

        function insert2ParamsWithAjax(url, key, value) {
            key = encodeURIComponent(key);
            value = encodeURIComponent(value);
            // kvp looks like ['key1=value1', 'key2=value2', ...]
            var kvp = url.split('?')[1].split('&');
            let i = 0;
            for (; i < kvp.length; i++) {
                if (kvp[i].startsWith(key + '=')) {
                    let pair = kvp[i].split('=');
                    pair[1] = value;
                    kvp[i] = pair.join('=');
                    break;
                }
            }
            if (i >= kvp.length) {
                kvp[kvp.length] = [key, value].join('=');
            }
            // can return this or...
            let params = kvp.join('&');
            return window.location.origin + window.location.pathname + '?' + params;

        }


        $('.ajax-loader').hide();
        $(document).on('change', '.record-limit', function (e) {
            getDataFromAjax();
        });

        $(document).on('change', '.sorting', function (e) {
            getDataFromAjax();

        });

        function getDataFromAjax() {
            let area_sort = '';
            let sort = '';
            let limit = '';
            if (sessionStorage.getItem("page-layout") === 'list-layout') {
                limit = $('#list-record').val();
                area_sort = $('#list-area-filter').val();
                sort = $('#list-sorting').val();
            } else if (sessionStorage.getItem("page-layout") === 'grid-layout') {
                limit = $('#grid-record').val();
                area_sort = $('#grid-area-filter').val();
                sort = $('#grid-sorting').val();
            } else {
                limit = $('#list-record').val();
                area_sort = $('#list-area-filter').val();
                sort = $('#list-sorting').val();
            }
            //get value from other filters and add them to new url
            let new_url = insertParamWithAjax('limit', limit)
            let url = insert2ParamsWithAjax(new_url, 'sort', sort);
            if (area_sort) {
                url = insert2ParamsWithAjax(url, 'area_sort', area_sort);
            }
            $('.ajax-loader').show();
            $('#listings-div').html('');
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'get',
                url: url,

                dataType: 'json',
                success: function (data) {
                    $('.ajax-loader').hide();
                    $('#listings-div').html(data.view);
                    layoutSelection();
                    $('[data-toggle="tooltip"]').tooltip();
                    $('[data-toggle="popover"]').popover({trigger: "hover"});
                    if ($('.pagination-box').length > 0) {
                        addPaginationAjaxLinks(url);
                    }
                },
                error: function (xhr, status, error) {
                },
                complete: function (url, options) {

                }
            });
        }


        if ($('.pagination-box').length > 0) {
            addPaginationLinks();
        }

        $('.select2').select2({
            language: '{{app()->getLocale()}}',
            direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
        });
        $('.select2bs4').select2({
            language: '{{app()->getLocale()}}',
            direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
            theme: 'bootstrap4',
        });
        $('#subscribe-form').on('submit', function (e) {
            e.preventDefault();
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/subscribe',
                data: {
                    email: $('#subscribe').val()
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status === 200) {
                        let btn = '';
                        if (data.msg === 'already exists') {
                            btn = '<button class="btn btn-block color-white" style="background-color: #274abb;"><i class="far fa-check-circle"></i> Already Subscribed </button>';
                        } else if (data.msg === 'new subscriber') {
                            btn = '<button class="btn btn-block color-white" style="background-color: #274abb;"><i class="far fa-check-circle"></i> Subscribed </button>';
                        }
                        $("#subscribe-form").slideUp();
                        $('.Subscribe-box').append(btn);
                    }
                },
                error: function (xhr, status, error) {
                    // console.log(error);
                },
                complete: function (url, options) {
                }
            });
        });

        let input = document.querySelector("#cell");

        var errorMsg = document.querySelector("#error-msg");
        var validMsg = document.querySelector("#valid-msg");
        var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
        var ag_iti_cell = window.intlTelInput(input, {
            preferredCountries: ["pk"],
            preventInvalidNumbers: true,
            separateDialCode: true,
            numberType: "MOBILE",
            utilsScript: "/../../plugins/intl-tel-input/js/utils.js?1603274336113"
        });
        var reset = function () {
            input.classList.remove("error");
            input.classList.remove("valid");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
            validMsg.classList.add("hide");
        };
        input.addEventListener('blur', function () {
            reset();
            if (input.value.trim()) {
                if (ag_iti_cell.isValidNumber()) {
                    $('[name=phone]').val(ag_iti_cell.getNumber());
                    validMsg.classList.remove("hide");
                    $('#phone-error').hide();
                } else {
                    // input.classList.add("error");

                    var errorCode = ag_iti_cell.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                    $('[name=phone]').val('');
                }
            }
        });

        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
        let phone = '';

        let form = $('#email-contact-form');

        let call_btn = $('.agent-call');
        call_btn.on('click', function () {
            call_btn.attr('href', 'tel:' + phone).text(phone);
        });


        form.validate({
            rules: {
                name: {
                    required: true,
                },
                'phone_#': {
                    required: true,
                    // checkcellnum: true,
                },
                'phone': {
                    required: true,
                    // checkcellnum: true,
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: true,
                },
            },
            messages: {'phone': ", please enter a valid value."},
            errorElement: 'span',
            errorClass: 'error help-block text-red',
            ignore: [],

            submitHandler: function (form) {
                form.preventDefault();
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
                    document.querySelector("input").classList.remove("valid");
                }
            }
        });

        $('.btn-email').click(function (e) {
            // console.log($(this).closest('.contact-container').find('input[name=property]').val());
            let property = $(this).closest('.contact-container').find('input[name=property]').val();
            let title = $(this).closest('.contact-container').find('input[name=title]').val();
            // let agency = $(this).closest('.contact-container').find('input[name=agency]').val();
            // let reference = $(this).closest('.contact-container').find('input[name=reference]').val();
            let property_link = $(this).closest('.contact-container').find('.property-description').find('a').attr('href');
            let anchor_link = '<a href="' + property_link + '" style="text-decoration:underline; color:blue">' + property_link + ' </a>';
            let link = '<a href="https://www.jagha.com" style="text-decoration:underline; color:blue">https://www.jagha.com</a>.';
            let message = 'I would like to inquire about your property\n' + anchor_link + 'Property ID <span style="text-decoration:underline; color:blue">' + property + '</span> displayed at ' + link + '<br><br> Please contact me at your earliest.';
            phone = $(this).closest('.contact-container').find('input[name=phone]').val();
            let editable_div = $('.editable-div');
            editable_div.html(message);
            $('input[name=message]').val(editable_div.html());
            editable_div.click(function () {
                if (editable_div.html() !== '') {
                    $('input[name=message]').val(editable_div.html());
                }
            });

            if (!(property == null))
                $('.selected').val(property).attr('name', 'property');
            // else if (!(agency == null))
            //     $('.selected').val(agency).attr('name', 'agency');
            call_btn.text('Call');
        });


        $('#send-mail').click(function (event) {
            if (form.valid()) {
                event.preventDefault();
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    type: 'post',
                    url: window.location.origin + '/contactAgent',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === 200) {
                            // console.log(data.data);
                            form.trigger("reset");
                            $('#EmailModelCenter').modal('hide');
                            $('#EmailConfirmModel').modal('show');
                        } else {
                            // console.log(data.data);
                        }
                    },
                    error: function (xhr, status, error) {
                        // console.log(error);
                        // console.log(status);
                        // console.log(xhr);
                    },
                    complete: function (url, options) {
                    }
                });
            }
        });

        $('.search-options-btn').on('click', function () {
            $('#data-section').toggleClass('content-area').toggleClass('content-area2');

        });

    });
})(jQuery);
