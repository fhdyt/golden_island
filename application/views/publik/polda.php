<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="<?= tanggal($this->uri->segment('3')); ?>">
    <meta property="og:description" content="Data Penyaluran Tabung Oksigen Wilayah Prov. Bengkulu">
    <meta property="og:image" content="<?php echo base_url(); ?>uploads/perusahaan/BGS.png">
    <title>Data Penyaluran Tabung Oksigen Wilayah Prov. Bengkulu</title>

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
        <!-- title row -->
        <div class="row">
            <!-- <div class="col-sm-2 text-right">
                <img src="<?php echo base_url(); ?>uploads/perusahaan/BGS.png" height="70px" alt="">
            </div> -->
            <div class="col-sm-12 invoice-col">
                <address>
                    <h4><b>PT. BUMI GASINDO SUMATERA</b></h4>
                    <small>Jalan Padang Makmur 1, RT 8, RW 6 Kec. Selebar, Kel Bentungan, Bengkulu<br>
                        Telp : +628 22839 18834, +628 12727 57908</small>
                </address>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <hr>
        <center>
            <h5><b>Data Penyaluran Tabung Oksigen Wilayah Prov. Bengkulu</b></h5>
            <p>Tanggal : <?= tanggal($this->uri->segment('3')); ?></p>
        </center>
        <br>
        <br>


        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table id="example2" class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle;">No.</th>
                            <th>Nama</th>
                            <th>Jenis Tabung</th>
                            <th>Permintaan</th>
                            <th>Disalurkan</th>
                            <th>Penyuplay</th>
                        </tr>
                    </thead>
                    <tbody id="zone_data">
                        <?php
                        $no = 1;
                        $tableContent = "";
                        $total_tabung = 0;
                        $total_tabung = 0;
                        $total = 0;
                        for ($x = 0; $x < count($surat_jalan); $x++) {
                            $rowspan = 0;
                            $detailLength = count($surat_jalan[$x]->BARANG);
                            $rowspan += $detailLength;
                            $tableContent .= "<tr><td style='vertical-align:middle' rowspan=" . (1 + $rowspan) . ">" . $no++ . "</td><td style='vertical-align:middle' rowspan=" . (1 + $rowspan) . ">" . $surat_jalan[$x]->MASTER_RELASI_NAMA . "<br>" . jam($surat_jalan[$x]->WAKTU) . "</td></tr>";

                            $baranglenght = 0;
                            for ($j = 0; $j < $detailLength; $j++) {
                                if ($surat_jalan[$x]->SURAT_JALAN_STATUS == "open") {
                                    $quantity = $surat_jalan[$x]->BARANG[$j]->SURAT_JALAN_BARANG_QUANTITY;
                                } else {
                                    $quantity = $surat_jalan[$x]->BARANG[$j]->FAKTUR_BARANG_QUANTITY;
                                }
                                $total += $quantity;

                                $tableContent .= "<tr><td>" . $surat_jalan[$x]->BARANG[$j]->NAMA_BARANG[0]->MASTER_BARANG_NAMA . "</td><td align='right'>" . $quantity . "</td><td align='right'>" . $quantity . "</td><td>PT. BUMI GASINDO SUMATERA</td></tr>";
                            }
                        ?>
                        <?php
                        }
                        echo $tableContent;
                        ?>
                    </tbody>
                    <tbody id="zone_data_total">
                        <tr>
                            <td colspan="4" align="right"><b>Total</b></td>
                            <td align="right"><?= $total; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
    </div>
</body>

</html>