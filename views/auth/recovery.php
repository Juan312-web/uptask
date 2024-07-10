<?php include_once __DIR__ . "/../components/header.php"; ?>

<div class="contenedor recovery">
  <div class="image">
    <img src="/build/img/reset-password.svg" alt="Reset image">
    <a href="https://storyset.com/online">Online illustrations by Storyset</a>
  </div>
  <div class="contenido">
    <h1>Restablecer Contraseña</h1>

    <?php include_once __DIR__ . "/../components/alerts.php"; ?>

    <form class="form" method="POST">
      <div class="input">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Nueva Contraseña">
      </div>
      <div class="input">
        <label for="repeat-password">Repite Contraseña</label>
        <input type="repeat-password" name="repeat-password" id="repeat-password" placeholder="Nueva Contraseña">
      </div>
      <input type="submit" value="Restablecer" class="boton">
    </form>
  </div>
</div>