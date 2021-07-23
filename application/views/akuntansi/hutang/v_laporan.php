<style>
    .table {
        font-size: 13px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Laporan Hutang Bulanan</h1>
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
                        <div class="col-md-2">
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
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="form-control nama_supllier" name="nama_supllier" autocomplete="off" placeholder="Nama Relasi">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary filter"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <table id="example2" class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align:center; vertical-align:middle">No.</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle"><?= $this->lang->line('nama'); ?></th>
                                <th style="text-align:center; vertical-align:middle" colspan="12">Bulan</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle">Total</th>
                            </tr>
                            <tr>
                                <th>Januari</th>
                                <th>Februari</th>
                                <th>Maret</th>
                                <th>April</th>
                                <th>Mei</th>
                                <th>Juni</th>
                                <th>Juli</th>
                                <th>Agustus</th>
                                <th>September</th>
                                <th>Oktober</th>
                                <th>November</th>
                                <th>Desember</th>
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
            url: "<?php echo base_url() ?>index.php/akuntansi/hutang/laporan_list",
            async: false,
            dataType: 'json',
            data: {
                nama_supplier: $(".nama_supplier").val(),
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
                    var total_januari = 0
                    var total_februari = 0
                    var total_maret = 0
                    var total_april = 0
                    var total_mei = 0
                    var total_juni = 0
                    var total_juli = 0
                    var total_agustus = 0
                    var total_september = 0
                    var total_oktober = 0
                    var total_november = 0
                    var total_desember = 0
                    var total = 0
                    data = jQuery.grep(data, function(value) {
                        return value.TOTAL != "0";
                    });
                    for (i = 0; i < data.length; i++) {
                        total_januari += parseInt(data[i].Januari)
                        total_februari += parseInt(data[i].Februari)
                        total_maret += parseInt(data[i].Maret)
                        total_april += parseInt(data[i].April)
                        total_mei += parseInt(data[i].Mei)
                        total_juni += parseInt(data[i].Juni)
                        total_juli += parseInt(data[i].Juli)
                        total_agustus += parseInt(data[i].Agustus)
                        total_september += parseInt(data[i].September)
                        total_oktober += parseInt(data[i].Oktober)
                        total_november += parseInt(data[i].November)
                        total_desember += parseInt(data[i].Desember)
                        total += parseInt(data[i].TOTAL)
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_SUPPLIER_NAMA + "</td>" +
                            "<td>" + number_format(data[i].Januari) + "</td>" +
                            "<td>" + number_format(data[i].Februari) + "</td>" +
                            "<td>" + number_format(data[i].Maret) + "</td>" +
                            "<td>" + number_format(data[i].April) + "</td>" +
                            "<td>" + number_format(data[i].Mei) + "</td>" +
                            "<td>" + number_format(data[i].Juni) + "</td>" +
                            "<td>" + number_format(data[i].Juli) + "</td>" +
                            "<td>" + number_format(data[i].Agustus) + "</td>" +
                            "<td>" + number_format(data[i].September) + "</td>" +
                            "<td>" + number_format(data[i].Oktober) + "</td>" +
                            "<td>" + number_format(data[i].November) + "</td>" +
                            "<td>" + number_format(data[i].Desember) + "</td>" +
                            "<td>" + number_format(data[i].TOTAL) + "</td>" +
                            "</tr>");
                    }
                    $("tbody#zone_data").append("<tr class=''>" +
                        "<td colspan='2' style='text-align:right'><b>Total</b></td>" +
                        "<td>" + number_format(total_januari) + "</td>" +
                        "<td>" + number_format(total_februari) + "</td>" +
                        "<td>" + number_format(total_maret) + "</td>" +
                        "<td>" + number_format(total_april) + "</td>" +
                        "<td>" + number_format(total_mei) + "</td>" +
                        "<td>" + number_format(total_juni) + "</td>" +
                        "<td>" + number_format(total_juli) + "</td>" +
                        "<td>" + number_format(total_agustus) + "</td>" +
                        "<td>" + number_format(total_september) + "</td>" +
                        "<td>" + number_format(total_oktober) + "</td>" +
                        "<td>" + number_format(total_november) + "</td>" +
                        "<td>" + number_format(total_desember) + "</td>" +
                        "<td>" + number_format(total) + "</td>" +
                        "</tr>");
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
                $(".qr_id").val(data[0].MASTER_RELASI_QR_ID)
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