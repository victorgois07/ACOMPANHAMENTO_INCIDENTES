$(document).ready(function () {
    $("#example").DataTable({
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false,
        "autoWidth": false,
        "bAutoWidth": false,
        "columns": [
            { "width": "50%" },
            { "width": "5%" },
            { "width": "5%" },
            { "width": "5%" }
          ]
    });
    var larg = $(window).width();
    larg -= 60;

    $("#example").width(larg);

    if(larg <= 1600){
        $("#example tbody").css("font-size","50");
    }else{
        $("#example tbody").css("font-size","90");
    }
});
