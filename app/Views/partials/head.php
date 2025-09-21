<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> 
    <meta name="author" content="PIXCELSTHEMES">
    <meta name="description" content="Geex - Admin Dashboard HTML Template Pack">
    <meta name="keywords" content="Responsive, HTML5, ASP, .NET, MVC, Admin Template, Light Mode, Dark Mode, RTL Support, Customizable, PIXCELSTHEMES, Software, SaaS, Startup, Creative, Digital Product">


    <title><?= \App\Helpers\SettingsHelper::getStoreName() ?> - Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS FILES IMPORT START -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/bootstrap/bootstrap.css') ?>">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://fullcalendar.io/releases/fullcalendar/3.9.0/fullcalendar.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/cupertino/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.27.0/dist/apexcharts.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <!-- CSS FILES IMPORT END -->
   
    <?php 
    $navicon = \App\Helpers\SettingsHelper::getNavicon();
    $storeIcon = \App\Helpers\SettingsHelper::getStoreIcon();
    ?>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $navicon ? base_url($navicon) : ($storeIcon ? base_url($storeIcon) : base_url('assets/img/rmb_circle2.png')) ?>">
    <!-- FONTS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@iconscout/unicons@4.0.8/css/line.min.css">


    <script>
        // RENDER LOCAL STORAGE JAVASCRIPT
        if (localStorage.theme) document.documentElement.setAttribute("data-theme", localStorage.theme);
        if (localStorage.layout) document.documentElement.setAttribute("data-nav", localStorage.navbar);
        if (localStorage.layout) document.documentElement.setAttribute("dir", localStorage.layout);
    </script>
    <script src="<?= base_url('assets/vendor/js/jquery/jquery-3.5.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/jquery/jquery-ui.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/bootstrap/bootstrap.min.js') ?>"></script>
</head>