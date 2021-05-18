<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $detail[0]->PEMBELIAN_NOMOR; ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <style>
        body {
            font-family: "Source Sans Pro", sans-serif;
            color: #444444;
        }

        .table-noborder {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            margin-bottom: 50px;
        }

        .table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        .table th {
            text-align: left;
            padding: 10px;
            background-color: #343A40;
            color: white;
        }

        .table td {
            text-align: left;
            padding: 8px;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2
        }
    </style>

<body>
    <table>
        <tr>
            <td rowspan="3"><img src="<?php echo base_url(); ?>uploads/perusahaan/<?= detail_perusahaan()[0]->PERUSAHAAN_KODE; ?>.png" height="90px" alt=""></td>
            <td>
                <h3><?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?></h3>
            </td>
            <td rowspan="3"></td>
        </tr>
        <tr>
            <td><?= detail_perusahaan()[0]->PERUSAHAAN_ALAMAT; ?></td>
        </tr>
        <tr>
            <td><?= detail_perusahaan()[0]->PERUSAHAAN_TELP; ?></td>
        </tr>
    </table>
    <hr>
    <p style="font-size:24px; font-weight:bold;">Purchase Order <br><small> <?= $detail[0]->PEMBELIAN_NOMOR; ?></small></p>
    <table class="table-noborder" style="margin-top:50px">
        <tr>
            <td width="50%">
                <p style="margin-bottom: 60px; font-weight: bold;">Kepada:</p>
                <br>
                <p style="font-size: 18px; font-weight:bold;"><?= $supplier[0]->MASTER_SUPPLIER_NAMA; ?></p>
                <p style="font-size: 14px; font-color:#757575;"><?= $supplier[0]->MASTER_SUPPLIER_ALAMAT; ?></p>
                <p style="font-size: 14px; font-color:#757575;"><?= $supplier[0]->MASTER_SUPPLIER_HP; ?></p>
            </td>
            <td width="50%" align="right">

                <p style="font-size: 16px;"><?= detail_perusahaan()[0]->PERUSAHAAN_KOTA; ?> ,<?= tanggal($detail[0]->PEMBELIAN_TANGGAL); ?></p>
            </td>
        </tr>
    </table>
    <table class="table">
        <tr>
            <th>No.</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Quantity</th>
            <th>Satuan</th>
            <th>Total</th>
        </tr>
        <?php
        $no = 1;
        foreach ($barang as $row) { ?>
            <tr>
                <td><?= $no++; ?>.</td>
                <td><?= $row->MASTER_BARANG_NAMA; ?></td>
                <td><?= number_format($row->PEMBELIAN_BARANG_HARGA, 0, ",", "."); ?></td>
                <td><?= number_format($row->PEMBELIAN_BARANG_QUANTITY, 0, ",", "."); ?></td>
                <td><?= $row->PEMBELIAN_BARANG_SATUAN; ?></td>
                <td align="right"><?= number_format($row->PEMBELIAN_BARANG_TOTAL, 0, ",", "."); ?></td>
            </tr>
        <?php
        }
        ?>

        <tr>
            <td colspan="10" align="center">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="5" align="right"><b>Total</b></td>
            <td align="right"><?= number_format($transaksi[0]->PEMBELIAN_TRANSAKSI_TOTAL, 0, ",", "."); ?></td>
        </tr>
        <tr>
            <td colspan="5" align="right"><b>Potongan</b></td>
            <td align="right"><?= number_format($transaksi[0]->PEMBELIAN_TRANSAKSI_POTONGAN, 0, ",", "."); ?></td>
        </tr>
        <tr>
            <td colspan="5" align="right"><b>Pajak (<?= $transaksi[0]->PEMBELIAN_TRANSAKSI_PAJAK; ?>%)</b></td>
            <td align="right"><?= number_format($transaksi[0]->PEMBELIAN_TRANSAKSI_PAJAK_RUPIAH, 0, ",", "."); ?></td>
        </tr>
        <tr>
            <td colspan="5" align="right"><b>Bayar</b></td>
            <td align="right"><?= number_format($transaksi[0]->PEMBELIAN_TRANSAKSI_UANG_MUKA, 0, ",", "."); ?></td>
        </tr>
        <tr>
            <td colspan="5" align="right"><b>Sisa Bayar</b></td>
            <td align="right">
                <?php
                $total = $transaksi[0]->PEMBELIAN_TRANSAKSI_TOTAL - $transaksi[0]->PEMBELIAN_TRANSAKSI_POTONGAN + $transaksi[0]->PEMBELIAN_TRANSAKSI_PAJAK_RUPIAH;
                echo number_format($total - $transaksi[0]->PEMBELIAN_TRANSAKSI_UANG_MUKA, 0, ",", ".");
                ?>
            </td>
        </tr>
    </table>

    <table class="table-noborder" style="margin-top: 20px;">
        <tr>
            <td width="50%">
                <p style="margin-bottom: 60px;"><?= $this->lang->line('keterangan'); ?>:</p>
                <br>
                <p><?php echo nl2br($detail[0]->PEMBELIAN_KETERANGAN); ?></p>
            <td width="50%" align="center">
                <p>Ditanda tangani oleh :</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <p><b><?= $oleh[0]->USER_NAMA; ?></b></p>
                <p><?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?></p>
            </td>
        </tr>
    </table>
    <div id="qrcode" style="margin-top:15px;"></div>
</body>


</html>