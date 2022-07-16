<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="utf-8" />
        <!-- <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.ico"> -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <title>Absensi Online</title>

        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
        <link href="<?= base_url('assets/vendor/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" />

        <!-- CSS Files -->
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" />
        <link href="<?= base_url('assets/css/light-bootstrap-dashboard.css?v=2.0.1') ?>" rel="stylesheet" />
        <!-- CSS Just for demo purpose, don't include it in your project -->
        <link href="<?= base_url('assets/css/demo.css') ?>" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script>
            var BASEURL = '<?= base_url() ?>';
        </script>
    </head>
</head>

<body class="bg-primary">
    <!--  -->
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div style="margin-top: 10%;">
                <div class="card">
                    <div class="card-body text-center">
                        <h4>Scan Barcode Absensi</h4>
                        <div id='qrcode'></div>
                        <span>scan barcode saat Jam Masuk dan Pulang</span>
                    </div>
                </div>
            </div>
        </div>
</body>




<!--   Core JS Files   -->
<script src="<?= base_url('assets/js/core/jquery.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/core/popper.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/js/core/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>

<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="<?= base_url('assets/js/plugins/bootstrap-switch.js') ?>"></script>
<!--  Notifications Plugin    -->
<script src="<?= base_url('assets/js/plugins/bootstrap-notify.js') ?>"></script>
<!-- SweetAlert -->
<script src="<?= base_url('assets/js/plugins/sweetalert.min.js') ?>"></script>


<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.qrcode.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js//qrcode.js"></script>

<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="<?= base_url('assets/js/light-bootstrap-dashboard.js?v=2.0.1') ?>" type="text/javascript"></script>

<!-- Main Js -->
<script src="<?= base_url('assets/js/main.js') ?>"></script>

<script>
    $('#qrcode').qrcode("<?= $id ?>");
</script>

</html>
<?php
