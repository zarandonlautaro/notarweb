<div class="container d-flex justify-content-center  " id="ventana-admin">

    <div id="loginbox" style="background:white;" class="mainbox-sm col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-1 mb-5 ">

        <div class="panel panel-info">
            <div class="modal-header">
                <div class="panel-title ">Seleccione curso y periodo </div> <i class="fas fa-photo-video"></i>

            </div>

            <div style="padding-top:30px" class="panel-body">

                <form id="form-sales" class="form-horizontal" role="form" method="POST" autocomplete="off">



                    <div class="form-group">
                        <label for="date1">Seleccione curso</label>
                        <select class="form-control form-control-sm" id="course-select">
                            <option>Seleccionar</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date1">Desde</label>
                        <input type="text" id="date1" class="form-control datepicker" value="" placeholder="Fecha inicio" data-date-format="mm/dd/yyyy" id="dp2">

                    </div>

                    <div class="form-group">
                        <label for="date2">Hasta</label>
                        <input type="text" id="date2" class="form-control datepicker" value="" placeholder="Fecha Fin" data-date-format="mm/dd/yyyy" id="dp2">
                    </div>


                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12 controls">
                            <button id="find-date" type="submit"  class="btn btn-warning">Consultar</button>
                        </div>
                    </div>


                    <div id="alert">

                    </div>

                </form>
            </div>
        </div>
    </div>