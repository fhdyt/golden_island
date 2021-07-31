<div class="modal fade" id="tangkiModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Tangki</h4>
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
                        <label for="exampleInputEmail1">Jenis Tangki</label>
                        <select name="tangki" id="tangki" class="form-control tangki select2" style="width: 100%;">
                            <option value="">-- Jenis --</option>
                            <?php foreach (tangki() as $row) {
                            ?>
                                <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Tangki</label>
                        <input type="text" class="form-control kode" name="kode" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Satuan</label>
                        <select name="satuan" id="satuan" class="form-control satuan select2" style="width: 100%;">
                            <option value="">-- Satuan --</option>
                            <?php foreach (satuan() as $row) {
                            ?>
                                <option value="<?= $row->SATUAN_NAMA; ?>"><?= $row->SATUAN_NAMA; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Lokasi</label>
                        <input type="text" class="form-control lokasi" name="lokasi" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kapasitas</label>
                        <input type="text" class="form-control kapasitas" name="kapasitas" autocomplete="off">
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
                    <h1 class="m-0"><?= $this->lang->line('TAngki'); ?></h1>
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
                    <button type="button" class="btn btn-secondary btn_tangki mb-2">Tambah Tangki</button>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('kode'); ?></th>
                                <th>Jenis Barang</th>
                                <th>Lokasi</th>
                                <th>Kapasitas</th>
                                <th>Sisa</th>
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
    $(".btn_tangki").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $(".tangki").val("").trigger("change")
        $("#tangkiModal").modal("show")
    })
    $(function() {
        tangki_list();
    });

    function tangki_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/master/tangki/list",
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
                        var persentase = data[i].TOTAL / data[i].MASTER_TANGKI_KAPASITAS * 100
                        if (persentase < 30) {
                            var warna_persentase = "danger"
                        } else {
                            var warna_persentase = "success"
                        }
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_TANGKI_KODE + "<br><span class='description-percentage text-" + warna_persentase + "'> " + persentase + "%</span></td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + data[i].MASTER_TANGKI_LOKASI + "</td>" +
                            "<td>" + data[i].MASTER_TANGKI_KAPASITAS + " " + data[i].MASTER_TANGKI_SATUAN + "</td>" +
                            "<td>" + data[i].TOTAL + " " + data[i].MASTER_TANGKI_SATUAN + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].MASTER_TANGKI_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='detail(\"" + data[i].MASTER_TANGKI_ID + "\")'><i class='fas fa-edit'></i></a></td>" +
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
            url: '<?php echo base_url(); ?>index.php/master/tangki/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                tangki_list();
                Swal.fire('Berhasil', 'Tangki berhasil ditambahkan', 'success')
                $("#tangkiModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/master/tangki/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            tangki_list();
                            Swal.fire('Berhasil', 'Tangki Berhasil dihapus', 'success')
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
            url: '<?php echo base_url() ?>index.php/master/tangki/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $(".id").val(data[0].MASTER_TANGKI_ID)
                $(".kode").val(data[0].MASTER_TANGKI_KODE)
                $(".lokasi").val(data[0].MASTER_TANGKI_LOKASI)
                $(".satuan").val(data[0].MASTER_TANGKI_SATUAN).trigger("change")
                $(".kapasitas").val(data[0].MASTER_TANGKI_KAPASITAS)
                $(".tangki").val(data[0].MASTER_BARANG_ID).trigger('change')

                $("#tangkiModal").modal("show")
            },
            error: function(x, e) {} //end error
        });
    }
</script>