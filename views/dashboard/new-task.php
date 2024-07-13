<div id="form-task" class="form-task">
  <div id="crateTask" class="form">
    <h2>Nueva Tarea</h2>
    <div class="input">
      <label for="task">Nombre: </label>
      <input type="text" name="task" id="task">
      <input type="hidden" name="projectId" id="projectId" value="<?php echo $projectId ?>">
    </div>
    <div class="task-actions">
      <button id="taskCreate" class="boton">Crear Tarea</button>
      <button id="taskCancel" class="boton danger">Cancelar</button>
    </div>
  </div>
</div>