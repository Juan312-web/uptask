<?php include_once __DIR__ . '/header-dashboard.php' ?>
<h2 class="upper"><?php echo $titulo ?></h2>
<button id="newTask" class="boton xl new-task">+ Nueva Tarea</button>
<div class="filter">
  <h2>Filtros:</h2>
  <form class="form radio">
    <div class="input-radio">
      <label for="all">Todas</label>
      <input type="radio" name="all" id="all">
    </div>
    <div class="input-radio">
      <label for="complete">Completas</label>
      <input type="radio" name="complet" id="complet">
    </div>
    <div class="input-radio">
      <label for="pending">Completas</label>
      <input type="radio" name="pending" id="pending">
    </div>
  </form>
</div>
<div class="contenido task">
  <?php include_once __DIR__ . '/new-task.php' ?>
  <p class="xl">No Hay Tareas</p>
</div>
<?php include_once __DIR__ . '/footer-dashboard.php' ?>