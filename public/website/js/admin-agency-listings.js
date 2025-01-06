(function ($) {
    $(document).ready(function () {
        $('#delete').on('show.bs.modal', function (event) {
            let record_id = $(event.relatedTarget).data('record-id');
            $(this).find('.modal-body #record-id').val(record_id);
        });

        // $('[data-toggle-1="tooltip"]').tooltip();

        function changePropertyStatus(status, id) {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin  + '/admin/agency-change-status',
                data: {'id': id, 'status': status},
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    if (data.status === 200) {
                        window.location.reload(true);
                    }
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

        $('.restore-btn').on('click', function () {
                let id = $(this).attr('data-record-id');
                let status_value = 'pending';
                changePropertyStatus(status_value, id);
            }
        );
        $('[name=status]').on('change', function (event) {
            let status_value = $(this).val();
            if ($.inArray(status_value, ['verified']) > -1) {
                let id = $(this).attr('data-id');
                changePropertyStatus(status_value, id);
            }
        });

        //TODO: if page url change then change following accordingly
        $(document).on('click', '#listings-tab a', function () {
            var tab = $(this).attr('href').split('#');
            var special_listing = ['listings-super_hot', 'listings-magazine', 'listings-hot'];
            if (tab[1] != null) {
                let purpose;
                if (special_listing.includes(tab[1])) purpose = tab[1].split("-")[1] + '_listing';
                else purpose = tab[1].split("-")[1];
                $('.pagination li a').each(function (index) {
                    let url = $(this).attr('href');
                    let url_piece_1 = url.split('purpose/')[0];
                    let url_piece_2 = url.split('purpose/')[1];
                    let url_piece_3 = url_piece_2.split('user/')[1];
                    let new_url = url_piece_1 + 'purpose/' + purpose + '/user/' + url_piece_3;
                    $(this).attr('href', new_url)
                })
            }
        });
    });
    $('.btn-accept').on('click', function () {
        let alert = $(this);
        let agency_id = alert.attr('data-agency');
        let user_id = alert.attr('data-user');
        let notification_id = alert.attr('data-id');

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'post',
            url: window.location.origin  + '/admin/agencies/accept-invitation',
            data: {'agency_id': agency_id, 'user_id': user_id, 'notification_id': notification_id},
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                if (data.status === 200) {
                    alert.closest('.alert').remove();
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            },
            complete: function (url, options) {

            }
        });
    });
    $('.btn-reject').on('click', function () {
        let alert = $(this);
        let notification_id = alert.attr('data-id');

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            type: 'post',
            url: window.location.origin  + '/admin/agencies/reject-invitation',
            data: {'notification_id': notification_id},
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                if (data.status === 200) {
                    alert.closest('.alert').remove();
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            },
            complete: function (url, options) {

            }
        });
    });
})
(jQuery);
