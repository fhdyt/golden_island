<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Pembelian</h1>
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
                    <a href="<?= base_url(); ?>pembelian/pembelian/form_pembelian" class="btn btn-secondary mb-2 btn-form">Tambah Pembelian</a>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Nomor Surat</th>
                                <th>Jenis Pembelian</th>
                                <th>Supplier</th>
                                <th>Keterangan</th>
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
        pembelian_list();
    });

    function pembelian_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/pembelian/pembelian/list",
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
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].PEMBELIAN_NOMOR_SURAT + "</td>" +
                            "<td>" + data[i].PEMBELIAN_JENIS + "</td>" +
                            "<td>" + data[i].SUPPLIER[0].MASTER_SUPPLIER_NAMA + "<br><small class='text-muted'>" + data[i].SUPPLIER[0].MASTER_SUPPLIER_HP + "</small></td>" +
                            "<td>" + data[i].PEMBELIAN_KETERANGAN + "</td>" +
                            "<td><a class='btn btn-primary btn-sm' href='<?= base_url(); ?>pembelian/pembelian/form_pembelian/" + data[i].PEMBELIAN_ID + "'>Lihat</a></td>" +
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