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

    $(function () {
        var form;
        $('#fileInputData').change(function (event) {
            form = new FormData();
            form.append('fileUpload', event.target.files[0]); // para apenas 1 arquivo
            //var name = event.target.files[0].content.name; // para capturar o nome do arquivo com sua extenção
        });

        $('#btnEnviar').click(function () {
            $.ajax({
                url: 'leituraBaseXML.php', // Url do lado server que vai receber o arquivo
                data: form,
                type: 'POST',
                processData: false,
                contentType: false,
                dataType : 'json',
                encode : true,
                beforeSend: function () {
                    $(".square").removeClass("d-none");
                },
                success: function (data) {
                    console.log(data);
                    $(".square").addClass("d-none");

                    if (data == "BASE ATUALIZADA") {
                        $("div#loaderModal").addClass("d-none");

                        $.confirm({
                            title: 'SUCESSO',
                            content: 'Base atualizada!',
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
                    }else if(data == "BASE JA FOI ATUALIZADA"){
                        
                        $.confirm({
                            title: 'SUCESSO',
                            content: 'Base já foi atualizada!',
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
                        
                    }
                }
            });
        });
    });

});
