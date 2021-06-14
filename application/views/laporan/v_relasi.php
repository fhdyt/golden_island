<style>
    .table {
        font-size: 10px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Relasi'); ?></h1>
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
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control nama_relasi" name="nama_relasi" autocomplete="off" placeholder="Nama Relasi">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary filter"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <table id="example2" class="table table-bordered table-striped table-responsive">
                        <thead id="zone_header">
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('nama'); ?></th>
                                <th><?= $this->lang->line('alamat'); ?></th>
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

    function pad(str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

    function relasi_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/laporan/relasi/list",
            async: false,
            dataType: 'json',
            data: {
                bulan: $(".bulan").val(),
                tahun: $(".tahun").val(),
                nama_relasi: $(".nama_relasi").val()
            },
            success: function(data) {
                $("tbody#zone_data").empty();
                $("thead#zone_header").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var theader = ""
                    var tbody = ""
                    for (i = 0; i < data.length; i++) {
                        if (data[i].SELISIH_TANGGAL.length == 0) {
                            var selisih_tanggal = "-"
                        } else {
                            var selisih_tanggal = data[i].SELISIH_TANGGAL
                        }
                        if (data[i].SURAT_JALAN_TERAKHIR.length == 0) {
                            var tanggal_sj = "-"
                        } else {
                            var tanggal_sj = data[i].SURAT_JALAN_TERAKHIR
                        }

                        if (data[i].MASTER_RELASI_HP == "") {
                            var hp = "-"
                        } else {
                            var hp = data[i].MASTER_RELASI_HP
                        }

                        tbody += "<tr>"
                        tbody += "<td>" + no++ + ".</td>" +
                            "<td><b>" + data[i].MASTER_RELASI_NAMA + "</b><br><p class='text-success'>" + data[i].MASTER_RELASI_QR_ID + "</p><small class='text-muted'>Pemesanan Terakhir :<br> " + selisih_tanggal + "</small>" +
                            "<br>" + tanggal_sj + "</td>" +
                            "<td>" + hp + "</td>"

                        theader = "<tr><td>No.</td><td>Nama</td><td>Telp</td>"
                        for (j = 1; j <= data[i].JUMLAH_TANGGAL; j++) {
                            if (data[i].TANGGAL[pad(j, 2)] == null) {
                                var jumlah_pemesanan = "-"
                            } else {
                                var jumlah_pemesanan = data[i].TANGGAL[pad(j, 2)]
                            }
                            theader += "<td>" + j + "</td>"
                            tbody += "<td>" + jumlah_pemesanan + "</td>"
                        }
                        theader += "</tr>"
                        tbody += "</tr>"

                        // $("tbody#zone_data").append("<tr class=''>" +
                        //     "<td>" + no++ + ".</td>" +
                        //     "<td><b>" + data[i].MASTER_RELASI_NAMA + "</b><br><p class='text-success'>" + data[i].MASTER_RELASI_QR_ID + "</p><small class='text-muted'>Pemesanan Terakhir :<br> " + selisih_tanggal + "</small>" +
                        //     "<br>" + tanggal_sj + "</td>" +
                        //     "<td>" + data[i].MASTER_RELASI_ALAMAT + "<br>" + hp + "</td>" +

                        //     "</tr>");
                    }
                    $("thead#zone_header").append(theader);
                    $("tbody#zone_data").append(tbody);
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
            url: '<?php echo base_url(); ?>index.php/laporan/relasi/add',
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
                    url: '<?php echo base_url() ?>index.php/laporan/relasi/hapus/' + id,
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
            url: '<?php echo base_url() ?>index.php/laporan/relasi/detail/' + id,
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