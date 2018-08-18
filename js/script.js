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
            "ordering": false
        });

        $("table#tableAcompanhamentoIncidentes tbody tr:last-child td:nth-child(4)").attr("colspan","2");
        $("table#tableAcompanhamentoIncidentes tbody tr:last-child td:nth-child(2)").remove();
        $("table#tableAcompanhamentoIncidentes").css("font-family","Arial,sans-serif");
        $("table#tableAcompanhamentoIncidentes tbody").css({
            "font-weight":700,
            "font-size":"60px"
        });
        $("table#tableAcompanhamentoIncidentes tbody tr td").css("padding",0);
    });

} );