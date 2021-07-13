(function ($) {
    $(document).ready(function () {
        (function (window, document, undefined) {

            var factory = function ($, DataTable) {
                "use strict";

                $('.search-toggle').click(function () {
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
                DataTable.ext.renderer.pageButton.material = function (settings, host, idx, buttons, page, pages) {
                    var api = new DataTable.Api(settings);
                    var classes = settings.oClasses;
                    var lang = settings.oLanguage.oPaginate;
                    var btnDisplay, btnClass, counter = 0;

                    var attach = function (container, buttons) {
                        var i, ien, node, button;
                        var clickHandler = function (e) {
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
                    } catch (e) {
                    }

                    attach(
                        $(host).empty().html('<ul class="material-pagination"/>').children('ul'),
                        buttons
                    );

                    if (activeEl) {
                        $(host).find('[data-dt-idx=' + activeEl + ']').focus();
                    }
                };


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

        $(document).ready(function () {
            $('#societies-table').DataTable({
                deferRender: true,
            });

            $.get('/get_housing_societies',  // url
                function (data, textStatus, jqXHR) {  // success callback
                    // $('#loader-property-logs').hide();
                    $('#societies-table').DataTable().clear().destroy();

                    $('#tbody-property-logs').html(data.view);
                    $('#societies-table').DataTable({
                        deferRender: true,
                        "scrollX": true,
                        "ordering": false,
                        responsive: true,
                        pageLength: 50,
                        "oLanguage": {
                            "sStripClasses": "",
                            "sSearch": "",
                            "sSearchPlaceholder": "Enter any keyword here to filter...",
                            "sInfo": "_START_ -_END_ of _TOTAL_",
                            "sLengthMenu":
                                '<span>Rows per page:</span><select class="browser-default">' +
                                // '<option value="10">10</option>' +
                                '<option value="50">50</option>' +
                                '<option value="100">100</option>' +
                                '<option value="300">300</option>' +
                                '<option value="500">500</option>' +
                                // '<option value="-1">All</option>' +
                                '</select></div>'
                        },
                        "aoColumnDefs": [
                            {"bSortable": false, "aTargets": [0, 1, 2, 3, 4, 5]},
                        ],

                        bAutoWidth: false,

                        "columnDefs": [
                            {"width": "5%", "targets": 0},
                            // {"width": "35%", "targets": 0},
                            {"width": "8%", "targets": 2},
                            {"width": "10%", "targets": 3},
                            {"width": "10%", "targets": 5}
                        ]

                    });
                });
            $('#societies-search').on('click', function (e) {
                e.preventDefault();


                let data = $('#societies-search-form').serialize();
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    type: 'post',
                    url: window.location.origin + '/get_housing_societies',
                    data: data,
                    dataType: 'json',
                    success: function (data) {
                        // mydt.clear().destroy();
                        $('#societies-table').DataTable().clear().destroy();
                        $('#tbody-property-logs').html(data.view);
                        $('#societies-table').DataTable({
                            deferRender: true,
                            "scrollX": true,
                            "ordering": false,
                            responsive: true,
                            pageLength: 50,
                            "oLanguage": {
                                "sStripClasses": "",
                                "sSearch": "",
                                "sSearchPlaceholder": "Enter any keyword here to filter...",
                                "sInfo": "_START_ -_END_ of _TOTAL_",
                                "sLengthMenu":
                                    '<span>Rows per page:</span><select class="browser-default">' +
                                    // '<option value="10">10</option>' +
                                    '<option value="50">50</option>' +
                                    '<option value="100">100</option>' +
                                    '<option value="300">300</option>' +
                                    '<option value="500">500</option>' +
                                    // '<option value="-1">All</option>' +
                                    '</select></div>'
                            },
                            "aoColumnDefs": [
                                {"bSortable": false, "aTargets": [0, 1, 2, 3, 4, 5]},
                            ],
                            bAutoWidth: false,
                            "columnDefs": [
                                {"width": "5%", "targets": 0},
                                // {"width": "35%", "targets": 0},
                                {"width": "8%", "targets": 2},
                                {"width": "10%", "targets": 3},
                                {"width": "10%", "targets": 5}
                            ]

                        });

                    },
                });


            });

        });
    })
})
(jQuery);
