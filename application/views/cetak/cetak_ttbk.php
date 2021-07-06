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
    <title><?= $no_ttbk; ?></title>

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
                <h3><b>Tanda Terima Botol Kembali (TTBK)</b></h3>
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
                <div class="col-sm-5 invoice-col">
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
                        <tr>
                            <td>.....</td>
                            <td>.....</td>
                        </tr>
                        <tr>
                            <td>.....</td>
                            <td>.....</td>
                        </tr>
                        <tr>
                            <td>.....</td>
                            <td>.....</td>
                        </tr>
                    </table>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->

            <hr>
            <?php
            $data = range(1, 42);

            $numcols = 6;

            $numrows = ceil(count($data) / $numcols);

            echo '<table class="table table-bordered">';

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
                    <?= $this->lang->line('keterangan'); ?>
                    <address>
                        <?php echo nl2br($detail[0]->SURAT_JALAN_KETERANGAN); ?>
                    </address>
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
            <div class="row invoice-info mt-5">
                <div class="col-12 text-center">
                    <p>Claim hanya dapat dilayani dalam waktu 1x24 Jam sejak barang diterima.</p>
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