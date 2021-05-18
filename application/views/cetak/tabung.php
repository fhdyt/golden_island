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
            <table class="table table-bordered">


                <?php foreach ($tabung as $row) {
                ?>
                    <tr>
                        <td>
                            <img src="<?= base_url(); ?>uploads/qr/<?= str_replace("/", "-", $row->MASTER_TABUNG_KODE); ?>.png" class="card-img-top" alt="...">
                        </td>
                        <td>
                            <img src="<?= base_url(); ?>uploads/qr/<?= str_replace("/", "-", $row->MASTER_TABUNG_KODE); ?>.png" class="card-img-top" alt="...">
                        </td>
                        <td>
                            <img src="<?= base_url(); ?>uploads/qr/<?= str_replace("/", "-", $row->MASTER_TABUNG_KODE); ?>.png" class="card-img-top" alt="...">
                        </td>
                        <td>
                            <img src="<?= base_url(); ?>uploads/qr/<?= str_replace("/", "-", $row->MASTER_TABUNG_KODE); ?>.png" class="card-img-top" alt="...">
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <h2><b><?= $row->MASTER_TABUNG_KODE; ?></b></h2>
                            <small class="text-muted"><?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?></small>
                        </td>
                        <td align="center">
                            <h2><b><?= $row->MASTER_TABUNG_KODE; ?></b></h2>
                            <small class="text-muted"><?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?></small>
                        </td>
                        <td align="center">
                            <h2><b><?= $row->MASTER_TABUNG_KODE; ?></b></h2>
                            <small class="text-muted"><?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?></small>
                        </td>
                        <td align="center">
                            <h2><b><?= $row->MASTER_TABUNG_KODE; ?></b></h2>
                            <small class="text-muted"><?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?></small>
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