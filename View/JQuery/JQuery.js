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
  //Cookies
  const banner = `
    <div id="cookie-banner" style="background: var(--bg-card); border: 1px solid var(--blue); padding: 20px; margin: 20px; border-radius: var(--radius); text-align: center;">
        <p>¿Aceptas el uso de cookies para iniciar sesión?</p>
        <button id="aceptarCookies" class="btn">Aceptar</button>
    </div>`;

  if (!localStorage.getItem("cookiesAceptadas")) {
    $("main").prepend(banner);
    $('button[type="submit"]').hide();
    console.log("Cookies no aceptadas. Login bloqueado.");
  }

  $(document).on("click", "#aceptarCookies", function () {
    localStorage.setItem("cookiesAceptadas", "true");
    $("#cookie-banner").fadeOut();
    $('button[type="submit"]').fadeIn();
    console.log("Cookies aceptadas. Login habilitado.");
  });

  //Slider
  const configResponsiva = [
    { breakpoint: 1024, settings: { slidesToShow: 3 } },
    { breakpoint: 768, settings: { slidesToShow: 2 } },
    { breakpoint: 480, settings: { slidesToShow: 1 } }
  ];

  //Eventos
  $(".lista-eventos").slick({
    infinite: true,
    slidesToShow: 4,
    autoplay: true,
    responsive: configResponsiva
  });

  // Slider Promotores/Clientes
  $(".lista-eventos").slick({
    infinite: true,
    slidesToShow: 3,
    dots: true,
    responsive: configResponsiva
  });

  //Hover
  $(".evento img, .imagen-evento").on("mouseenter", function () {
    $(this).css("filter", "brightness(0.5)");
    console.log("Ratón sobre imagen: mostrando info.");

  }).on("mouseleave", function () {
    $(this).css("filter", "brightness(1)");
    console.log("El ratón ha salido de la imagen.");
  });

  
});

