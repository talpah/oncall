var dTable;
$(document).ready(function () {

    dTable = new DataTable(
        [
            {date:'2013-02-04', assignee:'Cosmin I.'},
            {date:'2013-02-05', assignee:'Robert S.'},
            {date:'2013-02-06', assignee:'Alexandru V.'},
            {date:'2013-02-07', assignee:'Stefan V.'},
            {date:'2013-02-08', assignee:'Cosmin I.'},

            {date:'2013-02-11', assignee:'Robert S.'},
            {date:'2013-02-12', assignee:'Alexandru V.'},
            {date:'2013-02-13', assignee:'Stefan V.'},
            {date:'2013-02-14', assignee:'Cosmin I.'},
            {date:'2013-02-15', assignee:'Robert S.'},

            {date:'2013-02-18', assignee:'Alexandru V.'},
            {date:'2013-02-19', assignee:'Stefan V.'},
            {date:'2013-02-20', assignee:'Cosmin I.'},
            {date:'2013-02-21', assignee:'Robert S.'},
            {date:'2013-02-22', assignee:'Alexandru V.'}
        ],
        {
            container: $('#dataTable'),
            skipWeekends: true
        }
        
    );

    $('#hilightme').click(function() {
        dTable.hilight($('#user').text());
    });
});