<div class="modal fade" id="barangModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Jenis Barang</h4>
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
                        <label for="exampleInputEmail1">Jenis</label>
                        <select name="jenis" id="jenis" class="form-control jenis select2" style="width: 100%;">

                            <?php
                            foreach (jenis_barang() as $value => $text) {
                            ?>
                                <option value="<?= $value; ?>"><?= $text; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <small class="text-muted">*Wajib diisi.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama</label>
                        <input type="text" class="form-control nama" name="nama" autocomplete="off">
                        <small class="text-muted">*Wajib diisi.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control keterangan"></textarea>
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
                    <h1 class="m-0">Barang</h1>
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
                        <div class="col-6">
                            <button type="button" class="btn btn-secondary btn_barang mb-2">Tambah Barang</button>
                        </div>
                        <div class="col-6">
                            <select name="jenis_filter" id="jenis_filter" class="form-control jenis_filter select2" style="width: 100%;">
                                <option value="">Semua</option>

                                <?php
                                foreach (jenis_barang() as $value => $text) {
                                ?>
                                    <option value="<?= $value; ?>"><?= $text; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <small class="text-muted">Jenis Barang</small>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                                <td colspan="9">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <!-- <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div> -->
            </div>

        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(".btn_barang").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#barangModal").modal("show")
    })
    $(function() {
        barang_list();
    });

    function barang_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/master/barang/list?jenis=" + $(".jenis_filter").val(),
            async: false,
            dataType: 'json',
            success: function(data) {
                memuat()
                $("tbody#zone_data").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'>Tidak ada data</td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + data[i].MASTER_BARANG_JENIS + "</td>" +
                            "<td>" + data[i].MASTER_BARANG_KETERANGAN + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].MASTER_BARANG_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='detail(\"" + data[i].MASTER_BARANG_ID + "\")'><i class='fas fa-edit'></i></a> " +
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
            url: '<?php echo base_url(); ?>index.php/master/barang/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                barang_list();
                Swal.fire('Berhasil', 'Jenis Barang berhasil ditambahkan', 'success')
                $("#barangModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/master/barang/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            barang_list();
                            Swal.fire('Berhasil', 'Jenis Barang Berhasil dihapus', 'success')
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
            url: '<?php echo base_url() ?>index.php/master/barang/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $("#barangModal").modal("show")
                $(".jenis").val(data[0].MASTER_BARANG_JENIS).trigger('change')
                $(".id").val(data[0].MASTER_BARANG_ID)
                $(".nama").val(data[0].MASTER_BARANG_NAMA)


            },
            error: function(x, e) {} //end error
        });
    }

    $('#jenis_filter').change(function() {
        memuat()
        barang_list()
    });
</script>