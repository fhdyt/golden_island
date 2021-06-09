<div class="modal fade" id="pajakModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pajak</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit">
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <select name="jenis" id="jenis" class="form-control jenis select2" style="width: 100%;" required>
                                <option value=""><?= $this->lang->line('semua'); ?></option>
                                <?php
                                foreach (tabung($relasi[0]->MASTER_RELASI_ID) as $row) {
                                ?>
                                    <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required value="<?= date("Y-m-d"); ?>" required>
                            <small class="text-muted">Tanggal</small>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control total" name="total" autocomplete="off" required>
                            <small class="text-muted">Total</small>
                        </div>
                        <div class="col-md-2">
                            <select name="status" id="status" class="form-control status select2" style="width: 100%;" required>
                                <option value="">-</option>
                                <option value="MP">MP</option>
                                <option value="MR">MR</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary"><?= $this->lang->line('simpan'); ?></button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th><?= $this->lang->line('tanggal'); ?></th>
                                    <th>Jenis</th>
                                    <th>Kepemilikan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="saldo_awal">
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('tutup'); ?></button>
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
                    <h1 class="m-0">Panggung</h1>
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
                        <div class="col-md-12">
                            <select name="perusahaan" id="perusahaan" class="form-control perusahaan select2" style="width: 100%;" required>
                                <option value="">-- Perusahaan --</option>
                                <?php
                                foreach (perusahaan() as $row) {
                                ?>
                                    <option value="<?= $row->PERUSAHAAN_KODE; ?>"><?= $row->PERUSAHAAN_NAMA; ?> (<?= $row->PERUSAHAAN_KODE; ?>)</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                            </tr>
                        </tbody>
                        <tbody id="total_saldo_panggung">
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="4" style="text-align: center;"><?= tanggal(date("Y-m-d")) ?></th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>Oleh</th>
                                <th>Tanggal</th>
                                <th>Jumlah Saat Verfikasi</th>
                            </tr>
                        </thead>
                        <tbody id="verifikasi_list">
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
        $("#pajakModal").modal("show")
        saldo_awal_list()
    })
    $(function() {
        memuat()
    });

    $(".refresh").on("click", function() {
        memuat()
        barang_list();
    })

    function barang_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/laporan/panggung/list",
            async: false,
            dataType: 'json',
            data: {
                perusahaan: $(".perusahaan").val()
            },
            success: function(data) {
                $("tbody#zone_data").empty();
                $("tbody#total_saldo_panggung").empty()
                memuat()
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var total_mp = 0
                    var total_mr = 0

                    var total = 0

                    console.log(data)
                    for (i = 0; i < data.length; i++) {
                        if (data[i].SALDO_AWAL_MP.length == 0) {
                            var saldo_awal_mp = 0
                        } else {
                            var saldo_awal_mp = parseInt(data[i].SALDO_AWAL_MP[0].JURNAL_TABUNG_KEMBALI)
                        }
                        if (data[i].SALDO_AWAL_MR.length == 0) {
                            var saldo_awal_mr = 0
                        } else {
                            var saldo_awal_mr = parseInt(data[i].SALDO_AWAL_MR[0].JURNAL_TABUNG_KEMBALI)
                        }


                        if (data[i].SALDO_MP[0].KIRIM == null) {
                            var saldo_kirim_mp = 0
                        } else {
                            var saldo_kirim_mp = parseInt(data[i].SALDO_MP[0].KIRIM)
                        }
                        if (data[i].SALDO_MP[0].KEMBALI == null) {
                            var saldo_kembali_mp = 0
                        } else {
                            var saldo_kembali_mp = parseInt(data[i].SALDO_MP[0].KEMBALI)
                        }


                        if (data[i].SALDO_MR[0].KIRIM == null) {
                            var saldo_kirim_mr = 0
                        } else {
                            var saldo_kirim_mr = parseInt(data[i].SALDO_MR[0].KIRIM)
                        }
                        if (data[i].SALDO_MR[0].KEMBALI == null) {
                            var saldo_kembali_mr = 0
                        } else {
                            var saldo_kembali_mr = parseInt(data[i].SALDO_MR[0].KEMBALI)
                        }

                        total_mp = saldo_awal_mp + (saldo_kembali_mp - saldo_kirim_mp)
                        total_mr = saldo_awal_mr + (saldo_kembali_mr - saldo_kirim_mr)
                        // total_mp = saldo_awal_mp + saldo_kirim_mp + saldo_kembali_mp
                        // total_mr = saldo_awal_mr + saldo_kirim_mr + saldo_kembali_mr

                        total += total_mp + total_mr
                        $("tbody#zone_data").append("<tr >" +
                            "<td rowspan='3' style='text-align:center; vertical-align:middle;'>" + no++ + ".</td>" +
                            "<td rowspan='3' style='text-align:center; vertical-align:middle;'>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "</tr>" +
                            "<tr class='table-success'><td>MP</td><td>" + number_format(total_mp) + "</td>" +
                            "<tr class='table-warning'><td>MR</td><td>" + number_format(total_mr) + "</td>");


                    }
                    $(".total_tabung_panggung").val(total)
                    $("tbody#total_saldo_panggung").append("<tr class=''>" +
                        "<td colspan='3' style='text-align:right; vertical-align:middle;'><b>Total Panggung</b></td>" +
                        "<td>" + number_format(total) + "</td>" +
                        "</tr>");
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function saldo_awal_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/laporan/panggung/saldo_awal_list",
            async: false,
            dataType: 'json',
            data: {
                tanggal_dari: $('.tanggal_dari').val(),
                tanggal_sampai: $('.tanggal_sampai').val(),
                jenis: $('.jenis').val(),
            },
            success: function(data) {
                $("tbody#saldo_awal").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#saldo_awal").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        $("tbody#saldo_awal").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + data[i].JURNAL_TABUNG_STATUS + "</td>" +
                            "<td>" + data[i].JURNAL_TABUNG_KEMBALI + "</td>" +
                            "</tr>");
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function verifikasi_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/laporan/panggung/verifikasi_list",
            async: false,
            dataType: 'json',
            data: {
                perusahaan: $(".perusahaan").val()
            },
            success: function(data) {
                $("tbody#verifikasi_list").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#verifikasi_list").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        $("tbody#verifikasi_list").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].USER[0].USER_NAMA + "</td>" +
                            "<td>" + data[i].VERIFIKASI_PANGGUNG_TANGGAL + "</td>" +
                            "<td>" + data[i].VERIFIKASI_PANGGUNG_TOTAL + "</td>" +
                            "</tr>");
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
            url: '<?php echo base_url(); ?>index.php/laporan/panggung/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                // memuat()
            },
            success: function(data) {
                //pajak_list();
                //Swal.fire('Berhasil', 'Berhasil ditambahkan', 'success')
                saldo_awal_list()
                // $("#pajakModal").modal("hide")
            }
        });
    })

    $(".verifikasi_panggung").on("click", function() {
        Swal.fire({
            title: 'Verifikasi Saldo Panggung ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Verfikasi`,
            denyButtonText: `Batal`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>index.php/laporan/panggung/verifikasi',
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    data: {
                        total: $(".total_tabung_panggung").val()
                    },
                    success: function(data) {
                        if (data.length === 0) {} else {
                            verifikasi_list()
                            memuat()
                            Swal.fire('Berhasil', 'Saldo panggung berhasil terverifikasi', 'success')
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
    })

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
        saldo_list()
    });

    $('.perusahaan').change(function() {
        memuat()
        barang_list($(".perusahaan").val())
        verifikasi_list()
    });
</script>