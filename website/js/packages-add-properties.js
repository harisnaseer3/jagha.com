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
            let days = $(this).closest("tr").find('td:eq(10) input').val();
            if (days === '') {
                alert('Please mention days in Duration column.');
            } else {
                addToPackage($(this).attr('data-package-id'), $(this).attr('data-property-id'), $(this), days);

            }

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
                    if (data.status === 200) {
                        div.next().hide();
                        div.prev().show();
                    } else if (data.status !== 200) {
                        div.show();
                        div.next().hide();
                        let html = ' <div class="alert alert-danger alert-block text-white">' +
                            '        <button type="button" class="close" data-dismiss="alert">×</button>' +
                            '        <strong>' + data.message + '</strong>' +
                            '    </div>';
                        $('.message-block').html(html);
                    }

                },
            });

        }
    });

})
(jQuery);
