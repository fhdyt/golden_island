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
                <div class="col-sm-12">
                    <h1 class="m-0">Transfer Produksi</h1>
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
                    <form id="submit">
                        <input type="hidden" class="form-control id" name="id" value="<?= $id; ?>" autocomplete="off">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No Transfer Produksi</label>
                                    <input type="text" class="form-control nomor_transfer_produksi" name="nomor_transfer_produksi" autocomplete="off" readonly>
                                    <small class="text-muted">Nomor Otomatis akan terisi.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?= $this->lang->line('tanggal'); ?></label>
                                    <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                                    <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <small class="text-muted">Dari</small>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Jenis Barang</th>
                                            <th>Kepemilikan</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="form_tt">
                                        <tr class="table-secondary">
                                            <td>#
                                            </td>
                                            <td>
                                                <select name="barang_dari" id="barang_dari" class="form-control form-control-sm barang_dari select2" style="width: 100%;">
                                                    <?php
                                                    foreach (tabung() as $row) {
                                                    ?>
                                                        <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="kepemilikan_barang_dari" id="kepemilikan_barang_dari" class="form-control form-control-sm kepemilikan_barang_dari select2" style="width: 100%;">
                                                    <option value="MP">MP</option>
                                                    <option value="MR">MR</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm total_barang_dari" name="total_barang_dari" autocomplete="off" value="0">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-secondary btn-sm btn-add-barang_dari"><i class="nav-icon fas fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody id="zone_data_barang_dari">
                                        <tr>
                                        </tr>
                                    </tbody>
                                    <tfoot id="zone_total_barang_dari">

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <small class="text-muted">Jadi</small>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Jenis Barang</th>
                                            <th>Kepemilikan</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="form_tt">
                                        <tr class="table-secondary">
                                            <td>#
                                            </td>
                                            <td>
                                                <select name="barang_jadi" id="barang_jadi" class="form-control form-control-sm barang_jadi select2" style="width: 100%;">
                                                    <?php
                                                    foreach (tabung() as $row) {
                                                    ?>
                                                        <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="kepemilikan_barang_jadi" id="kepemilikan_barang_jadi" class="form-control form-control-sm kepemilikan_barang_jadi select2" style="width: 100%;">
                                                    <option value="MP">MP</option>
                                                    <option value="MR">MR</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm total_barang_jadi" name="total_barang_jadi" autocomplete="off" value="0">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-secondary btn-sm btn-add-barang_jadi"><i class="nav-icon fas fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody id="zone_data_barang_jadi">
                                        <tr>
                                        </tr>
                                    </tbody>
                                    <tfoot id="zone_total_barang_jadi">

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <small class="text-muted">Karyawan Produksi</small>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Karyawan</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="form_tt">
                                        <tr class="table-secondary">
                                            <td>#
                                            </td>
                                            <td>
                                                <select name="karyawan_produksi" id="karyawan_produksi" class="form-control form-control-sm karyawan_produksi select2" style="width: 100%;">
                                                    <?php
                                                    foreach (karyawan_produksi() as $row) {
                                                    ?>
                                                        <option value="<?= $row->MASTER_KARYAWAN_ID; ?>"><?= $row->MASTER_KARYAWAN_NAMA; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm total_produksi" name="total_produksi" autocomplete="off" value="0">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-secondary btn-sm btn-add-karyawan"><i class="nav-icon fas fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody id="zone_data_karyawan">
                                        <tr>
                                        </tr>
                                    </tbody>
                                    <tfoot id="zone_total_karyawan">

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default color-palette-box">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success btn-lg simpan_surat_jalan"><?= $this->lang->line('simpan'); ?></button>
                        </form>
                    </div>
                </div>
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
<!-- /.content-wrapper -->
<script>
    $(function() {
        detail();
    });

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/produksi/transfer/detail/<?= $id; ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                memuat()
                if (data.length == 0) {} else {
                    if (data['data'].length == "") {
                        $(".level_awal").val("0")
                    }
                    // if (data['data'].length == "") {
                    //     $(".level_awal").val(data['terakhir'][0].PRODUKSI_LEVEL_AKHIR)
                    // }
                    $(".nomor_transfer_produksi").val(data['data'][0].PRODUKSI_TRANSFER_NOMOR)
                    $(".tanggal").val(data['data'][0].TANGGAL)
                    $(".jenis").val(data['data'][0].MASTER_BARANG_ID).trigger('change')
                    $(".master_tangki").val(data['data'][0].MASTER_TANGKI_ID).trigger('change')
                    $(".level_awal").val(data['data'][0].PRODUKSI_LEVEL_AWAL)
                    $(".level_akhir").val(data['data'][0].PRODUKSI_LEVEL_AKHIR)
                    $(".konversi").val(data['data'][0].PRODUKSI_KONVERSI_NILAI).trigger("change")
                    if (data['data'][0].PRODUKSI_LEVEL_AWAL_FILE == "") {} else {
                        $(".userfile_name_awal").val(data['data'][0].PRODUKSI_LEVEL_AWAL_FILE)
                        $(".link_dokument_awal").html("Lihat Dokumen")
                        $(".link_dokument_awal").attr("href", "<?= base_url(); ?>uploads/produksi/" + data['data'][0].PRODUKSI_LEVEL_AWAL_FILE + "")
                    }

                    if (data['data'][0].PRODUKSI_LEVEL_AKHIR_FILE == "") {} else {
                        $(".userfile_name").val(data['data'][0].PRODUKSI_LEVEL_AKHIR_FILE)
                        $(".link_dokument").html("Lihat Dokumen")
                        $(".link_dokument").attr("href", "<?= base_url(); ?>uploads/produksi/" + data['data'][0].PRODUKSI_LEVEL_AKHIR_FILE + "")
                    }
                    barang_list_dari()
                    barang_list_jadi()
                    karyawan_list()
                }


            },
            error: function(x, e) {
                console.log('gagag')
            } //end error
        });
    }

    $('#jenis').change(function() {
        jenis_barang($(".jenis").val())
    });

    $('#master_tangki').change(function() {
        kapasitas_tangki()
    });

    $('.btn-add-barang_dari').on("click", function(e) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/produksi/transfer/add_barang_dari',
            dataType: "JSON",
            beforeSend: function() {
                memuat()
            },
            data: {
                id: "<?= $id; ?>",
                barang: $('.barang_dari').val(),
                total_barang: $('.total_barang_dari').val(),
                kepemilikan_barang: $('.kepemilikan_barang_dari').val(),
            },
            success: function(data) {
                memuat()
                barang_list_dari()

            }
        });
    })
    $('.btn-add-barang_jadi').on("click", function(e) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/produksi/transfer/add_barang_jadi',
            dataType: "JSON",
            beforeSend: function() {
                memuat()
            },
            data: {
                id: "<?= $id; ?>",
                barang: $('.barang_jadi').val(),
                total_barang: $('.total_barang_jadi').val(),
                kepemilikan_barang: $('.kepemilikan_barang_jadi').val(),
            },
            success: function(data) {
                memuat()
                barang_list_jadi()

            }
        });
    })

    $('.btn-add-karyawan').on("click", function(e) {
        // if (parseInt($('.total_produksi').val()) > parseInt($(".total_tabung").val())) {
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Oops...',
        //         text: 'Melebih total Produksi'
        //     })
        // } else {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/produksi/transfer/add_karyawan',
            dataType: "JSON",
            beforeSend: function() {
                memuat()
            },
            data: {
                id: "<?= $id; ?>",
                karyawan_produksi: $('.karyawan_produksi').val(),
                total_produksi: $('.total_produksi').val(),
            },
            success: function(data) {
                memuat()
                karyawan_list()
            }
        });
        // }
    })

    function barang_list_dari() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/produksi/transfer/list_barang_dari/<?= $id; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data_barang_dari").empty();
                $("tfoot#zone_total_barang").empty();
                if (data.length === 0) {
                    $("tbody#zone_data_barang_dari").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                    $(".total").val("0")
                } else {
                    var no_isi = 1
                    var total = 0
                    var kapasitas = 0
                    for (i = 0; i < data.length; i++) {
                        kapasitas += parseInt(data[i].MASTER_BARANG_TOTAL) * parseInt(data[i].PRODUKSI_TRANSFER_BARANG_DARI_TOTAL)
                        total += parseInt(data[i].PRODUKSI_TRANSFER_BARANG_DARI_TOTAL)
                        var btn_hapus = "<a class='btn btn-danger btn-sm' onclick='hapus_dari(\"" + data[i].PRODUKSI_TRANSFER_BARANG_DARI_ID + "\")'><i class='fas fa-trash'></i>"
                        $("tbody#zone_data_barang_dari").append("<tr class=''>" +
                            "<td>" + no_isi++ + ".</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + data[i].PRODUKSI_TRANSFER_BARANG_DARI_KEPEMILIKAN + "</td>" +
                            "<td>" + data[i].PRODUKSI_TRANSFER_BARANG_DARI_TOTAL + "</td>" +
                            "<td>" + btn_hapus + " " +
                            "</td>" +
                            "</tr>");
                    }
                    $(".total_kapasitas").val(kapasitas)
                    $(".total_tabung").val(total)
                    $("tfoot#zone_total_barang").append("<tr class=''>" +
                        "<td colspan='3' style='text-align:right'>Total.</td>" +
                        "<td>" + total + "</td>" +
                        "</tr>");
                    kalkulasi()
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function barang_list_jadi() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/produksi/transfer/list_barang_jadi/<?= $id; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data_barang_jadi").empty();
                $("tfoot#zone_total_barang").empty();
                if (data.length === 0) {
                    $("tbody#zone_data_barang_jadi").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                    $(".total").val("0")
                } else {
                    var no_isi = 1
                    var total = 0
                    var kapasitas = 0
                    for (i = 0; i < data.length; i++) {
                        kapasitas += parseInt(data[i].MASTER_BARANG_TOTAL) * parseInt(data[i].PRODUKSI_TRANSFER_BARANG_JADI_TOTAL)
                        total += parseInt(data[i].PRODUKSI_TRANSFER_BARANG_JADI_TOTAL)
                        var btn_hapus = "<a class='btn btn-danger btn-sm' onclick='hapus_jadi(\"" + data[i].PRODUKSI_TRANSFER_BARANG_JADI_ID + "\")'><i class='fas fa-trash'></i>"
                        $("tbody#zone_data_barang_jadi").append("<tr class=''>" +
                            "<td>" + no_isi++ + ".</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + data[i].PRODUKSI_TRANSFER_BARANG_JADI_KEPEMILIKAN + "</td>" +
                            "<td>" + data[i].PRODUKSI_TRANSFER_BARANG_JADI_TOTAL + "</td>" +
                            "<td>" + btn_hapus + " " +
                            "</td>" +
                            "</tr>");
                    }
                    $(".total_kapasitas").val(kapasitas)
                    $(".total_tabung").val(total)
                    $("tfoot#zone_total_barang").append("<tr class=''>" +
                        "<td colspan='3' style='text-align:right'>Total.</td>" +
                        "<td>" + total + "</td>" +
                        "</tr>");
                    kalkulasi()
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function karyawan_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/produksi/transfer/list_karyawan/<?= $id; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $("tbody#zone_data_karyawan").empty();
                $("tfoot#zone_total_karyawan").empty();
                if (data.length === 0) {
                    $("tbody#zone_data_karyawan").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                    $(".total").val("0")
                } else {
                    var no_isi = 1
                    var total = 0
                    for (i = 0; i < data.length; i++) {
                        // total += parseInt(data[i].PRODUKSI_BARANG_TOTAL)
                        var btn_hapus = "<a class='btn btn-danger btn-sm' onclick='hapus_karyawan(\"" + data[i].PRODUKSI_TRANSFER_KARYAWAN_ID + "\")'><i class='fas fa-trash'></i>"
                        $("tbody#zone_data_karyawan").append("<tr class=''>" +
                            "<td>" + no_isi++ + ".</td>" +
                            "<td>" + data[i].MASTER_KARYAWAN_NAMA + "</td>" +
                            "<td>" + data[i].PRODUKSI_TRANSFER_KARYAWAN_TOTAL + "</td>" +
                            "<td>" + btn_hapus + " " +
                            "</td>" +
                            "</tr>");
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function hapus_dari(id) {
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
                    url: '<?php echo base_url() ?>index.php/produksi/transfer/hapus_dari/' + id,
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            Swal.fire('Berhasil', 'Barang Berhasil dihapus', 'success')
                            barang_list_dari()
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

    function hapus_jadi(id) {
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
                    url: '<?php echo base_url() ?>index.php/produksi/transfer/hapus_jadi/' + id,
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            Swal.fire('Berhasil', 'Barang Berhasil dihapus', 'success')
                            barang_list_jadi()
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

    function hapus_karyawan(id) {
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
                    url: '<?php echo base_url() ?>index.php/produksi/transfer/hapus_karyawan/' + id,
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            Swal.fire('Berhasil', 'Berhasil dihapus', 'success')
                            karyawan_list()
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
    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/produksi/transfer/add_selesai',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                detail();
                window.location.href = '<?= base_url(); ?>produksi/transfer/form/<?= $id; ?>'
            }
        });
    })

    function kalkulasi() {
        var level_awal = parseInt($(".level_awal").val())

        var level_akhir = parseInt($(".level_akhir").val())

        var total_kapasitas = parseInt($(".total_kapasitas").val())

        var konversi = $(".konversi").val()
        var terpakai = (level_awal - level_akhir) * konversi
        var g_l = total_kapasitas - terpakai

        $(".terpakai").val(terpakai)
        $(".g_l").val(g_l)
    }
</script>