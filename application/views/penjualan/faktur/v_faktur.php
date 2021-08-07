<div class="modal fade" id="suratjalanModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Surat Jalan Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Tanggal</td>
                            <td>Nomor Surat Jalan</td>
                            <td>Relasi</td>
                            <td>Dibuat Oleh</td>
                        </tr>
                    </thead>
                    <tbody id="surat_jalan_baru">
                        <tr>
                            <td colspan="10">Memuat Surat Jalan Baru ...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('tutup'); ?></button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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

                    <div class="row">
                        <div class="col-md-12 mb-4" hidden>
                            <input type="text" class="form-control surat_jalan_nomor" name="surat_jalan_nomor" id="surat_jalan_nomor" value="" autocomplete="off" placeholder="Nomor Surat Jalan">
                        </div>
                        <div class="col-md-4">
                            <a href="<?= base_url(); ?>penjualan/faktur/form" class="btn btn-secondary mb-2 btn-form mr-2">Tambah Faktur</a>
                            <a class="btn btn-success mb-2 btn-form surat_jalan_baru">Surat Jalan Baru</a>
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
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('tanggal'); ?></th>
                                <th>Nomor Invoice</th>
                                <th><?= $this->lang->line('Relasi'); ?></th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- /.card-body -->
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(".surat_jalan_baru").on("click", function() {
        $("#suratjalanModal").modal("show")
        surat_jalan_baru_list()
    })
    $(function() {
        $('.surat_jalan_nomor').focus()
        po_list();
    });

    $('.surat_jalan_nomor').keyup(function(e) {
        if (e.keyCode == 13) {
            add_sj_scan()
        }
    });

    $('.filter_tanggal').on("click", function() {
        memuat()
        po_list()
    });

    function po_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/penjualan/faktur/list",
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
                        if (data[i].TRANSAKSI.length == 0) {
                            var transaksi = "0"
                        } else {
                            var transaksi = number_format(data[i].TRANSAKSI[0].PEMBELIAN_TRANSAKSI_BAYAR)
                        }
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].FAKTUR_NOMOR + "</td>" +
                            "<td>" + data[i].RELASI[0].MASTER_RELASI_NAMA + "</td>" +
                            "<td>Rp. " + transaksi + "</td>" +
                            "<td><a class='btn btn-primary btn-sm mb-2 ' href='<?= base_url(); ?>penjualan/faktur/form/" + data[i].FAKTUR_ID + "?jenis_sj=penjualan'>Lihat</a> " +
                            // "<a target='_blank' class='btn btn-success btn-sm mb-2' onclick='cetak(\"" + data[i].FAKTUR_ID + "\")'> <i class='right fas fa-print'></i> Cetak Faktur</a> " +
                            "<a target='_blank' class='btn btn-primary btn-sm mb-2' onclick='cetak_full(\"" + data[i].FAKTUR_ID + "\")'> <i class='right fas fa-print'></i> Cetak Faktur</a> " +
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

    function add_sj_scan() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/penjualan/faktur/add_sj_scan",
            async: false,
            dataType: 'json',
            data: {
                surat_jalan_nomor: $('.surat_jalan_nomor').val(),
            },
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                console.log(data)
                if (data == "error") {
                    memuat()
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Nomor Surat Jalan tidak dapat di proses'
                    })
                } else {

                    window.location.href = '<?= base_url(); ?>penjualan/faktur/form/' + data + ''
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function buat_faktur(surat_jalan_nomor) {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/penjualan/faktur/add_sj_scan",
            async: false,
            dataType: 'json',
            data: {
                surat_jalan_nomor: surat_jalan_nomor,
            },
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                console.log(data)
                if (data == "error") {
                    memuat()
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Nomor Surat Jalan tidak dapat di proses'
                    })
                } else {

                    window.location.href = '<?= base_url(); ?>penjualan/faktur/form/' + data + ''
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function surat_jalan_baru_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/penjualan/faktur/surat_jalan_baru",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#surat_jalan_baru").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#surat_jalan_baru").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    console.log()
                    for (i = 0; i < data.length; i++) {
                        if (data[i].SURAT_JALAN_JAMINAN == 'Yes') {
                            var jaminan = "<span class='float-left badge bg-success'>Jaminan</span>"
                        } else {
                            var jaminan = ""
                        }
                        $("tbody#surat_jalan_baru").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "<br>" + jaminan + "</td>" +
                            "<td>" + data[i].SURAT_JALAN_NOMOR + "<br><small>Keterangan : " + data[i].SURAT_JALAN_KETERANGAN + "</small></td>" +
                            "<td>" + data[i].RELASI[0].MASTER_RELASI_NAMA + "</td>" +
                            "<td>" + data[i].OLEH[0].USER_NAMA + "</td>" +
                            // "<td><a class='btn btn-warning btn-sm' onclick='buat_faktur(\"" + data[i].SURAT_JALAN_NOMOR + "\")'>Buat Faktur</td>" +
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

    function cetak_full(id) {
        window.open('<?= base_url(); ?>cetak/faktur_penjualan/' + id + '');
    }
</script>