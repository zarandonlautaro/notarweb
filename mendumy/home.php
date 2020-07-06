<?php
include("./php/directorio.php");
if (session_status() == PHP_SESSION_NONE) {
  session_start();

  $nombre = $_SESSION['nombre'];
  $sesion = $_SESSION['rol'];

  if (isset($_POST['back_url'])) {
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    header("Location: " . $_POST['back_url']); /* Redirección del navegador */
  }
}


if (!isset($_SESSION['id'])) {
  header("Location: http://" . $directorio); /* Redirección del navegador */
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Mendumy</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/home.css" rel="stylesheet">
  <link rel="shortcut icon" type="image/png" href="img/favicon.png" />
  <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
  <link href="css/dropdown.css" rel="stylesheet">
  <!-- Deshabilitamos cache -->
  <meta http-equiv="expires" content="0">

  <meta http-equiv="Cache-Control" content="no-cache">

  <meta http-equiv="Pragma" CONTENT="no-cache">



</head>

<body>        
<div class="navbar navbar-expand-md navbar-dark bg-dark mb-4 fixed-top" role="navigation" style="background: #4e4e50 !important">
    <a class="navbar-brand" href="#"><img src="img/logo.jpeg" width="150" alt="Notarweb"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <!--Item Inicio-->
        <li class="nav-item active">
          <a id="inicio" class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
        </li>
        <!--Item Dropdown Cursos categoria-->
        <li class="nav-item dropdown active">
          <a  class="nav-link dropdown-toggle" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cursos</a>
          <ul id="categorias" class="dropdown-menu" aria-labelledby="dropdown1">
          
            <!--Item categoria-->
            <li class="dropdown-item dropdown">

              <a class="dropdown-toggle" id="dropdown1-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categoria 2</a>
              <!--Item subcategoria-->
              <ul class="dropdown-menu" aria-labelledby="dropdown1-1">
                <li class="dropdown-item" href="#"><a>Subcategoria</a></li>

              </ul>
          
            </li>
            
          </ul>
        </li>
        <!--Item Mis Cursos-->
        <li class="nav-item active">
          <a id="cursos_comprados" class="nav-link" href="#">Mis Cursos</a>
        </li>
        <!--Item Administrador-->
        <?php
        if ($_SESSION['rol'] == 0) {
         
        ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Administrador
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" id="adminpanel">Subir cursos</a>
              <a class="dropdown-item" id="subirvideo">Subir videos</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" id="modificarcurso">Modificar cursos</a>
            </div>
          </li>
        <?php
        }
        ?>

       <!--Item Salir-->
        <li class="nav-item active">
          <a class="nav-link" href="php/cerrar_sesion.php">Salir</a>
        </li>

      </ul>

      <!-- Formulario de busqueda
      <form class="form-inline mt-2 mt-md-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
      -->

      <span class="navbar-text text-white">
        Contacto:
        <a href="mailto:soporte@notarweb.com.ar">soporte@notarweb.com.ar</a>
      </span>
    </div>
  </div>

  <?php
  include('sidebar.php');
  ?>

  <div class="modal fade bd-example-modal-lg" id="modalvideo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <video id="video" controls style="width:100%;">
          Tu navegador no admite el elemento <code>video</code>.
          <source src="" type="video/mp4" preload="auto">
        </video>
      </div>
    </div>
  </div>




  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="js/fontawesome-all.min.js"></script>
  <script src="js/home.js"></script>
  <script src="js/dropdown.js"></script>
  <script src="js/admin.js"></script>
  <script src="js/subirvideo.js"></script>
  <script src="js/sweetalert2.js"></script>
</body>

</html>