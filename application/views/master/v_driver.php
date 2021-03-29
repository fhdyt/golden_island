<div class="modal fade" id="driverModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Driver</h4>
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
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" class="form-control nama" name="nama" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Alamat</label>
                        <input type="text" class="form-control alamat" name="alamat" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">No. HP</label>
                        <input type="text" class="form-control hp" name="hp" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">SIM</label>
                        <input type="text" class="form-control sim" name="sim" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">KTP</label>
                        <input type="text" class="form-control ktp" name="ktp" autocomplete="off">
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
                    <h1 class="m-0">Driver</h1>
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
                    <button type="button" class="btn btn-secondary btn_driver mb-2">Tambah Driver</button>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No. HP</th>
                                <th>SIM</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                                <td colspan="9">
                                    <center>
                                        <div class="loader"></div>
                                    </center>
                                </td>
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
    $(".btn_driver").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#driverModal").modal("show")
    })
    $(function() {
        driver_list();
    });

    function driver_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/master/driver/list",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'>Tidak ada data</td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_DRIVER_NAMA + "</td>" +
                            "<td>" + data[i].MASTER_DRIVER_ALAMAT + "</td>" +
                            "<td>" + data[i].MASTER_DRIVER_HP + "</td>" +
                            "<td>" + data[i].MASTER_DRIVER_SIM + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].MASTER_DRIVER_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='detail(\"" + data[i].MASTER_DRIVER_ID + "\")'><i class='fas fa-edit'></i></a></td>" +
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
            url: '<?php echo base_url(); ?>index.php/master/driver/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                driver_list();
                Swal.fire('Berhasil', 'Driver berhasil ditambahkan', 'success')
                $("#driverModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/master/driver/hapus/' + id,
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            driver_list();
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
        Swal.fire({
            title: 'Edit ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Edit`,
            denyButtonText: `Batal`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'ajax',
                    url: '<?php echo base_url() ?>index.php/master/driver/detail/' + id,
                    async: false,
                    dataType: 'json',
                    success: function(data) {
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
        })
    }
</script>