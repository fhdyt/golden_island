<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Realtime Penjualan</h1>
                    <small class="text-muted">PT. BUMI GASINDO SUMATERA</small>

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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <input type="date" class="form-control tanggal_dari" name="tanggal_dari" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                            <small class="text-muted">Tanggal Dari.</small>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" class="form-control tanggal_sampai" name="tanggal_sampai" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-success filter_tanggal"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <small class="text-muted">Tanggal Sampai.</small>
                        </div>
                    </div>
                    <hr>
                    <h4 class="text-muted">Penjualan</h4>
                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;">No.</th>
                                <th>Nomor Surat Jalan</th>
                                <th>Tanggal</th>
                                <th>Nama Relasi</th>
                                <th>Jenis Barang</th>
                                <th>Qty</th>
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
                    <h4 class="text-muted">Jumlah Penjualan</h4>
                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Barang</th>
                                <th style="text-align:right">Jumlah</th>
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
    $(function() {
        penjualan_list()
        barang_list()
    });

    function penjualan_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/laporan/penjualan/list_bgs",
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
                    var total_qty = 0
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
                            var terbayar = data[i].TERBAYAR[0].PEMBELIAN_TRANSAKSI_BAYAR;
                            var piutang = parseInt(data[i].TOTAL) - parseInt(terbayar)
                            if (piutang < 0) {
                                piutang = 0
                            } else {
                                piutang = piutang
                            }
                            var btn_faktur_cetak = "<a class='btn btn-primary btn-xs' target='_blank' href='<?= base_url(); ?>cetak/faktur/" + data[i].TERBAYAR[0].FAKTUR_ID + "'>Lihat Faktur Penjualan</a>"
                        }
                        total_terbayar += parseInt(terbayar)
                        total_piutang += parseInt(piutang)

                        if (data[i].SURAT_JALAN_REALISASI_STATUS != "selesai") {
                            var riwayat_status = "<small class='text-danger'>Belum Realisasi</small>"
                        } else {
                            var riwayat_status = "<small class='text-success'>Telah Terealisasi</small>"
                        }

                        if (data[i].SURAT_JALAN_REALISASI_TTBK_STATUS != "selesai") {
                            var riwayat_status_ttbk = "<small class='text-danger'>TTBK Belum Realisasi</small>"
                        } else {
                            var riwayat_status_ttbk = "<small class='text-success'>TTBK Telah terealisasi</small>"

                        }

                        var btn_cetak = "<a class='btn btn-success btn-xs' target='_blank' href='<?= base_url(); ?>cetak/cetak_sj/" + data[i].SURAT_JALAN_ID + "'>Lihat Surat Jalan</a>"

                        tableContent += "<tr><td rowspan=" + parseInt(1 + rowspan) + " style='vertical-align:middle'>" + no++ + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + " style='vertical-align:middle'><b>" + data[i].SURAT_JALAN_NOMOR + "</b></td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + " style='vertical-align:middle'>" + data[i].TANGGAL + " (" + data[i].JAM + ")</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + " style='vertical-align:middle'>" + data[i].RELASI[0].MASTER_RELASI_NAMA + "</td>" +
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
                            total_qty += parseInt(quantity)
                            tableContent += "<tr>" +
                                "<td>" + data[i].BARANG[j].NAMA_BARANG[0].MASTER_BARANG_NAMA + "</td>" +
                                "<td style='text-align:right'>" + quantity + "</td>" +
                                "</tr>";
                        }
                    }
                    $("tbody#zone_data").append(tableContent);
                    $("tbody#zone_data_total").append("<tr>" +
                        "<td colspan='5' style='text-align:right'><b>Total</b></td><td style='text-align:right'>" + total_qty + "</td>" +
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
            url: "<?php echo base_url() ?>index.php/laporan/penjualan/barang_list",
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


    $('.filter_tanggal').on("click", function() {
        if ($('.tanggal_dari').val() < "2021-07-05") {
            $("tbody#zone_data").empty()
            $("tbody#zone_data_barang").empty()
            $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
            $("tbody#zone_data_barang").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
        } else {
            memuat()
            penjualan_list()
            barang_list()
        }
    });
</script>