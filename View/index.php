<?php
// Iniciamos sesión para poder mostrar mensajes de error
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zentry - Inicio</title>
  <meta name="description" content="Zentry es una plataforma para descubrir eventos gaming de forma clara y accesible.">
  <link rel="stylesheet" href="styles.css">
</head>

<body>

  <a class="skip-link" href="#contenido-principal">Saltar al contenido principal</a>

  <header class="header header-publico">
    <!-- Cambiado a index.php porque ahora usamos PHP para mostrar errores -->
    <a href="index.php" class="logo-container" aria-label="Ir al inicio de Zentry">
      <img src="Imagenes/logo.png" alt="Logo de Zentry" class="logo">
    </a>

    <div class="header-title">
      <h1>Zentry</h1>
      <p>Plataforma de eventos gaming</p>
    </div>

    <nav aria-label="Navegación principal">
      <a href="index.php" aria-current="page">Inicio</a>
      <a href="listado-evento.html">Eventos</a>
      <a href="login.html">Login</a>
      <a href="registro-usuario.html">Registro</a>
    </nav>
  </header>

  <div class="page-layout">

    <aside class="sidebar" aria-label="Mapa web lateral">
      <h2>Mapa web</h2>
      <nav aria-label="Mapa web">
        <ul class="sidebar-links">
          <li><a href="index.php">Inicio</a></li>
          <li><a href="listado-evento.html">Listado de eventos</a></li>
          <li><a href="buscar-evento.html">Buscar evento</a></li>
          <li><a href="login.html">Login</a></li>
          <li><a href="registro-usuario.html">Registro de usuario</a></li>
          <li><a href="registro-promotor.html">Registro de administrador</a></li>
          <li><a href="perfil-usuario.html">Perfil de usuario</a></li>
          <li><a href="crear-evento.html">Crear evento</a></li>
        </ul>
      </nav>
    </aside>

    <main id="contenido-principal" class="main-content">
      <?php if (isset($_SESSION['error'])): ?>
      <!-- Muestra el error guardado desde el ControllerUser -->
      <div class="error">
        <?php
      echo $_SESSION['error'];

      // Eliminamos el error para que no se repita al recargar
      unset($_SESSION['error']);
    ?>
      </div>
      <?php endif; ?>

      <section class="hero" aria-labelledby="titulo-bienvenida">
        <h2 id="titulo-bienvenida">Descubre eventos de forma simple</h2>
        <p>
          En Zentry puedes buscar, ver y conocer eventos gaming, torneos,
          festivales y ferias tecnológicas de una forma más clara y accesible.
        </p>

        <div class="hero-actions">
          <a href="listado-evento.html" class="btn">Ver eventos</a>
          <a href="login.html" class="btn">Iniciar sesión</a>
          <a href="registro-usuario.html" class="btn">Crear cuenta</a>
        </div>
      </section>

      <section aria-labelledby="titulo-eventos">
        <h2 id="titulo-eventos">Eventos destacados</h2>
        <div class="lista-eventos">
          <article class="evento">
            <img src="../View/Imagenes/GAMEAWARD.jpg" alt="Game Award">
            <h3>The Game Awards</h3>
            <p>Evento temático sobre la gala de los juegos del año.</p>
            <a href="detalle_GameAward.html" class="btn">Información detallada</a>
          </article>

          <article class="evento">
            <img src="../View/Imagenes/Tokyo Game Show 2026.png" alt="Tokyo Game Show">
            <h3>Tokyo Game Show</h3>
            <p>Evento presencial enfocado en juegos japoneses e internacionales.</p>
            <a href="detalle_TokyoGameShow.html" class="btn">Información detallada</a>
          </article>

          <article class="evento">
            <img src="../View/Imagenes/Gamescom 2026.jpg" alt="Gamescom">
            <h3>GamesCom</h3>
            <p>Evento presencial enfocado en videojuegos, comunidad y tecnología.</p>
            <a href="detalle_GamesCom.html" class="btn">Información detallada</a>
          </article>

          <article class="evento">
            <img src="../View/Imagenes/PlayStation State of Play.jpg" alt="PlayStation State of Play">
            <h3>Playstation State of Play</h3>
            <p>Evento digital enfocado al catálogo exclusivo de Playstation.</p>
            <a href="detalle_PlayStation.html" class="btn">Información detallada</a>
          </article>
        </div>
      </section>

    </main>

  </div>

</body>

</html>