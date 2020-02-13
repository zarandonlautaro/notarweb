<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();
?>
<div class="d-flex" id="wrapper">
    <div class="" id="sidebar-wrapper">
        <div class="sidebar-heading">Mendumy</div>
        <div class="list-group list-group-flush">
            <a id="cursos" class="list-group-item list-group-item-action">
                <div class="row boton_sidebar">
                    <div class="col-2 text-center">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="col-10">
                        Inicio
                    </div>
                </div>
            </a>
            <a id="cursos_comprados" class="list-group-item list-group-item-action">
                <div class="row boton_sidebar">
                    <div class="col-2 text-center">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="col-10">
                        Mis cursos
                    </div>
                </div>
            </a>
            <?php
            if ($_SESSION['rol'] > 1) {
            ?>
                <a id="adminpanel" class="list-group-item list-group-item-action">
                    <div class="row boton_sidebar">
                        <div class="col-2 text-center">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="col-10">
                            Administrador
                        </div>
                    </div>
                </a>
            <?php
            }
            ?>
            <a href="php/cerrar_sesion.php" class="list-group-item list-group-item-action">
                <div class="row boton_sidebar">
                    <div class="col-2 text-center">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div class="col-10">
                        Cerrar sesión
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div id="page-content-wrapper" style="background: rgba(200, 200, 200, 0.5);">
        <nav class="navbar navbar-expand-lg">
            <button id="menu-toggle">Menú <i class="fas fa-bars"></i></button>
            <!--Boton burgerrr-->
        </nav>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">Hola de nuevo!
                </h1>
                <p class="lead">¿Listo para continuar?
                </p>
            </div>
        </div>
        <div class="container-fluid">
            <!-- SKELETON -->
            <div id="carga_cursos" style="display:none;">
                <div class="row">
                    <div class="col-xl-4 ">
                        <div id="" class="ph-item" style="width: 18rem;">
                            <div class="ph-col-12">
                                <div class="ph-picture"></div>
                                <div class="ph-row">
                                    <div class="ph-col-6 big"></div>
                                    <div class="ph-col-6 empty"></div>
                                    <div class="ph-col-12"></div>
                                    <div class="ph-col-12 empty"></div>
                                    <div class="ph-col-12 big"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 ">
                        <div id="" class="ph-item" style="width: 18rem;">
                            <div class="ph-col-12">
                                <div class="ph-picture"></div>
                                <div class="ph-row">
                                    <div class="ph-col-6 big"></div>
                                    <div class="ph-col-6 empty"></div>
                                    <div class="ph-col-12"></div>
                                    <div class="ph-col-12 empty"></div>
                                    <div class="ph-col-12 big"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 ">
                        <div id="" class="ph-item" style="width: 18rem;">
                            <div class="ph-col-12">
                                <div class="ph-picture"></div>
                                <div class="ph-row">
                                    <div class="ph-col-6 big"></div>
                                    <div class="ph-col-6 empty"></div>
                                    <div class="ph-col-12"></div>
                                    <div class="ph-col-12 empty"></div>
                                    <div class="ph-col-12 big"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 ">
                        <div id="" class="ph-item" style="width: 18rem;">
                            <div class="ph-col-12">
                                <div class="ph-picture"></div>
                                <div class="ph-row">
                                    <div class="ph-col-6 big"></div>
                                    <div class="ph-col-6 empty"></div>
                                    <div class="ph-col-12"></div>
                                    <div class="ph-col-12 empty"></div>
                                    <div class="ph-col-12 big"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 ">
                        <div id="" class="ph-item" style="width: 18rem;">
                            <div class="ph-col-12">
                                <div class="ph-picture"></div>
                                <div class="ph-row">
                                    <div class="ph-col-6 big"></div>
                                    <div class="ph-col-6 empty"></div>
                                    <div class="ph-col-12"></div>
                                    <div class="ph-col-12 empty"></div>
                                    <div class="ph-col-12 big"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 ">
                        <div id="" class="ph-item" style="width: 18rem;">
                            <div class="ph-col-12">
                                <div class="ph-picture"></div>
                                <div class="ph-row">
                                    <div class="ph-col-6 big"></div>
                                    <div class="ph-col-6 empty"></div>
                                    <div class="ph-col-12"></div>
                                    <div class="ph-col-12 empty"></div>
                                    <div class="ph-col-12 big"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RENDER COURSES BY JQUERY -->
            <div id="contenedor_home" class="">
            </div>
        </div>

    </div>
</div>