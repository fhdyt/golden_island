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
                    <table id="example2" class="table table-bordered table-striped">
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
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    // var no = 1
                    // for (i = 0; i < data.length; i++) {
                    //     $("tbody#zone_data").append("<tr class=''>" +
                    //         "<td>" + no++ + ".</td>" +
                    //         "<td>" + data[i].MASTER_KARYAWAN_NAMA + "</td>" +
                    //         "</td>" +
                    //         "</tr>");
                    // }

                    var tableContent = "";
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        var rowspan = 0;
                        var detailLength = data[i].SURAT_JALAN.length;
                        rowspan += detailLength;
                        tableContent += "<tr><td rowspan=" + parseInt(1 + rowspan) + ">" + no++ + "</td><td rowspan=" + parseInt(1 + rowspan) + ">" + data[i].MASTER_KARYAWAN_NAMA + "</td></tr>";
                        console.log(detailLength)
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
                            tableContent += "<tr><td rowspan=" + parseInt(1 + surat_jalanLength) + ">" +
                                data[i].SURAT_JALAN[j].TANGGAL + "</td>" +
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