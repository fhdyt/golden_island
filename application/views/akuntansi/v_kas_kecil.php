<div class="modal fade" id="kas_kecilModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Kas Kecil</h4>

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
                        <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis</label>
                        <select name="jenis" id="jenis" class="form-control">
                            <option value="D">Debit</option>
                            <option value="K">Kredit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= $this->lang->line('keterangan'); ?></label>
                        <input type="text" class="form-control keterangan" name="keterangan" autocomplete="off" required>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Rupiah</label>
                        <input type="text" class="form-control rupiah" name="rupiah" autocomplete="off" required>
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
                    <h1 class="m-0"><?= $this->lang->line('Kas Kecil'); ?></h1>
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
                        <div class="col-md-4">
                            <button type="button" class="btn btn-secondary btn_kas_kecil mb-2">Tambah Kas Kecil</button>
                        </div>
                        <div class="col-md-4">
                            <select name="bulan" id="bulan" class="form-control bulan select2" style="width: 100%;">
                                <option value=""><?= $this->lang->line('semua'); ?></option>

                                <?php
                                foreach (bulan() as $value => $text) {
                                ?>
                                    <option value="<?= $value; ?>"><?= $text; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="tahun" id="tahun" class="form-control tahun select2" style="width: 100%;">
                                <option value=""><?= $this->lang->line('semua'); ?></option>

                                <?php
                                foreach (tahun() as $value => $text) {
                                ?>
                                    <option value="<?= $value; ?>"><?= $text; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?= $this->lang->line('tanggal'); ?></th>
                                <th><?= $this->lang->line('keterangan'); ?></th>
                                <th>K/D</th>
                                <th>Rupiah</th>
                                <th>Saldo</th>
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
    $(".btn_kas_kecil").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#kas_kecilModal").modal("show")
    })
    $(function() {
        $(".rupiah").mask("#.##0", {
            reverse: true
        });

        kas_kecil_list();
    });

    function kas_kecil_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/akuntansi/kas_kecil/list?bulan=04&tahun=2021",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data.saldo_awal)
                if (data.kas_kecil.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.kas_kecil.length; i++) {
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + data.kas_kecil[i].KAS_KECIL_TANGGAL + "</td>" +
                            "<td>" + data.kas_kecil[i].KAS_KECIL_KETERANGAN + "</td>" +
                            "<td>" + data.kas_kecil[i].KAS_KECIL_JENIS + "</td>" +
                            "<td>" + number_format(data.kas_kecil[i].KAS_KECIL_RUPIAH) + "</td>" +
                            "<td></td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data.kas_kecil[i].KAS_KECIL_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='detail(\"" + data.kas_kecil[i].KAS_KECIL_ID + "\")'><i class='fas fa-edit'></i></a></td>" +
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
            url: '<?php echo base_url(); ?>index.php/akuntansi/kas_kecil/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                kas_kecil_list();
                Swal.fire('Berhasil', 'Kas Kecil berhasil ditambahkan', 'success')
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
                    url: '<?php echo base_url() ?>index.php/akuntansi/kas_kecil/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            kas_kecil_list();
                            Swal.fire('Berhasil', 'Driver Berhasil dihapus', 'success')
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
</script>