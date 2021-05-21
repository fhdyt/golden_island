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
                    <a href="<?= base_url(); ?>penjualan/faktur/form" class="btn btn-secondary mb-2 btn-form">Tambah Faktur</a>
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
            url: "<?php echo base_url() ?>index.php/penjualan/faktur/list",
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
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].FAKTUR_NOMOR + "</td>" +
                            "<td>" + data[i].RELASI[0].MASTER_RELASI_NAMA + "</td>" +
                            "<td><a class='btn btn-primary btn-sm mb-2 ' href='<?= base_url(); ?>penjualan/faktur/form/" + data[i].FAKTUR_ID + "?jenis_sj=penjualan'>Lihat</a> " +
                            "<a target='_blank' class='btn btn-success btn-sm mb-2' onclick='cetak(\"" + data[i].FAKTUR_ID + "\")'> <i class='right fas fa-print'></i> Cetak Faktur</a> " +
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

    function cetak(id) {
        window.open('<?= base_url(); ?>cetak/faktur/' + id + '');
    }
</script>