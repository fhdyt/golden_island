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
                    <h3><?= date("Y-m-d h:i:sa"); ?></h3>
                    <table border="2">
                        <tr>
                            <th>No.</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Saldo</th>
                        </tr>
                        <?php
                        $no = 1;
                        $total_mp = 0;
                        $total_mr = 0;

                        $total = 0;
                        foreach ($barang as $row) {
                            if (count($row->SALDO_AWAL_MP) == 0) {
                                $saldo_awal_mp = 0;
                            } else {
                                $saldo_awal_mp = $row->SALDO_AWAL_MP[0]->JURNAL_TABUNG_KEMBALI;
                            }
                            if (count($row->SALDO_AWAL_MR) == 0) {
                                $saldo_awal_mr = 0;
                            } else {
                                $saldo_awal_mr = $row->SALDO_AWAL_MR[0]->JURNAL_TABUNG_KEMBALI;
                            }

                            if ($row->SALDO_MP[0]->KIRIM == null) {
                                $saldo_kirim_mp = 0;
                            } else {
                                $saldo_kirim_mp = $row->SALDO_MP[0]->KIRIM;
                            }
                            if ($row->SALDO_MP[0]->KEMBALI == null) {
                                $saldo_kembali_mp = 0;
                            } else {
                                $saldo_kembali_mp = $row->SALDO_MP[0]->KEMBALI;
                            }


                            if ($row->SALDO_MR[0]->KIRIM == null) {
                                $saldo_kirim_mr = 0;
                            } else {
                                $saldo_kirim_mr = $row->SALDO_MR[0]->KIRIM;
                            }
                            if ($row->SALDO_MR[0]->KEMBALI == null) {
                                $saldo_kembali_mr = 0;
                            } else {
                                $saldo_kembali_mr = $row->SALDO_MR[0]->KEMBALI;
                            }
                            $total_mp = $saldo_awal_mp + ($saldo_kembali_mp - $saldo_kirim_mp);
                            $total_mr = $saldo_awal_mr + ($saldo_kembali_mr - $saldo_kirim_mr);
                            $total += $total_mp + $total_mr;

                            echo "<tr>";
                            echo "<td rowspan='3'>" . $no++ . "</td>";
                            echo "<td rowspan='3'>" . $row->MASTER_BARANG_NAMA . "</td>";
                            echo "</tr>";
                            echo "<tr><td>MP</td><td>" . number_format($total_mp) . "</td>";
                            echo "<tr><td>MR</td><td>" . number_format($total_mr) . "</td></tr>";
                        }
                        ?>
                        <tr>
                            <td style="text-align:right" colspan="3">Total</td>
                            <td><?= $total; ?></td>
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