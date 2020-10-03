@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    @if ($current_route_name === 'properties.create')   <title> Post New Listing : Property Management Software By https://www.aboutpakistan.com</title>
    @elseif ($current_route_name === 'properties.edit') <title> Edit Listing : Property Management Software By https://www.aboutpakistan.com </title>
    @endif
@endsection

@section('css_library')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.css')}}">

@endsection

@section('content')
    @include('website.admin-pages.includes.admin-nav')
    <!-- Top header start -->
    <div style="min-height:90px"></div>
    <!-- Submit Property start -->
    <div class="submit-property">
        <div class="container-fluid container-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content" id="portfolioTabContent">
                        <div class="tab-pane fade show active" id="property_management" role="tabpanel" aria-labelledby="property_management-tab">
                            <div class="row my-4">
                                <div class="col-md-3">
                                    @include('website.admin-pages.includes.sidebar')
                                </div>
                                <div class="col-md-9">
                                    @include('website.admin-pages.property_management')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/script-modal-features.js')}}"></script>
    <script>
        (function ($) {
            $(document).ready(function () {
                $('select option:first-child').prop('disabled', true);

                (function priceInWords() {

                    let val = $('[name=all_inclusive_price]').val();
                    if (val !== undefined) {
                        let helpEl = $('#all_inclusive_price-help');
                        let valStr = '';

                        if (!val.trim()) {
                            helpEl.html(valStr);
                            return;
                        }

                        if (val >= 1000) {
                            if (val >= 100000000000) {
                                helpEl.html('Price is too big. Please contact us.');
                                return;
                            } else if (val >= 1000000000) {
                                valStr += parseInt(val / 1000000000) + ' arab';
                                val %= 1000000000;
                            }
                            if (val >= 10000000) {
                                if (valStr) valStr += ', ';
                                valStr += parseInt(val / 10000000) + ' crore';
                                val %= 10000000;
                            }
                            if (val >= 100000) {
                                if (valStr) valStr += ', ';
                                valStr += parseInt(val / 100000) + ' lac';
                                val %= 100000;
                            }
                            if (val >= 1000) {
                                if (valStr) valStr += ', ';
                                valStr += parseInt(val / 1000) + ' thousand';
                                val %= 1000;
                            }
                        }
                        if (val > 0) {
                            valStr += (valStr ? ', ' : '') + val;
                        }
                        helpEl.html('PKR ' + valStr);
                        console.log(valStr);
                    }

                })();

                // Initialize Select2 Elements
                $('.select2').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                });
                $('.select2bs4').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === 'en' ? 'ltr' : 'rtl'}}',
                    theme: 'bootstrap4',
                });

                $('[name=purpose]').on('click', function (e) {
                    const selectedValue = $(this).val();
                    if (selectedValue === 'Wanted') {
                        $('#purpose-Wanted').slideDown().find('input[type=radio]').attr('required', 'true');
                        $('[for=wanted_for]').append(' <span class="text-danger">*</span>');
                    } else {
                        $('#purpose-Wanted').slideUp().find('input[type=radio]').removeAttr('required');
                        $('[for=wanted_for] span').remove('span');
                    }
                });

                $('[name=property_type]').on('click', function (e) {
                    const selectedValue = $(this).val();
                    $('[id^=property_subtype-]').prop('checked', false).slideUp().removeAttr('required');
                    $('#property_subtype-' + selectedValue).attr('required', 'true').slideDown();
                    $('[for=property_subtype]').html('Property Subtype <span class="text-danger">*</span>');
                });

                //if user edit a property then a property type must be selected then subtype must be visible
                if ($('[name=property_type]').is(':checked')) {
                    const selectedValue = $('[name=property_type]:checked').val();
                    $('[name=property_subtype-' + selectedValue + ']').each(function (index, value) {
                        $(value).attr('required', true);
                    });
                    $('#property_subtype-' + selectedValue).attr('required', true).slideDown();
                    $('[for=property_subtype-' + selectedValue + ']').html('Property Subtype <span class="text-danger">*</span>');
                }
                $('[name^=property_subtype-]').on('click', function (e) {
                    $('[name^=property_subtype-]').prop('checked', false).attr('disable', 'true');
                    $(this).prop('checked', true);
                });

                $('[name=all_inclusive_price]').on('input', function (e) {
                    priceInWords();
                });
                //hide or show bedroom, bathroom and features btn
                //form validation

                $('#delete-image').on('show.bs.modal', function (event) {
                    let record_id = $(event.relatedTarget).data('record-id');
                    $(this).find('.modal-body #image-record-id').val(record_id);
                });
                $('#delete-plan').on('show.bs.modal', function (event) {
                    let record_id = $(event.relatedTarget).data('record-id');
                    $(this).find('.modal-body #plan-record-id').val(record_id);
                });
                $('#delete-video').on('show.bs.modal', function (event) {
                    let record_id = $(event.relatedTarget).data('record-id');
                    $(this).find('.modal-body #video-record-id').val(record_id);
                });

                $("input[name='phone']").keyup(function () {
                    $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
                });
                $("input[name='mobile']").keyup(function () {
                    $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
                });
                $("input[name='fax']").keyup(function () {
                    $(this).val($(this).val().replace(/^(\d{1})(\d+)$/, "+92-$2"));
                });
                $('.custom-select').parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});

                $('[name=call_for_price_inquiry]').click(function () {
                    if ($('[name=call_for_price_inquiry]').is(':checked')) {
                        $('[name=all_inclusive_price]').removeAttr('required').attr('disable', 'true');
                        $('[name=all_inclusive_price]').val('');
                        $('.price-block').slideUp();
                    } else {
                        $('[name=all_inclusive_price]').attr('required', 'required').attr('disable', 'false');
                        $('.price-block').slideDown();
                    }
                });
                let radios = $('[name=property_package]')

                radios.prop("disabled", true);

                let rejection_input = $('[name=rejection_reason]');
                let rejection_div = $('#reason-of-rejection');
                if ($("#status option:selected").text() === 'Rejected') {
                    rejection_input.attr('required', 'required').attr('disable', 'false');
                    rejection_div.slideDown();
                }

                $('#status').on('change', function (e) {

                    if ($("#status option:selected").text() === 'Rejected') {
                        rejection_input.attr('required', 'required').attr('disable', 'false');
                        rejection_div.slideDown();
                    } else {
                        rejection_input.removeAttr('required').attr('disable', 'true');
                        rejection_input.val('');
                        rejection_div.slideUp();
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
