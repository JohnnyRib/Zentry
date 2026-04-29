$(document).ready(function () {

  console.log("JQuery.js cargado correctamente");

  $("#formCrearEvento").on("submit", function (event) {
    event.preventDefault();

    console.log("Formulario enviado. Mostrando modal.");

    $("#fondoModalEvento").addClass("activo");
  });

  $("#fondoModalEvento").on("click", function () {
    console.log("Fondo pulsado. Cerrando modal.");

    $("#fondoModalEvento").removeClass("activo");
  });

  $("#cajaModalEvento").on("click", function (event) {
    event.stopPropagation();
  });

});