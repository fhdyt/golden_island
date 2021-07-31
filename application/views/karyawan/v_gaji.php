<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Karyawan'); ?></h1>
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                    </div>
                    <hr>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('nama'); ?></th>
                                <th>Jabatan</th>
                                <th>Total Gaji</th>
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
    $(".btn_karyawan").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $(".jabatan").val("").trigger("change")
        $("#karyawanModal").modal("show")
    })
    $(function() {
        $(".gaji").mask("#.##0", {
            reverse: true
        });
        karyawan_list();
    });

    function karyawan_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/karyawan/gaji/list",
            async: false,
            dataType: 'json',
            data: {
                bulan: $(".bulan").val(),
                tahun: $(".tahun").val()
            },
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var total_seluruh = 0
                    for (i = 0; i < data.length; i++) {
                        if (data[i].GAJI.length === 0) {
                            var total_gaji = 0
                            var btn_gaji = "<a class='mr-2 btn btn-primary btn-sm' href='<?= base_url(); ?>karyawan/gaji/gaji/" + data[i].MASTER_KARYAWAN_ID + "?bulan=" + $(".bulan").val() + "&tahun=" + $(".tahun").val() + "'><i class='fas fa-calculator'></i> Perhitungan</a>"
                        } else {
                            var total_gaji = data[i].GAJI[0].GAJI_TOTAL
                            var btn_gaji = "<a class='mr-2 btn btn-success btn-sm' href='<?= base_url(); ?>cetak/cetak_gaji/" + data[i].MASTER_KARYAWAN_ID + "?bulan=" + $(".bulan").val() + "&tahun=" + $(".tahun").val() + "'><i class='fas fa-print'></i> Cetak</a></td>"
                        }


                        total_seluruh += parseInt(total_gaji)
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_KARYAWAN_NAMA + "</td>" +
                            "<td>" + data[i].MASTER_KARYAWAN_JABATAN + "</td>" +
                            "<td>Rp. " + number_format(total_gaji) + "</td>" +
                            "<td> " +
                            btn_gaji +
                            "</tr>");
                    }
                    $("tbody#zone_data").append("<tr><td colspan='3'style='text-align:right'>Total</td><td>Rp. " + number_format(total_seluruh) + "</td></tr>")
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
            url: '<?php echo base_url(); ?>index.php/master/karyawan/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                karyawan_list();
                Swal.fire('Berhasil', 'Karyawan berhasil ditambahkan', 'success')
                $("#karyawanModal").modal("hide")
            }
        });
    })

    $('.bulan, .tahun').change(function() {
        memuat()
        karyawan_list()
    });
</script>