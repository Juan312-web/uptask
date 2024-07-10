<div class="dashboard">
  <aside class="barra">
    <h2>UpTask</h2>
    <div class="slide">
      <img class="bar" src="/build/img/menu.svg" alt="icono">
      <nav class="nav hide">
        <a class="enlace <?php echo ($titulo === 'project') ? 'activo' : '' ?>" href="/dashboard">Proyectos</a>
        <a class="enlace <?php echo ($titulo === 'createProject') ? 'activo' : '' ?>" href="/create-project">Crear Proyecto</a>
        <a class="enlace <?php echo ($titulo === 'profile') ? 'activo' : '' ?>" href="/profile">Perfil</a>
      </nav>
    </div>

  </aside>
  <div class="contenedor-proyectos">
    <header>
      <h3>Hola, <?php echo $_SESSION['name']; ?></h3>
      <form action="/logout" method="POST">
        <input type="submit" class="boton" value="Cerrar Sesion">
      </form>
    </header>
    <main class="main-dashboard">