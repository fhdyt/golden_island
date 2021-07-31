<style>
    .table {
        font-size: small;
    }
</style>
<div class="modal fade" id="akunModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah</h4>
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
                        <label for="exampleInputEmail1">Tanggal</label>
                        <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required readonly value="<?= date("Y-m-d"); ?>">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis</label>
                        <select class="form-control jenis_pengeluaran" name="jenis_pengeluaran">
                            <option value="Pengeluaran Harian">Pengeluaran Harian</option>
                            <option value="Uang Jalan">Uang Jalan</option>
                            <option value="Jaminan">Jaminan</option>
                            <option value="Reimburse">Reimburse</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group uang_jalan" hidden>
                        <label for="exampleInputEmail1">Nomor Surat Jalan</label>
                        <select name="nomor_surat_jalan" id="nomor_surat_jalan" class="form-control form-control-sm nomor_surat_jalan select2" style="width: 100%;">
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
                        <label for="exampleInputEmail1">Debet</label>
                        <input type="text" class="form-control debet" name="debet" autocomplete="off" value="0" required>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kredit</label>
                        <input type="text" class="form-control kredit" name="kredit" autocomplete="off" value="0" required>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group userfile">
                        <label for="exampleInputEmail1">Dokumen</label>
                        <input type="file" name="userfile" class="form-control userfile" required>
                        <small class="text-muted"><a href="" target="_blank" class="link_dokument"></a></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Keterangan</label>
                        <input type="text" class="form-control keterangan" name="keterangan" autocomplete="off">
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
<div class="modal fade" id="transferModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Transfer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit_transfer">
                    <div class="form-group">
                        <input type="hidden" class="form-control id" name="id" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal</label>
                        <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required readonly value="<?= date("Y-m-d"); ?>">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Dari</label>
                        <select name="akun_dari" id="akun_dari" class="form-control akun_dari select2" style="width: 100%;" required>
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
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tujuan</label>
                        <select name="akun_tujuan" id="akun_tujuan" class="form-control akun_tujuan select2" style="width: 100%;" required>
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
                    <div class="form-group">
                        <label for="exampleInputEmail1">Rupiah</label>
                        <input type="text" class="form-control rupiah" name="rupiah" autocomplete="off" value="0" required>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Keterangan</label>
                        <input type="text" class="form-control keterangan" name="keterangan" autocomplete="off">
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Buku Besar'); ?></h1>
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
                            <select name="akun" id="akun" class="form-control akun select2" style="width: 100%;" required>
                                <option value="">-- Akun --</option>
                                <?php foreach (akun_list() as $row) {
                                ?>
                                    <option value="<?= $row->AKUN_ID; ?>"><?= $row->AKUN_NAMA; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control tanggal_dari" name="tanggal_dari" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                            <small class="text-muted">Tanggal Dari.</small>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="date" class="form-control tanggal_sampai" name="tanggal_sampai" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary filter_tanggal"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <small class="text-muted">Tanggal Sampai.</small>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-secondary btn_akun mb-2 mr-2">Tambah</button>
                            <button type="button" class="btn btn-success btn_transfer mb-2"><i class="fas fa-exchange-alt"></i> Transfer</button>
                        </div>
                    </div>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th><?= $this->lang->line('tanggal'); ?></th>
                                <th><?= $this->lang->line('keterangan'); ?></th>
                                <th>Sumber</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody id="zone_saldo_awal">
                            <tr>
                            </tr>
                        </tbody>
                        <tbody id="zone_data">
                            <tr>
                            </tr>
                        </tbody>
                        <tfoot id="total_buku_besar">
                            <tr>
                            </tr>
                        </tfoot>
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
    $(".btn_akun").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        if ($(".akun").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silahkan pilih Akun terlebih dahulu'
            })
        } else {
            $("#akunModal").modal("show")
        }

    })
    $(".btn_transfer").on("click", function() {
        $("#submit_transfer").trigger("reset");
        $("#transferModal").modal("show")


    })

    $(function() {
        $(".rupiah").mask("#.##0", {
            reverse: true
        });
        $(".kredit").mask("#.##0", {
            reverse: true
        });
        $(".debet").mask("#.##0", {
            reverse: true
        });
        buku_besar_list();
    });

    function buku_besar_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/akuntansi/buku_besar/list?akun=" + $(".akun").val() + "",
            async: false,
            dataType: 'json',
            data: {
                tanggal_dari: $('.tanggal_dari').val(),
                tanggal_sampai: $('.tanggal_sampai').val(),
            },
            success: function(data) {
                $("tbody#zone_saldo_awal").empty();
                $("tbody#zone_data").empty();
                $("tfoot#total_buku_besar").empty()
                memuat()
                console.log(data)
                if ($(".akun").val() == "") {
                    $("tbody#zone_data").append("<td colspan='10'>Silahkan pilih Jenis Akun terlebih dahulu.</td>")
                }
                if (data.length === 0) {

                } else {
                    var no = 1
                    if (data['saldo_awal'][0].DEBET == null) {
                        var saldo_awal_debet = 0
                    } else {
                        var saldo_awal_debet = data['saldo_awal'][0].DEBET
                    }
                    if (data['saldo_awal'][0].KREDIT == null) {
                        var saldo_awal_kredit = 0
                    } else {
                        var saldo_awal_kredit = data['saldo_awal'][0].KREDIT
                    }
                    var saldo_awal = parseInt(saldo_awal_debet) - parseInt(saldo_awal_kredit)
                    // var saldo_awal = parseInt(data['saldo_awal'][0].DEBET) - parseInt(data['saldo_awal'][0].KREDIT)
                    console.log(saldo_awal)
                    $("tbody#zone_saldo_awal").append("<tr class=''>" +
                        "<td colspan='5' style='text-align:right; vertical-align:middle;'><b>Saldo Awal</b></td>" +
                        "<td>" + number_format(saldo_awal) + "</td>" +
                        "</tr>");
                    var saldo = 0 + saldo_awal
                    var total_debet = 0
                    var total_kredit = 0
                    for (i = 0; i < data['data'].length; i++) {
                        saldo += parseInt(data['data'][i].SALDO)

                        if (data['data'][i].BUKU_BESAR_REF == "") {
                            var btn_hapus = ""
                            //var btn_hapus = "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data['data'][i].BUKU_BESAR_ID + "\")'><i class='fas fa-trash'></i></a></td>"
                        } else {
                            var btn_hapus = ""
                        }

                        if (data['data'][i].BUKU_BESAR_FILE == "") {
                            var file = ""
                        } else if (data['data'][i].BUKU_BESAR_FILE == null) {
                            var file = ""
                        } else {
                            var file = "<a class='btn btn-secondary btn-xs' href='<?= base_url() ?>uploads/buku_besar/" + data['data'][i].BUKU_BESAR_FILE + "' target='_blank'><i class='fas fa-file'></i> Buka Dokumen</a>"
                        }

                        total_debet += parseInt(data['data'][i].BUKU_BESAR_DEBET)
                        total_kredit += parseInt(data['data'][i].BUKU_BESAR_KREDIT)

                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + data['data'][i].TANGGAL + "</td>" +
                            "<td>" + data['data'][i].BUKU_BESAR_KETERANGAN + "<br>" + file + "</td>" +
                            "<td>" + data['data'][i].BUKU_BESAR_SUMBER + "<br><small class='text-muted'>" + data['data'][i].BUKU_BESAR_JENIS_PENGELUARAN + "</small></td>" +
                            "<td>" + number_format(data['data'][i].BUKU_BESAR_DEBET) + "</td>" +
                            "<td>" + number_format(data['data'][i].BUKU_BESAR_KREDIT) + "</td>" +
                            "<td>" + number_format(saldo) + "</td>" +
                            btn_hapus +
                            "</tr>");
                    }
                    $("tfoot#total_buku_besar").append("<tr><td colspan='3' style='text-align:right; vertical-align:middle;'><b>Total</b></td><td>" + number_format(total_debet) + "</td><td>" + number_format(total_kredit) + "</td></tr>")
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/akuntansi/buku_besar/add?akun=' + $(".akun").val() + '',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                buku_besar_list();
                Swal.fire('Berhasil', '', 'success')
                $("#akunModal").modal("hide")
            }
        });
    })

    $('#submit_transfer').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/akuntansi/buku_besar/transfer',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                buku_besar_list();
                Swal.fire('Berhasil', '', 'success')
                $("#transferModal").modal("hide")
            }
        });
    })

    function hapus(id) {
        console.log(id)
        Swal.fire({
            title: '<?= $this->lang->line('hapus'); ?> ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `<?= $this->lang->line('hapus'); ?>`,
            denyButtonText: `Batal`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'ajax',
                    url: '<?php echo base_url() ?>index.php/akuntansi/buku_besar/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            buku_besar_list();
                            Swal.fire('Berhasil', 'DBerhasil dihapus', 'success')
                        }
                    },
                    error: function(x, e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Proses Gagal'
                        })
                    } //end error
                });

            }
        })
    }

    function detail(id) {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/master/kas_kecil/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $(".id").val(data[0].MASTER_DRIVER_ID)
                $(".nama").val(data[0].MASTER_DRIVER_NAMA)
                $(".alamat").val(data[0].MASTER_DRIVER_ALAMAT)
                $(".hp").val(data[0].MASTER_DRIVER_HP)
                $(".sim").val(data[0].MASTER_DRIVER_SIM)
                $(".ktp").val(data[0].MASTER_DRIVER_KTP)

                $("#driverModal").modal("show")
            },
            error: function(x, e) {} //end error
        });
    }
    $('.akun').change(function() {
        memuat()
        buku_besar_list()
    });
    $('.jenis_pengeluaran').change(function() {
        if ($('.jenis_pengeluaran').val() == "Uang Jalan") {
            $(".uang_jalan").attr("hidden", false)
            $(".nomor_surat_jalan").attr("required", true)

            $(".userfile").attr("hidden", true)
            $(".userfile").attr("required", false)
        } else {
            $(".uang_jalan").attr("hidden", true)
            $(".nomor_surat_jalan").attr("required", false)

            $(".userfile").attr("hidden", false)
            $(".userfile").attr("required", true)
        }
    });

    $('.filter_tanggal').on("click", function() {
        if ($(".akun").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silahkan pilih Akun terlebih dahulu'
            })
        } else {
            memuat()
            buku_besar_list()
        }

    });
</script>