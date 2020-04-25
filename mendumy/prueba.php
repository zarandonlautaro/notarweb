<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <table class="table table-responsive-sm ">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th colspan="2" scope="col" class="text-center">Opciones</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Contabilidad</td>
                <td colspan="2">

                    <div class="row d-flex justify-content-around">
                        <div class="col "> <button class="modificar-curso btn btn-dark">Modificar</button> </div>
                        <div class="col "> <button class="modificar-videos btn btn-info" >Modificar Videos</button> </div>
                        <div class="col"> <button class="eliminar-curso btn btn-danger">Eliminar</button></div>
                    </div>

                </td>

            </tr>

        </tbody>
    </table>
<div class="container"></div>


</body>


<script src="vendor/jquery/jquery.min.js"></script>


<script type="text/javascript">
    //funciones para inputs dinamicos----------------------------------------------------------------------------
    function agregarinput() {
        $('#file1').val("");
        $('#btnDel').attr('disabled', 'disabled');
        $('#btnAdd').click(function() {
            var num = $('.clonedInput').length; // length devuelve la cantidad de elementos de una seleccion
            var newNum = new Number(num + 1); // the numeric ID of the new input field being added

            var newElem = '<fieldset id="input' + newNum + '" class="clonedInput custom-file">' +
                '<label class="custom-file-label" for="file' + newNum + '">Seleccionar Archivo</label>' +
                '<input type="file" class="custom-file-input " name="file' + newNum + '" id="file' + newNum + '" /></fieldset>';

            $('#input' + num).after(newElem);
            // enable the "remove" button
            $('#btnDel').attr('disabled', false);

            // business rule: you can only add 10 names
            if (newNum == 10)
                $('#btnAdd').attr('disabled', 'disabled');
            nombreInputfile();

            /*
            // clonamos el elemento actual y le ponemos un id=id+numero de elemento
            var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);
            // cambiamos el nombre del elemento
            newElem.children(':last').attr('id', 'input' + newNum).attr('name', 'file' + newNum);
            //newElem.children(':first').attr('placeholder', 'Nombre de archivo ' + newNum);
            //$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            */

        });



    }

    function quitarinput() {

        $('#btnDel').click(function() {
            var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
            $('#input' + num).remove(); // remove the last element

            // enable the "add" button
            $('#btnAdd').attr('disabled', false);

            // if only one element remains, disable the "remove" button
            if (num - 1 == 1)
                $('#btnDel').attr('disabled', 'disabled');
        });


    }

    function nombreInputfile() {
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            console.log(fileName);
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    }

    $(document).ready(function() {

        nombreInputfile();
        agregarinput();
        quitarinput();


    });
</script>

<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="js/fontawesome-all.min.js"></script>

</html>