<div class="d-flex" id="wrapper">
    <!--INICIO DE CONTENIDO DE PAGINA -->

    <div id="page-content-wrapper" style="background: rgb(250,250,250);">

        <div class="jumbotron jumbotron-fluid p-2" id="jumbotron">
            <div class="container text-right">
                <h1 class="display-3">¡Hola <?php echo $nombre; ?>!
                </h1>
                <?php
                if ($sesion == 0) {
                ?>
                    <h3 id="registradosTotales">
                    </h3>
                <?php
                }
                ?>
            </div>
        </div>

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