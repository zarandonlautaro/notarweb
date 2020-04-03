<div class="d-flex" id="wrapper">
    <!--INICIO DE BARRA LATERAL DESPLAZABLE -->
    <div class="" id="sidebar-wrapper">
        <div class="sidebar-heading text-warning">Mendumy</div>
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
            if ($_SESSION['rol'] == 0) {
            ?>
                <a id="adminpanel" class="list-group-item list-group-item-action">
                    <div class="row boton_sidebar ">
                        <div class="col-2 text-center">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="col-10 ">
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
    <!--FIN DE BARRA LATERAL DESPLAZABLE -->
    <!--INICIO DE CONTENIDO DE PAGINA -->
    <div id="page-content-wrapper" style="background: rgba(200, 200, 200, 0.5);">
        <nav class="navbar navbar-expand-lg">
            <button id="menu-toggle">Menú <i class="fas fa-bars"></i></button>
            <!--BOTON BURGER-->
        </nav>
        <div class="jumbotron jumbotron-fluid" id="jumbotron">
            <div class="container">
                <h1 class="display-4">¡Hola <?php echo $nombre; ?>!
                </h1>
                <p class="lead">¿Listo para continuar?
                </p>

                <!-- Button trigger modal -->
              <!--  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Launch demo modal
                </button>-->

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Comprar Curso</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div id='pago' class="modal-body">
                                
                            </div>
                           <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>-->
                        </div>
                    </div>
                </div>




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
            <div id="contenedor_home" class="mb-2">



            </div>
        </div>

    </div>
    <!--INICIO DE CONTENIDO DE PAGINA -->
</div>