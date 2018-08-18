$(document).ready(function() {

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

    $("a#buttonReadBaseAtual").on("click", function () {

        $("div#modalBodyUpdate").removeClass("d-none");

        $("h5#exampleModalLabel").text("Upload Arquivo");

        let cls = document.getElementById('modalBodyMes').className;

        if(/d-none/ig.test(cls) === false){
            $("div#modalBodyMes").addClass("d-none");
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

} );