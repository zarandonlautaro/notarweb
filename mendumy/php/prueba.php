<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/home.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">

</head>

<body>



    <div class="container">


        <div class="container">

            <a class="btn btn-dark col-4" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                Link with href
            </a>

            <div class="collapse  col-4 w-100 p-0" id="collapseExample2">

                <a class="btn btn-info col" data-toggle="collapse" href="#" role="button" aria-expanded="false" aria-controls="collapseExample">
                    1
                </a>
                <a class="btn btn-info col" data-toggle="collapse" href="#" role="button" aria-expanded="false" aria-controls="collapseExample">
                    2
                </a>
                <a class="btn btn-info col" data-toggle="collapse" href="#" role="button" aria-expanded="false" aria-controls="collapseExample">
                    3
                </a>

            </div>
        </div>

        <div class="container">
            <button class="btn btn-primary col-4" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Button with data-target
            </button>



            <div class="collapse" id="collapseExample">
                <div class="card card-body col-4">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                </div>
            </div>

        </div>
    </div>

    <!--Acordeon----------------------------------------------------------------------------------------------------------->


    <div id="accordion">
        <!--Elemento colapsable-->
        <div class="card">
            <!--Cabecera de elemento de acordeon-->
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Collapsible Group Item #1
                    </button>
                </h5>
            </div>
            <!--Elemento colapsable al tocar cabecera-->
            <div id="collapseOne" class="collapse text-white bg-dark" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
            </div>
        </div>
        <!--Elemento no colapsable-->



    </div>



    <div class="list-group card text-white bg-dark ">
        <a href="#" class="list-group-item list-group-item-action ">
            Cras justo odio
        </a>
        <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
        <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
        <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
        <a href="#" class="list-group-item list-group-item-action">Vestibulum at eros</a>
    </div>




    <div class="col-xl-4 mt-2">
        <div class="  mendocard shadow-lg" style="width: 18rem;">
            <img src="imgcourses/' + imgvideo + '" class="mendocard-picture">
            <div class="">
                <h5 class="pt-2">' + title + '</h5>

                <p class=""> ' + description + ' </p>
                <div class="container d-flex justify-content-around mb-3  ">
                    <button class=" btn btn-md p-1  btn-info mr-2 col-xs-12 col-xl-4"  id="'+idcourse+'">Volver</button>
                    <button class=" btn btn-md p-1  btn-info mr-2 col-xs-12 col-xl-4" id="video'+id+'">Ver </button>
                </div>
            </div>

        </div>
    </div>















</body>

</html>