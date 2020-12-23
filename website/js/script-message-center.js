(function ($) {

    $(document).ready(function () {
        $('#user-notification').DataTable({
            "scrollX": true
        });
        $(document).on('click', '.mark-as-read', function () {
            let div = $(this);

            let notification_id = div.attr('data-id');

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/dashboard/property-notification',
                data: {'notification_id': notification_id},
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    if (data.status === 200) {
                        div.toggleClass('mark-as-read mark-as-unread');
                        div.closest('tr').find('.alert').toggleClass('alert-primary  alert-danger');
                        div.text() === 'Mark as read' ? div.text('Mark as unread') : div.text('Mark as read');
                    }
                },
                error: function (xhr, status, error) {
                },
                complete: function (url, options) {

                }
            });
        });
        $(document).on('click', '.mark-as-unread', function () {
            let div = $(this);
            let notification_id = div.attr('data-id');

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                type: 'post',
                url: window.location.origin + '/dashboard/property-notification',
                data: {'notification_id': notification_id, 'unread': 'true'},
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    if (data.status === 200) {
                        div.toggleClass('mark-as-read mark-as-unread');
                        div.closest('tr').find('.alert').toggleClass('alert-primary  alert-danger');
                        div.text() === 'Mark as read' ? div.text('Mark as unread') : div.text('Mark as read');
                    }
                },
                error: function (xhr, status, error) {
                },
                complete: function (url, options) {

                }
            });
        });


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
    });
})
(jQuery);
