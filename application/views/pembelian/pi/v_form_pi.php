td<?php
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1 class="m-0">Form Faktur</h1>
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
                                            <label for="exampleInputEmail1">No Faktur</label>
                                            <input type="text" class="form-control nomor_pembelian" name="nomor_pembelian" autocomplete="off" readonly>
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?= $this->lang->line('keterangan'); ?></label>
                                            <textarea name="keterangan" id="keterangan" class="form-control keterangan" rows="6"><?= keterangan_pembelian(); ?></textarea>
                                            <small class="text-muted">Kosongkan jika tidak diperlukan.</small>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Upload Dokumen</label>
                                <button type="button" nama_input="sampul_tema" class="btn btn-primary btn-block btn_upload">Pilih File</button>
                            </div>
                        </div> -->
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
                                        <th>Harga</th>
                                        <th>Quantity</th>
                                        <th>Satuan</th>
                                        <th>Total</th>
                                        <!-- <th></th> -->
                                    </tr>
                                </thead>
                                <tbody id="form_tt">
                                    <!-- <tr class="table-secondary">
                                        <td>#</td>
                                        <td>
                                            <select name="barang" id="barang" class="form-control form-control-sm barang select2" style="width: 100%;" required>
                                                <option value="">-- Jenis Barang --</option>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="text" class="form-control form-control-sm harga_barang" name="harga_barang" autocomplete="off" value="0" onkeyup="kalkulasi_total_rupiah_barang()">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm quantity_barang" name="quantity_barang" autocomplete="off" value="0" onkeyup="kalkulasi_total_rupiah_barang()">
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
                                        <td>
                                            <input type="text" class="form-control form-control-sm total_rupiah_barang" name="total_rupiah_barang" autocomplete="off" value="0" onkeyup="" readonly>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-secondary btn-sm btn-add-barang"><i class="nav-icon fas fa-plus"></i></button>
                                        </td>
                                    </tr> -->
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
                                <label class="col-sm-2 col-form-label text-right">Total</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control total" name="total" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">Potongan</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control potongan" name="potongan" autocomplete="off" value="0" onkeyup="kalkulasi_seluruh()">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">Pajak</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <select name="pajak" id="pajak" class="form-control pajak select2" style="width: 100%;">
                                                <option value="0">0</option>
                                                <?php foreach (pajak_list() as $row) {
                                                ?>
                                                    <option value="<?= $row->PAJAK_NILAI; ?>"><?= $row->PAJAK_NAMA; ?> - <?= $row->PAJAK_NILAI; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <input type="text" class="form-control pajak_rupiah" name="pajak_rupiah" autocomplete="off" value="0" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">Total Bayar</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control total_bayar" name="total_bayar" autocomplete="off" value="0" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">Uang Muka</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control uang_muka" name="uang_muka" autocomplete="off" value="0" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">Jumlah yang Harus Dibayar</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control grand_total" name="grand_total" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row pengembalian_dana">
                                <label class="col-sm-2 col-form-label text-right">Pengembalian Dana</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control biaya_tambahan" name="biaya_tambahan" autocomplete="off" onkeyup="kalkulasi_seluruh()">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">Bayar</label>
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
                                <div class="col-sm-4">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control bayar" name="bayar" onkeyup="kalkulasi_seluruh()">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control tanggal_tempo" name="tanggal_tempo">
                                    <small class="text-muted">Tanggal jatuh tempo hutang</small>
                                </div>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label text-right">Sisa Hutang</label>
                            <div class="col-sm-10">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control sisa_bayar" name="sisa_bayar" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label text-right">Biaya Lainnya</label>
                            <div class="col-sm-10">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control lainnya" name="lainnya" autocomplete="off" value="0" readonly>
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
        $("#edit_harga").mask("#.##0", {
            reverse: true
        });
        $(".uang_muka").mask("#.##0", {
            reverse: true
        });
        $(".bayar").mask("#.##0", {
            reverse: true
        });
        $(".potongan").mask("#.##0", {
            reverse: true
        });
        $(".biaya_tambahan").mask("#.##0", {
            reverse: true
        });

        detail()
        barang_list()
        kalkulasi_seluruh()
    });

    function edit_harga(id) {
        console.log(id)
        console.log()
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/pembelian/pi/edit',
            dataType: "JSON",
            beforeSend: function() {
                memuat()
            },
            data: {
                id: id,
                harga: $(".edit_harga_" + id + "").val(),
            },
            success: function(data) {
                detail()
                barang_list()
                Swal.fire('Berhasil', '', 'success')
                kalkulasi_seluruh()
            }
        });
    }

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/pembelian/pi/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                console.log(data)
                Swal.fire('Berhasil', 'Pembelian berhasil ditambahkan', 'success')
                detail()
            }
        });
    })

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/pembelian/pi/detail/<?= $id; ?>/<?= $id_pembelian; ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                memuat()
                console.log(data)
                if (data.length == 0) {
                    detail_jenis_barang()
                    barang_list()
                } else {
                    $(".nomor_pembelian").val(data[0].PEMBELIAN_NOMOR)
                    $(".tanggal").val(data[0].PEMBELIAN_TANGGAL)
                    $(".supplier").val(data[0].MASTER_SUPPLIER_ID)
                    $(".jenis").val(data[0].PEMBELIAN_BARANG).trigger("change")
                    $(".akun").val(data[0].AKUN_ID)
                    $(".keterangan").html(data[0].PEMBELIAN_KETERANGAN)


                    if (data[0].TRANSAKSI == "") {
                        if (data[0].TRANSAKSI_PO != "") {
                            $(".pajak").val(data[0].TRANSAKSI_PO[0].PEMBELIAN_TRANSAKSI_PAJAK)
                            $(".potongan").val(number_format(data[0].TRANSAKSI_PO[0].PEMBELIAN_TRANSAKSI_POTONGAN))
                            $(".uang_muka").val(number_format(data[0].TRANSAKSI_PO[0].PEMBELIAN_TRANSAKSI_UANG_MUKA))
                        }

                        $(".lainnya").val(number_format(data[0].TRANSAKSI_PD[0].PEMBELIAN_TRANSAKSI_LAINNYA))
                        $(".bayar").val("0")
                        $(".biaya_tambahan").val("0")
                    } else {
                        $(".pajak").val(data[0].TRANSAKSI[0].PEMBELIAN_TRANSAKSI_PAJAK)
                        $(".potongan").val(number_format(data[0].TRANSAKSI[0].PEMBELIAN_TRANSAKSI_POTONGAN))
                        $(".uang_muka").val(number_format(data[0].TRANSAKSI[0].PEMBELIAN_TRANSAKSI_UANG_MUKA))
                        $(".lainnya").val(number_format(data[0].TRANSAKSI[0].PEMBELIAN_TRANSAKSI_LAINNYA))
                        $(".bayar").val(number_format(data[0].TRANSAKSI[0].PEMBELIAN_TRANSAKSI_BAYAR))
                        $(".biaya_tambahan").val(number_format(data[0].TRANSAKSI[0].PEMBELIAN_TRANSAKSI_BIAYA_TAMBAHAN))
                        $(".tanggal_tempo").val(data[0].TRANSAKSI[0].HUTANG_TANGGAL_TEMPO)
                    }

                    if (data[0].PEMBELIAN_STATUS == "open") {
                        $(".btn-pengiriman").attr("hidden", false)
                    } else {
                        $(".btn-pengiriman").attr("hidden", true)
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
            url: '<?php echo base_url(); ?>index.php/pembelian/po/add_barang',
            dataType: "JSON",
            beforeSend: function() {
                memuat()
            },
            data: {
                id: "<?= $id; ?>",
                id_pembelian: "<?= $id_pembelian; ?>",
                barang: $('.barang').val(),
                satuan: $('.satuan').val(),
                harga_barang: $('.harga_barang').val(),
                quantity_barang: $('.quantity_barang').val(),
            },
            success: function(data) {
                detail()
                $('.harga_barang').val("0")
                $('.quantity_barang').val("0")
                $('.total_rupiah_barang').val("0")
                kalkulasi_seluruh()
                barang_list()
            }
        });
    })

    function kalkulasi_total_rupiah_barang() {

        var quantity = $(".quantity_barang").val()
        var harga = $(".harga_barang").val()
        var total = quantity * harga
        $(".total_rupiah_barang").val(total)
    }

    function barang_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/pembelian/pi/list_barang/<?= $id; ?>/<?= $id_pembelian; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                $("tfoot#total_data").empty();
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'>Tidak ada data</td>")
                    $(".total").val("0")
                } else {
                    var no = 1
                    var total = 0
                    for (i = 0; i < data.length; i++) {
                        total += parseInt(data[i].PEMBELIAN_BARANG_TOTAL);
                        $("tbody#zone_data").append("<tr class='xxx' id_barang ='adfasdf'>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td><input type='text' class='form-control edit_harga_" + data[i].PEMBELIAN_BARANG_ID + "' id='edit_harga' id_barang='" + data[i].PEMBELIAN_BARANG_ID + "' value='" + number_format(data[i].PEMBELIAN_BARANG_HARGA) + "' onfocusout='edit_harga(\"" + data[i].PEMBELIAN_BARANG_ID + "\")'/></td>" +
                            "<td>" + data[i].PEMBELIAN_BARANG_QUANTITY + "</td>" +
                            "<td>" + data[i].PEMBELIAN_BARANG_SATUAN + "</td>" +
                            "<td align='right'>" + number_format(data[i].PEMBELIAN_BARANG_TOTAL) + "</td>" +
                            // "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].PEMBELIAN_BARANG_ID + "\")'><i class='fas fa-trash'></i></a></td>" +
                            "</tr>");
                    }
                    $("tfoot#total_data").append("<tr><td colspan='5' align='right'><b>Total</b></td><td align='right'>" + number_format(total) + "</td></tr>")
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
                    url: '<?php echo base_url() ?>index.php/pembelian/po/hapus/' + id,
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

    $('.pajak').change(function() {
        kalkulasi_seluruh()
    });

    function kalkulasi_seluruh() {
        var pajak = ($(".pajak").val())
        console.log($(".pajak").val())
        var potongan = parseInt($(".potongan").val().split('.').join(""))

        var total = parseInt($(".total").val().split('.').join(""))
        var uang_muka = parseInt($(".uang_muka").val().split('.').join(""))
        var bayar = parseInt($(".bayar").val().split('.').join(""))

        var biaya_tambahan = parseInt($(".biaya_tambahan").val().split('.').join(""))

        var pajak_rupiah = (total - potongan) * (pajak / 100)
        $(".pajak_rupiah").val(number_format(pajak_rupiah))

        var total_bayar = (total - potongan) + pajak_rupiah
        var grand_total = total_bayar - uang_muka + biaya_tambahan
        $(".grand_total").val(number_format(grand_total))

        var sisa_bayar = grand_total - bayar
        $(".total_bayar").val(number_format(total_bayar))
        $(".sisa_bayar").val(number_format(sisa_bayar))

        if (grand_total > 0) {
            $("div.pengembalian_dana").attr("hidden", true)
        }
    }

    $(".btn-pengiriman").on("click", function() {
        Swal.fire({
            title: 'Buat Pengiriman ?',
            icon: 'question',
            text: 'Setelah membuat Pengiriman, anda tidak dapat merubah form pemesanan',
            showCancelButton: true,
            confirmButtonText: `Buat`,
            denyButtonText: `Batal`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url(); ?>index.php/pembelian/po/po_to_pd/<?= $id; ?>/<?= $id_pembelian; ?>',
                    type: "ajax",
                    dataType: 'json',
                    beforeSend: function() {
                        memuat()
                    },
                    success: function(data) {
                        window.open(
                            '<?= base_url(); ?>pembelian/pd/form_pd/' + data.PD_ID + '/' + data.PEMBELIAN_ID,
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