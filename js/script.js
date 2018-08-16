$(document).ready(function() {

    $.ajax({
        'url': "http://localhost/ACOMPANHAMENTO_INCIDENTES/controller/dataTableDB.php",
        'method': "GET",
        'contentType': 'application/json'
    }).done( function(data) {
        $('#tableAcompanhamentoIncidentes').dataTable({
            "aaData": data,
            "paging": false,
            "info": false,
            "searching": false,
        });
    });

} );