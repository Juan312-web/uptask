<?php include_once __DIR__ . '/header-dashboard.php' ?>

<h2>Crear Proyecto</h2>
<div class="contenido">
  <?php include_once __DIR__ . "/../components/alerts.php"; ?>

  <form action="/create-project" class="form" method="POST">
    <div class="input dark">
      <label for="project">Nombre Proyecto</label>
      <input type="text" name="project" id="project">
    </div>
    <input type="submit" class="boton" value="Crear Proyecto">
  </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>