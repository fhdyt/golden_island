<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Buku Besar'); ?></h1>
                    <small class="text-muted">PT. GOLDEN ISLAND GROUP</small>
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
                        <div class="col-md-3">
                            <select name="perusahaan" id="perusahaan" class="form-control perusahaan select2" style="width: 100%;" required>
                                <option value="">-- Perusahaan --</option>
                                <?php
                                foreach (perusahaan_akses() as $row) {
                                ?>
                                    <option value="<?= $row->PERUSAHAAN_KODE; ?>"><?= $row->PERUSAHAAN_NAMA; ?> (<?= $row->PERUSAHAAN_KODE; ?>)</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="akun" id="akun" class="form-control akun select2" style="width: 100%;" required>

                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control tanggal_dari" name="tanggal_dari" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                            <small class="text-muted">Tanggal Dari.</small>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="date" class="form-control tanggal_sampai" name="tanggal_sampai" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-success filter_tanggal"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <small class="text-muted">Tanggal Sampai.</small>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?= $this->lang->line('tanggal'); ?></th>
                                <th><?= $this->lang->line('keterangan'); ?></th>
                                <th>Sumber</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Saldo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="zone_saldo_awal">
                            <tr>
                            </tr>
                        </tbody>
                        <tbody id="zone_data">
                            <tr>
                                <td colspan="10"><?= $this->lang->line('tidak_ada_data'); ?></td>
                            </tr>
                        </tbody>
                        <tfoot id="total_buku_besar">
                            <tr>
                            </tr>
                        </tfoot>
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
    $(".btn_akun").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        if ($(".akun").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silahkan pilih Akun terlebih dahulu'
            })
        } else {
            $("#akunModal").modal("show")
        }

    })
    $(".btn_transfer").on("click", function() {
        $("#submit_transfer").trigger("reset");
        $("#transferModal").modal("show")


    })

    $(function() {
        $(".rupiah").mask("#.##0", {
            reverse: true
        });
        $(".kredit").mask("#.##0", {
            reverse: true
        });
        $(".debet").mask("#.##0", {
            reverse: true
        });
        // buku_besar_list();
        memuat()
    });

    function buku_besar_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/gig/buku_besar/list?akun=" + $(".akun").val() + "",
            async: false,
            dataType: 'json',
            data: {
                tanggal_dari: $('.tanggal_dari').val(),
                tanggal_sampai: $('.tanggal_sampai').val(),
                perusahaan: $('.perusahaan').val(),
            },
            success: function(data) {
                $("tbody#zone_saldo_awal").empty();
                $("tbody#zone_data").empty();
                $("tfoot#total_buku_besar").empty()
                memuat()
                console.log(data)
                if ($(".akun").val() == "") {
                    $("tbody#zone_data").append("<td colspan='10'>Silahkan pilih Jenis Akun terlebih dahulu.</td>")
                }
                if (data.length === 0) {

                } else {
                    var no = 1
                    if (data['saldo_awal'][0].DEBET == null) {
                        var saldo_awal_debet = 0
                    } else {
                        var saldo_awal_debet = data['saldo_awal'][0].DEBET
                    }
                    if (data['saldo_awal'][0].KREDIT == null) {
                        var saldo_awal_kredit = 0
                    } else {
                        var saldo_awal_kredit = data['saldo_awal'][0].KREDIT
                    }
                    var saldo_awal = parseInt(saldo_awal_debet) - parseInt(saldo_awal_kredit)

                    $("tbody#zone_saldo_awal").append("<tr class=''>" +
                        "<td colspan='5' style='text-align:right; vertical-align:middle;'><b>Saldo Awal</b></td>" +
                        "<td>" + number_format(saldo_awal) + "</td><td></td>" +
                        "</tr>");
                    var saldo = 0 + saldo_awal
                    var total_debet = 0
                    var total_kredit = 0
                    for (i = 0; i < data['data'].length; i++) {
                        saldo += parseInt(data['data'][i].SALDO)

                        if (data['data'][i].BUKU_BESAR_REF == "") {
                            var btn_hapus = ""
                            //var btn_hapus = "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data['data'][i].BUKU_BESAR_ID + "\")'><i class='fas fa-trash'></i></a></td>"
                        } else {
                            var btn_hapus = ""
                        }

                        if (data['data'][i].BUKU_BESAR_FILE == "") {
                            var file = ""
                        } else if (data['data'][i].BUKU_BESAR_FILE == null) {
                            var file = ""
                        } else {
                            var file = "<a class='btn btn-secondary btn-sm' href='<?= base_url() ?>uploads/buku_besar/" + data['data'][i].BUKU_BESAR_FILE + "' target='_blank'><i class='fas fa-file'></i> Buka Dokumen</a>"
                        }

                        total_debet += parseInt(data['data'][i].BUKU_BESAR_DEBET)
                        total_kredit += parseInt(data['data'][i].BUKU_BESAR_KREDIT)

                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + data['data'][i].TANGGAL + "</td>" +
                            "<td>" + data['data'][i].BUKU_BESAR_KETERANGAN + "</td>" +
                            "<td>" + data['data'][i].BUKU_BESAR_SUMBER + "</td>" +
                            "<td>" + number_format(data['data'][i].BUKU_BESAR_DEBET) + "</td>" +
                            "<td>" + number_format(data['data'][i].BUKU_BESAR_KREDIT) + "</td>" +
                            "<td>" + number_format(saldo) + "</td>" +
                            "<td>" + file + "</td>" +
                            btn_hapus +
                            "</tr>");
                    }
                    $("tfoot#total_buku_besar").append("<tr><td colspan='3' style='text-align:right; vertical-align:middle;'><b>Total</b></td><td>" + number_format(total_debet) + "</td><td>" + number_format(total_kredit) + "</td></tr>")
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
            url: '<?php echo base_url(); ?>index.php/akuntansi/buku_besar/add?akun=' + $(".akun").val() + '',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                buku_besar_list();
                Swal.fire('Berhasil', '', 'success')
                $("#akunModal").modal("hide")
            }
        });
    })

    $('#submit_transfer').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/akuntansi/buku_besar/transfer',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                buku_besar_list();
                Swal.fire('Berhasil', '', 'success')
                $("#transferModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/akuntansi/buku_besar/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            buku_besar_list();
                            Swal.fire('Berhasil', 'DBerhasil dihapus', 'success')
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

    function akun_list(id) {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/gig/buku_besar/akun_list/' + id,
            dataType: 'json',
            success: function(data) {
                $(".akun").empty()
                memuat()
                for (i = 0; i < data.length; i++) {
                    $(".akun").append("<option value='" + data[i].AKUN_ID + "'>" + data[i].AKUN_NAMA + "</option>")
                }

            },
            error: function(x, e) {} //end error
        });
    }

    $('.perusahaan').change(function() {
        memuat()
        akun_list($(".perusahaan").val())
    });

    $('.filter_tanggal').on("click", function() {
        if ($(".akun").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silahkan pilih Akun terlebih dahulu'
            })
        } else {
            memuat()
            buku_besar_list()
        }

    });
</script>