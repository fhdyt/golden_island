<div class="modal fade" id="balanceModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Balance Panggung</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit">
                    <div class="form-group">
                        <input type="hidden" class="form-control id" name="id" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= $this->lang->line('tanggal'); ?></label>
                        <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required value="<?= date("Y-m-d"); ?>" readonly>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis</label>
                        <select name="jenis" id="jenis" class="form-control jenis select2" style="width: 100%;" required>
                            <option value="">-- Jenis --</option>

                            <?php
                            foreach (tabung() as $row) {
                            ?>
                                <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jumlah</label>
                        <input type="text" class="form-control jumlah" name="jumlah" autocomplete="off" required value="0">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Masuk / Keluar</label>
                        <select name="in_out" id="in_out" class="form-control in_out select2" style="width: 100%;" required>
                            <option value="in">Masuk</option>
                            <option value="out">Keluar</option>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kepemilikan</label>
                        <select name="kepemilikan" id="kepemilikan" class="form-control kepemilikan select2" style="width: 100%;" required>
                            <option value="MP">MP</option>
                            <option value="MR">MR</option>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <div class="form-group clearfix">
                            <div class="icheck-primary">
                                <input type="checkbox" id="isi" name="isi">
                                <label for="isi">
                                    ISI
                                </label>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('tutup'); ?></button>
                <button type="submit" class="btn btn-primary"><?= $this->lang->line('simpan'); ?></button>
                </form>
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
                        <div class="col-md-3">
                            <button type="button" class="btn btn-secondary balance mb-2">Balance Panggung</button>
                        </div>
                    </div>

                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2" style="text-align:center; vertical-align:middle">No.</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle">Jenis</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle">Status</th>
                                <th colspan="2" style="text-align:center; vertical-align:middle">Keluar</th>
                                <th colspan="2" style="text-align:center; vertical-align:middle">Masuk</th>
                                <th colspan="2" style="text-align:center; vertical-align:middle">Panggung</th>
                                <th rowspan="2" style="text-align:center; vertical-align:middle">Saldo</th>
                            </tr>
                            <tr>
                                <th style="text-align:center; vertical-align:middle">Isi</th>
                                <th style="text-align:center; vertical-align:middle">Kosong</th>
                                <th style="text-align:center; vertical-align:middle">Isi</th>
                                <th style="text-align:center; vertical-align:middle">Kosong</th>
                                <th style="text-align:center; vertical-align:middle">Isi</th>
                                <th style="text-align:center; vertical-align:middle">Kosong</th>
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
                        <tbody>
                            <tr>
                                <td colspan="10" style="text-align: right;">
                                    <input type="hidden" class="form-control total_tabung_panggung" name="total_tabung_panggung" id="total_tabung_panggung" value="" autocomplete="off">
                                    <a href="<?= base_url(); ?>cetak/cetak_panggung" class="btn btn-success mb-2" target="_blank">Print</a>
                                    <button type="button" class="btn btn-secondary mb-2 verifikasi_panggung">Verifikasi Saldo Panggung</button>
                                    <br>
                                    <a class="refresh">Perbarui</a>
                                </td>
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
    $(".balance").on("click", function() {
        $("#balanceModal").modal("show")
    })
    $(function() {
        barang_list();
        verifikasi_list();
    });

    $(".refresh").on("click", function() {
        memuat()
        barang_list();
    })

    function barang_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/laporan/panggung/ex_list",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                $("tbody#total_saldo_panggung").empty()
                memuat()
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var mp_isi_out = 0
                    var mp_kosong_out = 0
                    var mr_isi_out = 0
                    var mr_kosong_out = 0

                    var mp_isi_in = 0
                    var mp_kosong_in = 0
                    var mr_isi_in = 0
                    var mr_kosong_in = 0

                    var total_seluruh = 0
                    console.log(data)
                    for (i = 0; i < data.length; i++) {
                        if (data[i].SALDO_MP_ISI_OUT[0].JUMLAH == null) {
                            mp_isi_out = 0
                        } else {
                            mp_isi_out = parseInt(data[i].SALDO_MP_ISI_OUT[0].JUMLAH)
                        }

                        if (data[i].SALDO_MP_KOSONG_OUT[0].JUMLAH == null) {
                            mp_kosong_out = 0
                        } else {
                            mp_kosong_out = parseInt(data[i].SALDO_MP_KOSONG_OUT[0].JUMLAH)
                        }

                        if (data[i].SALDO_MR_ISI_OUT[0].JUMLAH == null) {
                            mr_isi_out = 0
                        } else {
                            mr_isi_out = parseInt(data[i].SALDO_MR_ISI_OUT[0].JUMLAH)
                        }

                        if (data[i].SALDO_MR_KOSONG_OUT[0].JUMLAH == null) {
                            mr_kosong_out = 0
                        } else {
                            mr_kosong_out = parseInt(data[i].SALDO_MR_KOSONG_OUT[0].JUMLAH)
                        }

                        if (data[i].SALDO_MP_ISI_IN[0].JUMLAH == null) {
                            mp_isi_in = 0
                        } else {
                            mp_isi_in = parseInt(data[i].SALDO_MP_ISI_IN[0].JUMLAH)
                        }

                        if (data[i].SALDO_MP_KOSONG_IN[0].JUMLAH == null) {
                            mp_kosong_in = 0
                        } else {
                            mp_kosong_in = parseInt(data[i].SALDO_MP_KOSONG_IN[0].JUMLAH)
                        }

                        if (data[i].SALDO_MR_ISI_IN[0].JUMLAH == null) {
                            mr_isi_in = 0
                        } else {
                            mr_isi_in = parseInt(data[i].SALDO_MR_ISI_IN[0].JUMLAH)
                        }

                        if (data[i].SALDO_MR_KOSONG_IN[0].JUMLAH == null) {
                            mr_kosong_in = 0
                        } else {
                            mr_kosong_in = parseInt(data[i].SALDO_MR_KOSONG_IN[0].JUMLAH)
                        }

                        total_mp_out = mp_isi_out + mp_kosong_out
                        total_mr_out = mr_isi_out + mr_kosong_out

                        total_mp_in = mp_isi_in + mp_kosong_in
                        total_mr_in = mr_isi_in + mr_kosong_in

                        panggung_mp_isi = mp_isi_in - mp_isi_out
                        panggung_mp_kosong = mp_kosong_in - mp_kosong_out

                        panggung_mr_isi = mr_isi_in - mr_isi_out
                        panggung_mr_kosong = mr_kosong_in - mr_kosong_out

                        total_mp = panggung_mp_isi + panggung_mp_kosong
                        total_mr = panggung_mr_isi + panggung_mr_kosong

                        total_seluruh += total_mp + total_mr
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td rowspan='3' style='text-align:center; vertical-align:middle'>" + no++ + ".</td>" +
                            "<td rowspan='3' style='text-align:center; vertical-align:middle'>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "</tr>" +
                            "<tr><td>MP</td><td>" + mp_isi_out + "<td>" + mp_kosong_out + "</td><td>" + mp_isi_in + "<td>" + mp_kosong_in + "</td><td>" + panggung_mp_isi + "</td><td>" + panggung_mp_kosong + "</td><td>" + total_mp + "</td></tr>" +
                            "<tr><td>MR</td><td>" + mr_isi_out + "<td>" + mr_kosong_out + "</td><td>" + mr_isi_in + "<td>" + mr_kosong_in + "</td><td>" + panggung_mr_isi + "</td><td>" + panggung_mr_kosong + "</td><td>" + total_mr + "</td></tr>");
                    }
                    $(".total_tabung_panggung").val(total_seluruh)
                    $("tbody#total_saldo_panggung").append("<tr class=''>" +
                        "<td colspan='9' style='text-align:right; vertical-align:middle;'><b>Total Panggung</b></td>" +
                        "<td>" + number_format(total_seluruh) + "</td>" +
                        "</tr>");
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }
    // function barang_list() {
    //     $.ajax({
    //         type: 'POST',
    //         url: "<?php echo base_url() ?>index.php/laporan/panggung/list",
    //         async: false,
    //         dataType: 'json',
    //         success: function(data) {
    //             $("tbody#zone_data").empty();
    //             $("tbody#total_saldo_panggung").empty()
    //             memuat()
    //             if (data.length === 0) {
    //                 $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
    //             } else {
    //                 var no = 1
    //                 var total_mp = 0
    //                 var total_mr = 0

    //                 var total = 0

    //                 console.log(data)
    //                 for (i = 0; i < data.length; i++) {
    //                     if (data[i].SALDO_AWAL_MP.length == 0) {
    //                         var saldo_awal_mp = 0
    //                     } else {
    //                         var saldo_awal_mp = parseInt(data[i].SALDO_AWAL_MP[0].JURNAL_TABUNG_KEMBALI)
    //                     }
    //                     if (data[i].SALDO_AWAL_MR.length == 0) {
    //                         var saldo_awal_mr = 0
    //                     } else {
    //                         var saldo_awal_mr = parseInt(data[i].SALDO_AWAL_MR[0].JURNAL_TABUNG_KEMBALI)
    //                     }


    //                     if (data[i].SALDO_MP[0].KIRIM == null) {
    //                         var saldo_kirim_mp = 0
    //                     } else {
    //                         var saldo_kirim_mp = parseInt(data[i].SALDO_MP[0].KIRIM)
    //                     }
    //                     if (data[i].SALDO_MP[0].KEMBALI == null) {
    //                         var saldo_kembali_mp = 0
    //                     } else {
    //                         var saldo_kembali_mp = parseInt(data[i].SALDO_MP[0].KEMBALI)
    //                     }


    //                     if (data[i].SALDO_MR[0].KIRIM == null) {
    //                         var saldo_kirim_mr = 0
    //                     } else {
    //                         var saldo_kirim_mr = parseInt(data[i].SALDO_MR[0].KIRIM)
    //                     }
    //                     if (data[i].SALDO_MR[0].KEMBALI == null) {
    //                         var saldo_kembali_mr = 0
    //                     } else {
    //                         var saldo_kembali_mr = parseInt(data[i].SALDO_MR[0].KEMBALI)
    //                     }

    //                     total_mp = saldo_awal_mp + (saldo_kembali_mp - saldo_kirim_mp)
    //                     total_mr = saldo_awal_mr + (saldo_kembali_mr - saldo_kirim_mr)
    //                     // total_mp = saldo_awal_mp + saldo_kirim_mp + saldo_kembali_mp
    //                     // total_mr = saldo_awal_mr + saldo_kirim_mr + saldo_kembali_mr

    //                     total += total_mp + total_mr
    //                     $("tbody#zone_data").append("<tr >" +
    //                         "<td rowspan='3' style='text-align:center; vertical-align:middle;'>" + no++ + ".</td>" +
    //                         "<td rowspan='3' style='text-align:center; vertical-align:middle;'>" + data[i].MASTER_BARANG_NAMA + "</td>" +
    //                         "</tr>" +
    //                         "<tr class='table-success'><td>MP</td><td>" + number_format(total_mp) + "</td>" +
    //                         "<tr class='table-warning'><td>MR</td><td>" + number_format(total_mr) + "</td>");


    //                 }
    //                 $(".total_tabung_panggung").val(total)
    //                 $("tbody#total_saldo_panggung").append("<tr class=''>" +
    //                     "<td colspan='3' style='text-align:right; vertical-align:middle;'><b>Total Panggung</b></td>" +
    //                     "<td>" + number_format(total) + "</td>" +
    //                     "</tr>");
    //             }
    //         },
    //         error: function(x, e) {
    //             console.log("Gagal")
    //         }
    //     });
    // }

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
                tanggal_dari: $('.tanggal_dari').val(),
                tanggal_sampai: $('.tanggal_sampai').val(),
                jenis: $('.jenis').val(),
            },
            success: function(data) {
                $("tbody#verifikasi_list").empty();
                //console.log(data)
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
            url: '<?php echo base_url(); ?>index.php/laporan/panggung/balance',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                $("#balanceModal").modal("hide")
                barang_list();
                verifikasi_list();
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
</script>