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



    




    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/fontawesome-all.min.js"></script>
    <script src="../js/home.js"></script>
    <script src="../js/admin.js"></script>
    <script src="../js/sweetalert2.js"></script>

</body>

</html>