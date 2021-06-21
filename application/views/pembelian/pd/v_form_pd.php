<?php
if (empty($this->uri->segment('4'))) {
    $id = create_id();
} else {
    $id = $this->uri->segment('4');
}

if (empty($this->uri->segment('5'))) {
    $id_pembelian = create_id();
} else {
    $id_pembelian = $this->uri->segment('5');
}
?>
<div class="modal fade" id="realisasi_tabungModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Realikasi Tabung</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="realisasi_tabung">
                    <div class="form-group">
                        <input type="hidden" class="form-control id_realisasi" name="id_realisasi" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Quantity</label>
                        <input type="text" class="form-control quantity_realisasi" name="quantity_realisasi" autocomplete="off">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
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
<div class="modal fade" id="realisasi_liquidModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Realikasi Liquid</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="realisasi_liquid">
                    <div class="form-group">
                        <input type="hidden" class="form-control id_realisasi" name="id_realisasi" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Lokasi Tangki</label>
                        <select name="master_tangki" id="master_tangki" class="form-control master_tangki select2" style="width: 100%;">
                            <option value="">-- Lokasi Tangki --</option>
                            <?php
                            foreach (tangki_list() as $row) {
                            ?>
                                <option value="<?= $row->MASTER_TANGKI_ID; ?>"><?= $row->MASTER_TANGKI_LOKASI; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Quantity</label>
                        <input type="text" class="form-control quantity_realisasi_liquid" name="quantity_realisasi_liquid" autocomplete="off" readonly>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Satuan</label>
                        <input type="text" class="form-control satuan_realisasi_liquid" name="satuan_realisasi_liquid" autocomplete="off" readonly>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Koversi</label>
                        <select name="konversi" id="konversi" name="konversi" class="form-control konversi select2" style="width: 100%;">
                            <option value="">-- Konversi --</option>
                            <?php
                            foreach (konversi() as $row) {
                            ?>
                                <option value="<?= $row->KONVERSI_NILAI; ?>"><?= $row->KONVERSI_NAMA; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Total</label>
                        <input type="text" class="form-control total_realisasi_liquid" name="total_realisasi_liquid" autocomplete="off">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
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

<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Barang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit">
                    <div class="form-group">
                        <input type="hidden" class="form-control id_barang" name="id_barang" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Quantity</label>
                        <input type="text" class="form-control quantity_barang" name="quantity_barang" autocomplete="off">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Satuan</label>
                        <select name="satuan_barang" id="satuan_barang" class="form-control satuan_barang select2" style="width: 100%;">
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
                <div class="col-sm-10">
                    <h1 class="m-0">Form Pengiriman</h1>
                </div><!-- /.col -->
                <div class="col-sm-2 text-right btn-faktur" hidden>
                    <button class="btn btn-block btn-warning">Buat Faktur</button>
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
                                <input type="hidden" class="form-control id_pembelian" name="id_pembelian" value="<?= $id_pembelian; ?>" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">No Pengiriman</label>
                                            <input type="text" class="form-control nomor_pembelian" name="nomor_pembelian" autocomplete="off" readonly>
                                            <small class="text-muted">Nomor Otomatis akan terisi.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">No Surat</label>
                                            <input type="text" class="form-control nomor_surat" name="nomor_surat" autocomplete="off">

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
                                            <label for="exampleInputEmail1"><?= $this->lang->line('supplier'); ?></label>
                                            <select name="supplier" id="supplier" class="form-control supplier select2" style="width: 100%;" required>
                                                <option value="">-- Pilih Supplier --</option>
                                                <?php foreach ($supplier as $row) {
                                                ?>
                                                    <option value="<?= $row->MASTER_SUPPLIER_ID; ?>"><?= $row->MASTER_SUPPLIER_NAMA; ?></option>
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
                                                foreach (jenis_barang_pembelian() as $value => $text) {
                                                ?>
                                                    <option value="<?= $value; ?>"><?= $text; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Dokumen</label>
                                            <input type="hidden" name="userfile_name" class="form-control userfile_name">
                                            <input type="file" name="userfile" class="form-control userfile">
                                            <small class="text-muted"><a href="" target="_blank" class="link_dokument"></a></small>
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
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <!-- <th>Harga</th> -->
                                        <th>Quantity</th>
                                        <th>Satuan</th>
                                        <!-- <th>Total</th> -->
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="form_tt">
                                    <tr class="table-secondary">
                                        <td>#</td>
                                        <td>
                                            <select name="barang" id="barang" class="form-control form-control-sm barang select2" style="width: 100%;" required>
                                                <option value="">-- Jenis Barang --</option>
                                            </select>
                                        </td>

                                        <!-- <td>
                                            <input type="text" class="form-control form-control-sm harga_barang" name="harga_barang" autocomplete="off" value="0" onkeyup="kalkulasi_total_rupiah_barang()">
                                        </td> -->
                                        <td>
                                            <input type="text" class="form-control form-control-sm quantity_barang_add" name="quantity_barang_add" autocomplete="off" value="0" onkeyup="kalkulasi_total_rupiah_barang()">
                                        </td>
                                        <td>
                                            <select name="satuan" id="satuan" class="form-control form-control-sm satuan select2" style="width: 100%;">
                                                <option value="">-- Satuan --</option>
                                                <?php foreach (satuan() as $row) {
                                                ?>
                                                    <option value="<?= $row->SATUAN_NAMA; ?>"><?= $row->SATUAN_NAMA; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <!-- <td>
                                            <input type="text" class="form-control form-control-sm total_rupiah_barang" name="total_rupiah_barang" autocomplete="off" value="0" onkeyup="" readonly>
                                        </td> -->
                                        <td>
                                            <button type="button" class="btn btn-secondary btn-sm btn-add-barang"><i class="nav-icon fas fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody id="zone_data">
                                    <tr>
                                    </tr>
                                </tbody>
                                <tfoot id="total_data">

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
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">Biaya Lainnya</label>
                                <div class="col-sm-3">
                                    <select name="akun" id="akun" class="form-control akun select2" style="width: 100%;" required>
                                        <option value="">-- Akun --</option>
                                        <?php foreach (akun_list() as $row) {
                                        ?>
                                            <option value="<?= $row->AKUN_ID; ?>"><?= $row->AKUN_NAMA; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-7">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control lainnya" name="lainnya" autocomplete="off" value="0" onkeyup="kalkulasi_seluruh()">
                                    </div>
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

        $(".lainnya").mask("#.##0", {
            reverse: true
        });

        detail()
        barang_list()
        kalkulasi_seluruh()
    });

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/pembelian/pd/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                window.location.href = '<?= base_url(); ?>pembelian/pd/form_pd/<?= $id; ?>/<?= $id_pembelian; ?>'

            }
        });
    })

    $('#edit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/pembelian/pd/edit',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                barang_list()
                memuat()
                Swal.fire('Berhasil', '', 'success')
            }
        });
    })

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/pembelian/pd/detail/<?= $id; ?>/<?= $id_pembelian; ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                memuat()
                if (data.length == 0) {
                    detail_jenis_barang()
                    barang_list()
                } else {
                    $(".nomor_pembelian").val(data[0].PEMBELIAN_NOMOR)
                    $(".nomor_surat").val(data[0].PEMBELIAN_NOMOR_SURAT)
                    $(".tanggal").val(data[0].PEMBELIAN_TANGGAL)
                    $(".supplier").val(data[0].MASTER_SUPPLIER_ID)
                    $(".userfile_name").val(data[0].PEMBELIAN_FILE)
                    $(".jenis").val(data[0].PEMBELIAN_BARANG).trigger('change')
                    $(".akun").val(data[0].AKUN_ID)
                    $(".keterangan").html(data[0].PEMBELIAN_KETERANGAN)
                    $(".lainnya").val(number_format(data[0].TRANSAKSI[0].PEMBELIAN_TRANSAKSI_LAINNYA))

                    if (data[0].PEMBELIAN_FILE == "") {

                    } else {
                        $(".link_dokument").html("Lihat Dokumen")
                        $(".link_dokument").attr("href", "<?= base_url(); ?>uploads/pembelian/" + data[0].PEMBELIAN_FILE + "")
                    }

                    if (data[0].PEMBELIAN_STATUS == "open") {
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

    function kalkulasi_total_bayar() {
        var quantity = $(".quantity").val()
        var harga = $(".harga").val()
        var total = parseInt(quantity) * parseInt(harga)
    }

    $('#jenis').change(function() {
        detail_jenis_barang()
    });

    function detail_jenis_barang() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/pembelian/po/detail_jenis_barang?jenis=" + $(".jenis").val(),
            async: false,
            dataType: 'json',
            success: function(data) {
                $("select#barang").empty();
                if (data.length === 0) {} else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        $("#barang").append("<option value='" + data[i].MASTER_BARANG_ID + "'>" + data[i].MASTER_BARANG_NAMA + "</option>")
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    $('.btn-add-barang').on("click", function(e) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/pembelian/pd/add_barang',
            dataType: "JSON",
            beforeSend: function() {
                memuat()
            },
            data: {
                id: "<?= $id; ?>",
                id_pembelian: "<?= $id_pembelian; ?>",
                barang: $('.barang').val(),
                satuan: $('.satuan').val(),
                quantity_barang: $('.quantity_barang_add').val(),
            },
            success: function(data) {
                detail()
                $('.harga_barang').val("0")
                $('.quantity_barang_add').val("0")
                $('.total_rupiah_barang').val("0")
                kalkulasi_seluruh()
                barang_list()
            }
        });
    })

    function kalkulasi_total_rupiah_barang() {

        // var quantity = $(".quantity_barang").val()
        // var harga = $(".harga_barang").val()
        // var total = quantity * harga
        // $(".total_rupiah_barang").val(total)
    }

    function barang_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/pembelian/pd/list_barang/<?= $id; ?>/<?= $id_pembelian; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                $("tfoot#total_data").empty();
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                    $(".total").val("0")
                } else {
                    var no = 1
                    var total = 0
                    for (i = 0; i < data.length; i++) {
                        total += parseInt(data[i].PEMBELIAN_BARANG_TOTAL);

                        if (data[i].PEMBELIAN_BARANG_REALISASI == "1") {
                            var tr = "table-success"
                        } else {
                            var tr = "table-default"
                        }
                        $("tbody#zone_data").append("<tr class='" + tr + "'>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            // "<td>" + number_format(data[i].PEMBELIAN_BARANG_HARGA) + "</td>" +
                            "<td>" + data[i].PEMBELIAN_BARANG_QUANTITY + "</td>" +
                            "<td>" + data[i].PEMBELIAN_BARANG_SATUAN + "</td>" +
                            // "<td align='right'>" + number_format(data[i].PEMBELIAN_BARANG_TOTAL) + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].PEMBELIAN_BARANG_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='edit(\"" + data[i].PEMBELIAN_BARANG_ID + "\",\"" + data[i].PEMBELIAN_BARANG_QUANTITY + "\",\"" + data[i].PEMBELIAN_BARANG_SATUAN + "\")'><i class='fas fa-edit'></i></a> " +
                            "<a class='btn btn-success btn-sm' onclick='realisasi(\"" + data[i].PEMBELIAN_BARANG_ID + "\",\"" + data[i].PEMBELIAN_BARANG_QUANTITY + "\",\"" + data[i].PEMBELIAN_BARANG_SATUAN + "\")'><i class='fas fa-check'></i></a> " +
                            "</td>" +
                            "</tr>");
                    }
                    $(".total").val(number_format(total))
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
                    url: '<?php echo base_url() ?>index.php/pembelian/pd/hapus/' + id,
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            Swal.fire('Berhasil', 'Jenis Barang Berhasil dihapus', 'success')
                            kalkulasi_seluruh()
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

    function realisasi(id, quantity, satuan) {
        var jenis_barang = $(".jenis").val()

        if (jenis_barang == "tabung") {
            $("#realisasi_tabungModal").modal("show")
            $(".id_realisasi").val(id)
        } else if (jenis_barang == "tangki") {
            $("#realisasi_tangkiModal").modal("show")
            $(".id_realisasi").val(id)
        } else if (jenis_barang == "liquid") {
            $("#realisasi_liquidModal").modal("show")
            $(".quantity_realisasi_liquid").val(quantity)
            $(".satuan_realisasi_liquid").val(satuan)
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

    $('.pajak').change(function() {
        kalkulasi_seluruh()
    });

    function kalkulasi_seluruh() {
        // var pajak = parseInt($(".pajak").val())
        // var potongan = parseInt($(".potongan").val().split('.').join(""))

        // var total = parseInt($(".total").val().split('.').join(""))
        // var bayar = parseInt($(".bayar").val().split('.').join(""))
        // var pajak_rupiah = (total - potongan) * (pajak / 100)
        // $(".pajak_rupiah").val(number_format(pajak_rupiah))
        // var total_bayar = (total - potongan) + pajak_rupiah
        // var sisa_bayar = total_bayar - bayar
        // $(".total_bayar").val(number_format(total_bayar))
        // $(".sisa_bayar").val(number_format(sisa_bayar))
    }

    // $(".btn-faktur").on("click", function() {
    //     $.ajax({
    //         url: '<?php echo base_url(); ?>index.php/pembelian/po/po_to_pd/<?= $id; ?>/<?= $id_pembelian; ?>',
    //         type: "ajax",
    //         dataType: 'json',
    //         beforeSend: function() {
    //             memuat()
    //         },
    //         success: function(data) {
    //             window.open(
    //                 '<?= base_url(); ?>pembelian/pd/form_pd/' + data.PI_ID + '/' + data.PEMBELIAN_ID,
    //                 '_blank'
    //             );
    //             Swal.fire('Berhasil', 'Pembelian berhasil ditambahkan', 'success')
    //             detail()
    //         }
    //     });
    // })

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
                    url: '<?php echo base_url(); ?>index.php/pembelian/pd/pd_to_pi/<?= $id; ?>/<?= $id_pembelian; ?>',
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

    $('.konversi').change(function() {
        var quantity = parseInt($(".quantity_realisasi_liquid").val())
        var konversi = $(".konversi").val()
        var total = quantity * konversi
        console.log(total)
        console.log(quantity)
        console.log(konversi)
        $(".total_realisasi_liquid").val(total)
    });
</script>