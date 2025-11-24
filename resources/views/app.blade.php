<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

        <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="../../css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/vendor/fonts/iconify-icons.css">

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->
    
    <link rel="stylesheet" href=" {{ url('assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/font_lao.css') }}">

    
    <!-- Vendors CSS -->
    
      <link rel="stylesheet" href="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    
    <!-- endbuild -->

    <link rel="stylesheet" href="{{ url('assets/vendor/libs/apex-charts/apex-charts.css') }}">
    <!-- Page CSS -->


    @vite('resources/css/app.css')

</head>
<body>


    <div id="app-vue"></div>

     <!-- Core JS -->
    
      <script src="{{ url('assets/vendor/libs/jquery/jquery.js') }}"></script>
    
    <script src="{{ url('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ url('assets/vendor/js/bootstrap.js') }}"></script>
    

    
      <script src="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
      
      <script src="{{ url('assets/vendor/js/menu.js') }}"></script>
    
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ url('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    
      <script src="{{ url('assets/js/main.js') }}"></script>
    

    <!-- Page JS -->
    <script src="{{ url('assets/js/dashboards-analytics.js') }}"></script>


    @vite('resources/js/app.js')

</body>
</html>