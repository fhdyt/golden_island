<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Surat Jalan & TTBK</h1>
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
                    <a href="<?= base_url(); ?>distribusi/surat_jalan/form_sj" type="button" class="btn btn-secondary mb-2">Tambah Surat Jalan</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Nomor SJ</th>
                                <th>Nama</th>
                                <th>Nama Driver</th>
                                <th>Nama Kendaraan</th>
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
        sj_list();
    });

    function sj_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/distribusi/surat_jalan/list",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'>Tidak ada data</td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        if (data[i].SURAT_JALAN_NAMA_PELANGGAN == "") {
                            var nama = data[i].RELASI[0].MASTER_RELASI_NAMA
                        } else {
                            var nama = data[i].SURAT_JALAN_NAMA_PELANGGAN
                        }

                        if (data[i].DRIVER.length == 0) {
                            var driver = "-"
                        } else {
                            var driver = data[i].DRIVER[0].MASTER_DRIVER_NAMA
                        }

                        if (data[i].KENDARAAN.length == 0) {
                            var kendaraan = "-"
                        } else {
                            var kendaraan = data[i].KENDARAAN[0].MASTER_KENDARAAN_NOMOR
                        }

                        if (data[i].SURAT_JALAN_JENIS == "langsung") {
                            var jenis_sj = "<br><small class='text-muted'>Langsung</small>"
                        } else if (data[i].SURAT_JALAN_JENIS == "kirim") {
                            var jenis_sj = "<br><small class='text-muted'>Dikirim</small>"
                        }


                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].SURAT_JALAN_NOMOR + "" + jenis_sj + "</td>" +
                            "<td>" + nama + "</td>" +
                            "<td>" + driver + "</td>" +
                            "<td>" + kendaraan + "</td>" +
                            "<td><a target='_blank' class='btn btn-primary btn-sm' href='<?= base_url(); ?>distribusi/surat_jalan/form_sj/" + data[i].SURAT_JALAN_ID + "'>Lihat</a></td>" +
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