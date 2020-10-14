<?php if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    $id = "";
} ?>

<div class="container d-flex justify-content-center  " id="ventana-admin">

    <div id="loginbox" style="background:white;" class="mainbox-sm col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-1 mb-5 ">

        <div class="panel panel-info">
            <div class="modal-header">
                <div class="panel-title ">Subir curso</div> <i class="fas fa-photo-video"></i>

            </div>

            <div style="padding-top:30px" class="panel-body">

                <form id="formFile" class="form-horizontal" role="form" method="POST" autocomplete="off" enctype="multipart/form-data">

                    <div class="form-group">

                        <div class="col-12">
                            <input id="nombre" type="text" class="form-control form-control-sm" name="nombre" placeholder="Título" required>
                        </div>
                    </div>

                    <div class="form-group d-flex">

                        <div class="col-6">
                            <input id="precio" type="text" class="form-control form-control-sm" title="Precio" name="precio" placeholder="Precio" required>
                        </div>
                        <div class="custom-control custom-checkbox  col-6">
                            <input type="checkbox" class="custom-control-input" id="cb-gratis">
                            <label class="custom-control-label" for="cb-gratis">Gratis</label>
                        </div>
                    </div>
                    <div class="input-group input-group-sm col-12 mb-2">
                        <div class="input-group-prepend ">
                            <label class="input-group-text" for="input-select-credential" required>Credencial</label>
                        </div>

                        <select class="custom-select custom-select col-12" name="credencial" id="input-select-credential" title="seleccionar credencial">
                            <option selected>Seleccionar...</option>
                            

                        </select>


                    </div>


                    <div class="input-group input-group-sm col-12 mb-2">
                        <div class="input-group-prepend ">
                            <label class="input-group-text" for="input-select" required>Categoria</label>
                        </div>

                        <select class="custom-select custom-select col-6" id="input-select" title="seleccionar categoría">
                            <option selected>Seleccionar...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="-">Otro</option>

                        </select>

                        <input type="text" class="form-control col-3 " id="categoria" name="categoria">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-success" id="btn-agregar" type="button" title="agregar nueva categoría"><i class="fas fa-check"></i></button>
                        </div>
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-danger" id="btn-eliminar" type="button" title="eliminar categoría"><i class="fas fa-times"></i></button>
                        </div>

                    </div>
                    <div class="input-group input-group-sm col-12 mb-2">
                        <div class="input-group-prepend ">
                            <label class="input-group-text" for="input-select" required>Subcategoria</label>
                        </div>

                        <select class="custom-select custom-select col-6" id="input-select-sub" title="seleccionar subcategoría" disabled>
                            <option selected>Seleccionar...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="-">Otro</option>

                        </select>

                        <!--Subcategorias select option-->                    
                        <input type="text" class="form-control col-3 " id="subcategoria" name="subcategoria" disabled>
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-success" id="btn-agregar-sub" type="button" title="agregar nueva subcategoría" disabled><i class="fas fa-check"></i></button>
                        </div>
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-danger" id="btn-eliminar-sub" type="button" title="eliminar subcategoría" disabled><i class="fas fa-times"></i></button>
                        </div>
                      

                    </div>
                    <div class="modal-header pt-0">
                        <!-- Separador -->
                    </div>
                    <div class="form-group form-group-sm col-12">

                        <?php if ($id == "") { ?>
                            <label for="imagen" class="col-sm-12 col-form-label">Imagen de portada</label>
                        <?php } else { ?>

                            <input type="hidden" id="<?php echo $id ?>" name="id" value="<?php echo $id ?>" />
                            <div class="custom-control custom-checkbox  col-12 mb-2 ">
                                <input type="checkbox" class="custom-control-input" id="cb-imagen">
                                <label class="custom-control-label" for="cb-imagen">Cambiar imagen</label>
                            </div>
                        <?php } ?>
                        <div class="col-sm-12">
                            <input type="file" class="form-control-file" id="imagen" name="imagen" required>
                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col">
                            <textarea id="descripcion" class="form-control form-control-sm" name="descripcion" placeholder="Descripción" data-dispats="alert"></textarea>
                        </div>
                    </div>
                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12 controls">
                            <button id="cargarCurso" type="submit" value="Subir" idcurso="<?php echo $id ?>" class="btn btn-warning">Enviar</button>
                        </div>
                    </div>
                    <div id="alert">

                    </div>

                </form>
            </div>
        </div>
    </div>