(function ($) {
    $(document).ready(function () {
        // $('#delete').on('show.bs.modal', function (event) {
        //     let record_id = $(event.relatedTarget).data('record-id');
        //     $(this).find('.modal-body #record-id').val(record_id);
        // });

        // $('[data-toggle-1="tooltip"]').tooltip();

        // function changePropertyStatus(status, id) {
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     jQuery.ajax({
        //         type: 'post',
        //         url: window.location.origin  + '/admin/agency-change-status',
        //         data: {'id': id, 'status': status},
        //         dataType: 'json',
        //         success: function (data) {
        //             // console.log(data);
        //             if (data.status === 200) {
        //                 window.location.reload(true);
        //             }
        //         },
        //         error: function (xhr, status, error) {
        //             console.log(xhr);
        //             console.log(status);
        //             console.log(error);
        //         },
        //         complete: function (url, options) {
        //
        //         }
        //     });
        // }

        // $('.restore-btn').on('click', function () {
        //         let id = $(this).attr('data-record-id');
        //         let status_value = 'pending';
        //         changePropertyStatus(status_value, id);
        //     }
        // );
        $(document).on('change', '.sorting', function (e) {
            $('#sort-form').submit();
        });
        $(document).on('click', '.add-property', function (e) {
            addToPackage($(this).attr('data-package-id'), $(this).attr('data-property-id'), $(this), $(this).closest("tr").find('td:eq(10) input').val());

        });

        function addToPackage(pack, property, div, duration) {

            div.hide();
            div.next().show();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'get',
                url: window.location.origin + '/dashboard/packages/add-property',
                data: {package: pack, property: property, duration: duration},
                dataType: 'json',
                success: function (data) {
                    console.log('gg');
                    console.log(div.next().hide());
                    console.log(div.prev().show());
                    // let locations = data.data
                    // console.log(data.data);
                    // if (!jQuery.isEmptyObject({locations})) {
                    //
                    //     let add_select = $("#add_location");
                    //     add_select.empty();
                    //     for (let [index, options] of locations.entries()) {
                    //         add_select.append($('<option>', {value: options.name, text: options.name}));
                    //     }
                    //     add_select.select2({
                    //         sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
                    //     });
                    //     add_select.parent().children().css({'border': '1px solid #ced4da', 'border-radius': '.25rem'});
                    //     $('.fa-spinner').hide();
                    //     if (location !== '') {
                    //         add_select.val(location).trigger('change');
                    //     } else
                    //         add_select.trigger('change');
                    // }
                },
            });

        }
    });

})
(jQuery);
