<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $detail[0]->PRODUKSI_NOMOR; ?></title>

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

    <div class="container">
        <!-- Main content -->
        <section>
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
                <h3><b>Laporan Produksi</b></h3>
                <h4>No. <?= $detail[0]->PRODUKSI_NOMOR; ?></h4>
            </center>
            <br>
            <br>
            <div class="row">
                <div class="col-sm-6">

                </div>
                <!-- /.col -->
                <div class="col-sm-6 text-right">
                    <?= detail_perusahaan()[0]->PERUSAHAAN_KOTA; ?>, <?= tanggal($detail[0]->PRODUKSI_TANGGAL); ?>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row mt-4">
                <div class="col-12">
                    <?php
                    $tabung = round((($detail[0]->PRODUKSI_LEVEL_AWAL - $detail[0]->PRODUKSI_LEVEL_AKHIR) * $detail[0]->PRODUKSI_KONVERSI_NILAI) / 6)
                    ?>
                    <table class="table table-bordered">
                        <tr>
                            <td><b>Level Awal</b></td>
                            <td><?= $detail[0]->PRODUKSI_LEVEL_AWAL; ?></td>
                            <td>Kg</td>
                        </tr>
                        <tr>
                            <td><b>Level Akhir</b></td>
                            <td><?= $detail[0]->PRODUKSI_LEVEL_AKHIR; ?></td>
                            <td>Kg</td>
                        </tr>
                        <tr>
                            <td rowspan="3" style="vertical-align:middle"><b>Jumlah</b></td>
                            <td><?= $detail[0]->PRODUKSI_LEVEL_AWAL - $detail[0]->PRODUKSI_LEVEL_AKHIR; ?></td>
                            <td>Kg</td>
                        </tr>
                        <tr>
                            <td><?= ($detail[0]->PRODUKSI_LEVEL_AWAL - $detail[0]->PRODUKSI_LEVEL_AKHIR) * $detail[0]->PRODUKSI_KONVERSI_NILAI; ?></td>
                            <td>m3</td>
                        </tr>
                        <tr>
                            <td><?= $tabung; ?></td>
                            <td>Tabung 6 m3</td>
                        </tr>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


            <div class="row invoice-info mt-4">
                <h4><b>Hasil Produksi</b></h4>
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                        </tr>
                        <?php
                        $no = 1;
                        $total_tabung = 0;
                        foreach ($barang as $row) {
                            if ($row->MASTER_BARANG_TOTAL == 6) {
                                $total_tabung += $row->PRODUKSI_BARANG_TOTAL;
                            } else {
                                $total_tabung += 0;
                            }

                        ?>
                            <tr>
                                <td><?= $row->MASTER_BARANG_NAMA; ?></td>
                                <td><?= number_format(($row->PRODUKSI_BARANG_TOTAL), 0, ",", "."); ?> Tabung</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>


            <div class="row invoice-info mt-4">
                <h4><b>Anggota Produksi</b></h4>
                <div class="col-sm-12 invoice-col">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah</th>
                        </tr>
                        <?php
                        $no = 1;
                        foreach ($karyawan as $row) { ?>
                            <tr>
                                <td><?= $row->MASTER_KARYAWAN_NAMA; ?></td>
                                <td><?= number_format(($row->PRODUKSI_KARYAWAN_TOTAL), 0, ",", "."); ?> Tabung</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <?php
                    $loss_gain = $total_tabung - $tabung;
                    if ($loss_gain < 0) {
                        $ket_loss_gain = "LOSS";
                    } else {
                        $ket_loss_gain = "GAIN";
                    }
                    ?>
                    <table class="table table-bordered">
                        <tr>
                            <td style="vertical-align:middle"><b><?= $ket_loss_gain ?></b></td>
                            <td><?= $total_tabung - $tabung; ?> Tabung</td>
                        </tr>
                        <tr>
                            <td><b><?= $total_tabung; ?> * 6 m3</b></td>
                            <td><?= $total_tabung * 6; ?> m3</td>
                        </tr>
                        <tr>
                            <td><b><?= $total_tabung * 6; ?> : <?= $detail[0]->PRODUKSI_KONVERSI_NILAI; ?> m3</b></td>
                            <td><?= ($total_tabung * 6) / $detail[0]->PRODUKSI_KONVERSI_NILAI; ?> Kg</td>
                        </tr>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <div class="row invoice-info mt-5">
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