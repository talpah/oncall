var dTable;
$(document).ready(function () {

    dTable = new DataTable(
        '/oncall/json-get-assignments',
        {
            container: $('#dataTable'),
            skipWeekends: true
        }

    );

    $('#hilightme').click(function() {
        dTable.hilight($('#user').text());
    });
});