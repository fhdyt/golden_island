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

                    <div class="row mb-2">
                        <div class="col-md-3">
                            <a href="<?= base_url(); ?>distribusi/surat_jalan/form?jenis_sj=penjualan" class="btn btn-secondary mb-2 btn-block btn-form">Tambah Surat Jalan</a>
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
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('tanggal'); ?></th>
                                <th>Nomor Surat Jalan</th>
                                <th>Driver</th>
                                <th><?= $this->lang->line('Relasi'); ?></th>
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
        po_list();
    });

    $('.filter_tanggal').on("click", function() {
        memuat()
        po_list()
    });

    function po_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/distribusi/surat_jalan/list?jenis_sj=penjualan",
            async: false,
            dataType: 'json',
            data: {
                tanggal_dari: $('.tanggal_dari').val(),
                tanggal_sampai: $('.tanggal_sampai').val(),
            },
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
                            var status = "<span class='float-left badge bg-success'>Faktur Telah Diproses</span>"
                        } else {
                            var status = "<span class='float-left badge bg-danger'>Menunggu Faktur ...</span>"
                        }

                        if (data[i].SURAT_JALAN_REALISASI_STATUS != "selesai") {
                            var riwayat_status = "<span class='float-left badge bg-danger'>Belum Teralisasi</span>"
                            var btn_cetak = ""
                            var btn_cetak_ttbk = ""
                        } else {
                            var riwayat_status = "<span class='float-left badge bg-success'>Telah terealisasi</span>"
                            var btn_cetak = "<a class='btn btn-success btn-sm mr-1' target='_blank' href='<?= base_url(); ?>cetak/cetak_sj/" + data[i].SURAT_JALAN_ID + "'>Cetak</a>"
                            var btn_cetak_ttbk = "<a class='btn btn-warning btn-sm' target='_blank' href='<?= base_url(); ?>cetak/cetak_ttbk/" + data[i].SURAT_JALAN_ID + "'>Cetak TTBK</a>"

                        }

                        if (data[i].SURAT_JALAN_REALISASI_TTBK_STATUS != "selesai") {
                            var riwayat_status_ttbk = "<span class='float-left badge bg-danger'>TTBK Belum Teralisasi</span>"
                        } else {
                            var riwayat_status_ttbk = "<span class='float-left badge bg-success'>TTBK Telah terealisasi</span>"
                        }

                        if (data[i].RELASI == "") {
                            var relasi = "-"
                        } else {
                            var relasi = data[i].RELASI[0].MASTER_RELASI_NAMA
                        }

                        if (data[i].DRIVER == "") {
                            var driver = "-"
                        } else {
                            var driver = data[i].DRIVER[0].MASTER_KARYAWAN_NAMA
                        }
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "<br>" + data[i].JAM + "<br><small  class='text-muted'>" + data[i].SURAT_JALAN_STATUS_JENIS + "</small></td>" +
                            "<td>" + data[i].SURAT_JALAN_NOMOR + "<br>" + status + "<br>" + riwayat_status + "<br>" + riwayat_status_ttbk + "</td>" +
                            "<td>" + driver + "</td>" +
                            "<td>" + relasi + "</td>" +
                            "<td>" + data[i].SURAT_JALAN_KETERANGAN + "</td>" +
                            "<td><a class='btn btn-primary btn-sm mr-1' href='<?= base_url(); ?>distribusi/surat_jalan/form/" + data[i].SURAT_JALAN_ID + "?jenis_sj=penjualan'>Lihat</a>" +
                            btn_cetak +
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