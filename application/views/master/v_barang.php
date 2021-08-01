<div class="modal fade" id="barangModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Jenis Barang</h4>
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
                        <label for="exampleInputEmail1">Jenis</label>
                        <select name="jenis" id="jenis" class="form-control jenis select2" style="width: 100%;">
                            <option value="">-- Pilih --</option>
                            <?php
                            foreach (jenis_barang() as $value => $text) {
                            ?>
                                <option value="<?= $value; ?>"><?= $text; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= $this->lang->line('nama'); ?></label>
                        <input type="text" class="form-control nama" name="nama" autocomplete="off">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Harga Satuan</label>
                        <input type="text" class="form-control harga_satuan" name="harga_satuan" autocomplete="off" required>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Harga Jaminan</label>
                        <input type="text" class="form-control harga_jaminan" name="harga_jaminan" autocomplete="off" required>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Total Kapasitas</label>
                        <input type="text" class="form-control total" name="total" autocomplete="off" required>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Satuan</label>
                        <select name="satuan" id="satuan" name="satuan" class="form-control satuan select2" style="width: 100%;">
                            <option value="">-- Satuan --</option>
                            <?php foreach (satuan() as $row) {
                            ?>
                                <option value="<?= $row->SATUAN_NAMA; ?>"><?= $row->SATUAN_NAMA; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Bahan Produksi</label>
                        <select name="bahan" id="bahan" name="bahan" class="form-control bahan select2" style="width: 100%;">
                            <option value="">-</option>
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

                    <div class="form-group">
                        <label for="exampleInputEmail1">Prioritas</label>
                        <select name="prioritas" id="prioritas" name="prioritas" class="form-control prioritas select2" style="width: 100%;">
                            <option value="0">0. Sangat Rendah</option>
                            <option value="1">1. Rendah</option>
                            <option value="2">2. Sedang</option>
                            <option value="3">3. Tinggi</option>
                            <option value="4">4. Sangat Tinggi</option>
                            <option value="5">5. Utama</option>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= $this->lang->line('keterangan'); ?></label>
                        <textarea name="keterangan" id="keterangan" class="form-control keterangan"></textarea>
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
                    <h1 class="m-0"><?= $this->lang->line('Barang'); ?></h1>
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
                        <div class="col-6">
                            <button type="button" class="btn btn-secondary btn_barang mb-2">Tambah Barang</button>
                        </div>
                        <div class="col-6">
                            <select name="jenis_filter" id="jenis_filter" class="form-control jenis_filter select2" style="width: 100%;">
                                <option value=""><?= $this->lang->line('semua'); ?></option>

                                <?php
                                foreach (jenis_barang() as $value => $text) {
                                ?>
                                    <option value="<?= $value; ?>"><?= $text; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <small class="text-muted">Jenis Barang</small>
                        </div>
                    </div>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('nama'); ?></th>
                                <th>Stok</th>
                                <th>Jenis</th>
                                <th>Harga Satuan</th>
                                <th>Harga Jaminan</th>
                                <th>Prioritas</th>
                                <th><?= $this->lang->line('keterangan'); ?></th>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                                <td colspan="9">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <!-- <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div> -->
            </div>

        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(".btn_barang").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $(".jenis").val("").trigger("change")
        $("#barangModal").modal("show")
    })
    $(function() {
        $(".harga_satuan").mask("#.##0", {
            reverse: true
        });
        $(".harga_jaminan").mask("#.##0", {
            reverse: true
        });
        barang_list();
    });

    function barang_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/master/barang/list?jenis=" + $(".jenis_filter").val(),
            async: false,
            dataType: 'json',
            success: function(data) {
                memuat()
                $("tbody#zone_data").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        if (data[i].MASUK == null) {
                            var masuk = 0
                        } else {
                            var masuk = data[i].MASUK
                        }
                        if (data[i].KELUAR == null) {
                            var keluar = 0
                        } else {
                            var keluar = data[i].KELUAR
                        }

                        var total = parseInt(masuk) - parseInt(keluar)

                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + total + "</td>" +
                            "<td>" + data[i].MASTER_BARANG_JENIS + "</td>" +
                            "<td>Rp. " + number_format(data[i].MASTER_BARANG_HARGA_SATUAN) + "</td>" +
                            "<td>Rp. " + number_format(data[i].MASTER_BARANG_HARGA_JAMINAN) + "</td>" +
                            "<td>" + data[i].MASTER_BARANG_PRIORITAS + "</td>" +
                            "<td>" + data[i].MASTER_BARANG_KETERANGAN + "</td>" +
                            "<td>" +
                            // "<a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].MASTER_BARANG_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='detail(\"" + data[i].MASTER_BARANG_ID + "\")'><i class='fas fa-edit'></i></a> " +
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

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/master/barang/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                barang_list();
                Swal.fire('Berhasil', 'Jenis Barang berhasil ditambahkan', 'success')
                $("#barangModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/master/barang/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            barang_list();
                            Swal.fire('Berhasil', 'Jenis Barang Berhasil dihapus', 'success')
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
            url: '<?php echo base_url() ?>index.php/master/barang/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $("#barangModal").modal("show")
                $(".jenis").val(data[0].MASTER_BARANG_JENIS).trigger('change')
                $(".satuan").val(data[0].MASTER_BARANG_SATUAN).trigger('change')
                $(".bahan").val(data[0].MASTER_BARANG_BAHAN).trigger('change')
                $(".prioritas").val(data[0].MASTER_BARANG_PRIORITAS).trigger('change')
                $(".id").val(data[0].MASTER_BARANG_ID)
                $(".nama").val(data[0].MASTER_BARANG_NAMA)
                $(".keterangan").val(data[0].MASTER_BARANG_KETERANGAN)
                $(".total").val(data[0].MASTER_BARANG_TOTAL)
                $(".harga_satuan").val(number_format(data[0].MASTER_BARANG_HARGA_SATUAN))
                $(".harga_jaminan").val(number_format(data[0].MASTER_BARANG_HARGA_JAMINAN))


            },
            error: function(x, e) {} //end error
        });
    }

    $('#jenis_filter').change(function() {
        memuat()
        barang_list()
    });
</script>