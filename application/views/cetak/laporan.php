<!DOCTYPE html>
<html lang="en">
<style>
    .table-small {
        font-size: small;
    }
</style>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="Laporan <?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?>">
    <meta property="og:description" content=" Tanggal <?= tanggal($_GET['dari']); ?> - <?= tanggal($_GET['sampai']); ?>">
    <meta property="og:image" content="<?php echo base_url(); ?>uploads/perusahaan/<?= detail_perusahaan()[0]->PERUSAHAAN_KODE; ?>.png">
    <title>Laporan <?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?></title>

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
            <br>
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
                <h3><b>Laporan</b></h3>
            </center>
            <br>
            <br>

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <h4><b>Penjualan</b></h4>
                    <table class="table table-bordered table-small">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;">No.</th>
                                <th style="text-align: center; vertical-align: middle;">Nomor Surat Jalan</th>
                                <th style="text-align: center; vertical-align: middle;">Jenis Penjualan</th>
                                <th style="text-align: center; vertical-align: middle;">Nama Relasi</th>
                                <th style="text-align: center; vertical-align: middle;">Jenis Barang</th>
                                <th style="text-align: center; vertical-align: middle;">Qty</th>
                                <th style="text-align: center; vertical-align: middle;">Harga</th>
                                <th style="text-align: center; vertical-align: middle;">Total</th>
                                <th style="text-align: center; vertical-align: middle;">Tunai</th>
                                <th style="text-align: center; vertical-align: middle;">Piutang</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $tableContent = "";
                            $no = 1;
                            $total_seluruh_penjualan = 0;
                            $total_terbayar = 0;
                            $total_piutang = 0;
                            for ($j = 0; $j < count($penjualan); $j++) {
                                $rowspan = 0;
                                $detailLength = count($penjualan[$j]->BARANG);
                                $rowspan += $detailLength;
                                if (count($penjualan[$j]->TERBAYAR) == 0) {
                                    $terbayar = 0;
                                    $piutang = $penjualan[$j]->TOTAL;
                                } else {
                                    $grandtotal = $penjualan[$j]->TERBAYAR[0]->FAKTUR_TRANSAKSI_GRAND_TOTAL;
                                    $selisih = ($penjualan[$j]->TERBAYAR[0]->PEMBELIAN_TRANSAKSI_BAYAR - $penjualan[$j]->TOTAL);
                                    $terbayar = ($penjualan[$j]->TERBAYAR[0]->PEMBELIAN_TRANSAKSI_BAYAR - $selisih);
                                    $piutang = ($penjualan[$j]->TOTAL - $terbayar - $penjualan[$j]->TERBAYAR[0]->FAKTUR_TRANSAKSI_POTONGAN);
                                    if ($piutang < 0) {
                                        $piutang = 0;
                                    } else {
                                        $piutang = $piutang;
                                    }
                                }

                                // if (count($penjualan[$j]->AKUN) === 0) {
                                //     $akun = "-";
                                // } else {
                                //     $akun = $penjualan[$j]->AKUN[0]->AKUN_NAMA;
                                // }

                                $total_terbayar += $terbayar;
                                $total_piutang += $piutang;

                                // if ($penjualan[$j]->SURAT_JALAN_REALISASI_STATUS != "selesai") {
                                //     $riwayat_status = "<small class='text-danger'>Belum Realisasi</small>";
                                // } else {
                                //     $riwayat_status = "<small class='text-success'>Telah Terealisasi</small>";
                                // }

                                // if ($penjualan[$j]->SURAT_JALAN_REALISASI_TTBK_STATUS != "selesai") {
                                //     $riwayat_status_ttbk = "<small class='text-danger'>TTBK Belum Realisasi</small>";
                                // } else {
                                //     $riwayat_status_ttbk = "<small class='text-success'>TTBK Telah terealisasi</small>";
                                // }


                                $tableContent .= "<tr>";
                                $tableContent .= "<td rowspan=" . (1 + $rowspan) . " style='text-align:center; vertical-align:middle'>" . $no++ . "</td>";
                                $tableContent .= "<td rowspan=" . (1 + $rowspan) . " style='text-align:center; vertical-align:middle'><b>" . $penjualan[$j]->SURAT_JALAN_NOMOR . "</b><br>" . $penjualan[$j]->TANGGAL . " (" . $penjualan[$j]->JAM . ")</td>";
                                $tableContent .= "<td rowspan=" . (1 + $rowspan) . " style='text-align:center; vertical-align:middle'>" . strtoupper($penjualan[$j]->SURAT_JALAN_STATUS_JENIS)  . "</td>";
                                $tableContent .= "<td rowspan=" . (1 + $rowspan) . " style='text-align:center; vertical-align:middle'>" . $penjualan[$j]->RELASI[0]->MASTER_RELASI_NAMA . "</td>";
                                $tableContent .= "<td colspan='4'></td>";
                                $tableContent .= "<td rowspan=" . (1 + $rowspan) . " style='text-align:right; vertical-align:middle'>" . number_format($terbayar) . "</td>";
                                $tableContent .= "<td rowspan=" . (1 + $rowspan) . " style='text-align:right; vertical-align:middle'>" . number_format($piutang) . "</td>";
                                $tableContent .= "</tr>";

                                for ($z = 0; $z < count($penjualan[$j]->BARANG); $z++) {
                                    if ($penjualan[$j]->SURAT_JALAN_STATUS == "open") {
                                        $quantity = ($penjualan[$j]->BARANG[$z]->SURAT_JALAN_BARANG_QUANTITY) - ($penjualan[$j]->BARANG[$z]->SURAT_JALAN_BARANG_QUANTITY_KLAIM);
                                        if (count($penjualan[$j]->BARANG[$z]->HARGA_BARANG) == 0) {
                                            $harga = $penjualan[$j]->BARANG[$z]->MASTER_BARANG_HARGA_SATUAN;
                                        } else {
                                            $harga = $penjualan[$j]->BARANG[$z]->HARGA_BARANG[0]->MASTER_HARGA_HARGA;
                                        }

                                        $terbayar = 0;
                                    } else if ($penjualan[$j]->SURAT_JALAN_STATUS == "close") {
                                        $quantity = $penjualan[$j]->BARANG[$z]->FAKTUR_BARANG_QUANTITY;
                                        $harga = $penjualan[$j]->BARANG[$z]->FAKTUR_BARANG_HARGA;
                                        $terbayar = 0;
                                    } else {
                                        $quantity = 0;
                                        $harga = 0;
                                    }

                                    $total_harga = $quantity * $harga;
                                    $tableContent .= "<tr>";
                                    $tableContent .= "<td>" . $penjualan[$j]->BARANG[$z]->NAMA_BARANG[0]->MASTER_BARANG_NAMA . "</td>";
                                    $tableContent .= "<td style='text-align:right'>" . number_format($quantity) . "</td>";
                                    $tableContent .= "<td style='text-align:right'>" . number_format($harga) . "</td>";
                                    $tableContent .= "<td style='text-align:right'>" . number_format($total_harga) . "</td>";
                                    $tableContent .= "</tr>";
                                }
                            }
                            $tableContent .= "<tr><td colspan='8' align='right'><b>Total</b></td><td align='right'>" . number_format($total_terbayar) . "</td><td align='right'>" . number_format($total_piutang) . "</td></tr>";
                            echo $tableContent;
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- Table row -->
            <div class="row">
                <div class="col-6 table-responsive">
                    <h4><b>Penjualan Barang</b></h4>
                    <table class="table table-bordered table-small">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Barang</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $tableContent = "";
                            $no = 1;
                            $total_barang = 0;
                            for ($j = 0; $j < count($barang); $j++) {
                                $total_barang += $barang[$j]->TOTAL;
                                $tableContent .= "<tr>";
                                $tableContent .= "<td>" . $no++ . "</td>";
                                $tableContent .= "<td>" . $barang[$j]->MASTER_BARANG_NAMA . "</td>";
                                $tableContent .= "<td>" . $barang[$j]->TOTAL . "</td>";
                                $tableContent .= "</tr>";
                            }
                            $tableContent .= "<tr><td colspan='2' align='right'><b>Total</b></td><td align='left'>" . number_format($total_barang) . "</td></tr>";
                            echo $tableContent;
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-6 table-responsive">
                    <h4><b>Produksi</b></h4>
                    <table class="table table-bordered table-small">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Produksi</th>
                                <th>Tanggal</th>
                                <th>Level Awal</th>
                                <th>Level Akhir</th>
                                <th>Jenis Barang</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $tableContent = "";
                            $no = 1;
                            $total_produksi = 0;
                            for ($j = 0; $j < count($produksi); $j++) {
                                $rowspan = 0;
                                $detailLength = count($produksi[$j]->BARANG);
                                $rowspan += $detailLength;

                                $tableContent .= "<tr>";
                                $tableContent .= "<td style='text-align:center; vertical-align:middle' rowspan='" . (1 + $rowspan) . "'>" . $no++ . "</td>";
                                $tableContent .= "<td style='text-align:center; vertical-align:middle' rowspan='" . (1 + $rowspan) . "'>" . ($produksi[$j]->PRODUKSI_NOMOR) . "</td>";
                                $tableContent .= "<td style='text-align:center; vertical-align:middle' rowspan='" . (1 + $rowspan) . "'>" . tanggal($produksi[$j]->PRODUKSI_TANGGAL) . "</td>";
                                $tableContent .= "<td style='text-align:center; vertical-align:middle' rowspan='" . (1 + $rowspan) . "'>" . ($produksi[$j]->PRODUKSI_LEVEL_AWAL) . "</td>";
                                $tableContent .= "<td style='text-align:center; vertical-align:middle' rowspan='" . (1 + $rowspan) . "'>" . ($produksi[$j]->PRODUKSI_LEVEL_AKHIR) . "</td>";
                                $tableContent .= "</tr>";
                                for ($z = 0; $z < count($produksi[$j]->BARANG); $z++) {
                                    $total_produksi += $produksi[$j]->BARANG[$z]->PRODUKSI_BARANG_TOTAL;
                                    $tableContent .= "<tr>";
                                    $tableContent .= "<td>" . $produksi[$j]->BARANG[$z]->MASTER_BARANG_NAMA . "</td>";
                                    $tableContent .= "<td align='right'>" . $produksi[$j]->BARANG[$z]->PRODUKSI_BARANG_TOTAL . "</td>";
                                    $tableContent .= "</tr>";
                                }
                            }
                            $tableContent .= "<tr><td colspan='6' align='right'><b>Total</b></td><td align='right'>" . number_format($total_produksi) . "</td></tr>";
                            echo $tableContent;
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <hr>
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        // window.addEventListener("load", window.print());
    </script>
</body>

</html>