$(document).ready(function(){

    var fila;

$(document).on("click", "#btneditar", function(){
    $(".modal-header").css("background-color", "#1e1e21");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("EDITAR NOTAS");
    $(".modal-content").css("background-color", "#3b3b41");
    $(".modal-content").css("color", "#FFFF");             
    $("#modal_editar").modal("show");
    
    fila = $(this).closest("tr");
    posicion= parseInt(fila.find('td:eq(0)').text());
    descripcion = fila.find('td:eq(1)').text();
    porcentaje = fila.find('td:eq(2)').text();
    porcentaje = porcentaje.slice(0,-1);
    $("#posicion").val(posicion);
    $("#descripcion").val(descripcion);
    $("#porcentaje").val(porcentaje); 
    
}); 

$(document).on("click", "#btnañadir", function(){
    $("#formnotas").trigger("reset");
    $(".modal-header").css("background-color", "#1e1e21");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("AÑADIR NOTAS");
    $(".modal-content").css("background-color", "#3b3b41");
    $(".modal-content").css("color", "#FFFF");              
    $("#modal_añadir").modal("show");
    
    
}); 


});
