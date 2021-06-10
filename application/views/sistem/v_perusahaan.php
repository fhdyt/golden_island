<div class="modal fade" id="perusahaanModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Perusahaan</h4>
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
                        <label for="exampleInputEmail1"><?= $this->lang->line('kode'); ?></label>
                        <input type="text" class="form-control kode" name="kode" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= $this->lang->line('nama'); ?></label>
                        <input type="text" class="form-control nama" name="nama" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= $this->lang->line('alamat'); ?></label>
                        <input type="text" class="form-control alamat" name="alamat" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kota</label>
                        <input type="text" class="form-control kota" name="kota" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Telp</label>
                        <input type="text" class="form-control telp" name="telp" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Bank</label>
                        <input type="text" class="form-control bank" name="bank" value="" autocomplete="off">
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
                    <h1 class="m-0">Perusahaan</h1>
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
                    <button type="button" class="btn btn-secondary btn_perusahaan mb-2">Tambah Perusahaan</button>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('kode'); ?></th>
                                <th><?= $this->lang->line('nama'); ?></th>
                                <th><?= $this->lang->line('alamat'); ?></th>
                                <th>Kota</th>
                                <th>Telp</th>
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
    $(".btn_perusahaan").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#perusahaanModal").modal("show")
    })
    $(function() {
        perusahaan_list();
    });

    function perusahaan_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/sistem/perusahaan/list",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {} else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].PERUSAHAAN_KODE + "</td>" +
                            "<td>" + data[i].PERUSAHAAN_NAMA + "</td>" +
                            "<td>" + data[i].PERUSAHAAN_ALAMAT + "</td>" +
                            "<td>" + data[i].PERUSAHAAN_KOTA + "</td>" +
                            "<td>" + data[i].PERUSAHAAN_TELP + "</td>" +
                            "<td><a class='btn btn-danger btn-sm mb-2' onclick='hapus(\"" + data[i].PERUSAHAAN_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='detail(\"" + data[i].PERUSAHAAN_ID + "\")'><i class='fas fa-edit'></i></a></td>" +
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
            url: '<?php echo base_url(); ?>index.php/sistem/perusahaan/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                perusahaan_list();
                Swal.fire('Berhasil', 'Perusahaan berhasil ditambahkan', 'success')
                $("#perusahaanModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/sistem/perusahaan/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            perusahaan_list();
                            Swal.fire('Berhasil', 'Perusahaan Berhasil dihapus', 'success')
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
            url: '<?php echo base_url() ?>index.php/sistem/perusahaan/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $(".id").val(data[0].PERUSAHAAN_ID)
                $(".kode").val(data[0].PERUSAHAAN_KODE)
                $(".nama").val(data[0].PERUSAHAAN_NAMA)
                $(".alamat").val(data[0].PERUSAHAAN_ALAMAT)
                $(".kota").val(data[0].PERUSAHAAN_KOTA)
                $(".telp").val(data[0].PERUSAHAAN_TELP)
                $(".bank").val(data[0].PERUSAHAAN_BANK)

                $("#perusahaanModal").modal("show")
            },
            error: function(x, e) {} //end error
        });
    }
</script>