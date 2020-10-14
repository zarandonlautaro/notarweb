<?php

if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    $id = "";
}

?>
<div class="container d-flex justify-content-center ">

    <div id="loginbox" style="background:white;" class="mainbox-sm col-lg-6 col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-1 mb-5 ">

        <div class="panel panel-info">
            <div class="modal-header">
                <div class="panel-title ">Subir video</div> <i class="fas fa-photo-video"></i>

            </div>

            <div style="padding-top:30px" class="panel-body">

                <form id="formFile" class="form-horizontal" role="form" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <!--------------------------------------------------------------- INPUTs--------------------------------------------------------------------------------------------------------->
                    <input type="hidden" id="CVideo" idvideo="<?php echo $id ?>" name="id" value="<?php echo $id ?>" />
                    <!--------------------------------------------------------------- INPUT SELECT COURSE--------------------------------------------------------------------------------------------------------->
                    <div class="input-group input-group-sm col-12 mb-3">
                        <div class="input-group-prepend ">
                            <label class="input-group-text " for="input-select">Curso</label>
                        </div>

                        <select class="custom-select custom-select col" id="select-course" name="curso" title="seleccionar curso">
                            <option value="0" selected>Seleccionar...</option>
                            <option value="1">One</option>

                        </select>


                    </div>
                    <!--------------------------------------------------------------- INPUT VIDEO NAME--------------------------------------------------------------------------------------------------------->
                    <div class="form-group">

                        <div class="col-12">
                            <input id="nombre" type="text" class="form-control form-control-sm" name="titulo" placeholder="Título del video" required disabled>
                        </div>
                    </div>


                    <!--------------------------------------------------------------- INPUT SELECT THEME--------------------------------------------------------------------------------------------------------->
                    <div class="input-group input-group-sm col-12 ">
                        <div class="input-group-prepend ">
                            <label class="input-group-text" for="input-select">Tema</label>
                        </div>

                        <select class="custom-select custom-select col-6" name="tema" id="select-theme" title="seleccionar tema" disabled>
                            <option selected>Seleccionar...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="-">Otro</option>
                        </select>
                        <input type="text" class="form-control col-3 " id="theme" disabled>

                        <div class="input-group-prepend">
                            <button class="btn btn-outline-success ml-1 mr-1" id="btn-add-theme" type="button" title="agregar tema" disabled><i class="fas fa-check"></i></button>
                        </div>
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-danger " id="btn-delete-theme" type="button" title="eliminar tema" disabled><i class="fas fa-times"></i></button>
                        </div>

                    </div>
                    <!--------------------------------------------------------------- INPUT FILE IMAGE--------------------------------------------------------------------------------------------------------->


                    <!--------------------------------------------------------------- INPUT VIDEO NAME--------------------------------------------------------------------------------------------------------->
                    <!--
                    <div class="custom-file mb-1">
                        <label for="video" class="col-sm-12 custom-file-label">Video</label>

                        <input type="file" class="custom-file-input" name="video" id="video" title="video" required disabled>

                    </div>-->
                    <div class="form-group mt-3">

                        <div class="col-12 mb-2">
                            <input id="videoID" type="text" class="form-control form-control-sm" name="videoID" title="copiar aquí el ID de Vimeo" placeholder="VideoID" required disabled>
                        </div>


                        <div class="list-group list-group-flush text-info col-12 " id="archivos-cargados">

                        </div>


                    </div>
                    <div class="modal-header pt-0">
                        <!-- Separador -->
                    </div>
                    <!--
                    <div class="custom-file mb-1 ">
                        <label for="imagen" class="col-sm-12 custom-file-label">Imagen de portada</label>

                        <input type="file" class="custom-file-input " id="imagen" name="imagen" title="imagen de video" required disabled>

                    </div>-->
                      <!--------------------------------------------------------------- INPUT VIDEO NAME--------------------------------------------------------------------------------------------------------->



                    <!--------------------------------------------------------------- INPUTs dinamicos--------------------------------------------------------------------------------------------------------->



                    <div class="modal-header d-flex justify-content-around">
                        <div class="panel-title col-4">Adjuntar archivos</div>


                        <fieldset class="custom-file mt-3 mb-3 col-8">

                            <button class="btn btn-outline-success" id="btnAdd" type="button" title="agregar archivo" disabled><i class="fas fa-plus"></i></button>
                            <button class="btn btn-outline-danger" id="btnDel" type="button" title="eliminar archivo" disabled><i class="fas fa-minus"></i></button>

                        </fieldset>

                    </div>
                    <fieldset id="input1" class="clonedInput ">
                        <!-- <input type="text" class="form-control col-3 " id="file1name" name="file1name" placeholder="Nombre de archivo 1">-->
                        <!--<label class="custom-file-label" for="file1">Seleccionar Archivo</label>
                            <input type="file" class="custom-file-input " name="file1" id="file1" disabled />-->


                    </fieldset>

                    <!--------------------------------------------------------------- DESCRIPCION--------------------------------------------------------------------------------------------------------->
                    <div class="form-group mt-2">

                        <div class="col">
                            <textarea id="descripcion" class="form-control form-control-sm" name="descripcion" placeholder="Descripción" data-dispats="alert" required disabled></textarea>
                        </div>
                    </div>
                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12 controls">
                            <button id="cargarVideo" type="submit" idvideo="<?php echo $id ?>" value="Subir" class="btn btn-warning">Enviar</button>
                        </div>
                    </div>

                    <div id="alert">

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>