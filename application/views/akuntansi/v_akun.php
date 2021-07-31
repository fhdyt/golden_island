<div class="modal fade" id="akunModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Akun</h4>
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
                        <label for="exampleInputEmail1"><?= $this->lang->line('nama'); ?></label>
                        <input type="text" class="form-control nama" name="nama" autocomplete="off" required>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control kategori select2" style="width: 100%;">

                            <?php
                            foreach (kategori_akun() as $value => $text) {
                            ?>
                                <option value="<?= $value; ?>"><?= $text; ?></option>
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Akun'); ?></h1>
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
                    <button type="button" class="btn btn-secondary btn_akun mb-2">Tambah Akun</button>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('nama'); ?></th>
                                <th>Kategori</th>
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
    $(".btn_akun").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#akunModal").modal("show")
    })
    $(function() {
        akun_list();
    });

    function akun_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/akuntansi/akun/list",
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
                    for (i = 0; i < data.length; i++) {
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].AKUN_NAMA + "</td>" +
                            "<td>" + data[i].AKUN_KATEGORI + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].AKUN_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='detail(\"" + data[i].AKUN_ID + "\")'><i class='fas fa-edit'></i></a></td>" +
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
            url: '<?php echo base_url(); ?>index.php/akuntansi/akun/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                akun_list();
                Swal.fire('Berhasil', 'Akun berhasil ditambahkan', 'success')
                $("#akunModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/akuntansi/akun/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            akun_list();
                            Swal.fire('Berhasil', 'Akun Berhasil dihapus', 'success')
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
            url: '<?php echo base_url() ?>index.php/akuntansi/akun/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $(".id").val(data[0].AKUN_ID)
                $(".nama").val(data[0].AKUN_NAMA)
                $(".akun").val(data[0].AKUN_KATEGORI)

                $("#akunModal").modal("show")
            },
            error: function(x, e) {} //end error
        });
    }
</script>