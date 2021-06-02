<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/dist/css/adminlte.min.css">
    <style>
        table.table-bordered {
            border: 2px solid black !important;
            ;
            margin-top: 20px !important;
            ;
        }

        table.table-bordered>thead>tr>th {
            border: 2px solid black !important;
            ;
        }

        table.table-bordered>tbody>tr>td {
            border: 2px solid black !important;
            ;
        }

        table.table-bordered>tr>td {
            border: 2px solid black !important;
            ;
        }

        div.kolom {
            height: 600px;
            border: 2px solid black;
            margin-bottom: 50px;
        }

        @media print {
            table.table-bordered {
                border: 2px solid black !important;
                ;
                margin-top: 20px !important;
                ;
            }

            table.table-bordered>thead>tr>th {
                border: 2px solid black !important;
                ;
            }

            table.table-bordered>tbody>tr>td {
                border: 2px solid black !important;
                ;
            }

            table.table-bordered>tr>td {
                border: 2px solid black !important;
                ;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-2 text-right">
                    <img src="<?php echo base_url(); ?>uploads/perusahaan/<?= detail_perusahaan()[0]->PERUSAHAAN_KODE; ?>.png" height="90px" alt="">
                </div>
                <div class="col-8 invoice-col">
                    <address>
                        <h2><b><?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?></b></h2>
                        <?= detail_perusahaan()[0]->PERUSAHAAN_ALAMAT; ?><br>
                        Telp : <?= detail_perusahaan()[0]->PERUSAHAAN_TELP; ?>
                    </address>
                </div>
                <div class="col-2 text-left">
                    &nbsp;&nbsp;
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <hr>
            <center>
                <?php
                if ($detail[0]->SURAT_JALAN_JENIS == "penjualan") {
                    $jenis = "Penjualan";
                } else {
                    $jenis = "Pembelian";
                }
                ?>
                <h3><b> &nbsp;&nbsp;</b></h3>
                <h4></h4>
            </center>
            <br>
            <br>
            <div class="row invoice-info mb-2">
                <div class="col-sm-6 invoice-col">
                </div>
                <div class="col-sm-6 invoice-col text-right">
                    &nbsp;&nbsp;
                </div>
            </div>
            <div class="row invoice-info">
                <div class="col-sm-5 invoice-col">
                    Kepada :
                    <hr>
                    <address>
                        <strong>&nbsp;&nbsp;</strong><br>
                        &nbsp;&nbsp;<br>
                        &nbsp;&nbsp;<br>
                        &nbsp;&nbsp;<br>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col text-right">
                </div>
                <div class="col-sm-3 invoice-col text-right">

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->

            <hr>
            <div class="kolom"></div>
            <div class="row invoice-info">
                <div class="col-4 text-center">
                    <p>Diterima oleh :</p>
                    <br>
                    <br>
                    <br>
                    <br>

                </div>
                <div class="col-4 text-center">
                    <p>Dibawa Oleh :</p>

                    <br>
                    <br>
                    <br>
                    <br>
                </div>
                <div class="col-4 text-center">
                    <p>Dibuat oleh :</p>

                    <br>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
            <hr>
            <div class="row invoice-info">
                <div class="col-4 text-center">
                    Asli (Putih) : Administrasi
                </div>
                <div class="col-4 text-center">
                    Tembusan (Merah) : Penagihan
                </div>
                <div class="col-4 text-center">
                    (Kuning) : Akuntansi
                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>