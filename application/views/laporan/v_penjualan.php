<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Penjualan</h1>
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
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-success filter_tanggal"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <small class="text-muted">Tanggal Penjualan.</small>
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
    $(function() {
        penjualan_list()
        barang_list()
    });

    function penjualan_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/laporan/penjualan/list",
            async: false,
            dataType: 'json',
            data: {
                tanggal: $(".tanggal").val(),
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
                        } else {
                            var grandtotal = data[i].TERBAYAR[0].FAKTUR_TRANSAKSI_GRAND_TOTAL;
                            var terbayar = data[i].TERBAYAR[0].PEMBELIAN_TRANSAKSI_BAYAR;
                            var piutang = parseInt(grandtotal) - parseInt(terbayar)
                            if (piutang < 0) {
                                piutang = 0
                            } else {
                                piutang = piutang
                            }
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

                        tableContent += "<tr><td rowspan=" + parseInt(1 + rowspan) + " style='text-align:center; vertical-align:middle'>" + no++ + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + " style='text-align:center; vertical-align:middle'><b>" + data[i].SURAT_JALAN_NOMOR + "</b><br>" + riwayat_status + "<br>" + riwayat_status_ttbk + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + " style='text-align:center; vertical-align:middle'>" + data[i].RELASI[0].MASTER_RELASI_NAMA + "<br>" + btn_cetak + "</td>" +
                            "<td colspan='4'></td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + " style='text-align:right; vertical-align:middle'>" + number_format(terbayar) + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + " style='text-align:right; vertical-align:middle'>" + number_format(piutang) + "</td>" +
                            "</tr>";
                        var barangLlength = 0;

                        for (var j = 0; j < detailLength; j++) {
                            if (data[i].SURAT_JALAN_STATUS == "open") {
                                var quantity = parseInt(data[i].BARANG[j].SURAT_JALAN_BARANG_QUANTITY) - parseInt(data[i].BARANG[j].SURAT_JALAN_BARANG_QUANTITY_KLAIM)
                                if (data[i].BARANG[j].HARGA_BARANG.length == 0) {
                                    var harga = 0
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
            url: "<?php echo base_url() ?>index.php/laporan/penjualan/barang_list",
            async: false,
            dataType: 'json',
            data: {
                tanggal: $(".tanggal").val(),
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
        memuat()
        penjualan_list()
        barang_list()
    });
</script>