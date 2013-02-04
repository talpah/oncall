var dTable;
$(document).ready(function () {

    dTable = new DataTable($('#dataTable'),  {
        Luni: 'Luni',
        Marti: 'Marti',
        Miercuri: 'Miercuri',
        Joi: 'Joi',
        Vineri: 'Vineri'
    });
    dTable.generate();
    dTable.fill({
        1: {
                luni:'Cosmin I.',
                marti: 'Robert S.',
                miercuri: 'Alexandru V.',
                joi: 'Stefan V.',
                vineri: 'Cosmin I.',
                sambata:{html:'', class: 'gray'},
                duminica:{html:'', class: 'gray'}
        },
        2: {
                luni:'Robert S.',
                marti: 'Alexandru V.',
                miercuri: 'Stefan V.',
                joi: 'Cosmin I.',
                vineri: 'Robert S.',
                sambata:{html:'', class: 'gray'},
                duminica:{html:'', class: 'gray'}
        },
        3: {
                luni: 'Alexandru V.',
                marti: 'Stefan V.',
                miercuri: 'Cosmin I.',
                joi: 'Robert S.',
                vineri: 'Alexandru V.',
                sambata:{html:'', class: 'gray'},
                duminica:{html:'', class: 'gray'}
        },
        4: {
                luni: 'Stefan V.',
                marti: 'Cosmin I.',
                miercuri: 'Robert S.',
                joi: 'Alexandru V.',
                vineri: 'Stefan V.',
                sambata:{html:'', class: 'gray'},
                duminica:{html:'', class: 'gray'}
        }

    });
    $('#hilightme').click(function() {
        dTable.hilight($('#user').text());
    });
});