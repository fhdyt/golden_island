<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $relasi[0]->MASTER_RELASI_NAMA; ?></h1>
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kapasitas</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                                <td colspan="9">
                                    <center>
                                        <div class="loader"></div>
                                    </center>
                                </td>
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
        harga_relasi_list();
    });

    function harga_relasi_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/master/relasi/harga_list/<?= $relasi[0]->MASTER_RELASI_ID; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'>Tidak ada data</td>")
                } else {
                    var tableContent = "";
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        var rowspan = 0;
                        var detailLength = data[i].DETAIL.length;
                        rowspan += detailLength;
                        tableContent += "<tr><td rowspan=" + parseInt(1 + rowspan) + ">" + data[i].MASTER_JENIS_BARANG_NAMA + "</td></tr>";
                        console.log(detailLength)
                        var relasiLength = 0;
                        for (var j = 0; j < detailLength; j++) {
                            tableContent += "<tr><td rowspan=" + parseInt(1 + relasiLength) + ">" +
                                data[i].DETAIL[j].MASTER_JENIS_BARANG_DETAIL_KAPASITAS + "</td><td rowspan=" + parseInt(1 + relasiLength) + ">" +
                                data[i].DETAIL[j].MASTER_JENIS_BARANG_DETAIL_SATUAN + "</td><td></td><td><a class='btn btn-success btn-sm' onclick='detail(\"" + data[i].DETAIL[j].MASTER_JENIS_BARANG_DETAIL_ID + "\")'><i class='fas fa-tag'></i> Tambah Harga</a></td></tr>";
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