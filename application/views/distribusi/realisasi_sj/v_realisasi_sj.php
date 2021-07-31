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
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control surat_jalan_nomor" name="surat_jalan_nomor" id="surat_jalan_nomor" value="" autocomplete="off" placeholder="Nomor Surat Jalan">
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
                    <table id="example2" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Nomor Surat Jalan</th>
                                <th>Nama Driver</th>
                                <th>Nama Relasi</th>
                                <th>Nama Supplier</th>
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
        $('.surat_jalan_nomor').focus()
    });

    $('.surat_jalan_nomor').keyup(function(e) {
        if (e.keyCode == 13) {
            memuat()
            po_list()
        }
    });

    $('.filter_tanggal').on("click", function() {
        memuat()
        po_list()
    });

    function po_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/distribusi/realisasi_sj/list",
            async: false,
            dataType: 'json',
            data: {
                surat_jalan_nomor: $('.surat_jalan_nomor').val(),
                tanggal_dari: $('.tanggal_dari').val(),
                tanggal_sampai: $('.tanggal_sampai').val(),
            },
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else if (data.length === 1) {
                    window.location.href = '<?php base_url(); ?>realisasi_sj/form/' + data[0].SURAT_JALAN_ID + ''
                } else {
                    var tableContent = "";
                    var no = 1
                    console.log(data)
                    for (i = 0; i < data.length; i++) {
                        if (data[i].SURAT_JALAN_REALISASI_STATUS != "selesai") {
                            var realisasi_id = "<?= create_id(); ?>"
                            var status = ""
                        } else {
                            var realisasi_id = data[i].REALISASI_ID
                            var status = "Realisasi Selesai, Menunggu Faktur..."
                        }
                        var btn_realisasi = "<a class='btn btn-success btn-sm' href='<?php base_url(); ?>realisasi_sj/form/" + data[i].SURAT_JALAN_ID + "'>Realisasi</a>"

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

                        if (data[i].DRIVER == "") {
                            var driver = "-"
                        } else {
                            var driver = data[i].DRIVER[0].MASTER_KARYAWAN_NAMA
                        }


                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].SURAT_JALAN_NOMOR + "<br><small class='text-muted'>" + status + "</small></td>" +
                            "<td>" + driver + "</td>" +
                            "<td>" + relasi + "</td>" +
                            "<td>" + supplier + "</td>" +
                            "<td>" + btn_realisasi + "" +
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