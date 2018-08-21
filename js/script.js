$(document).ready(function() {

    $("div#divJumbotronTable").height($(window).height());

    $.ajax({
        'url': "controller/dataTableDB.php",
        'method': "GET",
        'contentType': 'application/json'
    }).done( function(data) {

        $("div#loader").delay(2000).fadeOut("slow");

        $('#tableAcompanhamentoIncidentes').dataTable({
            "aaData": data,
            "paging": false,
            "info": false,
            "searching": false,
            "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        $("table#tableAcompanhamentoIncidentes tbody tr:last-child td:nth-child(4)").attr("colspan","2");
        $("table#tableAcompanhamentoIncidentes tbody tr:last-child td:nth-child(2)").remove();
        $("table#tableAcompanhamentoIncidentes").css("font-family","Arial,sans-serif");
        $("table#tableAcompanhamentoIncidentes tbody").css({
            "font-weight":700,
            "font-size":"65px"
        });

        $("table#tableAcompanhamentoIncidentes tbody tr td").css("padding",0);

        $("table#tableAcompanhamentoIncidentes tbody tr td:nth-child(2)").css({
            "cursor":"pointer"
        }).on("click", function () {

            $("#modalBaseTable").modal('show');

            $("#dialogModal").addClass("w-100 p-3 mw-100");

            $("h5#titleModalDataTable").text("Incidentes "+$(this).prev().text());

            $.ajax({
                'url': "controller/tableDataBase.php",
                'method': "GET",
                'data': {horas:$(this).prev().text()},
                'contentType': "application/json;charset=utf-8",
                'dataType': "json"
            }).done( function(data) {

                $('#tableDataBase').dataTable({
                    "aaData": data,
                    "paging": false,
                    "info": false,
                    "searching": false,
                    "ordering": false,
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });

            });

        });
    });



    $("a#buttonReadBaseAtual").on("click", function () {

        $("div#modalBodyUpdate").removeClass("d-none");

        $("h5#exampleModalLabel").text("Upload Arquivo");

        let cls = document.getElementById('modalBodyMes').className;

        if(/d-none/ig.test(cls) === false){
            $("div#modalBodyMes").addClass("d-none");
        }

    });

    $("a#buttonVisualizarMes").on("click", function () {

        $("div#modalBodyMes").removeClass("d-none");

        $("h5#exampleModalLabel").text("Tabela mês");

        let cls = document.getElementById('modalBodyUpdate').className;

        if(/d-none/ig.test(cls) === false){
            $("div#modalBodyUpdate").addClass("d-none");
        }

    });

    $("form#formUpload").on("submit", function (event) {

        $.ajax({
            type: 'POST',
            url: 'controller/insertDataExcelDB.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("div#loaderModal").removeClass("d-none");
            },
            success: function(data){
                $("div#loaderModal").addClass("d-none").delay(2000).fadeOut("slow");

                if(/sucesso/ig.test(data) === true){

                    let string = data.split(" | ");

                    $.confirm({
                        title: 'SUCESSO!',
                        content: data,
                        icon: 'fas fa-check-square',
                        theme: 'modern',
                        closeIcon: false,
                        animation: 'scale',
                        type: 'green',
                        buttons: {
                            ok: function () {
                                location.reload(true);
                            }
                        }
                    });

                }else{

                    $.confirm({
                        title: 'ERRO!',
                        content: data,
                        icon: 'fas fa-plus-circle',
                        theme: 'modern',
                        closeIcon: false,
                        animation: 'scale',
                        type: 'red',
                        buttons: {
                            ok: function () {
                                location.reload(true);
                            }
                        }
                    });

                }




            },
            error: function (data) {
                console.log(data)
            }
        });

        event.preventDefault();
    });

    $.getJSON('controller/jsonMeses.php', function (data) {
        $.each(data, function (key, entry) {
            $('#selectDataTableMes').append($('<option></option>').attr('value', entry).text(entry));
        })
    });

} );