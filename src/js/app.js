document.addEventListener('DOMContentLoaded', function () {
  initApp();
});

function initApp() {
  menu();
  validateScreen();
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

  if (window.innerWidth > 765) {
    menuContainer.classList.remove('active');
  }
}

window.onresize = validateScreen;
