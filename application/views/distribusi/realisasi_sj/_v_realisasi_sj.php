<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Realisasi Surat Jalan'); ?></h1>
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
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('nama'); ?></th>
                                <th><?= $this->lang->line('Tanggal'); ?></th>
                                <th>Nomor Surat Jalan</th>
                                <th><?= $this->lang->line('Relasi'); ?></th>
                                <th><?= $this->lang->line('Supplier'); ?></th>
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
            url: "<?php echo base_url() ?>index.php/distribusi/realisasi_sj/list",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var tableContent = "";
                    var no = 1
                    console.log(data)
                    for (i = 0; i < data.length; i++) {
                        if (data[i].SURAT_JALAN.length < 1) {
                            var btn_realisasi = "<span class='float-left badge bg-danger'>Tidak ada Surat Jalan</span>"
                        } else {
                            if (data[i].SURAT_JALAN[0].SURAT_JALAN_REALISASI_STATUS != "selesai") {
                                var realisasi_id = "<?= create_id(); ?>"
                            } else {
                                var realisasi_id = data[i].SURAT_JALAN[0].REALISASI_ID
                            }
                            var btn_realisasi = "<a href='<?php base_url(); ?>realisasi_sj/form/" + data[i].MASTER_KARYAWAN_ID + "?realisasi_id=" + realisasi_id + "'>Realisasi</a>"
                        }


                        var rowspan = 0;
                        var detailLength = data[i].SURAT_JALAN.length;
                        rowspan += detailLength;
                        tableContent += "<tr><td rowspan=" + parseInt(1 + rowspan) + ">" + no++ + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + ">" + data[i].MASTER_KARYAWAN_NAMA + "<br>" + btn_realisasi + "</td></tr>";

                        var surat_jalanLength = 0;
                        for (var j = 0; j < detailLength; j++) {


                            if (data[i].SURAT_JALAN[j].RELASI == "") {
                                var relasi = "-"
                            } else {
                                var relasi = data[i].SURAT_JALAN[j].RELASI[0].MASTER_RELASI_NAMA
                            }
                            if (data[i].SURAT_JALAN[j].SUPPLIER == "") {
                                var supplier = "-"
                            } else {
                                var supplier = data[i].SURAT_JALAN[j].SUPPLIER[0].MASTER_SUPPLIER_NAMA
                            }
                            tableContent += "<tr>" +
                                "<td rowspan=" + parseInt(1 + surat_jalanLength) + ">" + data[i].SURAT_JALAN[j].TANGGAL + "</td>" +
                                "<td rowspan=" + parseInt(1 + surat_jalanLength) + ">" + data[i].SURAT_JALAN[j].SURAT_JALAN_NOMOR + "</td>" +
                                "<td rowspan=" + parseInt(1 + surat_jalanLength) + ">" + relasi + "</td>" +
                                "<td rowspan=" + parseInt(1 + surat_jalanLength) + ">" + supplier + "</td>" +
                                "</tr>";
                        }
                    }
                    $("tbody#zone_data").append(tableContent);
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }
</script>