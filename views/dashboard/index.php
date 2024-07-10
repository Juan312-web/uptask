<?php include_once __DIR__ . '/header-dashboard.php' ?>

<h2>Proyectos</h2>
<div class="contenido inicial">
  <div class="proyectos">
    <?php foreach ($proyectos as $proyecto) : ?>
      <a href="/project?id=<?php echo $proyecto->url ?>" class="proyecto">
        <h3><?php echo $proyecto->project ?> </h3>
      </a>
    <?php endforeach ?>
  </div>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php' ?>