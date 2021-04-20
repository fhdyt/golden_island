<!-- /.modal -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Akses Menu</h1>
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
                        <div class="col-12">
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
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Aplikasi</th>
                                <th>Menu</th>
                                <th>Aplikasi</th>
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
    $(".btn_user").on("click", function() {
        $("#submit").trigger("reset");
        $("#userModal").modal("show")
    })
    $(function() {
        menu_list();
    });

    function menu_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/sistem/user/menu_list/<?php echo $this->uri->segment('4'); ?>?menu_filter=" + $(".menu_filter").val(),
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {} else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        if (data[i].STATUS == "AKTIF") {
                            var tr = "table-success"
                        } else {
                            var tr = "table-default"
                        }
                        $("tbody#zone_data").append("<tr class='" + tr + "'>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].APLIKASI_NAMA + "</td>" +
                            "<td>" + data[i].MENU_NAMA + "</td>" +
                            "<td>" + data[i].MENU_LINK + "</td>" +
                            "<td><a class='btn btn-primary btn-sm' onclick='akses(\"" + data[i].MENU_ID + "\")'><i class='fas fa-thumbs-up'></i></a></td>" +
                            "</tr>");
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    // function aplikasi_list() {
    //     $.ajax({
    //         type: 'ajax',
    //         url: "<?php echo base_url() ?>index.php/sistem/aplikasi/list",
    //         async: false,
    //         dataType: 'json',
    //         success: function(data) {
    //             $("#aplikasi").empty();
    //             if (data.length === 0) {} else {
    //                 for (i = 0; i < data.length; i++) {
    //                     $("#aplikasi").append("<option value='" + data[i].APLIKASI_LINK + "'>" + data[i].APLIKASI_NAMA + "</option>");
    //                 }
    //             }
    //         },
    //         error: function(x, e) {
    //             console.log("Gagal")
    //         }
    //     });
    // }

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/sistem/user/add',
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
                Swal.fire('Berhasil', 'User berhasil ditambahkan', 'success')
                $("#userModal").modal("hide")
            }
        });
    })

    function akses(menu_id) {
        console.log(menu_id)
        Swal.fire({
            title: 'Ganti akses Menu ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Hapus`,
            denyButtonText: `Batal`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'ajax',
                    url: '<?php echo base_url() ?>index.php/sistem/user/akses_menu/<?php echo $this->uri->segment('4'); ?>/' + menu_id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            menu_list();
                            Swal.fire('Berhasil', 'User Berhasil dihapus', 'success')
                        }
                    },
                    error: function(x, e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Proses Gagal'
                        })
                        console.log(e)
                    } //end error
                });

            }
        })
    }

    $('#menu_filter').change(function() {
        memuat()
        menu_list()
    });
</script>