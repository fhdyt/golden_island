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
                        <input type="hidden" class="form-control id" name="id" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal</label>
                        <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required>
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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <button type="button" class="btn btn-secondary btn_akun mb-2">Tambah</button>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
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
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/akuntansi/buku_besar/list?akun=" + $(".akun").val() + "",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {

                    if ($(".akun").val() == "") {
                        $("tbody#zone_data").append("<td colspan='10'>Silahkan pilih Jenis Akun terlebih dahulu.</td>")
                    } else {
                        $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                    }

                } else {
                    var no = 1
                    var saldo = 0
                    for (i = 0; i < data.length; i++) {
                        saldo += data[i].SALDO

                        if (data[i].BUKU_BESAR_REF == "") {
                            var btn_hapus = "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].BUKU_BESAR_ID + "\")'><i class='fas fa-trash'></i></a></td>"
                        } else {
                            var btn_hapus = ""
                        }
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].BUKU_BESAR_KETERANGAN + "</td>" +
                            "<td>" + data[i].BUKU_BESAR_SUMBER + "</td>" +
                            "<td>" + number_format(data[i].BUKU_BESAR_DEBET) + "</td>" +
                            "<td>" + number_format(data[i].BUKU_BESAR_KREDIT) + "</td>" +
                            "<td>" + number_format(saldo) + "</td>" +
                            btn_hapus +
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
                $("#kas_kecilModal").modal("hide")
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
</script>