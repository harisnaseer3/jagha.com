(function ($) {
    $(document).ready(function () {

        // function validate()
        // {
        //     console.log('called');
        //     let value = $('#property_id').val();
        //     var letterNumber = /[0-9 ]+/;
        //     if((value.match(letterNumber)))
        //     {
        //         return true;
        //     }
        //     else
        //     {
        //         alert('Please Enter numeric value in search bar');
        //         return false;
        //     }
        // }
        // $('.property-listing').DataTable(
        //     {
        //         "paging": false,
        //         "scrollY": false,
        //         // "ordering": false,
        //         // "info":     false
        //     }
        // );

        $('#delete').on('show.bs.modal', function (event) {
            let record_id = $(event.relatedTarget).data('record-id');
            $(this).find('.modal-body #record-id').val(record_id);
        });

        //TODO: if page url change then change following accordingly
        $(document).on('click', '#listings-tab a', function () {
            var tab = $(this).attr('href').split('#');
            var special_listing = ['basic', 'silver', 'bronze', 'golden', 'platinum'];
            if (tab[1] != null) {
                let purpose;
                if (special_listing.includes(tab[1])) purpose = tab[1].split("-")[1] + '_listing';
                else purpose = tab[1].split("-")[1];
                $('.pagination li a').each(function (index) {
                    let url = $(this).attr('href');
                    let url_piece_1 = url.split('purpose/')[0];
                    let url_piece_2 = url.split('purpose/')[1];
                    let url_piece_3 = url_piece_2.split('admin/')[1];
                    let new_url = url_piece_1 + 'purpose/' + purpose + '/admin/' + url_piece_3;
                    $(this).attr('href', new_url)
                });
            }
        });
        let url_string = window.location.search;
        if (url_string.indexOf('?city=') >= 0) {
            let city = url_string.split("?")[1];
            $('.pagination li a').each(function (index) {
                let url = $(this).attr('href');
                let new_url = url + '&' + city
                $(this).attr('href', new_url);
            });
        }
        function changePropertyStatus(status, id) {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/admin/change-status',
                data: {'id': id, 'status': status},
                dataType: 'json',
                success: function (data) {
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
            changePropertyStatus('pending', id);
        });
        $('[name=status]').on('change', function (event) {
            let status_value = $(this).val();
            if ($.inArray(status_value, ['active', 'reactive', 'sold', 'expired', 'boost']) > -1) {
                if (status_value === 'reactive') {
                    status_value = 'pending'
                }
                let id = $(this).attr('data-id');
                changePropertyStatus(status_value, id);
            }
        });


    });
})(jQuery);
