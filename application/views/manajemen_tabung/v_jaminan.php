<style>
    .table {
        font-size: small;
    }
</style>
<div class="modal fade" id="pajakModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Jaminan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit">
                    <div class="form-group">
                        <input type="hidden" class="form-control id" name="id" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= $this->lang->line('tanggal'); ?></label>
                        <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" value="<?= date("Y-m-d"); ?>" required>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nomor Surat Jalan</label>
                        <select name="surat_jalan" id="surat_jalan" class="form-control form-control-sm surat_jalan select2" style="width: 100%;" required>
                            <option value="">-- Surat Jalan --</option>
                            <?php
                            foreach ($surat_jalan as $row) { ?>
                                <option value="<?= $row->SURAT_JALAN_ID ?>"><?= $row->SURAT_JALAN_NOMOR ?></option>
                            <?php }
                            ?>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jumlah</label>
                        <input type="text" class="form-control jumlah" name="jumlah" autocomplete="off" required onkeyup="kalkulasi_seluruh()">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Harga</label>
                        <input type="text" class="form-control harga" name="harga" autocomplete="off" required onkeyup="kalkulasi_seluruh()">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Total</label>
                        <input type="text" class="form-control total" name="total" autocomplete="off" readonly>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Akun</label>
                        <select name="akun" id="akun" class="form-control akun select2" style="width: 100%;" required>
                            <option value="">-- Akun --</option>
                            <?php foreach (akun_list() as $row) {
                            ?>
                                <option value="<?= $row->AKUN_ID; ?>"><?= $row->AKUN_NAMA; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('tutup'); ?></button>
                <button type="submit" class="btn btn-primary"><?= $this->lang->line('simpan'); ?></button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="selesaijaminanModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Selesai Jaminan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit_selesai">
                    <div class="form-group">
                        <input type="hidden" class="form-control id_jaminan" name="id_jaminan" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Akun</label>
                        <select name="akun" id="akun" class="form-control akun select2" style="width: 100%;" required>
                            <option value="">-- Akun --</option>
                            <?php foreach (akun_list() as $row) {
                            ?>
                                <option value="<?= $row->AKUN_ID; ?>"><?= $row->AKUN_NAMA; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <hr>
                    <table class="table table-bordered">
                        <tr>
                            <td>Jumlah</td>
                            <td>Harga</td>
                            <td>Total</td>
                        </tr>
                        <tr>
                            <td>
                                <p class="jumlah_jaminan"></p>
                            </td>
                            <td>
                                <p class="harga_jaminan"></p>
                            </td>
                            <td>
                                <p class="total_jaminan"></p>
                            </td>
                        </tr>

                    </table>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('tutup'); ?></button>
                <button type="submit" class="btn btn-primary">Jaminan Selesai</button>
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
                    <h1 class="m-0">Jaminan</h1>
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
                        <div class="col-md-2">
                            <!-- <button type="button" class="btn btn-secondary btn_pajak mb-2">Tambah Jaminan</button> -->
                        </div>
                        <div class="col-md-11">
                            <select name="relasi" id="relasi" class="form-control relasi select2" style="width: 100%;" required>
                                <option value="">-- Pilih Relasi --</option>
                                <?php foreach (relasi_list() as $row) {
                                ?>
                                    <option value="<?= $row->MASTER_RELASI_ID; ?>"><?= $row->MASTER_RELASI_NAMA; ?> - <?= $row->MASTER_RELASI_QR_ID; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <small class="text-muted">Nama Relasi.</small>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-outline-secondary filter"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Jaminan</th>
                                <th><?= $this->lang->line('nama'); ?></th>
                                <th>Surat Jalan</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
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
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(".btn_pajak").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#pajakModal").modal("show")
    })
    $(function() {
        $('a.menu-btn').click()
        jaminan_list();
        $(".jumlah").mask("#.##0", {
            reverse: true
        });
        $(".harga").mask("#.##0", {
            reverse: true
        });
        $(".total").mask("#.##0", {
            reverse: true
        });
    });

    $(".filter").on("click", function() {
        memuat()
        jaminan_list();
    })
    $('.nama_relasi').keyup(function(e) {
        if (e.keyCode == 13) {
            memuat()
            jaminan_list()
        }
    });


    function jaminan_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/manajemen_tabung/jaminan/list",
            async: false,
            dataType: 'json',
            data: {
                nama_relasi: $(".relasi").val()
            },
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var total_tabung = 0
                    var total_rupiah = 0
                    for (i = 0; i < data.length; i++) {
                        if (data[i].FAKTUR_JAMINAN_STATUS == "selesai") {
                            var tr = "table-success"
                            var tabung = 0
                            var rupiah = 0
                            var status = "<small class='text-muted'>Jaminan Telah Selesai <br>" + data[i].TANGGAL_SELESAI + "</small>"
                            var btn = ""
                        } else {
                            var tr = "table-default"
                            var tabung = parseInt(data[i].FAKTUR_JAMINAN_JUMLAH)
                            var rupiah = parseInt(data[i].FAKTUR_JAMINAN_TOTAL_RUPIAH)
                            var status = ""
                            var btn = "<a class='btn btn-warning btn-sm mb-2' onclick='detail(\"" + data[i].FAKTUR_JAMINAN_ID + "\")'><i class='fas fa-edit'></i> Selesai</a>"
                        }

                        total_tabung += tabung
                        total_rupiah += rupiah
                        if (data[i].SELISIH_TANGGAL.length == 0) {
                            var selisih_tanggal = "Belum melakukan pemesanan."
                        } else {
                            var selisih_tanggal = data[i].SELISIH_TANGGAL
                        }
                        if (data[i].NAMA_RELASI[0].MASTER_RELASI_NAMA == undefined) {
                            var nama = "-"
                        } else {
                            var nama = data[i].NAMA_RELASI[0].MASTER_RELASI_NAMA
                        }

                        if (data[i].SURAT_JALAN[0].SURAT_JALAN_REALISASI_TTBK_STATUS == "selesai") {
                            var btn_selesai = btn
                        } else {
                            var btn_selesai = "<br><small>Silahkan TTBK terlebih dahulu</small>"
                        }
                        $("tbody#zone_data").append("<tr class='" + tr + "'>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].FAKTUR_JAMINAN_NOMOR + "</td>" +
                            "<td>" + nama + "<br><small>Pemesanan Terakhir : " + selisih_tanggal + "</small></td>" +
                            "<td>" + data[i].SURAT_JALAN[0].SURAT_JALAN_NOMOR + "<br>" + status + "</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].FAKTUR_JAMINAN_JUMLAH + "</td>" +
                            "<td>" + number_format(data[i].FAKTUR_JAMINAN_HARGA) + "</td>" +
                            "<td>" + number_format(data[i].FAKTUR_JAMINAN_TOTAL_RUPIAH) + "</td>" +
                            "<td>" +
                            "<a target='_blank' class='mb-2 btn btn-success btn-sm' onclick='cetak(\"" + data[i].FAKTUR_JAMINAN_ID + "\")'> <i class='right fas fa-print'></i> Cetak</a> " +
                            "" + btn_selesai + "</td>" +
                            "</tr>");
                    }
                    $("tbody#zone_data").append("<tr><td colspan='5' style='text-align:right'>Total</td><td>" + total_tabung + "</td><td></td><td>" + number_format(total_rupiah) + "</td></tr > ")
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    $('#submit').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Proses Jaminan ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Simpan`,
            denyButtonText: `Batal`,
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/manajemen_tabung/jaminan/add',
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        memuat()
                    },
                    success: function(data) {
                        jaminan_list();
                        Swal.fire('Berhasil', 'Jaminan berhasil ditambahkan', 'success')
                        $("#pajakModal").modal("hide")
                    }
                });
            }
        })
    })

    $('#submit_selesai').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Proses Jaminan ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Simpan`,
            denyButtonText: `Batal`,
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/manajemen_tabung/jaminan/selesai',
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        memuat()
                    },
                    success: function(data) {
                        jaminan_list();
                        Swal.fire('Berhasil', 'Jaminan berhasil diselesaikan', 'success')
                        $("#pajakModal").modal("hide")
                    }
                });
            }
        })
    })

    function cetak(id) {
        window.open('<?= base_url(); ?>cetak/faktur_jaminan/' + id + '');
    }


    function kalkulasi_seluruh() {
        var harga = parseInt($(".harga").val().split('.').join(""))
        var jumlah = parseInt($(".jumlah").val().split('.').join(""))

        var total = harga * jumlah
        $(".total").val(number_format(total))
    }

    function detail(id) {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/manajemen_tabung/jaminan/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                console.log(data)
                $(".id_jaminan").val(data[0].FAKTUR_JAMINAN_ID)
                $("p.jumlah_jaminan").html(data[0].FAKTUR_JAMINAN_JUMLAH)
                $("p.harga_jaminan").html(number_format(data[0].FAKTUR_JAMINAN_HARGA))
                $("p.total_jaminan").html(number_format(data[0].FAKTUR_JAMINAN_TOTAL_RUPIAH))
                $("#selesaijaminanModal").modal("show")
            },
            error: function(x, e) {} //end error
        });
    }
</script>