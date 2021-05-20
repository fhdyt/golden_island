<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $detail[0]->FAKTUR_NOMOR; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/dist/css/adminlte.min.css">
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
                    <!-- <img alt="testing" src="<?= base_url(); ?>uploads/qr/<?= str_replace("/", "-", $detail[0]->SURAT_JALAN_NOMOR); ?>.png" height="90px" /> -->
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <hr>
            <center>
                <h3><b>Faktur Penjualan</b></h3>
                <h4>No. <?= $detail[0]->FAKTUR_NOMOR; ?></h4>
            </center>
            <br>
            <br>
            <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                    Kepada :
                    <hr>
                    <address>
                        <strong><?= $relasi[0]->MASTER_RELASI_NAMA; ?></strong><br>
                        <?= $relasi[0]->MASTER_RELASI_ALAMAT; ?><br>
                        Telp : <?= $relasi[0]->MASTER_RELASI_HP; ?><br>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col text-right">
                    <?= detail_perusahaan()[0]->PERUSAHAAN_KOTA; ?> ,<?= tanggal($detail[0]->FAKTUR_TANGGAL); ?>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table">
                        <tr>
                        <tr>
                            <th>No.</th>
                            <th>Nama Barang</th>
                            <th>Quantity</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                        </tr>
                        <?php
                        $no = 1;
                        $total_rp = 0;
                        foreach ($barang as $row) {
                            $total = $row->SUM * $row->FAKTUR_BARANG_HARGA;
                            $total_rp += $total;
                        ?>
                            <tr>
                                <td><?= $no++; ?>.</td>
                                <td><?= $row->MASTER_BARANG_NAMA; ?></td>
                                <td><?= $row->SUM; ?></td>
                                <td><?= number_format($row->FAKTUR_BARANG_HARGA, 0, ",", "."); ?></td>
                                <td><?= number_format($total, 0, ",", "."); ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="4" align="right">Total</td>
                            <td><?= number_format($total_rp, 0, ",", "."); ?></td>
                        </tr>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <hr>
            <div class="row invoice-info">
                <div class="col-sm-12 invoice-col">
                    Nomor Surat Jalan
                    <address>
                        <?php
                        foreach ($surat_jalan as $row) {
                            echo $row->SURAT_JALAN_NOMOR;
                            echo "<br>";
                        }
                        ?>
                    </address>
                </div>
            </div>
            <div class="row invoice-info">
                <div class="col-sm-12 invoice-col">
                    <?= $this->lang->line('keterangan'); ?>
                    <address>
                        <?php echo nl2br($detail[0]->FAKTUR_KETERANGAN); ?>
                    </address>
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