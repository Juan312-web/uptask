<?php include_once __DIR__ . '/header-dashboard.php' ?>

<h2>Perfil</h2>
<div class="contenido">
  <?php include_once __DIR__ . "/../components/alerts.php"; ?>
  <form action="/profile" class="form centrado" method="POST">
    <div class="input dark">
      <label for="name">Nombre</label>
      <input type="text" name="name" id="name" value="<?php echo $usuario->name ?>">
    </div>
    <div class="input dark">
      <label for="password">Contraseña</label>
      <input type="password" name="password" id="password">
    </div>
    <div class="input dark">
      <label for="repeat-password">Repetir Contraseña</label>
      <input type="password" name="repeat-password" id="repeat-password">
    </div>
    <input type="submit" class="boton" value="Actualizar Informacion">
  </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>