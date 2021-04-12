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
                        <label for="exampleInputEmail1">Kode</label>
                        <input type="text" class="form-control" name="kode" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" class="form-control" name="nama" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Alamat</label>
                        <input type="text" class="form-control" name="alamat" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Telp</label>
                        <input type="text" class="form-control" name="telp" value="" autocomplete="off">
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
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
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Alamat</th>
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
        $("#perusahaanModal").modal("show")
        aplikasi_list()
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
                            "<td>" + data[i].PERUSAHAAN_TELP + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].PERUSAHAAN_ID + "\")'><i class='fas fa-trash'></i></a></td>" +
                            "</tr>");
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function aplikasi_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/sistem/aplikasi/list",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("#aplikasi").empty();
                if (data.length === 0) {} else {
                    for (i = 0; i < data.length; i++) {
                        $("#aplikasi").append("<option value='" + data[i].APLIKASI_ID + "'>" + data[i].APLIKASI_NAMA + "</option>");
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
            title: 'Hapus ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Hapus`,
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
</script>