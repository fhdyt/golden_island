<?php
error_reporting(0);
?>

<?php
$no_surat_jalan = explode("/", $detail[0]->SURAT_JALAN_NOMOR);
$no_ttbk = $no_surat_jalan[0] . '/TTBK/' . $no_surat_jalan[2] . '/' . $no_surat_jalan[3];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $detail[0]->SURAT_JALAN_NOMOR; ?></title>

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

            table.liquid {
                border: 2px solid black !important;
                ;
                margin-top: 20px !important;
                ;
            }

            table.table-bordered {
                border: 2px solid white !important;
                ;
                margin-top: 20px !important;
                ;
            }

            table.table-bordered>thead>tr>th {
                border: 2px solid white !important;
                ;
            }

            table.table-bordered>tbody>tr>td {
                border: 2px solid white !important;
                ;
            }

            table.table-bordered>tr>td {
                border: 2px solid white !important;
                ;
            }

        }

        /* @page {
            size: 7in 9.25in;
        } */

        @media print {
            .pagebreak {
                page-break-before: always;
            }

            /* page-break-after works, as well */
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <br>
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
                    <img alt="testing" src="<?= base_url(); ?>uploads/qr/<?= str_replace("/", "-", $detail[0]->SURAT_JALAN_NOMOR); ?>.png" height="110px" />
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
                <h3><b>Surat Jalan <?= $jenis; ?></b></h3>
                <h4>No. <?= $detail[0]->SURAT_JALAN_NOMOR; ?></h4>
            </center>
            <br>
            <br>
            <div class="row invoice-info mb-2">
                <div class="col-sm-6 invoice-col">
                </div>
                <div class="col-sm-6 invoice-col text-right">
                    <?= detail_perusahaan()[0]->PERUSAHAAN_KOTA; ?>, <?= tanggal($detail[0]->SURAT_JALAN_TANGGAL); ?>
                </div>
            </div>
            <div class="row invoice-info">
                <div class="col-sm-5 invoice-col">
                    Kepada :
                    <address>
                        <?php
                        if ($detail[0]->SURAT_JALAN_JENIS == "penjualan") { ?>
                            <strong><?= $relasi[0]->MASTER_RELASI_NAMA; ?> - <?= $relasi[0]->MASTER_RELASI_QR_ID; ?></strong><br>
                            <?= $relasi[0]->MASTER_RELASI_ALAMAT; ?><br>
                            Telp : <?= $relasi[0]->MASTER_RELASI_HP; ?><br>
                        <?php } else { ?>
                            <strong><?= $supplier[0]->MASTER_SUPPLIER_NAMA; ?></strong><br>
                            <?= $supplier[0]->MASTER_SUPPLIER_ALAMAT; ?><br>
                            Telp : <?= $supplier[0]->MASTER_SUPPLIER_HP; ?><br>
                        <?php }
                        ?>

                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col text-right">
                </div>
                <div class="col-sm-3 invoice-col text-right">
                    <table class="table table-bordered">
                        <tr>
                            <td>Nama Barang</td>
                            <td>Quantity</td>
                        </tr>
                        <?php
                        $no = 1;
                        foreach ($barang as $row) { ?>
                            <tr>
                                <td><?= $row->MASTER_BARANG_NAMA; ?></td>
                                <td><?= number_format(($row->SURAT_JALAN_BARANG_QUANTITY + $row->SURAT_JALAN_BARANG_QUANTITY_KOSONG), 0, ",", "."); ?> <?= $row->SURAT_JALAN_BARANG_SATUAN; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->

            <?php
            if ($detail[0]->SURAT_JALAN_STATUS_JENIS == "gas") {
                $numcols = 6;
                $numrows = ceil((count($barang_mp) + count($barang_mr)) / $numcols);

                echo '<table class="table table-bordered">';
                $no = 1;
                for ($r = 0; $r < $numrows; $r++) {
                    echo '<tr>';
                    for ($c = 0; $c < $numcols; $c++) {

                        $cell = $r + $c * $numrows;
                        $cell_mr = 0;
                        if ($cell >= (count($barang_mp) + count($barang_mr))) {
                            echo '<td>----------</td>';
                        } elseif ($cell < count($barang_mp)) {
                            if (count($barang_mp[$cell]->KODE_TABUNG[0]) == 0) {
                                echo '<td>' . ($cell + 1) . '.) ................. (MP)</td>';
                            } else {
                                echo '<td>' . ($cell + 1) . '.) ' . $barang_mp[$cell]->KODE_TABUNG[0]->MASTER_TABUNG_KODE . ' (MP)</td>';
                            }
                        } else if ($cell >= count($barang_mp)) {
                            echo '<td>' . ($cell + 1) . '.) ................. (MR)</td>';
                        }
                    }
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<table class="table liquid">';
                echo '<tr>';
                echo '<td>';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo '</td>';
                echo '</tr>';
                echo '</table>';
            }
            ?>
            <br>
            <div class="row invoice-info mb-4 mt-4">
                <div class="col-sm-4 invoice-col">
                    <?= $this->lang->line('keterangan'); ?>
                    <address>
                        <?php echo nl2br($detail[0]->SURAT_JALAN_KETERANGAN); ?>
                    </address>
                </div>
                <div class="col-sm-8 invoice-col text-right">
                    <?php
                    if ($detail[0]->SURAT_JALAN_JAMINAN == "Yes") { ?>
                        <b>Jaminan :</b> Rp. ..........................................................
                        <br>
                        <br>
                    <?php } ?>
                    <b>Total :</b> Rp. ..........................................................
                </div>
            </div>
            <br>
            <div class="row invoice-info">
                <div class="col-4 text-center">
                    <p>Diterima oleh :</p>
                    <br>
                    <br>
                    <br>
                    <address>
                        <b>( ............................. )</b><br>
                        <?= $relasi[0]->MASTER_RELASI_NAMA; ?>
                    </address>
                </div>
                <div class="col-4 text-center">
                    <p>Dibawa Oleh :</p>
                    <br>
                    <br>
                    <br>
                    <address>
                        <?php
                        if (empty($driver)) {
                            $nama_driver = "( ............................. )";
                            $perusahaan = "";
                        } else {
                            $nama_driver = $driver[0]->MASTER_KARYAWAN_NAMA;
                            $perusahaan = detail_perusahaan()[0]->PERUSAHAAN_NAMA;
                        }
                        ?>
                        <b><?= $nama_driver; ?></b><br>
                        <?= $perusahaan; ?>
                    </address>
                </div>
                <div class="col-4 text-center">
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
            <div class="row invoice-info mt-5">
                <div class="col-12 text-center">
                    <p>Claim hanya dapat dilayani dalam waktu 1x24 Jam sejak barang diterima.</p>
                    <p>Nomor Rekening : <?= detail_perusahaan()[0]->PERUSAHAAN_BANK; ?></p>
                </div>
            </div>


        </section>

        <?php
        if (empty($driver)) {
        } else {
        ?>
            <div class="pagebreak"> </div>
            <br>
            <section class="invoice">
                <!-- title row -->
                <center>
                    <h3><b>TTBK</b></h3>
                    <h4>No. <?= $no_ttbk; ?></h4>
                </center>
                <br>
                <br>
                <div class="row invoice-info mb-2">
                    <div class="col-sm-6 invoice-col">
                    </div>
                    <div class="col-sm-6 invoice-col text-right">
                        <?= detail_perusahaan()[0]->PERUSAHAAN_KOTA; ?>, <?= tanggal($detail[0]->SURAT_JALAN_TANGGAL); ?>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-7 invoice-col">

                    </div>
                    <div class="col-sm-5 invoice-col text-right">
                        <table class="table table-bordered">
                            <tr>
                                <td style="text-align:center"><b>Terima Tabung Kembali</b></td>
                                <td style="text-align:center">MP</td>
                                <td style="text-align:center">MR</td>
                            </tr>
                            <tr>
                                <?php
                                foreach ($barang as $row) { ?>
                            <tr>
                                <td style="text-align:center ;vertical-align: middle;"><?= $row->MASTER_BARANG_NAMA; ?></td>
                                <td style="text-align:center ;vertical-align: middle;">.....</td>
                                <td style="text-align:center ;vertical-align: middle;">.....</td>
                            </tr>
                        <?php
                                }
                        ?>

                        <tr>
                            <td style="text-align:center ;vertical-align: middle;">.....</td>
                            <td style="text-align:center ;vertical-align: middle;">.....</td>
                            <td style="text-align:center ;vertical-align: middle;">.....</td>
                        </tr>
                        </table>

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->

                <?php
                $data = range(1, 42);

                $numcols = 6;

                $numrows = ceil(count($data) / $numcols);

                echo '<table class="table table-bordered table-ttbk nopadding">';

                for ($r = 0; $r < $numrows; $r++) {
                    echo '<tr>';
                    for ($c = 0; $c < $numcols; $c++) {
                        $cell = isset($data[$r + $c * $numrows]) ? $data[$r + $c * $numrows] : ' ';
                        echo '<td>', $cell, '.) ................. </td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
                ?>
                <div class="row invoice-info mb-4">
                    <div class="col-sm-4 invoice-col">
                    </div>
                    <div class="col-sm-3 invoice-col">
                    </div>
                    <div class="col-sm-5 invoice-col">
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-4 text-center">
                        <p>Diketahui oleh :</p>
                        <br>
                        <br>
                        <br>
                        <address>
                            <b>( ............................. )</b><br>
                            <?= $relasi[0]->MASTER_RELASI_NAMA; ?>
                        </address>
                    </div>
                    <div class="col-4 text-center">
                        <p>Diterima Oleh :</p>
                        <br>
                        <br>
                        <br>
                        <address>
                            <?php
                            if (empty($driver)) {
                                $nama_driver = "( ............................. )";
                                $perusahaan = "";
                            } else {
                                $nama_driver = $driver[0]->MASTER_KARYAWAN_NAMA;
                                $perusahaan = detail_perusahaan()[0]->PERUSAHAAN_NAMA;
                            }
                            ?>
                            <b><?= $nama_driver; ?></b><br>
                            <?= $perusahaan; ?>
                        </address>
                    </div>
                    <div class="col-4 text-center">
                        <p>Diperiksa oleh :</p>
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
        <?php } ?>
        <div class="pagebreak"> </div>
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>