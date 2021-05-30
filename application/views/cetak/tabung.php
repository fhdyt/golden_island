<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Qrcode Tabung</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/dist/css/adminlte.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <table class="table">


                <?php foreach ($tabung as $row) {
                ?>
                    <tr>
                        <td rowspan="2" style="text-align:center; vertical-align:middle">
                            <img src="<?= base_url(); ?>uploads/perusahaan/STIKER_<?= $this->session->userdata('PERUSAHAAN_KODE'); ?>.png" class="card-img-top" alt="...">
                        </td>
                        <td>
                            <img src="<?= base_url(); ?>uploads/qr/<?= str_replace("/", "-", $row->MASTER_TABUNG_KODE); ?>.png" class="card-img-top" alt="...">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <h3><?= $row->MASTER_TABUNG_KODE ?></h3>
                        </td>
                    </tr>

                <?php
                }
                ?>
            </table>
            <!-- /.content -->
        </div>
        <!-- ./wrapper -->
        <!-- Page specific script -->
        <script>
            window.addEventListener("load", window.print());
        </script>
</body>

</html>