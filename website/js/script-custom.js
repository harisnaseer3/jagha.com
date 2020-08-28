(function ($) {

    function searchWithparams() {
        //TODO: change base url when upload to server

        // let baseurl = 'http://127.0.0.1/Property/public';
        let baseurl = window.location.origin + '/property';

        let page_link = '', purpose = '', type = '', city = '', beds = '', min_price = '', max_price = '', min_area = '', max_area = '', area_unit = '', location = '', subtype = '';

        purpose = $('[name = property_purpose]').val();
        type = $('[name = property_type]').val();
        city = $('[name = city]').val();
        min_price = $('[name = min_price]').val();
        max_price = $('[name = max_price]').val();
        min_area = $('[name = min_area]').val();
        max_area = $('[name = max_area]').val();
        area_unit = $('[name = property_area_unit]').val();
        beds = $('[name = bedrooms]').val();
        subtype = $('[name^= property_subtype-' + type + ']').val();
        location = $('#location').val();
        // console.log(purpose, type, city, beds, min_price, max_price, min_area, max_area, area_unit,subtype);

        page_link = baseurl + '/'
        if (subtype == null) page_link += type.toLowerCase();
        else page_link += subtype.replace(/ /g, '-').toLowerCase();
        page_link += '_for_';
        if (purpose === 'Buy')
            page_link += 'sale';
        else page_link += purpose.toLowerCase();
        page_link += '/' + city.replace(/ /g, '-').toLowerCase() + '?';
        // in some location there is a desh(-) sign replace it with (_) and then on server side replace it (-) again
        if (location !== '') page_link += 'location=' + location.replace(/-/g, '_').replace(/ /g, '-').toLowerCase();
        if (min_price !== '0' && min_price !== null) page_link += '&min_price=' + min_price;
        if (max_price !== 'Any' && max_price !== null) page_link += '&max_price=' + max_price;
        if (min_area !== '0' && min_area !== null) page_link += '&min_area=' + min_area;
        if (max_area !== 'Any' && max_area !== null) page_link += '&max_area=' + max_area;
        if (beds !== 'All' && beds !== null) page_link += '&bedrooms=' + beds;
        page_link += '&area_unit=' + area_unit.replace(' ', '-').toLowerCase();
        page_link += '&sort=newest';
        // console.log(page_link);
        window.location.href = page_link;
    }

    function search2Withparams() {
        //TODO: change base url when upload to server
        // let baseurl = 'http://127.0.0.1/Property/public';
        let baseurl = window.location.origin + '/property';

        let purpose = '', type = '', city = '', beds = '', min_price = '', max_price = '', min_area = '', max_area = '', area_unit = '', location = '', subtype = '';

        purpose = $('#search2-property-purpose').val();
        type = $('#search2-property-type').val();
        city = $('#search2-city').val();
        min_price = $('#search2-select-min-price').val();
        max_price = $('#search2-select-max-price').val();
        min_area = $('#search2-select-min-area').val();
        max_area = $('#search2-select-max-area').val();
        area_unit = $('[name = search2-unit]').val();
        beds = $('#search2-beds').val();
        subtype = $('[id^= search2-subtype-' + type + ']').val()
        location = $('#search2-location').val();
        let page_link = baseurl + '/'
        if (subtype == null) page_link += type.toLowerCase();
        else page_link += subtype.replace(/ /g, '-').toLowerCase();
        page_link += '_for_';
        if (purpose === 'Buy')
            page_link += 'sale';
        else page_link += purpose.toLowerCase();
        page_link += '/' + city.replace(/ /g, '-').toLowerCase() + '?';
        // in some location there is a desh(-) sign replace it with (_) and then on server side replace it (-) again
        if (location !== '') page_link += 'location=' + location.replace(/-/g, '_').replace(/ /g, '-').toLowerCase();
        if (min_price !== '0' && min_price !== null) page_link += '&min_price=' + min_price;
        if (max_price !== 'Any' && max_price !== null) page_link += '&max_price=' + max_price;
        if (min_area !== '0' && min_area !== null) page_link += '&min_area=' + min_area;
        if (max_area !== 'Any' && max_area !== null) page_link += '&max_area=' + max_area;
        if (beds !== 'All' && beds !== null) page_link += '&bedrooms=' + beds;
        page_link += '&area_unit=' + area_unit.replace(' ', '-').toLowerCase();
        page_link += '&sort=newest';
        // console.log(area_unit, page_link);
        window.location.href = page_link;
    }

    function searchWithId(id) {
        //TODO: how make a dynamic url in ajax to call this function from any page
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //change url when shifted to server
        jQuery.ajax({
            type: 'post',
            // url: 'http://127.0.0.1/Property/public/searchWithID',
            url: window.location.origin + '/property/searchWithID',
            data: {id: id},
            // dataType: 'json',
            success: function (data) {
                if (data.status === 200) {
                    location.assign(data.data);
                } else $('#property_id-error').text(data.data)
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            },
            complete: function (url, options) {
            }
        });
    }

    function addFavorite(id, selector, task) {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'get',
            url: task === 'add' ? window.location.origin + '/property/dashboard/properties/' + id + '/favorites' : window.location.origin + '/property/dashboard/properties/' + id + '/favorites/1',
            dataType: 'json',
            success: function (data) {
            },
            error: function (xhr, status, error) {
                console.log(error);
                // console.log(xhr);
                // console.log(status);
            },
            complete: function (url, options) {
            }
        });
    }

    function getCityLocations(city) {
        // console.log('function call', city);
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'get',
            url: window.location.origin + '/property/locations',
            data: {city: city},
            dataType: 'json',
            success: function (data) {
                let locations = data.data
                if (!jQuery.isEmptyObject({locations})) {
                    let datalist = $('.location-datalist');
                    let html = '';
                    $.each(data.data, function (index, value) {
                        html += '<option value="' + value.name + '">';
                    });
                    datalist.html(html);
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
                console.log(status);
                console.log(xhr);
            },
            complete: function (url, options) {
            }
        });
    }

    function search2AreaUnitOption(area_options, area_short_form, min_options, max_options) {
        let search2_min_html =
            '                       <div class="form-group">' +
            '                           <div class="index-page-select" style="padding: 0;">' +
            '                               <label class="search2-input-label min-area-label" for="search2-select-min-area"> MIN AREA</label>' +
            '                               <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" id="search2-select-min-area" style="width: 100%;" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="min_area">';

        if (sessionStorage.getItem('min_area') === '0') search2_min_html += '   <option value="0" selected>0</option>';
        else search2_min_html += '  <option value="0">0</option>';
        search2_min_html += min_options;
        search2_min_html += '                    </select>' +
            '                           </div>' +
            '                       </div>';

        let search2_max_html = '    <div class="form-group">' +
            '                           <div class="index-page-select" style="padding: 0">' +
            '                               <label class="search2-input-label max-area-label" for="search2-select-max-area">MAX AREA</label>' +
            '                               <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" ' +
            'id="search2-select-max-area" style="width: 100%;" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="max_area">';
        if (sessionStorage.getItem('max_area') === 'any') search2_max_html += '   <option value="Any" selected>Any</option>';
        else search2_max_html += '   <option value="Any" >Any</option>';
        search2_max_html += max_options;
        search2_max_html += '                   </select>' +
            '                             </div>' +
            '                           </div>';

        $('#search2-min-area').html(search2_min_html);
        $('#search2-max-area').html(search2_max_html);
        $('#search2-select-max-area').select2();
        $('#search2-select-min-area').select2();

    }

//    change values of min and max area selectors
    function addAreaOptions(end, options) {
        $('#select-max-area option').remove();
        $('#search2-select-max-area option').remove();
        var max_value = $('#select-max-area');
        var max_value2 = $('#search2-select-max-area');

        max_value.append('<option selected value="Any">Any</option>');
        max_value2.append('<option selected value="Any">Any</option>');
        for (let i = end; i < options.length; i++) {
            max_value.append('<option value=' + options[i] + '>' + options[i] + '</option>');
            max_value2.append('<option value=' + options[i] + '>' + options[i] + '</option>');
        }
    }

    function areaUnitOptions(area_unit) {
        let area_short_form = '';
        let min_options = '';
        let max_options = '';
        var area_options;
        let marla = ['2', '3', '5', '8', '10', '15', '20', '30', '40', '50'];
        let sqyd = ['50', '60', '70', '80', '100', '120', '150', '200', '250', '300,', '350', '400', '450', '500', '1000', '2000', '4000'];
        let kanal = ['1', '2', '3', '4', '5', '6', '7', '8', '10', '12', '15', '20', '30', '50', '100'];
        let sqft = ['450', '675', '1,125', '1,800', '2,250', '3,375', '4500', '6,750', '9,000', '11,250'];
        let sqm = ['50', '80', '130', '200', '250', '380', '510', '760', '1,000', '1,300', '1,900', '2,500', '3,800', '5,100', '6,300', '13,000', '19,000', '2500', '51,000'];

        if (area_unit === "Square Yards") {
            area_options = sqyd;
            area_short_form = 'SQ.YD.';
        } else if (area_unit === "Square Feet") {
            area_options = sqft;
            area_short_form = 'SQ.FT.';
        } else if (area_unit === "Square Meters") {
            area_options = sqm;
            area_short_form = 'SQ.M.';
        } else if (area_unit === "Marla") {
            area_options = marla;
            area_short_form = 'marla';
        } else if (area_unit === "Kanal") {
            area_options = kanal;
            area_short_form = 'kanal';
        }
        $.each(area_options, function (idx, val) {
            if (idx + 1 < area_options.length)
                if (sessionStorage.getItem('min_area') === val) min_options += '<option value="' + val + '" data-index="' + (idx + 1) + '" selected>' + val + '</option>'
            min_options += '<option value="' + val + '" data-index="' + (idx + 1) + '">' + val + '</option>'
        });
        $.each(area_options, function (index, value) {
            if (sessionStorage.getItem('max_area') === value) max_options += '<option value="' + value + '" data-index="' + (index + 1) + '" selected>' + value + '</option>'
            max_options += '<option value="' + value + '" data-index="' + (index + 1) + '">' + value + '</option>'
        });
        let formatted_unit = area_unit.toLowerCase().replace(' ', '_');
        let html = '';
        html =
            '<div class="row">' +
            '       <div class="col-sm-6" style="padding-right:0; border-right:1px solid #ced4da">' +
            '           <div class="label-container"><label class="input-label min-area-label" for="select-min-area">MIN AREA</label></div>' +
            '           <div class="index-page-select">' +
            '               <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" id="select-min-area"' +
            '                       style="width: 100%;" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="min_area">';
        if (sessionStorage.getItem('min_area') === '0') html += '   <option data-index="0" value="0" selected>0</option>';
        else html += '  <option data-index="0" value="0">0</option>';
        html += min_options;
        html += '        </select>' +
            '               </div>' +
            '           </div>' +
            '        <div class="col-sm-6" style="padding-left: 0;">' +
            '           <div class="label-container"><label class="input-label max-area-label" for="select-max-area">MAX AREA</label></div>' +
            '           <div class="index-page-select">' +
            '               <select class="custom-select custom-select-sm select2bs4 select2-hidden-accessible" id="select-max-area" ' +
            'style="width: 100%; border:0" tabindex="-1" aria-hidden="true" aria-describedby="unit-error" aria-invalid="false" name="max_area">';
        if (sessionStorage.getItem('max_area') === 'any') html += '   <option data-index="0" value="Any" selected>Any</option>';
        else html += '   <option data-index="0" value="Any" >Any</option>';
        html += max_options;
        html +=
            '               </select>' +
            '           </div>' +
            '       </div>' +
            '</div>';
        $('#area-container').html(html);
        let select_min_area = $('#select-min-area');
        $('#select-max-area').select2();
        select_min_area.select2();

        search2AreaUnitOption(area_options, area_short_form, min_options, max_options);

        select_min_area.on('change', function (e) {
            addAreaOptions($("#select-min-area option:selected").data('index'), area_options);
        });
        $('#search2-select-min-area').on('change', function (e) {
            addAreaOptions($("#search2-select-min-area option:selected").data('index'), area_options);
        });
    }


    $(document).ready(function () {
        $('#search-property-ref').submit(function (event) {
            event.preventDefault();
            searchWithId($('#ref-id').val());
        });

        //Main Search form submission

        $('.index-form').submit(function (event) {
            event.preventDefault();
            searchWithparams();
        });

        $('.index-form-2').submit(function (event) {
            event.preventDefault();
            search2Withparams();
        });

        // add property to fav
        $('.favorite').on('click', function (e) {
            $(this).hide();
            addFavorite($(this).data('id'), $(this), 'add');
            $(this).next().show();
        });

        // remove property from fav
        $('.remove-favorite').on('click', function (e) {
            $(this).hide();
            addFavorite($(this).data('id'), $(this), 'delete');
            $(this).prev().show();
        });

        //    index page form subtype selection
        let property_type = $('.property-type-select2');
        property_type.on('change', function (e) {
            const selectedValue = $(this).val();
            if (selectedValue === 'Plots' || selectedValue === 'Commercial') $('.beds-block').hide();
            else $('.beds-block').show();

            $('[id^=property_subtype-]').hide();
            $('[id^=search2-property_subtype-]').hide();
            $('#property_subtype-' + selectedValue).toggle();
            $('#search2-property_subtype-' + selectedValue).toggle();
        });
        if (property_type.val() === 'Plots') $('.beds-block').hide();

        let selectedValue = '';
        if ($('.detail-page-banner').is(":visible")) {
            selectedValue = property_type.val();
            getCityLocations($('#city option:selected').val());
        } else {
            selectedValue = $('#search2-property-type').val();
            getCityLocations($('#search2-city option:selected').val());
        }
        //display property sub type options on page load
        $('[id^=search2-property_subtype-]').hide();
        $('[id^=-property_subtype-]').hide();
        $('#search2-property_subtype-' + selectedValue).toggle();
        $('#property_subtype-' + selectedValue).toggle();

        //    change values of min and max price selectors
        function addPriceOptions(end) {
            let options = ['500,000', '1,000,000', '2,000,000', '3,500,000', '5,000,000', '6,500,000', '8,000,000', '10,000,000', '12,500,000', '15,000,000', '17,500,000', '20,000,000', '25,000,000', '30,000,000', '40,000,000', '50,000,000', '75,000,000', '100,000,000', '250,000,000', '500,000,000', '1,000,000,000', '5,000,000,000']
            $('#select-max-price option').remove();
            $('#search2-select-max-price option').remove();
            var max_value = $('#select-max-price');
            var max_value2 = $('#search2-select-max-price');
            max_value.append('<option selected="selected" value="Any">Any</option>');
            max_value2.append('<option selected="selected" value="Any">Any</option>');
            for (let i = end; i < options.length; i++) {
                max_value.append('<option value=' + options[i] + '>' + options[i] + '</option>');
            }
            for (let i = end + 1; i < options.length; i++) {
                // max_value.append('<option value=' + options[i] + '>' + options[i] + '</option>');
                max_value2.append('<option value=' + options[i] + '>' + options[i] + '</option>');
            }
        }

        $('#select-min-price').on('change', function (e) {
            addPriceOptions($("#select-min-price option:selected").data('index'));
        });

        $('#search2-select-min-price').on('change', function (e) {
            addPriceOptions($("#search2-select-min-price option:selected").data('index'));
        });

        $('#city').on('change', function (e) {
            getCityLocations($('#city option:selected').val());
        });

        $('#search2-city').on('change', function (e) {
            getCityLocations($('#search2-city option:selected').val());
        });

        $('.reset-search-option').on('click', function () {
            $('#location').val('');
            $('input[name=area_unit]').val('Marla');
            // $('.min-area-label').text('MIN AREA');
            // $('.max-area-label').text('MAX AREA (Marla)');

            $('.index-form').trigger('reset');
            $('.custom-select').data('index', '0').trigger('change');

            sessionStorage.setItem('max_area', 'Any');
            sessionStorage.setItem('min_area', 0);


        });

        // call rest form from banner lg view
        $('.reset-search-banner2, #reset-search-banner2lg').on('click', function () {

            $.each($('.custom-select'), function (index, value) {
                if (!!~(value.id).indexOf("purpose"))
                    $(this).val('Buy').trigger('change');
                if (!!~(value.id).indexOf("type"))
                    $(this).val('Homes').trigger('change');
                if (!!~(value.id).indexOf("city"))
                    $(this).val('Islamabad').trigger('change');
                if (!!~(value.id).indexOf("beds"))
                    $(this).val('All').trigger('change');
                if (!!~(value.id).indexOf("min-price"))
                    $(this).val('0').trigger('change');
                if (!!~(value.id).indexOf("max-price"))
                    $(this).val('Any').trigger('change');
                if (!!~(value.id).indexOf("min-area"))
                    $(this).val('0').trigger('change');
                if (!!~(value.id).indexOf("max-area"))
                    $(this).val('Any').trigger('change');
                if (!!~(value.id).indexOf("area-unit"))
                    $(this).val('Marla').trigger('change');
            });

            sessionStorage.setItem('max_area', 'Any');
            sessionStorage.setItem('min_area', 0);

            $('#search2-location').val('');
            $('#location').val('');
        });

        //on max and min area btn find btn store values of area min and area max price min

        $(document.body).on("change", "[name=max_area]", function () {
            let data2 = $(this).val();
            sessionStorage.setItem('max_area', data2);
        });
        $(document.body).on("change", "[name=min_area]", function () {
            let data1 = $(this).val();
            sessionStorage.setItem('min_area', data1);
        });

        areaUnitOptions('Marla');

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
                            html += 'Logged in as' + user_name;
                            html += '</a>' +
                                '                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                            html += '<a class="dropdown-item" href=" ' + window.location.origin + '/property' + '/dashboard/accounts/users/' + user_id + '/edit"><i class="far fa-user-cog mr-2"></i>Manage Profile</a>' +
                                '                     <div class="dropdown-divider"></div>' +
                                '                          <a class="dropdown-item" href="{{route("accounts.logout")}}"><i class="far fa-sign-out mr-2"></i>Logout</a>';
                            html += '</div>' + '</div>';

                            user_dropdown.html(html);
                            // console.log(data.user.email);

                            if ($('.user-name').length > 0) {
                                $('input[name=name]').val(data.user.name);
                                $('input[name=email]').val(data.user.email)
                            }
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
        // $('.logout-btn').on('click', function (event) {
        //     console.log($('meta[name="csrf-token"]').attr('content'));
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     event.preventDefault();
        //     jQuery.ajax({
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
})
(jQuery);
