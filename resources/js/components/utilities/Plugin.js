export default {
    methods: {
        DataTable: function (tableId) {
            return $(tableId).DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
            });
        }
    }
}