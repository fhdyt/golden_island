<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Surat Jalan Penjualan'); ?></h1>
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
                    <a href="<?= base_url(); ?>distribusi/surat_jalan/form?jenis_sj=penjualan" class="btn btn-secondary mb-2 btn-form">Tambah Pengiriman</a>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('tanggal'); ?></th>
                                <th>Nomor Surat Jalan</th>
                                <th><?= $this->lang->line('Relasi'); ?></th>
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
            url: "<?php echo base_url() ?>index.php/distribusi/surat_jalan/list?jenis_sj=penjualan",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        if (data[i].SURAT_JALAN_STATUS == "close") {
                            var status = "<span class='float-left badge bg-danger'>Close</span>"
                        } else {
                            var status = "<span class='float-left badge bg-success'>Open</span>"
                        }

                        if (data[i].REALISASI_ID == null) {
                            var riwayat_status = "<span class='float-left badge bg-danger'>Belum Teralisasi</span>"
                        } else {
                            var riwayat_status = "<span class='float-left badge bg-success'>Telah terealisasi</span>"
                        }

                        if (data[i].RELASI == "") {
                            var relasi = "-"
                        } else {
                            var relasi = data[i].RELASI[0].MASTER_RELASI_NAMA
                        }
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].SURAT_JALAN_NOMOR + "<br>" + status + "<br>" + riwayat_status + "</td>" +
                            "<td>" + relasi + "</td>" +
                            "<td><a class='btn btn-primary btn-sm ' href='<?= base_url(); ?>distribusi/surat_jalan/form/" + data[i].SURAT_JALAN_ID + "?jenis_sj=penjualan'>Lihat</a> " +
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