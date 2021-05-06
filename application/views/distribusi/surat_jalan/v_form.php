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
                    <h1 class="m-0">Form Surat Jalan</h1>
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
                                            <label for="exampleInputEmail1">No Surat Jalan</label>
                                            <input type="text" class="form-control nomor_surat_jalan" name="nomor_surat_jalan" autocomplete="off" readonly>
                                            <small class="text-muted">Nomor Otomatis akan terisi.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?= $this->lang->line('tanggal'); ?></label>
                                            <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required>
                                            <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?= $this->lang->line('Relasi'); ?></label>
                                            <select name="relasi" id="relasi" class="form-control relasi select2" style="width: 100%;" required>
                                                <option value="">-- Pilih Relasi --</option>
                                                <?php foreach (relasi_list() as $row) {
                                                ?>
                                                    <option value="<?= $row->MASTER_RELASI_ID; ?>"><?= $row->MASTER_RELASI_NAMA; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Driver</label>
                                            <select name="driver" id="driver" class="form-control driver select2" style="width: 100%;">
                                                <option value="">-- Driver --</option>

                                                <?php
                                                foreach (driver() as $row) {
                                                ?>
                                                    <option value="<?= $row->MASTER_KARYAWAN_ID; ?>"><?= $row->MASTER_KARYAWAN_NAMA; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Kendaraan</label>
                                            <select name="kendaraan" id="kendaraan" class="form-control kendaraan select2" style="width: 100%;">
                                                <option value="">-- Kendaraan --</option>

                                                <?php
                                                foreach (Kendaraan() as $row) {
                                                ?>
                                                    <option value="<?= $row->MASTER_KENDARAAN_ID; ?>"><?= $row->MASTER_KENDARAAN_NOMOR; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Jenis Barang</label>
                                            <select name="jenis" id="jenis" class="form-control jenis select2" style="width: 100%;">
                                                <option value="">-- Jenis Barang --</option>

                                                <?php
                                                foreach (jenis_barang_penjualan() as $value => $text) {
                                                ?>
                                                    <option value="<?= $value; ?>"><?= $text; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?= $this->lang->line('keterangan'); ?></label>
                                            <textarea name="keterangan" id="keterangan" class="form-control keterangan" rows="6"></textarea>
                                            <small class="text-muted">Kosongkan jika tidak diperlukan.</small>
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
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">No.</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama Barang</th>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Quantity</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Satuan</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;"></th>
                                    </tr>
                                    <tr>
                                        <th>Isi</th>
                                        <th>Kosong</th>
                                        <th>Klaim</th>
                                    </tr>
                                </thead>
                                <tbody id="form_tt">
                                    <tr class="table-secondary">
                                        <td>#
                                            <input type="hidden" class="form-control status_barang_isi" name="status_barang_isi" id="status_barang_isi" value="ISI" autocomplete="off">
                                        </td>
                                        <td>
                                            <select name="barang_isi" id="barang_isi" class="form-control form-control-sm barang_isi select2" style="width: 100%;">
                                                <option value="">-- Jenis Barang --</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm quantity_barang_add_isi" name="quantity_barang_add_isi" autocomplete="off" value="0">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm quantity_barang_add_kosong" name="quantity_barang_add_kosong" autocomplete="off" value="0">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm quantity_barang_add_klaim" name="quantity_barang_add_klaim" autocomplete="off" value="0">
                                        </td>
                                        <td>
                                            <select name="satuan_barang" id="satuan_barang" class="form-control form-control-sm satuan_barang select2" style="width: 100%;">
                                                <option value="">-- Satuan --</option>
                                                <?php foreach (satuan() as $row) {
                                                ?>
                                                    <option value="<?= $row->SATUAN_NAMA; ?>"><?= $row->SATUAN_NAMA; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-secondary btn-sm btn-add-barang-isi"><i class="nav-icon fas fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody id="zone_data_isi">
                                    <tr>
                                    </tr>
                                </tbody>
                                <tfoot id="total_data_isi">

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

        detail()
        barang_list()
    });

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/distribusi/surat_jalan/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                window.location.href = '<?= base_url(); ?>distribusi/surat_jalan/form/<?= $id; ?>/'

            }
        });
    })

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/distribusi/surat_jalan/detail/<?= $id; ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                memuat()
                if (data.length == 0) {
                    detail_jenis_barang()
                    barang_list()
                } else {
                    $(".nomor_surat_jalan").val(data[0].SURAT_JALAN_NOMOR)
                    $(".tanggal").val(data[0].SURAT_JALAN_TANGGAL)
                    $(".relasi").val(data[0].MASTER_RELASI_ID).trigger("change")
                    $(".driver").val(data[0].DRIVER_ID).trigger("change")
                    $(".kendaraan").val(data[0].MASTER_KENDARAAN_ID).trigger("change")
                    $(".keterangan").html(data[0].SURAT_JALAN_KETERANGAN)

                    if (data[0].SURAT_JALAN_STATUS == "open") {
                        $(".btn-faktur").attr("hidden", false)
                    } else {
                        $(".btn-faktur").attr("hidden", true)
                        $("a.btn-danger").removeAttr("onclick")
                        $("button").prop("disabled", true)
                        $("input").attr("disabled", true)
                        $("select").attr("disabled", true)
                    }
                    detail_jenis_barang()
                }


            },
            error: function(x, e) {} //end error
        });
    }



    $('#jenis').change(function() {
        detail_jenis_barang()
    });

    function detail_jenis_barang() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/distribusi/surat_jalan/detail_jenis_barang?jenis=" + $(".jenis").val(),
            async: false,
            dataType: 'json',
            success: function(data) {
                $("select#barang_isi").empty();
                $("select#barang_kosong").empty();
                $("select#barang_klaim").empty();
                if (data.length === 0) {} else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        $("#barang_isi").append("<option value='" + data[i].MASTER_BARANG_ID + "'>" + data[i].MASTER_BARANG_NAMA + "</option>")
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    $('.btn-add-barang-isi').on("click", function(e) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/distribusi/surat_jalan/add_barang',
            dataType: "JSON",
            beforeSend: function() {
                memuat()
            },
            data: {
                id: "<?= $id; ?>",
                barang: $('.barang_isi').val(),
                jenis: $('.jenis').val(),
                quantity_barang: $('.quantity_barang_add_isi').val(),
                quantity_barang_kosong: $('.quantity_barang_add_kosong').val(),
                quantity_barang_klaim: $('.quantity_barang_add_klaim').val(),
                satuan_barang: $('.satuan_barang').val(),
            },
            success: function(data) {
                memuat()
                $('.quantity_barang_add_isi').val("0")
                $('.quantity_barang_add_kosong').val("0")
                $('.quantity_barang_add_klaim').val("0")
                barang_list()
            }
        });
    })






    function barang_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/distribusi/surat_jalan/list_barang/<?= $id; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data_isi").empty();
                $("tfoot#total_data_isi").empty();

                console.log(data.isi)
                if (data.length === 0) {
                    $("tbody#zone_data_isi").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                    $(".total").val("0")
                } else {
                    var no_isi = 1
                    var no_kosong = 1
                    var no_klaim = 1
                    var total = 0
                    for (i = 0; i < data.isi.length; i++) {
                        total += parseInt(data.isi[i].SURAT_JALAN_BARANG_QUANTITY);
                        $("tbody#zone_data_isi").append("<tr class=''>" +
                            "<td>" + no_isi++ + ".</td>" +
                            "<td>" + data.isi[i].MASTER_BARANG_NAMA + "<br><small class='text-muted'>" + data.isi[i].SURAT_JALAN_BARANG_JENIS + "</small></td>" +
                            "<td>" + number_format(data.isi[i].SURAT_JALAN_BARANG_QUANTITY) + "</td>" +
                            "<td>" + number_format(data.isi[i].SURAT_JALAN_BARANG_QUANTITY_KOSONG) + "</td>" +
                            "<td>" + number_format(data.isi[i].SURAT_JALAN_BARANG_QUANTITY_KLAIM) + "</td>" +
                            "<td>" + data.isi[i].SURAT_JALAN_BARANG_SATUAN + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data.isi[i].SURAT_JALAN_BARANG_ID + "\")'><i class='fas fa-trash'></i></a> " +
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
                    url: '<?php echo base_url() ?>index.php/distribusi/surat_jalan/hapus/' + id,
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            Swal.fire('Berhasil', 'Jenis Barang Berhasil dihapus', 'success')
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

    function edit(id, quantity, satuan) {
        console.log(id)
        console.log(quantity)
        console.log(satuan)
        $("#editModal").modal("show")
        $(".id_barang").val(id)
        $(".quantity_barang").val(quantity)
        $(".satuan_barang").val(satuan).trigger("change")
    }

    function realisasi(id) {
        var jenis_barang = $(".jenis").val()

        if (jenis_barang == "tabung") {
            $("#realisasi_tabungModal").modal("show")
            $(".id_realisasi").val(id)
        } else if (jenis_barang == "tangki") {
            $("#realisasi_tangkiModal").modal("show")
            $(".id_realisasi").val(id)
        } else if (jenis_barang == "liquid") {
            $("#realisasi_liquidModal").modal("show")
            $(".id_realisasi").val(id)
        }
    }

    $('#realisasi_tabung').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/pembelian/pd/realisasi_tabung',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                memuat()
                $("#realisasi_tabungModal").modal("hide")
                Swal.fire('Berhasil', 'Berhasil ditambahkan', 'success')
                barang_list()
            }
        });
    })

    $('#realisasi_tangki').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/pembelian/pd/realisasi_tangki',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                memuat()
                $("#realisasi_tangkiModal").modal("hide")
                Swal.fire('Berhasil', 'Berhasil ditambahkan', 'success')
                barang_list()
            }
        });
    })

    $('#realisasi_liquid').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/pembelian/pd/realisasi_liquid',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                memuat()
                $("#realisasi_liquidModal").modal("hide")
                Swal.fire('Berhasil', 'Berhasil ditambahkan', 'success')
                barang_list()
            }
        });
    })


    $(".btn-faktur").on("click", function() {
        Swal.fire({
            title: 'Buat Pengiriman ?',
            icon: 'question',
            text: 'Setelah membuat Faktur, anda tidak dapat merubah Form Pengiriman',
            showCancelButton: true,
            confirmButtonText: `Buat`,
            denyButtonText: `Batal`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/pembelian/pd/pd_to_pi/<?= $id; ?>',
                    type: "ajax",
                    dataType: 'json',
                    beforeSend: function() {
                        memuat()
                    },
                    success: function(data) {
                        window.open(
                            '<?= base_url(); ?>pembelian/pi/form_pi/' + data.PI_ID + '/' + data.PEMBELIAN_ID,
                            '_blank'
                        );
                        Swal.fire('Berhasil', 'Pembelian berhasil ditambahkan', 'success')
                        detail()
                    }
                });

            }
        })

    })
</script>