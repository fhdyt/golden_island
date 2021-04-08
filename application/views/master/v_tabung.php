<div class="modal fade" id="tabungModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Tabung</h4>
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
                        <label for="exampleInputEmail1">Kode Tabung</label>
                        <input type="text" class="form-control kode" name="kode" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nomor Surat Pembelian</label>
                        <select name="surat" id="surat" class="form-control surat">
                            <option value="">--Pilih Nomor Surat--</option>
                            <?php foreach ($pembelian_jenis_gas as $row) {
                            ?>
                                <option value="<?= $row->PEMBELIAN_NOMOR_SURAT; ?>"><?= $row->PEMBELIAN_NOMOR_SURAT; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis</label>
                        <select name="jenis_barang" id="jenis_barang" class="form-control jenis_barang">
                            <option value="">--Pilih Jenis Barang--</option>
                            <?php foreach ($jenis_barang as $row) {
                            ?>
                                <option value="<?= $row->MASTER_JENIS_BARANG_DETAIL_ID; ?>"><?= $row->MASTER_JENIS_BARANG_NAMA; ?> - <?= $row->MASTER_JENIS_BARANG_DETAIL_KAPASITAS; ?> <?= $row->MASTER_JENIS_BARANG_DETAIL_SATUAN; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-group clearfix">
                            <div class="icheck-primary">
                                <input type="checkbox" id="isi" name="isi">
                                <label for="isi">
                                    ISI
                                </label>
                            </div>
                        </div>
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
                    <h1 class="m-0">Tabung</h1>
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
                    <button type="button" class="btn btn-secondary btn_tabung mb-2">Tambah Tabung</button>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode Tabung</th>
                                <th>Surat Nomor</th>
                                <th>Jenis Barang</th>
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
    $(".btn_tabung").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#tabungModal").modal("show")
    })

    $(function() {
        tabung_list();
    });

    function tabung_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/master/tabung/list",
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
                            "<td>" + data[i].MASTER_TABUNG_KODE + "</td>" +
                            "<td>" + data[i].PEMBELIAN_NOMOR_SURAT + "</td>" +
                            "<td>" + data[i].JENIS[0].MASTER_JENIS_BARANG_NAMA + " (" + data[i].JENIS[0].MASTER_JENIS_BARANG_DETAIL_KAPASITAS + " " + data[i].JENIS[0].MASTER_JENIS_BARANG_DETAIL_SATUAN + ")</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].MASTER_TABUNG_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='detail(\"" + data[i].MASTER_TABUNG_ID + "\")'><i class='fas fa-edit'></i></a></td>" +
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
            url: '<?php echo base_url(); ?>index.php/master/tabung/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                tabung_list();
                Swal.fire('Berhasil', 'Tabung berhasil ditambahkan', 'success')
                $("#tabungModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/master/tabung/hapus/' + id,
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            tabung_list();
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
                    url: '<?php echo base_url() ?>index.php/master/tabung/detail/' + id,
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        $(".id").val(data[0].MASTER_TABUNG_ID)
                        $(".kode").val(data[0].MASTER_TABUNG_KODE)
                        $(".surat").val(data[0].PEMBELIAN_NOMOR_SURAT)
                        $(".jenis_barang").val(data[0].MASTER_JENIS_BARANG_DETAIL_ID)

                        $("#tabungModal").modal("show")
                    },
                    error: function(x, e) {} //end error
                });

            }
        })
    }
</script>