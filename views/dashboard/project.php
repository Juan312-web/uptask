<?php include_once __DIR__ . '/header-dashboard.php' ?>
<h2 class="project-title"><?php echo $titulo ?></h2>
<button id="newTask" class="boton xl new-task">+ Nueva Tarea</button>
<div class="filter">
  <h3>Filtros:</h3>
  <form class="form radio">
    <div class="input-radio">
      <label for="all">Todas</label>
      <input data-filter="2" type="radio" name="filter" id="all">
    </div>
    <div class="input-radio">
      <label for="complete">Completas</label>
      <input data-filter="1" type="radio" name="filter" id="complet">
    </div>
    <div class="input-radio">
      <label for="pending">Pendientes</label>
      <input data-filter="0" type="radio" name="filter" id="pending">
    </div>
  </form>
</div>
<div id="task" class="contenido task">
  <?php include_once __DIR__ . '/new-task.php' ?>
  <?php include_once __DIR__ . '/update-task.php' ?>
</div>
<?php include_once __DIR__ . '/footer-dashboard.php' ?>

<?php $script = "
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
  <script type='module' src='/build/js/app.js'></script>
"; ?>