<div class="modal fade" id="supplierModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Supplier</h4>
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
                        <input type="text" class="form-control nama" name="nama" autocomplete="off">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= $this->lang->line('alamat'); ?></label>
                        <input type="text" class="form-control alamat" name="alamat" autocomplete="off">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">No. HP</label>
                        <input type="text" class="form-control hp" name="hp" autocomplete="off">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">NPWP</label>
                        <input type="text" class="form-control npwp" name="npwp" autocomplete="off">
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
                    <h1 class="m-0"><?= $this->lang->line('supplier'); ?></h1>
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
                    <button type="button" class="btn btn-secondary btn_supplier mb-2">Tambah Supplier</button>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('nama'); ?></th>
                                <th><?= $this->lang->line('alamat'); ?></th>
                                <th>No. HP</th>
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
    $(".btn_supplier").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#supplierModal").modal("show")
    })
    $(function() {
        supplier_list();
    });

    function supplier_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/master/supplier/list",
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
                            "<td>" + data[i].MASTER_SUPPLIER_NAMA + "</td>" +
                            "<td>" + data[i].MASTER_SUPPLIER_ALAMAT + "</td>" +
                            "<td>" + data[i].MASTER_SUPPLIER_HP + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].MASTER_SUPPLIER_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='detail(\"" + data[i].MASTER_SUPPLIER_ID + "\")'><i class='fas fa-edit'></i></a> " +
                            "</tr>");
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    // $("form#submit").on("submit", function(e) {

    //     console.log($(this).serialize())
    // })

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/master/supplier/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                supplier_list();
                Swal.fire('Berhasil', 'Supplier berhasil ditambahkan', 'success')
                $("#supplierModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/master/supplier/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            supplier_list();
                            Swal.fire('Berhasil', 'Supplier Berhasil dihapus', 'success')
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
            url: '<?php echo base_url() ?>index.php/master/supplier/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $(".id").val(data[0].MASTER_SUPPLIER_ID)
                $(".nama").val(data[0].MASTER_SUPPLIER_NAMA)
                $(".alamat").val(data[0].MASTER_SUPPLIER_ALAMAT)
                $(".hp").val(data[0].MASTER_SUPPLIER_HP)
                $(".npwp").val(data[0].MASTER_SUPPLIER_NPWP)

                $("#supplierModal").modal("show")
            },
            error: function(x, e) {} //end error
        });
    }
</script>