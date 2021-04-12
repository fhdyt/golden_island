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
                    <h1 class="m-0">Form Pembelian</h1>
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
                                            <label for="exampleInputEmail1">Purchasing Order</label>
                                            <select name="po" id="po" class="form-control po select2" style="width: 100%;">
                                                <option value="">-- Pilih PO --</option>
                                                <?php foreach ($po as $row) {
                                                ?>
                                                    <option value="<?= $row->PO_ID; ?>"><?= $row->PO_NOMOR_SURAT; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <small class="text-muted">Nomor Purchasing Order.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nomor Surat</label>
                                            <input type="text" class="form-control nomor_surat" name="nomor_surat" autocomplete="off" required>
                                            <small class="text-muted">*Wajib diisi.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tanggal</label>
                                            <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required>
                                            <small class="text-muted">*Wajib diisi.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Supplier</label>
                                            <select name="supplier" id="supplier" class="form-control supplier select2" style="width: 100%;" required>
                                                <option value="">-- Pilih Supplier --</option>
                                                <?php foreach ($supplier as $row) {
                                                ?>
                                                    <option value="<?= $row->MASTER_SUPPLIER_ID; ?>"><?= $row->MASTER_SUPPLIER_NAMA; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <small class="text-muted">*Wajib diisi.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Jenis Barang</label>
                                            <select name="jenis" id="jenis" class="form-control jenis select2" style="width: 100%;">
                                                <option value="">-- Jenis Barang --</option>

                                                <?php
                                                foreach (jenis_barang() as $value => $text) {
                                                ?>
                                                    <option value="<?= $value; ?>"><?= $text; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <small class="text-muted">*Wajib diisi.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Dokumen Terkait</label>
                                            <input type="file" name="userfile" class="form-control">
                                            <small class="text-muted"><a href="" target="_blank" class="link_dokument"></a></small>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Keterangan</label>
                                            <textarea name="keterangan" id="keterangan" class="form-control keterangan"></textarea>
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
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="form_tt">
                                    <tr class="table-warning">
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
                                                <?php
                                                foreach (satuan() as $value => $text) {
                                                ?>
                                                    <option value="<?= $value; ?>"><?= $text; ?></option>
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
                                    </tr>
                                </tbody>
                                <tbody id="zone_data">
                                    <tr>
                                        <td colspan="9">
                                            <center>
                                                <div class="loader"></div>
                                            </center>
                                        </td>
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
                                        <input type="text" class="form-control potongan" name="potongan" onkeyup="kalkulasi_seluruh()" autocomplete="off" value="0">
                                    </div>
                                    <small class="text-muted">Potongan harga dari Supplier.</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">PPN</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <input type="checkbox" class="ppn_check" name="ppn_check">
                                                </span>
                                            </div>
                                            <input type="text" class="form-control ppn_rupiah" name="ppn_rupiah" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">Sub Total</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control sub_total" name="sub_total" readonly>
                                    </div>
                                    <small class="text-muted">Total Pembelian + PPN - Potongan.</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">Biaya Tambahan</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control biaya_tambahan" name="biaya_tambahan" value="0" onkeyup="kalkulasi_seluruh()">
                                    </div>
                                    <small class="text-muted">Biaya tambahan termasuk Ongkos Kirim dll.</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">Grand Total</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control grand_total" name="grand_total" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">Bayar</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control bayar" name="bayar" autocomplete="off" value="0" onkeyup="kalkulasi_seluruh()">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-right">Sisa Bayar</label>
                                <div class="col-sm-10">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control sisa_bayar" name="sisa_bayar" readonly>
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
                        <button type="submit" class="btn btn-success btn-lg">Simpan</button>
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
        $(".potongan").mask("#.##0", {
            reverse: true
        });

        $(".biaya_tambahan").mask("#.##0", {
            reverse: true
        });

        $(".bayar").mask("#.##0", {
            reverse: true
        });
        detail()
    });

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/pembelian/pembelian/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                Swal.fire('Berhasil', 'Pembelian berhasil ditambahkan', 'success')
                detail()
            }
        });
    })

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/pembelian/pembelian/detail/<?= $id; ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                if (data.length == 0) {
                    detail_jenis_barang()
                    barang_list()
                } else {
                    console.log(data)
                    $(".nomor_surat").val(data[0].PEMBELIAN_NOMOR_SURAT)
                    $(".tanggal").val(data[0].PEMBELIAN_TANGGAL)
                    $(".supplier").val(data[0].MASTER_SUPPLIER_ID)
                    $(".po").val(data[0].PO_ID)
                    $(".jenis").val(data[0].PEMBELIAN_JENIS)
                    $(".keterangan").val(data[0].PEMBELIAN_KETERANGAN)
                    if (data[0].PEMBELIAN_FILE == "") {

                    } else {
                        $("a.link_dokument").html("Lihat Dokumen")
                        $("a.link_dokument").prop("href", "<?= base_url(); ?>uploads/pembelian/" + data[0].PEMBELIAN_FILE + "")
                    }
                    if (data[0].TRANSAKSI_PEMBELIAN_PPN == "on") {
                        $('.ppn_check').prop('checked', true);
                    }
                    $(".ppn_rupiah").val(number_format(data[0].TRANSAKSI_PEMBELIAN_PPN_RUPIAH))
                    $(".sub_total").val(number_format(parseInt(data[0].SUB_TOTAL[0].TOTAL) + parseInt(data[0].TRANSAKSI_PEMBELIAN_PPN_RUPIAH)))
                    $(".potongan").val(number_format(data[0].TRANSAKSI_PEMBELIAN_POTONGAN))
                    $(".biaya_tambahan").val(number_format(data[0].TRANSAKSI_PEMBELIAN_BIAYA_TAMBAHAN))
                    $(".bayar").val(number_format(data[0].TRANSAKSI_PEMBELIAN_BAYAR))
                    $(".sisa_bayar").val(number_format(data[0].TRANSAKSI_PEMBELIAN_SISA_BAYAR))
                    $(".sub_total").val(number_format(parseInt(data[0].SUB_TOTAL[0].TOTAL) + parseInt(data[0].TRANSAKSI_PEMBELIAN_PPN_RUPIAH)))

                    detail_jenis_barang()
                    barang_list()
                    kalkulasi_seluruh()
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
            url: "<?php echo base_url() ?>index.php/pembelian/pembelian/detail_jenis_barang?jenis=" + $(".jenis").val(),
            async: false,
            dataType: 'json',
            success: function(data) {
                $("select#barang").empty();
                console.log(data)
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
            url: '<?php echo base_url(); ?>index.php/pembelian/pembelian/add_barang',
            dataType: "JSON",
            data: {
                id: "<?= $id; ?>",
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
            url: "<?php echo base_url() ?>index.php/pembelian/pembelian/list_barang/<?= $id; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                $("tfoot#total_data").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'>Tidak ada data</td>")
                } else {
                    var no = 1
                    var total = 0
                    for (i = 0; i < data.length; i++) {
                        total += parseInt(data[i].PEMBELIAN_BARANG_TOTAL);
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + number_format(data[i].PEMBELIAN_BARANG_HARGA) + "</td>" +
                            "<td>" + number_format(data[i].PEMBELIAN_BARANG_QUANTITY) + "</td>" +
                            "<td>" + data[i].PEMBELIAN_BARANG_SATUAN + "</td>" +
                            "<td align='right'>" + number_format(data[i].PEMBELIAN_BARANG_TOTAL) + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].PEMBELIAN_BARANG_ID + "\")'><i class='fas fa-trash'></i></a></td>" +
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
        console.log(id)
        Swal.fire({
            title: 'Hapus ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Hapus`,
            denyButtonText: `Batal`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'ajax',
                    url: '<?php echo base_url() ?>index.php/pembelian/pembelian/hapus/' + id,
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            detail();
                            Swal.fire('Berhasil', 'Jenis Barang Berhasil dihapus', 'success')
                            kalkulasi_seluruh()
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

    $('.ppn_check').change(function() {
        kalkulasi_seluruh()
    });

    function kalkulasi_seluruh() {
        console.log("Kalkulasi Seluruh")
        var potongan = parseInt($(".potongan").val().split('.').join(""))
        var total = parseInt($(".total").val().split('.').join(""))

        if ($(".ppn_check").is(':checked')) {
            var ppn = (total - potongan) * 0.1
        } else {
            var ppn = 0
        }

        $(".ppn_rupiah").val(number_format(ppn))

        var total = parseInt($(".total").val().split('.').join(""))
        var sub_total = total - potongan + ppn
        $(".sub_total").val(number_format(sub_total))
        var biaya_tambahan = parseInt($(".biaya_tambahan").val().split('.').join(""))
        var grand_total = biaya_tambahan + sub_total

        var bayar = parseInt($(".bayar").val().split('.').join(""))
        var sisa_bayar = grand_total - bayar
        $(".grand_total").val(number_format(grand_total))
        $(".sisa_bayar").val(number_format(sisa_bayar))
    }

    $('.po').change(function() {
        var id = $(this).val()
        pilih_po_barang(id)
    });

    function pilih_po_barang(id) {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/pembelian/pembelian/pilih_po_barang/' + id + "/<?= $id; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                if (data.length === 0) {} else {
                    detail();
                    Swal.fire('Berhasil', 'Berhasil ditambah', 'success')
                    kalkulasi_seluruh()
                }
            },
            error: function(x, e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Proses Gagal'
                })
            }
        });
    }
</script>