<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="Buku Besar">
    <meta property="og:description" content="Rincian Buku Besar Perusahaan">
    <meta property="og:image" content="<?php echo base_url(); ?>uploads/perusahaan/BGS.png">
    <title>Buku Besar</title>

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

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <?php
                foreach ($data as $row) {
                    echo "<h3>" . $row->AKUN_NAMA . "</h3>";
                ?>
                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th><?= $this->lang->line('tanggal'); ?></th>
                                <th><?= $this->lang->line('keterangan'); ?></th>
                                <th>Sumber</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <?php
                            foreach ($row->SALDO_AWAL as $saldo_awal) {
                                $saldo_awal = $saldo_awal->DEBET - $saldo_awal->KREDIT;
                            ?>
                                <tr>
                                    <td colspan="5" style="text-align:center">Saldo Awal</td>
                                    <td><?= number_format($saldo_awal, 0, ",", ".") ?></td>
                                </tr>
                            <?php
                            }
                            $saldo = 0 + $saldo_awal;
                            $total_debet = 0;
                            $total_kredit = 0;
                            foreach ($row->SALDO_DATA as $saldo_data) {
                                $saldo += $saldo_data->BUKU_BESAR_DEBET - $saldo_data->BUKU_BESAR_KREDIT;
                                $total_debet += $saldo_data->BUKU_BESAR_DEBET;
                                $total_kredit += $saldo_data->BUKU_BESAR_KREDIT;
                            ?>
                                <tr>
                                    <td><?= $saldo_data->TANGGAL ?></td>
                                    <td><?= $saldo_data->BUKU_BESAR_KETERANGAN ?></td>
                                    <td><?= $saldo_data->BUKU_BESAR_SUMBER ?></td>
                                    <td><?= number_format($saldo_data->BUKU_BESAR_DEBET, 0, ",", ".") ?></td>
                                    <td><?= number_format($saldo_data->BUKU_BESAR_KREDIT, 0, ",", ".") ?></td>
                                    <td><?= number_format($saldo, 0, ",", ".") ?></td>
                                </tr>
                            <?php
                            } ?>
                            <tr>
                                <td colspan="3" style="text-align:center">Total</td>
                                <td><?= number_format($total_debet, 0, ",", ".") ?></td>
                                <td><?= number_format($total_kredit, 0, ",", ".") ?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                <?php
                }
                ?>

            </div>
            <!-- /.col -->
        </div>
    </div>
</body>

</html>