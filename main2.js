$(document).ready(function(){

    var fila;

    $(document).on("click", "#bt_añadir", function(){
        $("#formnombre").trigger("reset");
        $(".modal-header").css("background-color", "#1e1e21");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("AÑADIR ESTUDIANTE");            
        $(".modal-content").css("background-color", "#3b3b41");
        $(".modal-content").css("color", "#FFFF");       
        $("#modalañadir").modal("show");
    }); 



});