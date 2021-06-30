<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slip Gaji</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/dist/css/adminlte.min.css">
</head>
<style>
    @media print {
        .pagebreak {
            page-break-before: always;
        }

        /* page-break-after works, as well */
    }
</style>

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

                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <hr>
            <center>
                <h3><b>Slip Gaji</b></h3>
                <h4>Bulan <?= $gaji[0]->GAJI_BULAN; ?> Tahun <?= $gaji[0]->GAJI_TAHUN; ?></h4>
            </center>
            <br>
            <br>
            <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                    <address>
                        <strong>Nama : <?= $gaji[0]->MASTER_KARYAWAN_NAMA; ?></strong>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col text-right">
                    <?= detail_perusahaan()[0]->PERUSAHAAN_KOTA; ?>, <?= tanggal(date("Y-m-d")); ?>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table">
                        <tr>
                            <td>Gaji Pokok</td>
                            <td><?= $gaji[0]->GAJI_POKOK; ?></td>
                        </tr>
                        <tr>
                            <td>Tunjangan Jabatan</td>
                            <td><?= number_format($gaji[0]->GAJI_JABATAN); ?></td>
                        </tr>
                        <tr>
                            <td>Tunjangan Transportasi</td>
                            <td><?= number_format($gaji[0]->GAJI_TRANSPORTASI); ?></td>
                        </tr>
                        <tr>
                            <td>Tunjangan Komunikasi</td>
                            <td><?= number_format($gaji[0]->GAJI_KOMUNIKASI); ?></td>
                        </tr>
                        <tr>
                            <td>Uang Makan (<?= number_format($gaji[0]->GAJI_UANG_MAKAN); ?> x <?= $gaji[0]->GAJI_UANG_MAKAN_HARI; ?> hari)</td>
                            <td><?= number_format($gaji[0]->GAJI_UANG_MAKAN_RUPIAH); ?></td>
                        </tr>
                        <tr>
                            <td>Premi Pengantaran</td>
                            <td><?= number_format($gaji[0]->GAJI_PREMI_PENGANTARAN_RUPIAH); ?></td>
                        </tr>
                        <tr>
                            <td>Premi Produksi</td>
                            <td><?= number_format($gaji[0]->GAJI_PREMI_PRODUKSI_RUPIAH); ?></td>
                        </tr>
                        <tr>
                            <td>Premi Penjualan (<?= number_format($gaji[0]->GAJI_PERSENTASE_PREMI); ?> %)</td>
                            <td><?= number_format($gaji[0]->GAJI_PREMI_PENJUALAN_RUPIAH); ?></td>
                        </tr>
                        <tr>
                            <td><b>Total</b></td>
                            <td><b><?= number_format($gaji[0]->GAJI_TOTAL); ?></b></td>
                        </tr>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <hr>
            <div class="row invoice-info">
                <div class="col-sm-12 invoice-col">
                    Keterangan :
                    <address>
                        <?= $gaji[0]->GAJI_KETERANGAN; ?>
                    </address>
                </div>
            </div>
            <div class="row invoice-info">
                <div class="col-sm-12 invoice-col">
                </div>
            </div>
            <div class="row invoice-info">
                <div class="col-6 text-center">

                </div>
                <div class="col-6 text-center">
                    <p>Dibuat oleh :</p>
                    <br>
                    <br>
                    <br>
                    <address>
                        <b><?= $oleh[0]->USER_NAMA; ?></b><br>
                        <?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?>
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