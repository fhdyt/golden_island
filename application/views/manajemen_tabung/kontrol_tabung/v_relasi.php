<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Relasi Kontrol Tabung</h1>
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
                        <div class="col-md-4">
                            <a href="<?= base_url(); ?>manajemen_tabung/kontrol_tabung/form" class="btn btn-block btn-secondary mb-2 btn-form mr-2">Tambah Saldo Kontrol Tabung</a>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control nama_relasi" name="nama_relasi" autocomplete="off" placeholder="Nama Relasi">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary filter"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>


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
    $(".btn_relasi").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#relasiModal").modal("show")
    })
    $(function() {
        relasi_list();
    });

    $(".filter").on("click", function() {
        memuat()
        relasi_list();
    })

    $('.nama_relasi').keyup(function(e) {
        if (e.keyCode == 13) {
            memuat()
            relasi_list()
        }
    });

    function relasi_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/manajemen_tabung/kontrol_tabung/relasi_list",
            async: false,
            dataType: 'json',
            data: {
                nama_relasi: $(".nama_relasi").val()
            },
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
                            "<td>" + data[i].MASTER_RELASI_NAMA + "</td>" +
                            "<td>" + data[i].MASTER_RELASI_ALAMAT + "</td>" +
                            "<td>" + data[i].MASTER_RELASI_HP + "</td>" +
                            "<td>" +
                            "<a class='btn btn-secondary btn-sm mb-2' href='<?php echo base_url(); ?>manajemen_tabung/kontrol_tabung/detail/" + data[i].MASTER_RELASI_ID + "'><i class='fas fa-vial'></i> Tabung</a></td>" +
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
            url: '<?php echo base_url(); ?>index.php/master/relasi/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                relasi_list();
                Swal.fire('Berhasil', 'Relasi berhasil ditambahkan', 'success')
                $("#relasiModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/master/relasi/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            relasi_list();
                            Swal.fire('Berhasil', 'Relasi Berhasil dihapus', 'success')
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
            url: '<?php echo base_url() ?>index.php/master/relasi/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $(".id").val(data[0].MASTER_RELASI_ID)
                $(".nama").val(data[0].MASTER_RELASI_NAMA)
                $(".alamat").val(data[0].MASTER_RELASI_ALAMAT)
                $(".hp").val(data[0].MASTER_RELASI_HP)
                $(".npwp").val(data[0].MASTER_RELASI_NPWP)
                $(".ktp").val(data[0].MASTER_RELASI_KTP)

                $("#relasiModal").modal("show")
            },
            error: function(x, e) {} //end error
        });
    }
</script>