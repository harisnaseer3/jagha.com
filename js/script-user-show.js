(function ($) {
    $(document).ready(function () {
        $('[data-toggle-1="tooltip"]').tooltip();
        $('.alert').fadeOut(3000);

        $('#delete').on('show.bs.modal', function (event) {
            let record_id = $(event.relatedTarget).data('record-id');
            $(this).find('.modal-body #record-id').val(record_id);
        });

        $('.index-table').DataTable({
            order: []
        });
    });
})(jQuery);
