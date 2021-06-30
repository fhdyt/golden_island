<?php
if (empty($this->uri->segment('4'))) {
    $id = create_id();
} else {
    $id = $this->uri->segment('4');
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h1 class="m-0">Konfigurasi Gaji</h1>

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
                        <div class="col-md-12">
                            <form id="submit">
                                <input type="hidden" class="form-control id" name="id" value="<?= $id; ?>" autocomplete="off">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Gaji Pokok</label>
                                            <input type="text" class="form-control gaji_pokok" name="gaji_pokok" autocomplete="off" value="0" required onkeyup="kalkulasi_total()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tunjangan Jabatan</label>
                                            <input type="text" class="form-control tunjangan_jabatan" name="tunjangan_jabatan" autocomplete="off" value="0" required onkeyup="kalkulasi_total()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tunjangan Transportasi</label>
                                            <input type="text" class="form-control tunjangan_transportasi" name="tunjangan_transportasi" autocomplete="off" value="0" required onkeyup="kalkulasi_total()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tunjangan Komunikasi</label>
                                            <input type="text" class="form-control tunjangan_komunikasi" name="tunjangan_komunikasi" autocomplete="off" value="0" required onkeyup="kalkulasi_total()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Uang Makan</label>
                                            <input type="text" class="form-control uang_makan" name="uang_makan" autocomplete="off" value="0" required onkeyup="kalkulasi_total()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Persentase Premi Penjualan</label>
                                            <input type="text" class="form-control persentase_premi" name="persentase_premi" autocomplete="off" value="0" required onkeyup="kalkulasi_total()">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Total</label>
                                            <input type="text" class="form-control form-control-lg total" name="total" autocomplete="off" value="0" required>
                                        </div>
                                    </div>
                                </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-default color-palette-box">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success btn-lg"><?= $this->lang->line('simpan'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    $(function() {
        $(".gaji_pokok").mask("#.##0", {
            reverse: true
        });
        $(".tunjangan_jabatan").mask("#.##0", {
            reverse: true
        });
        $(".tunjangan_jabatan").mask("#.##0", {
            reverse: true
        });
        $(".tunjangan_komunikasi").mask("#.##0", {
            reverse: true
        });
        $(".tunjangan_transportasi").mask("#.##0", {
            reverse: true
        });
        $(".uang_makan").mask("#.##0", {
            reverse: true
        });
        $(".persentase_premi").mask("#.##0", {
            reverse: true
        });
        detail()
        // detail()
        // surat_jalan_list()
        // barang_list()
    });

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/karyawan/gaji/add_konfigurasi',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                Swal.fire('Berhasil', 'Berhasil ditambahkan', 'success')
            }
        });
    })

    function detail(id) {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/karyawan/gaji/detail_konfigurasi/<?= $id; ?>',
            dataType: 'json',
            success: function(data) {
                memuat()
                $(".gaji_pokok").val(number_format(data[0].GAJI_KONFIGURASI_POKOK))
                $(".tunjangan_jabatan").val(number_format(data[0].GAJI_KONFIGURASI_JABATAN))
                $(".tunjangan_transportasi").val(number_format(data[0].GAJI_KONFIGURASI_TRANSPORTASI))
                $(".tunjangan_komunikasi").val(number_format(data[0].GAJI_KONFIGURASI_KOMUNIKASI))
                $(".uang_makan").val(number_format(data[0].GAJI_KONFIGURASI_UANG_MAKAN))
                $(".persentase_premi").val(number_format(data[0].GAJI_KONFIGURASI_PERSENTASE_PREMI))
                kalkulasi_total()
            },
            error: function(x, e) {} //end error
        });
    }

    function kalkulasi_total() {
        var gaji_pokok = parseInt($(".gaji_pokok").val().split('.').join(""))
        var tunjangan_jabatan = parseInt($(".tunjangan_jabatan").val().split('.').join(""))
        var tunjangan_transportasi = parseInt($(".tunjangan_transportasi").val().split('.').join(""))
        var tunjangan_komunikasi = parseInt($(".tunjangan_komunikasi").val().split('.').join(""))
        var uang_makan = parseInt($(".uang_makan").val().split('.').join(""))
        var persentase_premi = parseInt($(".persentase_premi").val().split('.').join(""))
        var total = gaji_pokok + tunjangan_jabatan + tunjangan_transportasi + tunjangan_komunikasi + uang_makan
        $(".total").val(number_format(total))
    }
</script>