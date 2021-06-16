<?php
error_reporting(0);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Produksi</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/dist/css/adminlte.min.css">
    <style>
        html,
        body {
            display: block;
            font-family: sans-serif;
            margin: 0;
        }

        tr td {
            padding: 0 !important;
            margin: 0 !important;
        }

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

        @media print {

            html,
            body {
                /* display: block; */
                font-family: sans-serif;
                margin: 0;
            }

            /* @page {
                size: 21.59cm 13.97cm;
            } */

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
            <div class="row mt-5">
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
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <br>
            <center>
                <?php
                if ($detail[0]->SURAT_JALAN_JENIS == "penjualan") {
                    $jenis = "Penjualan";
                } else {
                    $jenis = "Pembelian";
                }
                ?>
                <h3><b>Form Produksi (..........)</b></h3>
                <h4>No. ...............................</h4>
            </center>
            <br>
            <div class="row invoice-info mb-2">
                <div class="col-sm-3 invoice-col">
                    <h4>Level Awal</h4>
                    <h4>............</h4>
                </div>
                <div class="col-sm-3 invoice-col">
                    <h4>Level Akhir</h4>
                    <h4>............</h4>
                </div>
                <div class="col-sm-6 invoice-col text-right">
                    <?= detail_perusahaan()[0]->PERUSAHAAN_KOTA; ?>, .............................
                </div>
            </div>
            <!-- Table row -->

            <hr>
            <h4>Total Produksi</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Rak</th>
                        <th>MP</th>
                        <th>MR</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($x = 1; $x <= 8; $x++) {

                    ?>
                        <tr>
                            <td>1. </td>
                            <td>.....</td>
                            <td>.....</td>
                            <td>.....</td>

                        </tr>
                        <tr>
                            <td>2. </td>
                            <td>.....</td>
                            <td>.....</td>
                            <td>.....</td>

                        </tr>

                    <?php
                    }
                    ?>
                    <tr>
                        <td style="text-align:center"><b>Total</b></td>
                        <td>.....</td>
                        <td>.....</td>
                        <td>.....</td>

                    </tr>
                </tbody>
            </table>
            <hr>
            <h4>Anggota Produksi</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No. </th>
                        <th>Nama Karyawan</th>
                        <th>Total Produksi</th>
                        <th>Keterangan</th>
                        <th>Paraf</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>..........</td>
                        <td>..........</td>
                        <td>..........</td>
                        <td>..........</td>
                        <td>..........</td>
                    </tr>
                    <tr>
                        <td>..........</td>
                        <td>..........</td>
                        <td>..........</td>
                        <td>..........</td>
                        <td>..........</td>
                    </tr>
                    <tr>
                        <td>..........</td>
                        <td>..........</td>
                        <td>..........</td>
                        <td>..........</td>
                        <td>..........</td>
                    </tr>
                    <tr>
                        <td>..........</td>
                        <td>..........</td>
                        <td>..........</td>
                        <td>..........</td>
                        <td>..........</td>
                    </tr>
                </tbody>
            </table>
            <div class="row invoice-info mb-4">
                <div class="col-sm-4 invoice-col">
                </div>
            </div>
            <div class="col-sm-3 invoice-col">
            </div>
            <div class="col-sm-5 invoice-col">
            </div>
    </div>
    <div class="row invoice-info">
        <div class="col-4 text-center">

        </div>
        <div class="col-4 text-center">

        </div>
        <div class="col-4 text-center">
            <p>Diperiksa oleh :</p>
            <br>
            <br>
            <br>
            <address>
                <b>( ............................. )</b><br>
            </address>
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