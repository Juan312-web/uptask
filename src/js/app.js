document.addEventListener('DOMContentLoaded', function () {
  initApp();
});

function initApp() {
  menu();
  validateScreen();
  newTask();
  viewTask();
  filter();
}

// * Funcion Para Crear Alertas
function createAlert(message, type, reference) {
  const alerta = document.createElement('DIV');
  alerta.classList.add('alerta', type);
  alerta.textContent = message;

  const alertas = document.querySelector('.contenedor-alertas');
  if (alertas) {
    alertas.remove();
  }

  const contenedorAlerta = document.createElement('DIV');
  contenedorAlerta.classList.add('contenedor-alertas');
  contenedorAlerta.appendChild(alerta);

  reference.appendChild(contenedorAlerta);

  setTimeout(() => {
    cleanAlerts();
  }, 5000);
  return;
}

function cleanAlerts() {
  const alertas = document.querySelectorAll('.contenedor-alertas');
  alertas.forEach((alerta) => alerta.remove());
}
// * Funcion Para Mostrar Menu - Diseño Movil
function menu() {
  const menuBar = document.querySelector('.bar');
  const menuContainer = document.querySelector('.slide');

  menuBar.addEventListener('click', () => {
    menuContainer.classList.toggle('active');
  });
}
// * Validar Tamaño de pantaña - Diseño Movil
function validateScreen() {
  const menuContainer = document.querySelector('.slide');
  const formContainer = document.getElementById('form-task');

  if (window.innerWidth > 765) {
    menuContainer.classList.remove('active');
    if (formContainer) {
      formContainer.classList.remove('showTaskCreate');
    }
  }
}

// * Creacion de tareas Visual
function newTask() {
  const buttonTask = document.getElementById('newTask');
  const formContainer = document.getElementById('form-task');
  let value = '';

  if (buttonTask) {
    buttonTask.addEventListener('click', () => {
      formContainer.classList.add('showTaskCreate');
    });
  }

  const inputTaskForm = document.getElementById('task');
  if (inputTaskForm) {
    inputTaskForm.addEventListener('input', (e) => {
      value = e.target.value.trim();
    });
  }

  const cancel = document.getElementById('taskCancel');
  if (cancel) {
    cancel.addEventListener('click', (e) => {
      e.preventDefault();
      formContainer.classList.remove('showTaskCreate');
    });
  }

  const projectId = document.getElementById('projectId')?.value;
  const taskCreate = document.getElementById('taskCreate');

  taskCreate.addEventListener('click', () => {
    createTask(value, projectId);
  });
}

// * Creacion de tareas en BD
async function createTask(name, projectId) {
  if (!name) {
    createAlert(
      'El nombre es obligatorio',
      'error',
      document.querySelector('.form-task')
    );
    return;
  }

  try {
    const url = 'http://localhost:3000/api/task';
    const formData = new FormData();

    formData.append('name', name);
    formData.append('state', 0);
    formData.append('projectId', projectId);

    const respuesta = await fetch(url, {
      method: 'POST',
      body: formData,
    });

    const resultado = await respuesta.json();
    if (resultado) {
      viewTask();
      const formContainer = document.getElementById('form-task');
      formContainer.classList.remove('showTaskCreate');
      const inputTaskForm = document.getElementById('task');
      inputTaskForm.value = '';

      createAlert(
        'Tarea Creada Correctamente',
        'exito',
        document.querySelector('.dashboard')
      );
    }
  } catch (error) {}
}

// * Mostrar Tareas
async function viewTask() {
  try {
    const url = 'http://localhost:3000/api/task';
    const resultado = await fetch(url);

    const respuesta = await resultado.json();
    const { tareas } = respuesta;

    const containerTask = document.getElementById('task');

    if (tareas.length === 0) {
      const message = document.createElement('P');
      message.classList.add('no-task');
      message.textContent = 'No Hay Tareas Aún';
      containerTask.appendChild(message);
      return;
    }

    const message = document.querySelector('.no-task');
    const formTask = document.getElementById('task-input');

    if (message) {
      message.remove();
    }

    const preContainer = document.querySelector('.task-containter');
    if (preContainer) {
      preContainer.remove();
    }
    const container = createTaskStructure(tareas);
    containerTask.appendChild(container);
    formTask.value = '';

    const buttonState = document.querySelectorAll('#state');
    const buttonDelete = document.querySelectorAll('#delete');
    const taskText = document.querySelectorAll('#task-name');

    buttonState.forEach((button) => {
      button.addEventListener('click', () => {
        const taskId = parseInt(button.dataset.task);
        changeState(taskId);
      });
    });

    buttonDelete.forEach((button) => {
      button.addEventListener('click', () => {
        const taskId = parseInt(button.dataset.task);
        confirmDeleteTask(taskId);
      });
    });

    taskText.forEach((text) => {
      const taskId = text.dataset.id;
      text.addEventListener('dblclick', () => {
        updateTask(taskId);
      });
    });
  } catch (error) {
    console.log('Error: ', error);
  }
}

// * Cambiar Estado Visual de Tarea
async function changeState(id) {
  const task = document.querySelector(`[data-task="${id}"]`);
  const parent = task.parentNode.parentNode;

  const taskBD = await findTask(id);
  const taskState = taskBD.state;

  if (taskState === '0') {
    task.textContent = 'Pendiente';
    task.classList.add('pending');
    task.classList.remove('complete');
    parent.dataset.state = '0';
  } else {
    task.textContent = 'Completada';
    task.classList.add('complete');
    task.classList.remove('pending');
    parent.dataset.state = '1';
  }
}

// * Crear Estructura de Tarea
function createTaskStructure(tareas) {
  const container = document.createElement('DIV');
  container.classList.add('task-containter');

  tareas.forEach((tarea) => {
    let { id, name, state } = tarea;
    state = parseInt(state);

    let itemStructure = `
      <div data-state="${state}" class="task-item">
        <h3 id="task-name" data-id="${id}" class="task-name center">${name}</h3>
        <div class="task-actions">
          <button data-task="${id}" id="state" class="state ${
      state ? 'complete' : 'pending'
    }">${state ? 'Completada' : 'Pendiente'}</button>
          <button data-task="${id}" id="delete" class="state danger">Eliminar</button>
        </div>
      </div>
`;

    container.innerHTML += itemStructure;
  });

  return container;
}

// * Encontrar Tarea y actualizar estado en BD
async function findTask(id) {
  const url = `http://localhost:3000/api/task/find?id=${id}`;
  const resultado = await fetch(url);
  const respuesta = await resultado.json();

  return respuesta;
}

// * Eliminar Tarea
function confirmDeleteTask(id) {
  Swal.fire({
    title: '¿Estas seguro de eliminar esta tarea?',
    showCancelButton: true,
    confirmButtonText: 'Si',
    cancelButtonText: 'No',
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      deleteTarea(id);
    }
  });
}

async function deleteTarea(id) {
  try {
    const url = `http://localhost:3000/api/task/delete?id=${id}`;
    const resultado = await fetch(url);
    const respuesta = await resultado.text();

    if (respuesta) {
      viewTask();
    }
  } catch (error) {
    console.log('Error: ', error);
  }
}

// * Creacion de tareas Visual
function updateTask(id) {
  const formContainer = document.getElementById('update-task');
  formContainer.classList.add('showTaskCreate');

  let value = '';
  const inputTaskForm = document.getElementById('task-input-update');

  if (inputTaskForm) {
    inputTaskForm.addEventListener('input', (e) => {
      value = e.target.value.trim();
    });
  }

  const cancel = document.getElementById('taskCancelUpdate');
  if (cancel) {
    cancel.addEventListener('click', (e) => {
      e.preventDefault();
      formContainer.classList.remove('showTaskCreate');
      inputTaskForm.value = '';
    });
  }

  const taskUpdateButton = document.querySelector('#taskUpdate');

  if (taskUpdateButton) {
    taskUpdateButton.onclick = function () {
      updateTaskValue(value, id);
    };
  }
}

async function updateTaskValue(name, id) {
  if (!name) {
    createAlert(
      'El nombre es obligatorio',
      'error',
      document.querySelector('#update-task')
    );
    return;
  }

  try {
    const url = 'http://localhost:3000/api/task/update';
    const formData = new FormData();

    formData.append('name', name);
    formData.append('id', id);

    const resultado = await fetch(url, {
      method: 'POST',
      body: formData,
    });

    const respuesta = await resultado.json();
    if (respuesta) {
      const formContainer = document.getElementById('update-task');
      formContainer.classList.remove('showTaskCreate');

      const inputTaskForm = document.getElementById('task');
      inputTaskForm.value = '';

      createAlert(
        'Tarea Actualizada Correctamente',
        'exito',
        document.querySelector('.dashboard')
      );
    }
    viewTask();
  } catch (error) {
    console.log('Error: ', error);
  }
}

function filter() {
  const inputRadio = document.querySelectorAll('.input-radio input');

  inputRadio.forEach((input) => {
    input.addEventListener('input', () => {
      const state = parseInt(input.dataset.filter);

      if (state === 2) {
        viewTask();
        return;
      }

      if (state === 0) {
        const taskComplete = document.querySelectorAll(`[data-state="1"]`);
        const taskPending = document.querySelectorAll(`[data-state="0"]`);

        taskComplete.forEach((taskItem) =>
          taskItem.classList.add('hidden-task')
        );

        taskPending.forEach((taskItem) =>
          taskItem.classList.remove('hidden-task')
        );
        return;
      }

      if (state === 1) {
        const taskComplete = document.querySelectorAll(`[data-state="1"]`);
        const taskPending = document.querySelectorAll(`[data-state="0"]`);

        taskPending.forEach((taskItem) =>
          taskItem.classList.add('hidden-task')
        );

        taskComplete.forEach((taskItem) =>
          taskItem.classList.remove('hidden-task')
        );
        return;
      }
    });
  });
}
window.onresize = validateScreen;
