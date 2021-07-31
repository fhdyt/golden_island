<div class="modal fade" id="akunModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Bayar Hutang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit">
                    <div class="form-group">
                        <input type="hidden" class="form-control id" value="<?= $this->uri->segment('4'); ?>" name="id" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal</label>
                        <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required value="<?= date("Y-m-d"); ?>" readonly>
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
                    <div class="form-group">
                        <label for="exampleInputEmail1">Rupiah</label>
                        <input type="text" class="form-control rupiah" name="rupiah" autocomplete="off" required>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Keterangan</label>
                        <input type="text" class="form-control keterangan" name="keterangan" value="PEMBAYARAN HUTANG" autocomplete="off">
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

<div class="modal fade" id="saldopiutangModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Saldo Hutang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit_saldo_piutang">
                    <div class="form-group">
                        <input type="hidden" class="form-control id" value="<?= $this->uri->segment('4'); ?>" name="id" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal</label>
                        <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required value="<?= date("Y-m-d"); ?>" readonly>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Jatuh Tempo</label>
                        <input type="date" class="form-control tanggal_tempo" name="tanggal_tempo" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Rupiah</label>
                        <input type="text" class="form-control rupiah" name="rupiah" autocomplete="off" required>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Keterangan</label>
                        <input type="text" class="form-control keterangan" name="keterangan" value="TAGIHAN HUTANG" autocomplete="off">
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
                    <h1 class="m-0">Rincian Hutang Supplier</h1>
                    <p class="nama_relasi">Loading...</p>
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
                            <button type="button" class="btn btn-secondary btn_akun mb-2">Bayar Hutang</button>
                            <button type="button" class="btn btn-warning btn_saldo_piutang mb-2">Tambah Hutang</button>
                        </div>
                    </div>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jatuh Tempo</th>
                                <th>Keterangan</th>
                                <th>Hutang</th>
                                <th colspan="2" align="center">Sisa Hutang</th>
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
        detail()
        relasi_list()
        $(".rupiah").mask("#.##0", {
            reverse: true
        });
    })
    $(".btn_akun").on("click", function() {
        $("#akunModal").modal("show")
    })
    $(".btn_saldo_piutang").on("click", function() {
        $("#saldopiutangModal").modal("show")
    })

    function relasi_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/akuntansi/hutang/list_hutang?id=<?= $this->uri->segment('4') ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var saldo = 0
                    var total_hutang = 0
                    for (i = 0; i < data.length; i++) {
                        total_hutang += parseInt(data[i].HUTANG_DEBET)
                        if (data[i].STATUS == "CORET") {
                            var del = "del"
                        } else {
                            var del = "p"
                        }
                        if (data[i].PEMBAYARAN == "0") {
                            var tr = "success"
                            var lunas = "<a class='btn btn-success'>LUNAS</a>"
                        } else {
                            var tr = "default"
                            var lunas = ""
                        }
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].TANGGAL_TEMPO + "</td>" +
                            "<td><" + del + ">" + data[i].HUTANG_KETERANGAN + "</" + del + "></td>" +
                            "<td><" + del + ">" + number_format(data[i].HUTANG_DEBET) + "</" + del + "></td>" +
                            "<td>" + number_format(data[i].PEMBAYARAN) + "</td>" +
                            "<td>" + lunas + "</td>" +
                            "</tr>");
                    }
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
            url: '<?php echo base_url(); ?>index.php/akuntansi/hutang/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                relasi_list();
                Swal.fire('Berhasil', '', 'success')
                $("#akunModal").modal("hide")
            }
        });
    })

    $('#submit_saldo_piutang').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/akuntansi/hutang/add_saldo',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                relasi_list();
                Swal.fire('Berhasil', '', 'success')
                $("#akunModal").modal("hide")
            }
        });
    })

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/akuntansi/hutang/detail/<?= $this->uri->segment("4"); ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if (data.length == 0) {} else {
                    $("p.nama_relasi").html(data[0].MASTER_SUPPLIER_NAMA)
                }


            },
            error: function(x, e) {} //end error
        });
    }
</script>