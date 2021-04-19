<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Pengiriman</h1>
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
                    <a href="<?= base_url(); ?>pembelian/pd/form_pd" class="btn btn-secondary mb-2 btn-form">Tambah Pengiriman</a>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Nomor Pengiriman</th>
                                <th>Jenis Pembelian</th>
                                <th>Supplier</th>
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

    function po_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/pembelian/pd/list",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'>Tidak ada data</td>")
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
                            "<td><a class='btn btn-primary btn-sm ' href='<?= base_url(); ?>pembelian/pd/form_pd/" + data[i].PD_ID + "/" + data[i].PEMBELIAN_ID + "'>Lihat</a> " +
                            "<a class='btn btn-success btn-sm' href='<?= base_url(); ?>pdf/cetak_pd/" + data[i].PD_ID + "/" + data[i].PEMBELIAN_ID + "'> <i class='right fas fa-print'></i> Cetak</a></td>" +
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