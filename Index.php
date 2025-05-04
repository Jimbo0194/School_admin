<?php
$validPages = ['index', 'servicios', 'ubicacion', 'contacto', 'registro', 'login', 
               'docentes', 'estudiantes', 'grupos', 'notas'];
$page = basename($_SERVER['REQUEST_URI'], '.php');
if(!in_array($page,$validPages)){
    header("HTTP/1.0 404 Not Found");
    include("404.php");
    exit();
}
?>

<?php include("header.php"); ?>


<nav class="subnav">
  <ul>
    <li><a href="servicios.php">Servicios</a></li>
    <li><a href="ubicacion.php">Ubicación</a></li>
    <li><a href="contacto.php">Contáctenos</a></li>
    <li><a href="registro.php">Registro</a></li>
    <li><a href="login.php">Iniciar Sesión</a></li>
  </ul>
</nav>


<h1 class="welcome">🍪¡Bienvenidos Galletitas!🍪</h1>


<img src="img/IMG 1.png" class="main-image" alt="Galleta">

<?php include("footer.php"); ?>





