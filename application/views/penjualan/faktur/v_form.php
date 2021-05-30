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

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">No Faktur</label>
                                            <input type="text" class="form-control nomor_faktur" name="nomor_faktur" autocomplete="off" readonly>
                                            <small class="text-muted">Nomor Otomatis akan terisi.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?= $this->lang->line('tanggal'); ?></label>
                                            <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" value="<?= date("Y-m-d"); ?>" required readonly>
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
                                        <th>Surat Jalan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="form_tt">
                                    <tr class="table-secondary">
                                        <td>#
                                        </td>
                                        <td>
                                            <select name="surat_jalan" id="surat_jalan" class="form-control form-control-sm surat_jalan select2" style="width: 100%;">
                                                <option value="">-- Surat Jalan --</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-secondary btn-sm btn-add-surat-jalan"><i class="nav-icon fas fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody id="zone_data">
                                    <tr>
                                    </tr>
                                </tbody>
                            </table>
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
                                        <th>Jenis</th>
                                        <th>Quantity</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="zone_data_barang">
                                </tbody>
                                <tfoot id="total_rp">

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
                                            <label class="col-sm-2 col-form-label text-right">Total</label>
                                            <div class="col-sm-10">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" class="form-control grand_total" name="grand_total" readonly>
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
                                            <div class="col-sm-7">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" class="form-control bayar" name="bayar" onkeyup="kalkulasi_seluruh()" required>
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
        $(".bayar").mask("#.##0", {
            reverse: true
        });
        detail()
        surat_jalan_list()
        barang_list()
    });

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/penjualan/faktur/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                window.location.href = '<?= base_url(); ?>penjualan/faktur/form/<?= $id; ?>'

            }
        });
    })

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/penjualan/faktur/detail/<?= $id; ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                memuat()
                console.log(data)
                if (data.length == 0) {} else {
                    $(".nomor_faktur").val(data[0].FAKTUR_NOMOR)
                    $(".tanggal").val(data[0].FAKTUR_TANGGAL)
                    $(".relasi").val(data[0].MASTER_RELASI_ID).trigger("change")
                    $(".akun").val(data[0].AKUN_ID).trigger("change")
                    $(".keterangan").val(data[0].FAKTUR_KETERANGAN)
                    if (data[0].TRANSAKSI.length == 0) {
                        console.log("kosong")
                    } else {
                        // $(".total").val(data[0].TRANSAKSI[0].FAKTUR_TRANSAKSI_TOTAL)
                        $(".pajak").val(data[0].TRANSAKSI[0].FAKTUR_TRANSAKSI_PAJAK).trigger("change")
                        $(".bayar").val(number_format(data[0].TRANSAKSI[0].PEMBELIAN_TRANSAKSI_BAYAR))
                    }
                    kalkulasi_seluruh()

                }
            },
            error: function(x, e) {} //end error
        });
    }



    $('#relasi').change(function() {
        surat_jalan()
    });

    function surat_jalan() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/penjualan/faktur/surat_jalan?relasi=" + $(".relasi").val(),
            async: false,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $("select#surat_jalan").empty();
                if (data.length === 0) {} else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        $("#surat_jalan").append("<option value='" + data[i].SURAT_JALAN_ID + "'>" + data[i].SURAT_JALAN_NOMOR + "</option>")
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    $('.btn-add-surat-jalan').on("click", function(e) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/penjualan/faktur/add_surat_jalan',
            dataType: "JSON",
            beforeSend: function() {
                memuat()
            },
            data: {
                id: "<?= $id; ?>",
                surat_jalan: $('.surat_jalan').val(),
            },
            success: function(data) {
                memuat()
                surat_jalan_list()
                barang_list()
                kalkulasi_seluruh()
            }
        });
    })






    function surat_jalan_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/penjualan/faktur/surat_jalan_list/<?= $id; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                $("tfoot#total_rp").empty();
                if (data.length === 0) {

                } else {
                    var no = 1;
                    for (i = 0; i < data.length; i++) {
                        $(".surat_jalan option[value='" + data[i].SURAT_JALAN_ID + "']").remove();
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].SURAT_JALAN_NOMOR + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].FAKTUR_SURAT_JALAN_ID + "\")'><i class='fas fa-trash'></i></a> " +
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

    function barang_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/penjualan/faktur/barang_list/<?= $id; ?>?relasi=" + $(".relasi").val() + "",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data_barang").empty();
                if (data.length === 0) {
                    $(".total").val("0")
                    kalkulasi_seluruh()
                } else {
                    var no = 1;
                    var total_rp = 0
                    var total_qty = 0
                    for (i = 0; i < data.length; i++) {
                        if (data[i].FAKTUR_BARANG_HARGA > 0) {
                            var harga = data[i].FAKTUR_BARANG_HARGA
                        } else {
                            if (data[i].HARGA.length == 0) {
                                var harga = "0"
                            } else {
                                var harga = data[i].HARGA[0].MASTER_HARGA_HARGA
                            }
                        }

                        var total = data[i].FAKTUR_BARANG_QUANTITY * harga;
                        total_rp += total
                        total_qty += parseInt(data[i].FAKTUR_BARANG_QUANTITY)
                        $("tbody#zone_data_barang").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + data[i].FAKTUR_BARANG_JENIS + "</td>" +
                            "<td align='right'>" + data[i].FAKTUR_BARANG_QUANTITY + "</td>" +
                            "<td align='right'>" + number_format(harga) + "</td>" +
                            "<td align='right'>" + number_format(total) + "</td>" +
                            "</tr>");
                    }
                    $(".total").val(number_format(total_rp))
                    kalkulasi_seluruh()
                    $("tfoot#total_rp").append("<tr><td colspan='3' align='right'><b>Total</b></td><td align='right'>" + number_format(total_qty) + "</td><td></td><td align='right'>" + number_format(total_rp) + "</td></tr>")
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
                    url: '<?php echo base_url() ?>index.php/penjualan/faktur/hapus/' + id,
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            Swal.fire('Berhasil', '', 'success')
                            surat_jalan_list()
                            barang_list()
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

    $('.pajak').change(function() {
        kalkulasi_seluruh()
    });

    function kalkulasi_seluruh() {
        var pajak = ($(".pajak").val())
        console.log($(".pajak").val())

        var total = parseInt($(".total").val().split('.').join(""))
        var bayar = parseInt($(".bayar").val().split('.').join(""))

        var pajak_rupiah = total * (pajak / 100)
        $(".pajak_rupiah").val(number_format(pajak_rupiah))

        var total_bayar = total + pajak_rupiah
        var grand_total = total_bayar
        $(".grand_total").val(number_format(grand_total))

        var sisa_bayar = grand_total - bayar
        $(".total_bayar").val(number_format(total_bayar))
        $(".sisa_bayar").val(number_format(sisa_bayar))
    }
</script>