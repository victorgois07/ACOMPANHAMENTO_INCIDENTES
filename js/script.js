function nomeData(v) {
    var ex = v.split("-");

    switch (ex[1]){
        case "01":
            return "JANEIRO/"+ex[0];
            break;
        case "02":
            return "FEVEREIRO/"+ex[0];
            break;
        case "03":
            return "MARÇO/"+ex[0];
            break;
        case "04":
            return "ABRIL/"+ex[0];
            break;
        case "05":
            return "MAIO/"+ex[0];
            break;
        case "06":
            return "JUNHO/"+ex[0];
            break;
        case "07":
            return "JULHO/"+ex[0];
            break;
        case "08":
            return "AGOSTO/"+ex[0];
            break;
        case "09":
            return "SETEMBRO/"+ex[0];
            break;
        case "10":
            return "OUTUBRO/"+ex[0];
            break;
        case "11":
            return "NOVEMBRO/"+ex[0];
            break;
        case "12":
            return "DEZEMBRO/"+ex[0];
            break;
    }
}

function dataNome(v) {
    switch (v){
        case "JANEIRO":
            return "01";
            break;
        case "FEVEREIRO":
            return "02";
            break;
        case "MARÇO":
            return "03";
            break;
        case "ABRIL":
            return "04";
            break;
        case "MAIO":
            return "05";
            break;
        case "JUNHO":
            return "06";
            break;
        case "JULHO":
            return "07";
            break;
        case "AGOSTO":
            return "08";
            break;
        case "SETEMBRO":
            return "09";
            break;
        case "OUTUBRO":
            return "10";
            break;
        case "NOVEMBRO":
            return "11";
            break;
        case "DEZEMBRO":
            return "12";
            break;
    }
}

function modalQuantidadeTableModal() {
    var tab = [], le = $("tbody#bodyTable tr").length;
    var string;
    var tableData;

    for(var i=0; i <= le; i++){
        string = $("tbody#bodyTable tr:nth-child("+i+")").text().split("h");
        if (i < le) {
            tab[i] = ("td_"+string[0] + "h").replace(" ", "_").replace("_a ", "_a_");
        } else {
            tab[i] = "td_total";
        }
    }

    for (var j=0; j <= le; j++){
        tableData = $("table#tableIncidentes tbody tr:nth-child("+j+")").children("td:nth-child(2)").map(function()         {
            return $(this).attr('id',tab[j]);
        }).get();
    }

    var dt = $("div#containerTableInfo h2").text().split("/");

    var nDT = dt[1]+"-"+dataNome(dt[0]);
    
    $("table#tableIncidentes tbody tr").children("td:nth-child(2)")
        .on("click", function () {

            $.ajax({
                    type : 'get',
                    url : 'dataModalIncidentes.php',
                    data : {mes: nDT, ate: $(this).attr('id')},
                    beforeSend: function(){
                        $("div#loaderModal").removeClass("d-none");
                    },
                    success: function (data) {
                        $("body").off("load");
                        $("div#loaderModal").addClass("d-none").delay(2000).fadeOut("slow");
                        $("div#modalTableData").modal('show');
                        $("div#modalBodyTable").html(data);
                        $('#tableModalDados').dynatable({
                            features: {
                                paginate: false,
                                sort: false,
                                pushState: false,
                                search: false,
                                recordCount: false,
                                perPageSelect: false
                            },
                            columns:[{
                                text: 'Criado em',
                                dataIndex: 'criadoEm',
                                width: 80
                            }]
                        });
                    }
            });
            
        })
        .css("cursor","pointer");


    

}


$(document).ready(function () {

    var url = window.location;

    $.getJSON('phpJson.php', function (data) {
        $("div#loader").delay(2000).fadeOut("slow");
        
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

        modalQuantidadeTableModal();
    });
    
    $("a#buttonReadBaseAtual").on("click", function () {
        $("div#modalBodyUpdate").removeClass("d-none");

        $("h5#exampleModalLabel").text("Upload Arquivo");
        
        var cls = document.getElementById('modalBodyMes').className;
        
        if(/d-none/ig.test(cls) == false){
            $("div#modalBodyMes").addClass("d-none");
        }
    });

    $("a#buttonVisualizarMes").on("click", function () {
        
        $("div#modalBodyMes").removeClass("d-none");

        $("h5#exampleModalLabel").text("Visualizar Mês");

        var cls = document.getElementById('modalBodyUpdate').className;

        if(/d-none/ig.test(cls) == false){
            $("div#modalBodyUpdate").addClass("d-none");
        }
    });

    $("button#aExtracao").click(function(event) {

        $("#dados_a_enviar").val( $("<div>").append( $("div#containerTableInfo").eq(0).clone()).html());

        $("form#formExtracao").submit();

    });

    $("button#aExtracaoView").click(function(event) {

        $("#dados_a_enviar_view").val( $("<div>").append( $("div#containerTableInfo2").eq(0).clone()).html());

        $("form#formExtracaoView").submit();

    });

    $("form#formVisualizaMes").submit(function(event) {

        $.ajax({
            type : 'get',
            url : 'phpJson.php',
            data : {m: $("#selectMes").val()},
            beforeSend: function(){
                $("div#loaderModal").removeClass("d-none");
            },
            success: function (data) {

                $("div#loaderModal").addClass("d-none").delay(2000).fadeOut("slow");

                var sel = $("select#selectMes").val().toUpperCase();
                $("h2#h2data").text(nomeData(sel));
                var c = document.getElementById('modalContentTable').className;
                var cl = document.getElementById('modalContentDados').className;

                if(/d-none/ig.test(c) == true && /d-none/ig.test(cl) == false){
                    $("div#modalContentTable").removeClass("d-none");
                    $("div#modalContentDados").addClass("d-none");
                }

                $(".modal-dialog").css({
                    "max-width": "100%",
                    "margin": "5px"
                });

                $("table#tableIncidentes2 thead").css({
                    "font-size": "25px"
                });

                $("table#tableIncidentes2 tbody").css({
                    "font-size": "50px"
                });

                $("div#containerTableInfo2").css({
                    "margin-top": "20px",
                    "margin-bottom": "20px"
                });

                $("img#imgClose").on("click", function () {
                    $("div#uploadModal").modal('hide');
                    location.reload('true');
                });

                var dado = data;

                $('#tableIncidentes2').dynatable({
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

                $("table#tableIncidentes2 tbody tr:last-child td:nth-child(3)").attr('colspan',"2");
                $("table#tableIncidentes2 tbody tr:last-child td:nth-child(4)").remove();
            }
        });

        event.preventDefault();
    });

    $("form#formUpload").on("submit", function (event) {
        
        $.ajax({
            type: 'POST',
            url: 'leituraBaseXML.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $("div#loaderModal").removeClass("d-none");
            },
            success: function(data){
                $("div#loaderModal").addClass("d-none").delay(2000).fadeOut("slow");

                if(/sucesso/ig.test(data) == true){

                    var string = data.split(" | ");

                    $.confirm({
                        title: 'SUCESSO!',
                        content: string[0]+"<br/>"+string[1],
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
    })


});
