<style>
    .table {
        font-size: small;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Produksi</h1>
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
                        <div class="col-md-5">
                            <a href="<?= base_url(); ?>produksi/produksi/form_selesai" class="btn btn-secondary mb-2 btn-form mr-2">Tambah Produksi</a>
                            <a href="<?= base_url(); ?>cetak/form_produksi" target="_blank" class="btn btn-success mb-2 btn-form mr-2">Cetak Form Produksi</a>
                        </div>
                        <div class="col-md-3">
                            <select name="bulan" id="bulan" class="form-control select2 bulan" style="width: 100%;">
                                <?php
                                foreach (bulan() as $value => $text) {
                                    if ($value == date("m")) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                ?>
                                    <option value="<?= $value; ?>" <?= $select; ?>><?= $text; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="tahun" id="tahun" class="form-control select2 tahun" style="width: 100%;">
                                <?php
                                foreach (tahun() as $value => $text) {
                                    if ($value == date("Y")) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                ?>
                                    <option value="<?= $value; ?>" <?= $select; ?>><?= $text; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-success filter_tanggal"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Produksi</th>
                                <th>Tanggal</th>
                                <th>Jenis Bahan</th>
                                <th>Level Awal <small class="text-muted">Kg</small></th>
                                <th>Level Akhir <small class="text-muted">Kg</small></th>
                                <th>G/L <small class="text-muted">M3</small></th>
                                <th>Terpakai <small class="text-muted">M3</small></th>
                                <th>Total Produksi <small class="text-muted">Tabung</small></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                            </tr>
                        </tbody>
                        <tbody id="zone_data_total">
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
    $(".btn_pajak").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#pajakModal").modal("show")
    })
    $(function() {
        produksi_list();
    });

    function produksi_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/produksi/produksi/list",
            async: false,
            dataType: 'json',
            data: {
                bulan: $(".bulan").val(),
                tahun: $(".tahun").val()
            },
            success: function(data) {
                $("tbody#zone_data").empty();
                $("tbody#zone_data_total").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var total_gl = 0
                    var total_tabung = 0
                    var total_terpakai = 0
                    for (i = 0; i < data.length; i++) {
                        if (data[i].PRODUKSI_G_L == null) {
                            var g_l = "-"
                        } else {
                            var g_l = data[i].PRODUKSI_G_L
                        }
                        if (data[i].PRODUKSI_LEVEL_AKHIR == null) {
                            var level_akhir = "-"
                        } else {
                            var level_akhir = data[i].PRODUKSI_LEVEL_AKHIR
                        }
                        if (data[i].PRODUKSI_LEVEL_TERPAKAI == null) {
                            var level_terpakai = "-"
                        } else {
                            var level_terpakai = data[i].PRODUKSI_LEVEL_TERPAKAI
                        }

                        total_gl += parseInt(data[i].PRODUKSI_G_L)
                        total_terpakai += parseInt(data[i].PRODUKSI_LEVEL_TERPAKAI)
                        total_tabung += parseInt(data[i].TOTAL)
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].PRODUKSI_NOMOR + "</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + data[i].PRODUKSI_LEVEL_AWAL + "</td>" +
                            "<td>" + level_akhir + "</td>" +
                            "<td>" + g_l + "</td>" +
                            "<td>" + level_terpakai + "</td>" +
                            "<td>" + data[i].TOTAL + "</td>" +
                            "<td><a class='btn btn-primary btn-sm mr-2 ' href='<?= base_url(); ?>produksi/produksi/form_selesai/" + data[i].PRODUKSI_ID + "/'>Lihat</a> " +
                            "</td>" +
                            "</tr>");
                    }
                    $("tbody#zone_data_total").append('<tr><td colspan="6" style="text-align:right">Total</td><td>' + total_gl + '</td><td>' + total_terpakai + '</td><td>' + total_tabung + '</td><td></td></tr>')
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
            url: '<?php echo base_url(); ?>index.php/konfigurasi/pajak/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                produksi_list();
                Swal.fire('Berhasil', 'Pajak berhasil ditambahkan', 'success')
                $("#pajakModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/konfigurasi/pajak/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            produksi_list();
                            Swal.fire('Berhasil', 'Pajak Berhasil dihapus', 'success')
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
            url: '<?php echo base_url() ?>index.php/konfigurasi/pajak/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $(".id").val(data[0].PAJAK_ID)
                $(".nama").val(data[0].PAJAK_NAMA)
                $(".nilai").val(data[0].PAJAK_NILAI)

                $("#pajakModal").modal("show")
            },
            error: function(x, e) {} //end error
        });
    }

    $('.filter_tanggal').on("click", function() {
        memuat()
        produksi_list()
    });
</script>