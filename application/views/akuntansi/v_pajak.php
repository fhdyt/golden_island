<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Akun'); ?></h1>
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
                            <select name="jenis_pajak" id="jenis_pajak" class="form-control select2 jenis_pajak" style="width: 100%;">
                                <option value="masukan">-- Pilih Jenis --</option>
                                <option value="masukan">Masukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="bulan" id="bulan" class="form-control select2 bulan" style="width: 100%;">
                                <?php
                                foreach (bulan() as $value => $text) {
                                    if ($value == date("m")) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                ?>
                                    <option value="<?= $value; ?>" <?= $select; ?>><?= $text; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="tahun" id="tahun" class="form-control select2 tahun" style="width: 100%;">
                                <?php
                                foreach (tahun() as $value => $text) {
                                    if ($value == date("Y")) {
                                        $select = "selected";
                                    } else {
                                        $select = "";
                                    }
                                ?>
                                    <option value="<?= $value; ?>" <?= $select; ?>><?= $text; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-success filter btn-block"><i class="fas fa-search"></i> Cari</a>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Fakur</th>
                                <th>Pajak (%)</th>
                                <th>Rupiah</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                            </tr>
                        </tbody>
                        <tfoot id="zone_data">
                            <tr>
                            </tr>
                        </tfoot>
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
        memuat();
    });

    function pajak_list() {
        $.ajax({
            type: 'post',
            url: "<?php echo base_url() ?>index.php/akuntansi/pajak/list",
            async: false,
            dataType: 'json',
            data: {
                jenis_pajak: $('.jenis_pajak').val(),
                relasi_supplier: $('.relasi_supplier').val(),
                bulan: $('.bulan').val(),
                tahun: $('.tahun').val(),
            },
            success: function(data) {
                memuat()
                $("tbody#zone_data").empty();
                $("tfoot#zone_data").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var total_pajak = 0
                    if ($('.jenis_pajak').val() == "masukan") {
                        for (i = 0; i < data.length; i++) {
                            total_pajak += parseInt(data[i].PEMBELIAN_TRANSAKSI_PAJAK_RUPIAH)
                            $("tbody#zone_data").append("<tr class=''>" +
                                "<td>" + no++ + ".</td>" +
                                "<td>" + data[i].PEMBELIAN_NOMOR + "</td>" +
                                "<td>" + data[i].PEMBELIAN_TRANSAKSI_PAJAK + "</td>" +
                                "<td align='right'>" + number_format(data[i].PEMBELIAN_TRANSAKSI_PAJAK_RUPIAH) + "</td>" +

                                "</tr>");
                        }
                    } else if ($('.jenis_pajak').val() == "pengeluaran") {
                        for (i = 0; i < data.length; i++) {
                            total_pajak += parseInt(data[i].FAKTUR_TRANSAKSI_PAJAK_RUPIAH)
                            $("tbody#zone_data").append("<tr class=''>" +
                                "<td>" + no++ + ".</td>" +
                                "<td>" + data[i].FAKTUR_NOMOR + "</td>" +
                                "<td>" + data[i].FAKTUR_TRANSAKSI_PAJAK + "</td>" +
                                "<td align='right'>" + number_format(data[i].FAKTUR_TRANSAKSI_PAJAK_RUPIAH) + "</td>" +

                                "</tr>");
                        }
                    }
                    $("tfoot#zone_data").append("<tr><td colspan='3' style='text-align:right; vertical-align:middle;'><b>Total</b></td><td align='right'>" + number_format(total_pajak) + "</td></tr>")

                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }


    $(".filter").on("click", function() {
        memuat()
        pajak_list()
    })
</script>