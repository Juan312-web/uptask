document.addEventListener('DOMContentLoaded', function () {
  initApp();
});

function initApp() {
  menu();
  validateScreen();
  newTask();
}

function menu() {
  const menuBar = document.querySelector('.bar');
  const menuContainer = document.querySelector('.slide');

  menuBar.addEventListener('click', () => {
    menuContainer.classList.toggle('active');
  });
}

function validateScreen() {
  const menuContainer = document.querySelector('.slide');
  const formContainer = document.getElementById('form-task');

  if (window.innerWidth > 765) {
    menuContainer.classList.remove('active');
    formContainer.classList.remove('showTaskCreate');
  }
}

function newTask() {
  const buttonTask = document.getElementById('newTask');
  const formContainer = document.getElementById('form-task');
  let value = '';

  buttonTask.addEventListener('click', () => {
    formContainer.classList.add('showTaskCreate');
  });

  const inputTaskForm = document.getElementById('task');
  inputTaskForm.addEventListener('input', (e) => {
    value = e.target.value.trim();
  });

  const cancel = document.getElementById('taskCancel');
  cancel.addEventListener('click', (e) => {
    e.preventDefault();
    formContainer.classList.remove('showTaskCreate');
  });

  const projectId = document.getElementById('projectId').value;
  const taskCreate = document.getElementById('taskCreate');

  taskCreate.onclick = () => createTask(value, projectId);
}

function createAlert(message, type, reference) {
  const alerta = document.createElement('DIV');
  alerta.classList.add('alerta', type);
  alerta.textContent = message;

  const contenedorAlerta = document.createElement('DIV');
  contenedorAlerta.classList.add('contenedor-alertas');
  contenedorAlerta.appendChild(alerta);

  reference.appendChild(contenedorAlerta);
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
    const url = 'http://localhost:3000/create-task';
    const formData = new FormData();

    formData.append('name', name);
    formData.append('projectId', projectId);

    const respuesta = await fetch(url, {
      method: 'POST',
      body: formData,
    });

    const resultado = await respuesta.json();
    if (resultado) {
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

window.onresize = validateScreen;
