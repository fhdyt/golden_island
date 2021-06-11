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
                    <h1 class="m-0">Form Produksi</h1>
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
                        <div class="row">


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No Produksi</label>
                                    <input type="text" class="form-control nomor_produksi" name="nomor_produksi" autocomplete="off" readonly>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Jenis Bahan</label>
                                    <select name="jenis" id="jenis" class="form-control jenis select2" style="width: 100%;">
                                        <option value="">-- Jenis Barang --</option>
                                        <?php
                                        foreach (tangki() as $row) {
                                        ?>
                                            <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Level Awal</label>
                                    <input type="text" class="form-control level_awal" name="level_awal" autocomplete="off">
                                    <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Level Akhir</label>
                                    <input type="text" class="form-control level_akhir" name="level_akhir" autocomplete="off">
                                    <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Terpakai</label>
                                    <input type="text" class="form-control terpakai" name="terpakai" autocomplete="off">
                                    <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <small class="text-muted">Barang yang akan diproduksi</small>
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
                                                <select name="barang" id="barang" class="form-control form-control-sm barang select2" style="width: 100%;">
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
                                                <select name="kepemilikan_barang" id="kepemilikan_barang" class="form-control form-control-sm kepemilikan_barang select2" style="width: 100%;">
                                                    <option value="MP">MP</option>
                                                    <option value="MR">MR</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm total_barang" name="total_barang" autocomplete="off" value="0">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-secondary btn-sm btn-add-barang"><i class="nav-icon fas fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody id="zone_data_barang">
                                        <tr>
                                        </tr>
                                    </tbody>
                                    <tfoot id="zone_total_barang">

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
        memuat();
    });


    $('.btn-add-barang').on("click", function(e) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/produksi/produksi/add_barang',
            dataType: "JSON",
            beforeSend: function() {
                memuat()
            },
            data: {
                id: "<?= $id; ?>",
                barang: $('.barang').val(),
                total_barang: $('.total_barang').val(),
                kepemilikan_barang: $('.kepemilikan_barang').val(),
            },
            success: function(data) {
                memuat()
                barang_list()
            }
        });
    })

    $('.btn-add-karyawan').on("click", function(e) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/produksi/produksi/add_karyawan',
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
    })

    function barang_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/produksi/produksi/list_barang/<?= $id; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data_barang").empty();
                $("tfoot#zone_total_barang").empty();
                if (data.length === 0) {
                    $("tbody#zone_data_barang").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                    $(".total").val("0")
                } else {
                    var no_isi = 1
                    var total = 0
                    for (i = 0; i < data.length; i++) {
                        total += parseInt(data[i].PRODUKSI_BARANG_TOTAL)
                        var btn_hapus = "<a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].PRODUKSI_BARANG_ID + "\")'><i class='fas fa-trash'></i>"
                        $("tbody#zone_data_barang").append("<tr class=''>" +
                            "<td>" + no_isi++ + ".</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + data[i].PRODUKSI_BARANG_KEPEMILIKAN + "</td>" +
                            "<td>" + data[i].PRODUKSI_BARANG_TOTAL + "</td>" +
                            "<td>" + btn_hapus + " " +
                            "</td>" +
                            "</tr>");
                    }
                    $("tfoot#zone_total_barang").append("<tr class=''>" +
                        "<td colspan='3' style='text-align:right'>Total.</td>" +
                        "<td>" + total + "</td>" +
                        "</tr>");
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
            url: "<?php echo base_url() ?>index.php/produksi/produksi/list_karyawan/<?= $id; ?>",
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
                        var btn_hapus = "<a class='btn btn-danger btn-sm' onclick='hapus_karyawan(\"" + data[i].PRODUKSI_KARYAWAN_ID + "\")'><i class='fas fa-trash'></i>"
                        $("tbody#zone_data_karyawan").append("<tr class=''>" +
                            "<td>" + no_isi++ + ".</td>" +
                            "<td>" + data[i].MASTER_KARYAWAN_NAMA + "</td>" +
                            "<td>" + data[i].PRODUKSI_KARYAWAN_TOTAL + "</td>" +
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

    function hapus(id) {
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
                    url: '<?php echo base_url() ?>index.php/produksi/produksi/hapus/' + id,
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            Swal.fire('Berhasil', 'Barang Berhasil dihapus', 'success')
                            barang_list()
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
                    url: '<?php echo base_url() ?>index.php/produksi/produksi/hapus_karyawan/' + id,
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
                pajak_list();
                Swal.fire('Berhasil', 'Pajak berhasil ditambahkan', 'success')
                $("#pajakModal").modal("hide")
            }
        });
    })
</script>