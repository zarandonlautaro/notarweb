
<body id="page-top">

    <div class="container">
        <form class="form-inline mt-4">
            <div class="input-group input-group-sm col-12 mb-3">
                <div class="input-group-prepend ">
                    <label class="input-group-text " for="input-select">Curso</label>
                </div>

                <select class="custom-select custom-select col" id="select-course" name="curso" title="seleccionar curso">
                    <option value="0" selected>Seleccionar...</option>
                    <option value="1">One</option>

                </select>


            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input type="text" class="form-control" id="mail" placeholder="Correo">
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input type="text" class="form-control" id="dni" placeholder="DNI">
            </div>
            <div class="container">
                <button type="submit" id='course-user-add' class="btn btn-warning mb-2">Aceptar</button>
                <button id='listar-course-user-add' class="btn btn-primary mb-2">Listar</button>
            </div>
        </form>

        <div id="alert">

        </div>
    </div>


</body>

