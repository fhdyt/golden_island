<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Pemesanan'); ?></h1>
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
                            <a href="<?= base_url(); ?>pembelian/po/form_po" class="btn btn-secondary mb-2 btn-form">Tambah Pemesanan</a>
                        </div>
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
                                <th>Nomor Pemesanan</th>
                                <th>Jenis Pembelian</th>
                                <th><?= $this->lang->line('supplier'); ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                            </tr>
                        </tbody>
                    </table>
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
        po_list();
    });

    $('.filter_tanggal').on("click", function() {
        memuat()
        po_list()
    });

    function po_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/pembelian/po/list",
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

                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].PEMBELIAN_NOMOR + "<br>" + status + "</td>" +
                            "<td>" + data[i].PEMBELIAN_BARANG + "</td>" +
                            "<td>" + data[i].SUPPLIER[0].MASTER_SUPPLIER_NAMA + "<br><small class='text-muted'>" + data[i].SUPPLIER[0].MASTER_SUPPLIER_HP + "</small></td>" +
                            "<td><a class='btn btn-primary btn-sm ' href='<?= base_url(); ?>pembelian/po/form_po/" + data[i].PO_ID + "/" + data[i].PEMBELIAN_ID + "'>Lihat</a> " +
                            "<a class='btn btn-success btn-sm' href='<?= base_url(); ?>cetak/cetak_po/" + data[i].PO_ID + "/" + data[i].PEMBELIAN_ID + "'> <i class='right fas fa-print'></i> Cetak</a></td>" +
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