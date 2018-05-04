$(document).ready(function () {

    $.getJSON('phpJson.php', function (data) {
        var dado = data;
        $('#tableIncidentes').dynatable({
            features: {
                paginate: false,
                sort: false,
                pushState: false,
                search: false,
                recordCount: false,
                perPageSelect: false
            },
            dataset: {
                records: dado
            }
        });
        $("table#tableIncidentes tbody tr:last-child td:nth-child(3)").attr('colspan',"2");
        $("table#tableIncidentes tbody tr:last-child td:nth-child(4)").remove();
    });

    $("button#aExtracao").click(function(event) {

        $("#dados_a_enviar").val( $("<div>").append( $("div#containerTableInfo").eq(0).clone()).html());

        $("form#formExtracao").submit();

    });

});
