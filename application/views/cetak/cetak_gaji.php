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
                <h4>Bulan <?= bulan_id($gaji[0]->GAJI_BULAN); ?> Tahun <?= $gaji[0]->GAJI_TAHUN; ?></h4>
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
                            <td><?= number_format($gaji[0]->GAJI_POKOK, 0, ",", "."); ?></td>
                        </tr>
                        <tr>
                            <td>Tunjangan Jabatan</td>
                            <td><?= number_format($gaji[0]->GAJI_JABATAN, 0, ",", "."); ?></td>
                        </tr>
                        <tr>
                            <td>Tunjangan Transportasi</td>
                            <td><?= number_format($gaji[0]->GAJI_TRANSPORTASI, 0, ",", "."); ?></td>
                        </tr>
                        <tr>
                            <td>Tunjangan Komunikasi</td>
                            <td><?= number_format($gaji[0]->GAJI_KOMUNIKASI, 0, ",", "."); ?></td>
                        </tr>
                        <tr>
                            <td>Uang Makan (<?= number_format($gaji[0]->GAJI_UANG_MAKAN, 0, ",", "."); ?> x <?= $gaji[0]->GAJI_UANG_MAKAN_HARI; ?> hari)</td>
                            <td><?= number_format($gaji[0]->GAJI_UANG_MAKAN_RUPIAH, 0, ",", "."); ?></td>
                        </tr>
                        <tr>
                            <td>Premi Pengantaran</td>
                            <td><?= number_format($gaji[0]->GAJI_PREMI_PENGANTARAN_RUPIAH, 0, ",", "."); ?></td>
                        </tr>
                        <tr>
                            <td>Premi Produksi</td>
                            <td><?= number_format($gaji[0]->GAJI_PREMI_PRODUKSI_RUPIAH, 0, ",", "."); ?></td>
                        </tr>
                        <tr>
                            <td>Premi Penjualan (<?= number_format($gaji[0]->GAJI_PERSENTASE_PREMI, 0, ",", "."); ?> %)</td>
                            <td><?= number_format($gaji[0]->GAJI_PREMI_PENJUALAN_RUPIAH, 0, ",", "."); ?></td>
                        </tr>
                        <tr>
                            <td><b>Total</b></td>
                            <td><b><?= number_format($gaji[0]->GAJI_TOTAL, 0, ",", "."); ?></b></td>
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
        <div class="pagebreak"> </div>
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
                <h3><b>Premi Pengantaran</b></h3>
                <h4>Bulan <?= bulan_id($gaji[0]->GAJI_BULAN); ?> Tahun <?= $gaji[0]->GAJI_TAHUN; ?></h4>
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Nomor Surat Jalan</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Tanggal</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Relasi</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Supplier</th>
                                <th colspan="3" style="text-align: center; vertical-align: middle;">Quantity Surat Jalan</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Total</th>
                            </tr>
                            <tr>
                                <th>Isi</th>
                                <th>Kosong</th>
                                <th>Klaim</th>
                            </tr>
                        </thead>
                        <tbody id="zone_data_sj">
                            <?php
                            $no = 1;
                            $total_sj = 0;
                            foreach ($surat_jalan as $row) {
                                $total = ($row->BARANG[0]->ISI + $row->BARANG[0]->KOSONG) - $row->BARANG[0]->KLAIM;
                                $total_sj += $total;

                                if (count($row->RELASI) == 0) {
                                    $relasi = "-";
                                } else {
                                    $relasi = $row->RELASI[0]->MASTER_RELASI_NAMA;
                                }
                                if (count($row->SUPPLIER) == 0) {
                                    $supplier = "-";
                                } else {
                                    $supplier = $row->SUPPLIER[0]->MASTER_SUPPLIER_NAMA;
                                }
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row->SURAT_JALAN_NOMOR; ?></td>
                                    <td><?= $row->TANGGAL; ?></td>
                                    <td><?= $relasi; ?></td>
                                    <td><?= $supplier; ?></td>
                                    <td><?= $row->BARANG[0]->ISI; ?></td>
                                    <td><?= $row->BARANG[0]->KOSONG; ?></td>
                                    <td><?= $row->BARANG[0]->KLAIM; ?></td>
                                    <td><?= $total; ?></td>

                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="8" style="text-align:right">Total</td>
                                <td><?= $total_sj; ?></td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align:right">Total Terima</td>
                                <td>Rp. <?= number_format($total_sj  * $gaji[0]->GAJI_PREMI_PENGANTARAN); ?></td>
                            </tr>
                        </tbody>
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
        <div class="pagebreak"> </div>
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
                <h3><b>Premi Produksi</b></h3>
                <h4>Bulan <?= bulan_id($gaji[0]->GAJI_BULAN); ?> Tahun <?= $gaji[0]->GAJI_TAHUN; ?></h4>
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Nomor Produksi</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Tanggal</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Total</th>
                            </tr>
                        </thead>
                        <tbody id="zone_data_sj">
                            <?php
                            $no = 1;
                            $total_produksi = 0;
                            foreach ($produksi as $row) {
                                $total_produksi += $row->PRODUKSI_KARYAWAN_TOTAL;
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row->PRODUKSI_NOMOR; ?></td>
                                    <td><?= $row->TANGGAL; ?></td>
                                    <td><?= $row->PRODUKSI_KARYAWAN_TOTAL ?></td>

                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="3" style="text-align:right">Total</td>
                                <td><?= $total_produksi; ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right">Total Terima</td>
                                <td>Rp. <?= number_format($total_produksi  * $gaji[0]->GAJI_PREMI_PRODUKSI); ?></td>
                            </tr>
                        </tbody>
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
        <div class="pagebreak"> </div>
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
                <h3><b>Premi Penjualan</b></h3>
                <h4>Bulan <?= bulan_id($gaji[0]->GAJI_BULAN); ?> Tahun <?= $gaji[0]->GAJI_TAHUN; ?></h4>
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Jenis</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Total</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Rupiah</th>
                            </tr>
                        </thead>
                        <tbody id="zone_data_sj">
                            <?php
                            $total_gas = 0;
                            foreach ($gas as $row) {
                                $premi = $gaji[0]->GAJI_PREMI_PENJUALAN;
                                $rupiah = $row->TOTAL * $premi;
                                $total_gas += $rupiah;
                            ?>
                                <tr>
                                    <td>1.</td>
                                    <td>Penjualan Gas</td>
                                    <td><?= $row->TOTAL; ?></td>
                                    <td>Rp. <?= number_format($rupiah); ?></td>

                                </tr>
                            <?php
                            }
                            ?>
                            <?php
                            $total_liquid = 0;
                            foreach ($liquid as $row) {
                                $premi = $gaji[0]->GAJI_PREMI_PENJUALAN;

                                $tabung = $row->TOTAL / 6;
                                $rupiah = ($row->TOTAL / 6) * $premi;
                                $total_liquid += $rupiah;
                            ?>
                                <tr>
                                    <td>1.</td>
                                    <td>Penjualan Liquid</td>
                                    <td><?= $row->TOTAL; ?> (<?= $tabung; ?>)</td>
                                    <td>Rp. <?= number_format($rupiah); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="3" style="text-align:right">Total</td>
                                <td>Rp. <?= number_format($total_gas + $total_liquid); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right">Total Terima (<?= $gaji[0]->GAJI_PERSENTASE_PREMI; ?> %)</td>
                                <td>Rp. <?= number_format(($total_gas + $total_liquid) * ($gaji[0]->GAJI_PERSENTASE_PREMI / 100)); ?></td>
                            </tr>
                        </tbody>
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