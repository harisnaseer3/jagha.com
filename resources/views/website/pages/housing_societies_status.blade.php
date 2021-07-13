@extends('website.layouts.app')
@section('title')
    {!! SEO::generate(true) !!}
@endsection


@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/housing.css')}}" async defer>
    <style>

    </style>
@endsection

@section('content')

    @include('website.includes.nav')

    <!-- Properties section body start -->
    <div class="properties-section content-area pt-3">
        <div class="container">
            <div class="row cities-margin">
                <div class="col-lg-9 col-md-12 pb-3">
                    <!-- Listing -->
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="all-cities-header">Housing Societies Status</h1>

                                </div>
                            </div>


                        </div>
                        <div class="card-body">
                            <div id="listings-div">
                                <div class="page-list-layout">
                                    <div class="option-bar">
                                        <div class="cod-pad">
                                            <div class="sorting-options text-center" role="button" aria-label="sort by filter">
                                                <select class="record-limit none-992" id="list-record">
                                                    <option selected disabled>Housing Scheme Status</option>
                                                </select>
                                                <select class="sorting area-filter none-992" id="list-area-filter">
                                                    <option selected disabled >Approving Authority</option>

                                                </select>
                                                <select class="sorting" id="list-sorting">
                                                    <option selected disabled >Division</option>

                                                </select>
                                                <select class="sorting" id="list-sorting">
                                                    <option selected disabled >District</option>

                                                </select>
                                                <button class="btn btn-sm btn-primary btn-search-style p-2" id="property-reference" type="submit">
                                                    <i class="fa fa-search mx-1"></i>Search</button>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Property box 2 start -->
                                </div>
                            </div>
                            <div class="row">
                                <div id="admin" class="col s12">
                                    <div class="card material-table">
                                        <div class="table-header">
                                            <span class="table-title">All Results</span>
                                            <div class="actions">
                                                <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                        <table id="datatable" class="table-responsive-sm">
                                            <thead>
                                            <tr>
                                                <th class="color-white">#</th>
                                                <th class="color-white">Society Name</th>
                                                <th class="color-white">Status</th>
                                                <th class="color-white">City</th>
                                                <th class="color-white">Approving Authority</th>
                                                <th class="color-white">Total Land Area</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="sidebar-right mt-0">
                        @include('website.includes.subscribe-content')
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
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}" defer></script>
    <script src="{{asset('website/js/jquery.validate.min.js')}}" defer></script>
    <script src="{{asset('website/js/all-cities-page.js')}}" defer></script>
    <script src="{{asset('website/js/cookie.min.js')}}" defer></script>
    <script type="text/javascript" charset="utf8" src="{{asset('website/js/datatables.min.js')}}"></script>
    <script>
        (function(window, document, undefined) {

            var factory = function($, DataTable) {
                "use strict";

                $('.search-toggle').click(function() {
                    if ($('.hiddensearch').css('display') == 'none')
                        $('.hiddensearch').slideDown();
                    else
                        $('.hiddensearch').slideUp();
                });

                /* Set the defaults for DataTables initialisation */
                $.extend(true, DataTable.defaults, {
                    dom: "<'hiddensearch'f'>" +
                        "tr" +
                        "<'table-footer'lip'>",
                    renderer: 'material'
                });

                /* Default class modification */
                $.extend(DataTable.ext.classes, {
                    sWrapper: "dataTables_wrapper",
                    sFilterInput: "form-control input-sm",
                    sLengthSelect: "form-control input-sm"
                });

                /* Bootstrap paging button renderer */
                DataTable.ext.renderer.pageButton.material = function(settings, host, idx, buttons, page, pages) {
                    var api = new DataTable.Api(settings);
                    var classes = settings.oClasses;
                    var lang = settings.oLanguage.oPaginate;
                    var btnDisplay, btnClass, counter = 0;

                    var attach = function(container, buttons) {
                        var i, ien, node, button;
                        var clickHandler = function(e) {
                            e.preventDefault();
                            if (!$(e.currentTarget).hasClass('disabled')) {
                                api.page(e.data.action).draw(false);
                            }
                        };

                        for (i = 0, ien = buttons.length; i < ien; i++) {
                            button = buttons[i];

                            if ($.isArray(button)) {
                                attach(container, button);
                            } else {
                                btnDisplay = '';
                                btnClass = '';

                                switch (button) {

                                    case 'first':
                                        btnDisplay = lang.sFirst;
                                        btnClass = button + (page > 0 ?
                                            '' : ' disabled');
                                        break;

                                    case 'previous':
                                        btnDisplay = '<i class="far fa-arrow-left"></i>';
                                        btnClass = button + (page > 0 ?
                                            '' : ' disabled');
                                        break;

                                    case 'next':
                                        btnDisplay = '<i class="far fa-arrow-right"></i>';
                                        btnClass = button + (page < pages - 1 ?
                                            '' : ' disabled');
                                        break;

                                    case 'last':
                                        btnDisplay = lang.sLast;
                                        btnClass = button + (page < pages - 1 ?
                                            '' : ' disabled');
                                        break;

                                }

                                if (btnDisplay) {
                                    node = $('<li>', {
                                        'class': classes.sPageButton + ' ' + btnClass,
                                        'id': idx === 0 && typeof button === 'string' ?
                                            settings.sTableId + '_' + button : null
                                    })
                                        .append($('<a>', {
                                                'href': '#',
                                                'aria-controls': settings.sTableId,
                                                'data-dt-idx': counter,
                                                'tabindex': settings.iTabIndex
                                            })
                                                .html(btnDisplay)
                                        )
                                        .appendTo(container);

                                    settings.oApi._fnBindAction(
                                        node, {
                                            action: button
                                        }, clickHandler
                                    );

                                    counter++;
                                }
                            }
                        }
                    };

                    // IE9 throws an 'unknown error' if document.activeElement is used
                    // inside an iframe or frame.
                    var activeEl;

                    try {
                        // Because this approach is destroying and recreating the paging
                        // elements, focus is lost on the select button which is bad for
                        // accessibility. So we want to restore focus once the draw has
                        // completed
                        activeEl = $(document.activeElement).data('dt-idx');
                    } catch (e) {}

                    attach(
                        $(host).empty().html('<ul class="material-pagination"/>').children('ul'),
                        buttons
                    );

                    if (activeEl) {
                        $(host).find('[data-dt-idx=' + activeEl + ']').focus();
                    }
                };

                /*
                 * TableTools Bootstrap compatibility
                 * Required TableTools 2.1+
                 */
                if (DataTable.TableTools) {
                    // Set the classes that TableTools uses to something suitable for Bootstrap
                    $.extend(true, DataTable.TableTools.classes, {
                        "container": "DTTT btn-group",
                        "buttons": {
                            "normal": "btn btn-default",
                            "disabled": "disabled"
                        },
                        "collection": {
                            "container": "DTTT_dropdown dropdown-menu",
                            "buttons": {
                                "normal": "",
                                "disabled": "disabled"
                            }
                        },
                        "print": {
                            "info": "DTTT_print_info"
                        },
                        "select": {
                            "row": "active"
                        }
                    });

                    // Have the collection use a material compatible drop down
                    $.extend(true, DataTable.TableTools.DEFAULTS.oTags, {
                        "collection": {
                            "container": "ul",
                            "button": "li",
                            "liner": "a"
                        }
                    });
                }

            }; // /factory

            // Define as an AMD module if possible
            if (typeof define === 'function' && define.amd) {
                define(['jquery', 'datatables'], factory);
            } else if (typeof exports === 'object') {
                // Node/CommonJS
                factory(require('jquery'), require('datatables'));
            } else if (jQuery) {
                // Otherwise simply initialise as normal, stopping multiple evaluation
                factory(jQuery, jQuery.fn.dataTable);
            }

        })(window, document);

        $(document).ready(function() {
            $('#datatable').dataTable({
                "ajax": 'https://gist.githubusercontent.com/heiswayi/7fde241975ed8a80535a/raw/ff1caaeaf62bd6740ab7cafcd61f1215de173379/datatables-data.json',
                "oLanguage": {
                    "sStripClasses": "",
                    "sSearch": "",
                    "sSearchPlaceholder": "Enter any keyword here to filter...",
                    "sInfo": "_START_ -_END_ of _TOTAL_",
                    "sLengthMenu": '<span>Rows per page:</span><select class="browser-default">' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="30">30</option>' +
                        '<option value="40">40</option>' +
                        '<option value="50">50</option>' +
                        '<option value="-1">All</option>' +
                        '</select></div>'
                },  "aoColumnDefs": [
                    { "bSortable": false, "aTargets": [ 0, 1, 2, 3,4,5 ] },
                ],
                bAutoWidth: false,


            });
        });
    </script>
@endsection
