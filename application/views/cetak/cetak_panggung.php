<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Panggung</title>

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



            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <h3><?= date("Y-m-d G:i:s"); ?></h3>
                    <table border="2">
                        <tr>
                            <th rowspan="2" style="text-align:center; vertical-align:middle">No.</th>
                            <th rowspan="2" style="text-align:center; vertical-align:middle">Jenis</th>
                            <th rowspan="2" style="text-align:center; vertical-align:middle">Status</th>
                            <th colspan="2" style="text-align:center; vertical-align:middle">Keluar</th>
                            <th colspan="2" style="text-align:center; vertical-align:middle">Masuk</th>
                            <th colspan="2" style="text-align:center; vertical-align:middle">Panggung</th>
                            <th rowspan="2" style="text-align:center; vertical-align:middle">Saldo</th>
                        </tr>
                        <tr>
                            <th style="text-align:center; vertical-align:middle">Isi</th>
                            <th style="text-align:center; vertical-align:middle">Kosong</th>
                            <th style="text-align:center; vertical-align:middle">Isi</th>
                            <th style="text-align:center; vertical-align:middle">Kosong</th>
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
                        foreach ($barang as $row) {

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
                            echo "<tr><td>MP</td><td>" . $mp_isi_out . "<td>" . $mp_kosong_out . "</td><td>" . $mp_isi_in . "<td>" . $mp_kosong_in . "</td><td>" . $panggung_mp_isi . "</td><td>" . $panggung_mp_kosong . "</td><td>" . $total_mp . "</td></tr>";
                            echo "<tr><td>MR</td><td>" . $mr_isi_out . "<td>" . $mr_kosong_out . "</td><td>" . $mr_isi_in . "<td>" . $mr_kosong_in . "</td><td>" . $panggung_mr_isi . "</td><td>" . $panggung_mr_kosong . "</td><td>" . $total_mr . "</td></tr>";
                        }
                        ?>
                        <tr>
                            <td style="text-align:right" colspan="9">Total</td>
                            <td><?= $total_seluruh; ?></td>
                        </tr>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->




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