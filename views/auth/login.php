<?php include_once __DIR__ . "/../components/header.php"; ?>

<div class="login">
  <div class="contenido ">
    <h2>Llena tus Datos Para Ingresar</h2>
    <?php include_once __DIR__ . "/../components/alerts.php"; ?>

    <form action="/login" class="form" method="POST">
      <div class="input">
        <label for="email">Correo</label>
        <input type="email" placeholder="Tu Correo" name="email" id="email" value="<?php echo $usuario->email ?>">
      </div>
      <div class="input">
        <label for="password">Contraseña</label>
        <input type="password" placeholder="Tu Contraseña" name="password" id="password">
      </div>

      <input type="submit" class="boton" value="Iniciar Sesion">
    </form>
    <div class="acciones">
      <a href="/create-account">¿Aún no tienes cuenta? Obten Una</a>
      <a href="/forgot-password">¿Olvidaste tu Password?</a>
    </div>
  </div>
  <div class="image">
    <img src="/build/img/login.svg" alt="login image">
    <a href="https://storyset.com/online">Online illustrations by Storyset</a>
  </div>
</div>


<?php $script = "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function () {window.setTimeout(document.querySelector('svg').classList.add('animated'),1000);})</script>" ?>