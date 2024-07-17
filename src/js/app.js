document.addEventListener('DOMContentLoaded', function () {
  initApp();
});

function initApp() {
  menu();
  validateScreen();
  newTask();
  viewTask();
}

// ? Funcion Para Crear Alertas
function createAlert(message, type, reference) {
  const alerta = document.createElement('DIV');
  alerta.classList.add('alerta', type);
  alerta.textContent = message;

  const contenedorAlerta = document.createElement('DIV');
  contenedorAlerta.classList.add('contenedor-alertas');
  contenedorAlerta.appendChild(alerta);

  reference.appendChild(contenedorAlerta);
}

// ? Funcion Para Mostrar Menu - Diseño Movil
function menu() {
  const menuBar = document.querySelector('.bar');
  const menuContainer = document.querySelector('.slide');

  menuBar.addEventListener('click', () => {
    menuContainer.classList.toggle('active');
  });
}
// ? Validar Tamaño de pantaña - Diseño Movil
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

// ? Creacion de tareas
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

async function createTask(name, projectId) {
  if (name === '') {
    const alertas = document.querySelector('.contenedor-alertas');

    if (alertas) {
      alertas.remove();
    }

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

// ? Mostrar Tareas
async function viewTask() {
  const preContainer = document.querySelector('.task-containter');
  if (preContainer) {
    preContainer.remove();
  }

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

    const container = createTaskStructure(tareas);
    containerTask.appendChild(container);
    formTask.value = '';
  } catch (error) {
    console.log('Error: ', error);
  }
}

function createTaskStructure(tareas) {
  const container = document.createElement('DIV');
  container.classList.add('task-containter');

  tareas.forEach((tarea) => {
    let itemStructure = `
      <div class="task-item">
        <h3 class="task-name center">${tarea.name}</h3>
        <div class="task-actions">
          <button class="state">Estado</button>
          <button class="state danger">Eliminar</button>
        </div>
      </div>
`;

    container.innerHTML += itemStructure;
  });

  return container;
}

window.onresize = validateScreen;
