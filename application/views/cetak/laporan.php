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
                <h5><?= tanggal($_GET['dari']); ?> - <?= tanggal($_GET['sampai']); ?></h5>
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
                                    $terbayar = ($penjualan[$j]->TERBAYAR[0]->PEMBELIAN_TRANSAKSI_BAYAR - $selisih) - $penjualan[$j]->TERBAYAR[0]->FAKTUR_TRANSAKSI_POTONGAN;
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
                <div class="col-3 table-responsive">
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
                <div class="col-9 table-responsive">
                    <div class="row">
                        <div class="col-md-12">
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
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <h4><b>Pembelian</b></h4>
                            <table class="table table-bordered table-small">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nomor Surat Jalan</th>
                                        <th>Tanggal</th>
                                        <th>Supllier</th>
                                        <th>Tanggal Kirim</th>
                                        <th>Total Kirim</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Total Kembali</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $tableContent = "";
                                    $no = 1;
                                    $total_kirim = 0;
                                    $total_kembali = 0;
                                    for ($j = 0; $j < count($pembelian); $j++) {
                                        $total_kirim += $pembelian[$j]->SURAT_JALAN_REALISASI_JUMLAH_MR + $pembelian[$j]->SURAT_JALAN_REALISASI_JUMLAH_MP;
                                        $total_kembali += $pembelian[$j]->SURAT_JALAN_REALISASI_TTBK_JUMLAH_MR + $pembelian[$j]->SURAT_JALAN_REALISASI_TTBK_JUMLAH_MP;
                                        $rowspan = 0;

                                        $tableContent .= "<tr>";
                                        $tableContent .= "<td style='text-align:center; vertical-align:middle'>" . $no++ . "</td>";
                                        $tableContent .= "<td style='text-align:center; vertical-align:middle'>" . ($pembelian[$j]->SURAT_JALAN_NOMOR) . "</td>";
                                        $tableContent .= "<td style='text-align:center; vertical-align:middle'>" . tanggal($pembelian[$j]->SURAT_JALAN_TANGGAL) . "</td>";
                                        $tableContent .= "<td style='text-align:center; vertical-align:middle'>" . $pembelian[$j]->SUPPLIER[0]->MASTER_SUPPLIER_NAMA . "</td>";
                                        $tableContent .= "<td style='text-align:center; vertical-align:middle'>" . tanggal($pembelian[$j]->SURAT_JALAN_REALISASI_TANGGAL) . "</td>";
                                        $tableContent .= "<td style='text-align:right; vertical-align:middle'>" . ($pembelian[$j]->SURAT_JALAN_REALISASI_JUMLAH_MR + $pembelian[$j]->SURAT_JALAN_REALISASI_JUMLAH_MP) . "</td>";
                                        $tableContent .= "<td style='text-align:center; vertical-align:middle'>" . tanggal($pembelian[$j]->SURAT_JALAN_REALISASI_TTBK_TANGGAL) . "</td>";
                                        $tableContent .= "<td style='text-align:right; vertical-align:middle'>" . ($pembelian[$j]->SURAT_JALAN_REALISASI_TTBK_JUMLAH_MR + $pembelian[$j]->SURAT_JALAN_REALISASI_TTBK_JUMLAH_MP) . "</td>";
                                        $tableContent .= "</tr>";
                                    }
                                    $tableContent .= "<tr><td colspan='5' align='right'><b>Total</b></td><td align='right'>" . number_format($total_kirim) . "</td><td></td><td align='right'>" . number_format($total_kembali) . "</td></tr>";
                                    echo $tableContent;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <h4><b>Panggung</b></h4>
                            <table class="table table-bordered table-small">
                                <tr>
                                    <th rowspan="2" style="text-align:center; vertical-align:middle">No.</th>
                                    <th rowspan="2" style="text-align:center; vertical-align:middle">Jenis</th>
                                    <th rowspan="2" style="text-align:center; vertical-align:middle">Status</th>

                                    <th colspan="2" style="text-align:center; vertical-align:middle">Panggung</th>
                                    <th rowspan="2" style="text-align:center; vertical-align:middle">Saldo</th>
                                </tr>
                                <tr>

                                    <th style="text-align:center; vertical-align:middle">Isi</th>
                                    <th style="text-align:center; vertical-align:middle">Kosong</th>
                                </tr>
                                <?php
                                $no = 1;
                                $mp_isi_out = 0;
                                $mp_kosong_out = 0;
                                $mr_isi_out = 0;
                                $mr_kosong_out = 0;

                                $mp_isi_in = 0;
                                $mp_kosong_in = 0;
                                $mr_isi_in = 0;
                                $mr_kosong_in = 0;

                                $total_seluruh = 0;

                                $total = 0;
                                foreach ($panggung as $row) {

                                    if ($row->SALDO_MP_ISI_OUT[0]->JUMLAH == null) {
                                        $mp_isi_out = 0;
                                    } else {
                                        $mp_isi_out = $row->SALDO_MP_ISI_OUT[0]->JUMLAH;
                                    }

                                    if ($row->SALDO_MP_KOSONG_OUT[0]->JUMLAH == null) {
                                        $mp_kosong_out = 0;
                                    } else {
                                        $mp_kosong_out = $row->SALDO_MP_KOSONG_OUT[0]->JUMLAH;
                                    }

                                    if ($row->SALDO_MR_ISI_OUT[0]->JUMLAH == null) {
                                        $mr_isi_out = 0;
                                    } else {
                                        $mr_isi_out = $row->SALDO_MR_ISI_OUT[0]->JUMLAH;
                                    }

                                    if ($row->SALDO_MR_KOSONG_OUT[0]->JUMLAH == null) {
                                        $mr_kosong_out = 0;
                                    } else {
                                        $mr_kosong_out = $row->SALDO_MR_KOSONG_OUT[0]->JUMLAH;
                                    }

                                    if ($row->SALDO_MP_ISI_IN[0]->JUMLAH == null) {
                                        $mp_isi_in = 0;
                                    } else {
                                        $mp_isi_in = $row->SALDO_MP_ISI_IN[0]->JUMLAH;
                                    }

                                    if ($row->SALDO_MP_KOSONG_IN[0]->JUMLAH == null) {
                                        $mp_kosong_in = 0;
                                    } else {
                                        $mp_kosong_in = $row->SALDO_MP_KOSONG_IN[0]->JUMLAH;
                                    }

                                    if ($row->SALDO_MR_ISI_IN[0]->JUMLAH == null) {
                                        $mr_isi_in = 0;
                                    } else {
                                        $mr_isi_in = $row->SALDO_MR_ISI_IN[0]->JUMLAH;
                                    }

                                    if ($row->SALDO_MR_KOSONG_IN[0]->JUMLAH == null) {
                                        $mr_kosong_in = 0;
                                    } else {
                                        $mr_kosong_in = $row->SALDO_MR_KOSONG_IN[0]->JUMLAH;
                                    }

                                    // if (count($row->SALDO_AWAL_MP) == 0) {
                                    //     $saldo_awal_mp = 0;
                                    // } else {
                                    //     $saldo_awal_mp = $row->SALDO_AWAL_MP[0]->JURNAL_TABUNG_KEMBALI;
                                    // }
                                    // if (count($row->SALDO_AWAL_MR) == 0) {
                                    //     $saldo_awal_mr = 0;
                                    // } else {
                                    //     $saldo_awal_mr = $row->SALDO_AWAL_MR[0]->JURNAL_TABUNG_KEMBALI;
                                    // }

                                    // if ($row->SALDO_MP[0]->KIRIM == null) {
                                    //     $saldo_kirim_mp = 0;
                                    // } else {
                                    //     $saldo_kirim_mp = $row->SALDO_MP[0]->KIRIM;
                                    // }
                                    // if ($row->SALDO_MP[0]->KEMBALI == null) {
                                    //     $saldo_kembali_mp = 0;
                                    // } else {
                                    //     $saldo_kembali_mp = $row->SALDO_MP[0]->KEMBALI;
                                    // }


                                    // if ($row->SALDO_MR[0]->KIRIM == null) {
                                    //     $saldo_kirim_mr = 0;
                                    // } else {
                                    //     $saldo_kirim_mr = $row->SALDO_MR[0]->KIRIM;
                                    // }
                                    // if ($row->SALDO_MR[0]->KEMBALI == null) {
                                    //     $saldo_kembali_mr = 0;
                                    // } else {
                                    //     $saldo_kembali_mr = $row->SALDO_MR[0]->KEMBALI;
                                    // }
                                    // $total_mp = $saldo_awal_mp + ($saldo_kembali_mp - $saldo_kirim_mp);
                                    // $total_mr = $saldo_awal_mr + ($saldo_kembali_mr - $saldo_kirim_mr);
                                    // $total += $total_mp + $total_mr;

                                    $total_mp_out = $mp_isi_out + $mp_kosong_out;
                                    $total_mr_out = $mr_isi_out + $mr_kosong_out;

                                    $total_mp_in = $mp_isi_in + $mp_kosong_in;
                                    $total_mr_in = $mr_isi_in + $mr_kosong_in;

                                    $panggung_mp_isi = $mp_isi_in - $mp_isi_out;
                                    $panggung_mp_kosong = $mp_kosong_in - $mp_kosong_out;

                                    $panggung_mr_isi = $mr_isi_in - $mr_isi_out;
                                    $panggung_mr_kosong = $mr_kosong_in - $mr_kosong_out;

                                    $total_mp = $panggung_mp_isi + $panggung_mp_kosong;
                                    $total_mr = $panggung_mr_isi + $panggung_mr_kosong;

                                    $total_seluruh += $total_mp + $total_mr;
                                    echo "<tr>";
                                    echo "<td rowspan='3'>" . $no++ . "</td>";
                                    echo "<td rowspan='3'>" . $row->MASTER_BARANG_NAMA . "</td>";
                                    echo "</tr>";
                                    echo "<tr><td>MP</td><td>" . $panggung_mp_isi . "</td><td>" . $panggung_mp_kosong . "</td><td>" . $total_mp . "</td></tr>";
                                    echo "<tr><td>MR</td><td>" . $panggung_mr_isi . "</td><td>" . $panggung_mr_kosong . "</td><td>" . $total_mr . "</td></tr>";
                                }
                                ?>
                                <tr>
                                    <td style="text-align:right" colspan="5">Total</td>
                                    <td><?= $total_seluruh; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

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