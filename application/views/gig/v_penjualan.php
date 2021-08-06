<div class="modal fade" id="pajakModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pajak</h4>
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
                        <label for="exampleInputEmail1"><?= $this->lang->line('nama'); ?></label>
                        <input type="text" class="form-control nama" name="nama" autocomplete="off">
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">

                        <label for="exampleInputEmail1">Nilai</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control nilai" name="nilai" autocomplete="off">
                            <div class="input-group-prepend">
                                <span class="input-group-text">%</span>
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
                    <h1 class="m-0">Penjualan</h1>
                    <small class="text-muted">PT. GOLDEN ISLAND GROUP</small>
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
                            <select name="perusahaan" id="perusahaan" class="form-control perusahaan select2" style="width: 100%;" required>
                                <option value="">-- Perusahaan --</option>
                                <?php
                                foreach (perusahaan_akses() as $row) {
                                ?>
                                    <option value="<?= $row->PERUSAHAAN_KODE; ?>"><?= $row->PERUSAHAAN_NAMA; ?> (<?= $row->PERUSAHAAN_KODE; ?>)</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="relasi_filter" id="relasi_filter" class="form-control relasi_filter select2" style="width: 100%;">
                                <option value="">-</option>
                                <?php
                                foreach (relasi_list() as $row) {
                                ?>
                                    <option value="<?= $row->MASTER_RELASI_ID; ?>"><?= $row->MASTER_RELASI_NAMA; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <small class="text-muted">Nama Relasi</small>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control tanggal_dari" name="tanggal_dari" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                            <small class="text-muted">Tanggal Dari.</small>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="date" class="form-control tanggal_sampai" name="tanggal_sampai" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-success filter_tanggal"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <small class="text-muted">Tanggal Sampai.</small>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;">No.</th>
                                <th style="text-align: center; vertical-align: middle;">Nomor Surat Jalan</th>
                                <th style="text-align: center; vertical-align: middle;">Nama Relasi</th>
                                <th style="text-align: center; vertical-align: middle;">Jenis Barang</th>
                                <th style="text-align: center; vertical-align: middle;">Qty</th>
                                <th style="text-align: center; vertical-align: middle;">Harga</th>
                                <th style="text-align: center; vertical-align: middle;">Total</th>
                                <th style="text-align: center; vertical-align: middle;">Tunai</th>
                                <th style="text-align: center; vertical-align: middle;">Piutang</th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                            </tr>
                        </tbody>
                        <tbody id="zone_data_total">
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Barang</th>
                                <th style="text-align:right">Saldo</th>
                            </tr>
                        </thead>
                        <tbody id="zone_data_barang">
                            <tr>
                            </tr>
                        </tbody>
                        <tbody id="zone_data_barang_total">
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
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#pajakModal").modal("show")
    })
    $(function() {
        memuat();
    });

    function penjualan_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/gig/penjualan/list",
            async: false,
            dataType: 'json',
            data: {
                relasi: $(".relasi_filter").val(),
                tanggal_dari: $(".tanggal_dari").val(),
                tanggal_sampai: $(".tanggal_sampai").val(),
                perusahaan: $(".perusahaan").val()
            },
            success: function(data) {
                $("tbody#zone_data").empty();
                $("tbody#zone_data_total").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var tableContent = "";
                    var no = 1
                    var total_seluruh_penjualan = 0
                    var total_terbayar = 0
                    var total_piutang = 0
                    for (i = 0; i < data.length; i++) {
                        var rowspan = 0;
                        var detailLength = data[i].BARANG.length;
                        rowspan += detailLength;

                        if (data[i].TERBAYAR.length == 0) {
                            var terbayar = 0
                            var piutang = data[i].TOTAL
                            var btn_faktur_cetak = "<a class='btn btn-danger btn-xs'>Belum Ada Faktur</a>"
                        } else {
                            var grandtotal = data[i].TERBAYAR[0].FAKTUR_TRANSAKSI_GRAND_TOTAL;
                            var selisih = parseInt(data[i].TERBAYAR[0].PEMBELIAN_TRANSAKSI_BAYAR) - parseInt(data[i].TOTAL);
                            var terbayar = parseInt(data[i].TERBAYAR[0].PEMBELIAN_TRANSAKSI_BAYAR) - selisih;
                            var piutang = parseInt(data[i].TOTAL) - parseInt(terbayar) - parseInt(data[i].TERBAYAR[0].FAKTUR_TRANSAKSI_POTONGAN)
                            if (piutang < 0) {
                                piutang = 0
                            } else {
                                piutang = piutang
                            }
                            var btn_faktur_cetak = "<a class='btn btn-primary btn-xs' target='_blank' href='<?= base_url(); ?>cetak/faktur_penjualan/" + data[i].TERBAYAR[0].FAKTUR_ID + "'>Lihat Faktur Penjualan</a>"
                        }
                        var btn_cetak = "<a class='btn btn-success btn-xs' target='_blank' href='<?= base_url(); ?>cetak/cetak_sj/" + data[i].SURAT_JALAN_ID + "'>Lihat Surat Jalan</a>"

                        if (isNaN(piutang)) {
                            piutang = 0;
                        }
                        total_terbayar += parseInt(terbayar)
                        total_piutang += parseInt(piutang)
                        tableContent += "<tr><td rowspan=" + parseInt(1 + rowspan) + " style='text-align:center; vertical-align:middle'>" + no++ + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + " style='text-align:center; vertical-align:middle'>" + data[i].SURAT_JALAN_NOMOR + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + " style='text-align:center; vertical-align:middle'>" + data[i].RELASI[0].MASTER_RELASI_NAMA + "<br>" + btn_cetak + "<br>" + btn_faktur_cetak + "</td></td>" +
                            "<td colspan='4'></td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + " style='text-align:right; vertical-align:middle'>" + number_format(terbayar) + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + " style='text-align:right; vertical-align:middle'>" + number_format(piutang) + "</td>" +
                            "</tr>";
                        var barangLlength = 0;

                        for (var j = 0; j < detailLength; j++) {
                            if (data[i].SURAT_JALAN_STATUS == "open") {
                                var quantity = parseInt(data[i].BARANG[j].SURAT_JALAN_BARANG_QUANTITY) - parseInt(data[i].BARANG[j].SURAT_JALAN_BARANG_QUANTITY_KLAIM)
                                if (data[i].BARANG[j].HARGA_BARANG.length == 0) {
                                    var harga = data[i].BARANG[j].MASTER_BARANG_HARGA_SATUAN
                                } else {
                                    var harga = data[i].BARANG[j].HARGA_BARANG[0].MASTER_HARGA_HARGA
                                }

                                var terbayar = 0

                            } else if (data[i].SURAT_JALAN_STATUS == "close") {
                                var quantity = data[i].BARANG[j].FAKTUR_BARANG_QUANTITY
                                var harga = data[i].BARANG[j].FAKTUR_BARANG_HARGA
                                var terbayar = 0

                            } else {
                                var quantity = 0
                                var harga = 0
                            }
                            var total_harga = quantity * harga
                            tableContent += "<tr>" +
                                "<td>" + data[i].BARANG[j].NAMA_BARANG[0].MASTER_BARANG_NAMA + "</td>" +
                                "<td style='text-align:right'>" + quantity + "</td>" +
                                "<td style='text-align:right'>" + number_format(harga) + "</td>" +
                                "<td style='text-align:right'>" + number_format(total_harga) + "</td>" +
                                "</tr>";
                        }
                    }
                    $("tbody#zone_data").append(tableContent);
                    $("tbody#zone_data_total").append("<tr>" +
                        "<td colspan='7' style='text-align:right'><b>Total</b></td><td style='text-align:right'>" + number_format(total_terbayar) + "</td><td style='text-align:right'>" + number_format(total_piutang) + "</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td colspan='7' style='text-align:right'><b>Total Penjualan</b></td><td colspan='2' style='text-align:center'>Rp. " + number_format(total_terbayar + total_piutang) + "</td>" +
                        "</tr>");
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function barang_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/gig/penjualan/barang_list",
            async: false,
            dataType: 'json',
            data: {
                relasi: $(".relasi_filter").val(),
                tanggal_dari: $(".tanggal_dari").val(),
                tanggal_sampai: $(".tanggal_sampai").val(),
                perusahaan: $(".perusahaan").val()
            },
            success: function(data) {
                $("tbody#zone_data_barang").empty();
                $("tbody#zone_data_barang_total").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data_barang").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var total_seluruh = 0
                    for (i = 0; i < data.length; i++) {
                        data = jQuery.grep(data, function(value) {
                            return value.TOTAL != "0";
                        });

                        total_seluruh += data[i].TOTAL
                        $("tbody#zone_data_barang").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td style='text-align:right'>" + data[i].TOTAL + "</td>" +
                            "</tr>");
                    }
                    $("tbody#zone_data_barang_total").append("<tr><td colspan='2' style='text-align:right'><b>Total</b></td><td style='text-align:right'>" + number_format(total_seluruh) + "</td></tr>");
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
                    url: '<?php echo base_url() ?>index.php/konfigurasi/pajak/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            pajak_list();
                            Swal.fire('Berhasil', 'Pajak Berhasil dihapus', 'success')
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
        if ($(".perusahaan").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silahkan pilih Perusahaan terlebih dahulu'
            })
        } else {
            memuat()
            penjualan_list()
            barang_list()
        }

    });
</script>