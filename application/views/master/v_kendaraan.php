<div class="modal fade" id="kendaraanModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Kendaraan</h4>
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
                        <label for="exampleInputEmail1">Nomor</label>
                        <input type="text" class="form-control nomor" name="nomor" autocomplete="off">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Surat</label>
                        <input type="text" class="form-control surat" name="surat" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Produsen</label>
                        <input type="text" class="form-control produsen" name="produsen" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis</label>
                        <input type="text" class="form-control jenis" name="jenis" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tahun</label>
                        <input type="text" class="form-control tahun" name="tahun" autocomplete="off">
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
                    <h1 class="m-0"><?= $this->lang->line('Kendaraan'); ?></h1>
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
                    <button type="button" class="btn btn-secondary btn_kendaraan mb-2">Tambah Kendaraan</button>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor</th>
                                <th>Surat</th>
                                <th>Produsen</th>
                                <th>Jenis</th>
                                <th>Tahun</th>
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
    $(".btn_kendaraan").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#kendaraanModal").modal("show")
    })
    $(function() {
        kendaraan_list();
    });

    function kendaraan_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/master/kendaraan/list",
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
                            "<td>" + data[i].MASTER_KENDARAAN_NOMOR + "</td>" +
                            "<td>" + data[i].MASTER_KENDARAAN_SURAT + "</td>" +
                            "<td>" + data[i].MASTER_KENDARAAN_PRODUSEN + "</td>" +
                            "<td>" + data[i].MASTER_KENDARAAN_JENIS + "</td>" +
                            "<td>" + data[i].MASTER_KENDARAAN_TAHUN + "</td>" +
                            "<td>" +
                            // "<a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].MASTER_KENDARAAN_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='detail(\"" + data[i].MASTER_KENDARAAN_ID + "\")'><i class='fas fa-edit'></i></a></td>" +
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
            url: '<?php echo base_url(); ?>index.php/master/kendaraan/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                kendaraan_list();
                Swal.fire('Berhasil', 'Kendaraan berhasil ditambahkan', 'success')
                $("#kendaraanModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/master/kendaraan/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            kendaraan_list();
                            Swal.fire('Berhasil', 'Kendaraan Berhasil dihapus', 'success')
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
            url: '<?php echo base_url() ?>index.php/master/kendaraan/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $(".id").val(data[0].MASTER_KENDARAAN_ID)
                $(".nomor").val(data[0].MASTER_KENDARAAN_NOMOR)
                $(".surat").val(data[0].MASTER_KENDARAAN_SURAT)
                $(".produsen").val(data[0].MASTER_KENDARAAN_PRODUSEN)
                $(".jenis").val(data[0].MASTER_KENDARAAN_JENIS)
                $(".tahun").val(data[0].MASTER_KENDARAAN_TAHUN)

                $("#kendaraanModal").modal("show")
            },
            error: function(x, e) {} //end error
        });
    }
</script>