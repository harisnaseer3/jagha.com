(function ($) {

    $(document).ready(function () {
        $('#user-notification').DataTable({
            "scrollX": true
        });
        $('#customer-mails').DataTable({
            "scrollX": true
        });
        $('#support-mails').DataTable({
            "scrollX": true
        });
        $('#inquiry-mails').DataTable({
            "scrollX": true
        });
        $('[data-toggle="popover"]').popover();
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

        $(document).on('click', '#detail-modal', function ($this) {
            event.preventDefault();
            const name = $(this).attr('data-name');
            const type = $(this).attr('data-type');
            const email = $(this).attr('data-email');
            const cell = $(this).attr('data-cell');
            const location = $(this).attr('data-location');
            const message =$(this).attr('data-message');
            const time = $(this).attr('data-time');
            $('#name').html(name);
            $('#user-email').html(email);
            $('#cell').html(cell);
            $('#type').html(type);
            $('#location').html(location);
            $('#message').html(message);
            $('#time').html(time);

        });

        $(document).on('click', '#support-detail-modal', function ($this) {
            event.preventDefault();
            const inquire_about = $(this).attr('data-inquire-about');
            const inquire_id = $(this).attr('data-inquire-id');
            const url = $(this).attr('data-url');
            const message =$(this).attr('data-message');
            const time = $(this).attr('data-time');


            $('#about').html(inquire_about);
            $('#inquire-id').html(inquire_id);
            $('#url').html(url);
            $('#support-message').html(message);
            $('#support-time').html(time);

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
