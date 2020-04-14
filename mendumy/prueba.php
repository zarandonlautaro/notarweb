<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <form id="testform">
        <fieldset id="input1" class="clonedInput custom-file">
            <!-- <input type="text" class="form-control col-3 " id="file1name" name="file1name" placeholder="Nombre de archivo 1">-->
            <label class="custom-file-label" for="file1">Seleccionar Archivo</label>
            <input type="file" class="custom-file-input " name="file1" id="file1" />


        </fieldset>
        <fieldset class="custom-file mt-3">

            <button class="btn btn-outline-success" id="btnAdd" type="button" title="agregar nueva tema"><i class="fas fa-plus"></i></button>
            <button class="btn btn-outline-danger" id="btnDel" type="button" title="eliminar tema"><i class="fas fa-minus"></i></button>

        </fieldset>





    </form>

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