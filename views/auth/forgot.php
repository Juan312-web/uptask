<?php include_once __DIR__ . "/../components/header.php"; ?>

<div class="login">
  <div class="image">
    <img src="/build/img/recovery.svg" alt="login image">
    <a href="https://storyset.com/online">Online illustrations by Storyset</a>
  </div>
  <div class="contenido ">
    <h2>Restablece tu contraseña</h2>

    <?php include_once __DIR__ . "/../components/alerts.php"; ?>

    <form action="/forgot-password" class="form" method="POST">
      <div class="input">
        <label for="email">Correo</label>
        <input type="email" placeholder="Tu Correo" name="email" id="email">
      </div>
      <input type="submit" class="boton" value="Restablecer">
    </form>
    <div class="acciones">
      <a href="/login">¿Ya tienes una cuenta? Inicia Sesión</a>
      <a href="/create-account">¿Aún no tienes cuenta? Obten Una</a>

    </div>
  </div>
</div>


<?php $script = "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function () {window.setTimeout(document.querySelector('svg').classList.add('animated'),1000);})</script>" ?>