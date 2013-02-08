var dTable;
$(document).ready(function () {

    dTable = new DataTable(
        '/data.php',
        {
            container: $('#dataTable'),
            skipWeekends: true
        }
        
    );

    $('#hilightme').click(function() {
        dTable.hilight($('#user').text());
    });
});