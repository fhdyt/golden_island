<style>
    .table {
        font-size: small;
    }
</style>
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Faktur'); ?></h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    <div class="row mb-2">

                        <div class="col-md-4">
                            <input type="date" class="form-control tanggal_dari" name="tanggal_dari" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                            <small class="text-muted">Tanggal Dari.</small>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" class="form-control tanggal_sampai" name="tanggal_sampai" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-success filter_tanggal"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <small class="text-muted">Tanggal Sampai.</small>
                        </div>
                    </div>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('tanggal'); ?></th>
                                <th>Nomor Faktur</th>
                                <th>Nomor Pemesanan</th>
                                <th>Nomor Pengiriman</th>
                                <th>Jenis Pembelian</th>
                                <th>Pembelian</th>
                                <th><?= $this->lang->line('supplier'); ?></th>
                                <th>Total</th>
                                <th>Bayar</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- /.card-body -->
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(function() {
        $('a.menu-btn').click()
        pi_list();
    });

    $('.filter_tanggal').on("click", function() {
        memuat()
        pi_list()
    });

    function pi_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/pembelian/pi/list",
            async: false,
            dataType: 'json',
            data: {
                tanggal_dari: $('.tanggal_dari').val(),
                tanggal_sampai: $('.tanggal_sampai').val(),
            },
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        if (data[i].PEMBELIAN_STATUS == "close") {
                            var status = "<span class='float-left badge bg-danger'>Close</span>"
                        } else {
                            var status = "<span class='float-left badge bg-success'>Open</span>"
                        }
                        if (data[i].TRANSAKSI.length == 0) {
                            var total = "0"
                            var bayar = "0"
                        } else {
                            var total = number_format(parseInt(data[i].TRANSAKSI[0].PEMBELIAN_TRANSAKSI_TOTAL) + parseInt(data[i].TRANSAKSI[0].PEMBELIAN_TRANSAKSI_PAJAK_RUPIAH))
                            var bayar = number_format(data[i].TRANSAKSI[0].PEMBELIAN_TRANSAKSI_BAYAR)
                        }
                        if (data[i].PO.length === 0) {
                            var po = "Tidak Ada Pemesanan"
                        } else {
                            var po = "<a target=_blank href='<?= base_url(); ?>pembelian/po/form_po/" + data[i].PO[0].PO_ID + "/" + data[i].PEMBELIAN_ID + "'>" + data[i].PO[0].PEMBELIAN_NOMOR + "</a>"
                        }
                        if (data[i].PD.length === 0) {
                            var pd = "Tidak Ada Pengiriman"
                        } else {
                            var pd = "<a target=_blank href='<?= base_url(); ?>pembelian/pd/form_pd/" + data[i].PD[0].PD_ID + "/" + data[i].PEMBELIAN_ID + "'>" + data[i].PD[0].PEMBELIAN_NOMOR + "</a>"
                        }

                        var barang = ""
                        if (data[i].BARANG.length === 0) {
                            barang += "-"
                        } else {
                            for (j = 0; j < data[i].BARANG.length; j++) {
                                barang += "" + data[i].BARANG[j].MASTER_BARANG_NAMA + " - " + data[i].BARANG[j].PEMBELIAN_BARANG_QUANTITY + "<br>"
                            }
                        }
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].PEMBELIAN_NOMOR + "<br>" + status + "</td>" +
                            "<td>" + po + "</td>" +
                            "<td>" + pd + "</td>" +
                            "<td>" + data[i].PEMBELIAN_BARANG + "</td>" +
                            "<td>" + barang +
                            "<td>" + data[i].SUPPLIER[0].MASTER_SUPPLIER_NAMA + "<br><small class='text-muted'>" + data[i].SUPPLIER[0].MASTER_SUPPLIER_HP + "</small></td>" +
                            "<td>" + bayar + "</td>" +
                            "<td>" + total + "</td>" +
                            "<td><a class='btn btn-primary btn-sm ' href='<?= base_url(); ?>pembelian/pi/form_pi/" + data[i].PI_ID + "/" + data[i].PEMBELIAN_ID + "'>Lihat</a> " +
                            "</td>" +
                            "</tr>");
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }
</script>