<div class="modal fade" id="menuModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Menu</h4>
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
                        <label for="exampleInputEmail1">Aplikasi</label>
                        <select name="aplikasi" id="aplikasi" class="form-control select2 aplikasi" style="width: 100%;">

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= $this->lang->line('nama'); ?></label>
                        <input type="text" class="form-control nama" name="nama" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Link</label>
                        <input type="text" class="form-control link" name="link" value="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Icon</label>
                        <input type="text" class="form-control icon" name="icon" value="" autocomplete="off">
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
                    <h1 class="m-0">Menu</h1>
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
                        <div class="col-6">
                            <button type="button" class="btn btn-secondary btn_menu mb-2">Tambah Menu</button>
                        </div>
                        <div class="col-6">
                            <select name="menu_filter" id="menu_filter" class="form-control menu_filter select2" style="width: 100%;">
                                <option value=""><?= $this->lang->line('semua'); ?></option>

                                <?php
                                foreach ($aplikasi as $row) {
                                ?>
                                    <option value="<?= $row->APLIKASI_ID; ?>"><?= $row->APLIKASI_NAMA; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <small class="text-muted"></small>
                        </div>
                    </div>

                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Aplikasi</th>
                                <th><?= $this->lang->line('nama'); ?></th>
                                <th>Link</th>
                                <th>Icon</th>
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
    $(".btn_menu").on("click", function() {
        $("#submit").trigger("reset");
        $("#menuModal").modal("show")
    })
    $(function() {
        menu_list();
        aplikasi_list()
    });

    function menu_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/sistem/menu/list?menu_filter=" + $(".menu_filter").val(),
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                if (data.length === 0) {} else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].APLIKASI_NAMA + "</td>" +
                            "<td>" + data[i].MENU_NAMA + "</td>" +
                            "<td>" + data[i].MENU_LINK + "</td>" +
                            "<td>" + data[i].MENU_ICON + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].MENU_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='detail(\"" + data[i].MENU_ID + "\")'><i class='fas fa-edit'></i></a></td>" +
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
            url: '<?php echo base_url(); ?>index.php/sistem/menu/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                menu_list();
                Swal.fire('Berhasil', 'Menu berhasil ditambahkan', 'success')
                $("#menuModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/sistem/menu/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            menu_list();
                            Swal.fire('Berhasil', 'Menu Berhasil dihapus', 'success')
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
            url: '<?php echo base_url() ?>index.php/sistem/menu/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                console.log(id)
                memuat()
                $(".id").val(data[0].MENU_ID)
                $(".aplikasi").val(data[0].APLIKASI_ID).trigger("change")
                $(".nama").val(data[0].MENU_NAMA)
                $(".link").val(data[0].MENU_LINK)
                $(".icon").val(data[0].MENU_ICON)

                $("#menuModal").modal("show")
            },
            error: function(x, e) {} //end error
        });
    }

    $('#menu_filter').change(function() {
        memuat()
        menu_list()
    });
</script>