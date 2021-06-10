<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Riwayat Tabung</h1>
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
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Relasi</th>
                                <th>Supplier</th>
                                <th>Kirim</th>
                                <th>Kembali</th>
                                <th>Keterangan</th>
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
        tabung_list();
    });

    function tabung_list(id) {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/master/tabung/list_riwayat?id_tabung=<?= $this->uri->segment('4'); ?>",
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
                        if (data[i].RELASI == "") {
                            var relasi = "-"
                        } else {
                            var relasi = data[i].RELASI[0].MASTER_RELASI_NAMA
                        }
                        if (data[i].SUPPLIER == "") {
                            var supplier = "-"
                        } else {
                            var supplier = data[i].SUPPLIER[0].MASTER_SUPPLIER_NAMA
                        }

                        if (data[i].RIWAYAT_TABUNG_KIRIM == "1") {
                            var kirim = "<i class='fas fa-check-circle'></i>"
                        } else {
                            var kirim = "-"
                        }
                        if (data[i].RIWAYAT_TABUNG_KEMBALI == "1") {
                            var kembali = "<i class='fas fa-check-circle'></i>"
                        } else {
                            var kembali = "-"
                        }
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].RIWAYAT_TABUNG_STATUS + "</td>" +
                            "<td>" + relasi + "</td>" +
                            "<td>" + supplier + "</td>" +
                            "<td>" + kirim + "</td>" +
                            "<td>" + kembali + "</td>" +
                            "<td>" + data[i].RIWAYAT_TABUNG_KETERANGAN + "</td>" +
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