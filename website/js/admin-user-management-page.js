(function ($) {
    $(document).ready(function () {

        $.get('/get-user-logs',  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('#loader-user-logs').hide();
                $('#users-logs-block').slideDown();
                $('#tbody-user-logs').html(data.view);

                $('#user-log').DataTable({
                    "scrollX": true,
                    "ordering": false,
                    responsive: true
                });
            }
        );
        $.get('/get-reg-user',  // url
            function (data, textStatus, jqXHR) {  // success callback
                $('#loader-reg-user').hide();
                $('#reg-user-block').slideDown();
                $('#tbody-reg-user').html(data.view);

                $('#reg_users').DataTable({
                    "scrollX": true,
                    "ordering": false,
                    responsive: true
                });
            }
        );

    });
})
(jQuery);
