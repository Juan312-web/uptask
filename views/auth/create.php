<?php include_once __DIR__ . "/../components/header.php"; ?>

<div class="login">
  <div class="image">
    <img src="/build/img/create.svg" alt="login image">
    <a href="https://storyset.com/online">Online illustrations by Storyset</a>
  </div>
  <div class="contenido ">
    <h2>Completa EL Formulario Para Crear Una Cuenta</h2>

    <?php include_once __DIR__ . "/../components/alerts.php"; ?>+

    <form action="/create-account" class="form" method="POST">
      <div class="input">
        <label for="name">Nombre</label>
        <input type="text" placeholder="Tu Nombre" name="name" id="name" value="<?php echo s($usuario->name) ?>">
      </div>
      <div class="input">
        <label for="email">Correo</label>
        <input type="email" placeholder="Tu Correo" name="email" id="email" value="<?php echo s($usuario->email) ?>">
      </div>
      <div class="input">
        <label for="password">Contraseña</label>
        <input type="password" placeholder="Tu Contraseña" name="password" id="password">
      </div>
      <div class="input">
        <label for="repeat-password">Repetir Contraseña</label>
        <input type="password" placeholder="Repite tu Contraseña" name="repeat-password" id="repeat-password">
      </div>
      <input type="submit" class="boton" value="Crear Cuenta">
    </form>
    <div class="acciones">
      <a href="/login">¿Ya tienes una cuenta? Inicia Sesión</a>
      <a href="/forgot-password">¿Olvidaste tu Password?</a>
    </div>
  </div>
</div>
<?php $script = "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function () {window.setTimeout(document.querySelector('svg').classList.add('animated'),1000);})</script>" ?>