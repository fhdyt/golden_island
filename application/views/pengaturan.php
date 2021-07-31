<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Pengaturan</h1>
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
                        <div class="col-5 col-sm-3">
                            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Ganti Password</a>
                                <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Foto Profil</a>
                                <!-- <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Messages</a>
                                <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings" aria-selected="false">Settings</a> -->
                            </div>
                        </div>
                        <div class="col-7 col-sm-9">
                            <div class="tab-content" id="vert-tabs-tabContent">
                                <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                    <form id="submit">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Passsword Baru</label>
                                                    <input type="password" class="form-control password_baru" name="password_baru" onkeyup="check_password()">
                                                </div>
                                                <!-- /.form-group -->
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Konfirmasi Password Baru</label>
                                                    <input type="password" class="form-control" name="konfirmasi_password_baru" id="konfirmasi_password_baru" onkeyup="check_password()">
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        Password tidak sesuai.
                                                    </div>
                                                    <div class="valid-feedback">
                                                        Password Sesuai.
                                                    </div>
                                                </div>
                                                <!-- /.form-group -->
                                            </div>
                                            <!-- /.col -->
                                            <!-- /.col -->
                                        </div>
                                        <button type="submit" class="btn btn-secondary change_password">Simpan</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                                    <form id="foto_profil">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="file" name="userfile" class="form-control userfile" required>
                                                </div>
                                                <!-- /.form-group -->
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-secondary change_password">Simpan</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">

                                </div>
                                <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel" aria-labelledby="vert-tabs-settings-tab">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<script>
    $(function() {
        memuat()
    })

    function check_password() {
        var password = $('.password_baru').val()
        var password_confirm = $('#konfirmasi_password_baru').val()
        if (password == password_confirm) {
            console.log("Sukses")
            $('.change_password').attr('disabled', false)
            $('#konfirmasi_password_baru').attr('class', 'form-control is-valid')

        } else {
            console.log("Password tidak sama")
            $('.change_password').attr('disabled', true)
            $('#konfirmasi_password_baru').attr('class', 'form-control is-invalid')
        }
    }

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/sistem/user/ganti_password',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                memuat()
                Swal.fire('Berhasil', 'Password berhasil diganti', 'success')
            }
        });
    })
    $('#foto_profil').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/sistem/user/foto_profil',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                memuat()
                Swal.fire('Berhasil', 'Foto Berhasil', 'success')
            }
        });
    })
</script>