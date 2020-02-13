<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Mendumy</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/home.css" rel="stylesheet">
  <link rel="shortcut icon" type="image/png" href="img/favicon.png" />
  <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
</head>

<body>

  <?php
  include('sidebar.php');
  ?>

  <div class="modal fade bd-example-modal-lg" id="modalvideo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <video id="video" controls style="width:100%;">
          Tu navegador no admite el elemento <code>video</code>.
          <source src="" type="video/mp4" preload="auto">
        </video>
      </div>
    </div>
  </div>


  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="js/fontawesome-all.min.js"></script>
  <script src="js/home.js"></script>
  <script src="js/sweetalert2.js"></script>
</body>

</html>