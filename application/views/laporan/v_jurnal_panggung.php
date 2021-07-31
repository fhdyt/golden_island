<style>
    .table {
        font-size: small;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Jurnal Panggung</h1>
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
                            <select name="supplier_filter" id="supplier_filter" class="form-control supplier_filter select2" style="width: 100%;">
                                <option value="">-</option>
                                <?php
                                foreach (supplier_list() as $row) {
                                ?>
                                    <option value="<?= $row->MASTER_SUPPLIER_ID; ?>"><?= $row->MASTER_SUPPLIER_NAMA; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <small class="text-muted">Nama Supplier</small>
                        </div>
                        <div class="col-md-4">
                            <select name="tabung_filter" id="tabung_filter" class="form-control tabung_filter select2" style="width: 100%;">
                                <option value="">-</option>
                                <?php
                                foreach (tabung($relasi[0]->MASTER_RELASI_ID) as $row) {
                                ?>
                                    <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <small class="text-muted">Jenis Barang</small>
                        </div>
                        <div class="col-md-4 mt-2">
                            <select name="in_out_filter" id="in_out_filter" class="form-control in_out_filter select2" style="width: 100%;">
                                <option value="">-</option>
                                <option value="in">Masuk</option>
                                <option value="out">Keluar</option>
                            </select>
                            <small class="text-muted">Status Keluar Masuk</small>
                        </div>
                        <div class="col-md-4 mt-2">
                            <select name="isi_kosong_filter" id="isi_kosong_filter" class="form-control isi_kosong_filter select2" style="width: 100%;">
                                <option value="">-</option>
                                <option value="1">Isi</option>
                                <option value="0">Kosong</option>
                            </select>
                            <small class="text-muted">Status Isi Kosong</small>
                        </div>
                        <div class="col-md-4 mt-2">
                            <select name="status_filter" id="status_filter" class="form-control status_filter select2" style="width: 100%;">
                                <option value="">-</option>
                                <option value="MP">MP</option>
                                <option value="MR">MR</option>
                            </select>
                            <small class="text-muted">Status Kepemilikan Tabung</small>
                        </div>
                        <div class="col-md-4 mt-2">
                            <input type="text" class="form-control keterangan" name="keterangan" autocomplete="off" required placeholder="Keterangan Panggung" value="<?php if (empty($_GET)) {
                                                                                                                                                                            // no data passed by get
                                                                                                                                                                        } else {
                                                                                                                                                                            echo str_replace("_", "/", $_GET['sj']);
                                                                                                                                                                        } ?>">
                            <small class="text-muted">Keterangan</small>
                        </div>
                        <div class="col-md-4 mt-2">
                            <input type="date" class="form-control tanggal_dari" name="tanggal_dari" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                            <small class="text-muted">Tanggal Dari.</small>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="input-group">
                                <input type="date" class="form-control tanggal_sampai" name="tanggal_sampai" autocomplete="off" required value="<?= date("Y-m-d"); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-success filter_tanggal"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            <small class="text-muted">Tanggal Sampai.</small>
                        </div>
                        <div class="col-md-2 mt-4">
                            <table class="table">
                                <tr>
                                    <td class="table-success">Masuk (In)</td>
                                </tr>
                                <tr>
                                    <td class="table-danger">Keluar (Out)</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('tanggal'); ?></th>
                                <th><?= $this->lang->line('Relasi'); ?></th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Volume</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Total</th>
                                <th><?= $this->lang->line('keterangan'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
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
        jurnal_tabung_list();
    });

    function jurnal_tabung_list() {
        $.ajax({
            type: 'post',
            url: "<?php echo base_url() ?>index.php/laporan/jurnal_panggung/list",
            async: false,
            dataType: 'json',
            data: {
                keterangan: $(".keterangan").val(),
                supplier: $(".supplier_filter").val(),
                relasi: $(".relasi_filter").val(),
                tabung: $(".tabung_filter").val(),
                status: $(".status_filter").val(),
                tanggal_dari: $('.tanggal_dari').val(),
                tanggal_sampai: $('.tanggal_sampai').val(),
                in_out: $(".in_out_filter").val(),
                isi_kosong: $(".isi_kosong_filter").val(),
            },
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var total = 0
                    var total_masuk = 0
                    var total_keluar = 0
                    for (i = 0; i < data.length; i++) {

                        if (data[i].RELASI_NAMA.length == 0) {
                            var relasi = "-"
                        } else {
                            var relasi = data[i].RELASI_NAMA[0].MASTER_RELASI_NAMA
                        }
                        if (data[i].SUPPLIER_NAMA.length == 0) {
                            var supplier = "-"
                        } else {
                            var supplier = data[i].SUPPLIER_NAMA[0].MASTER_SUPPLIER_NAMA
                        }
                        if (data[i].PANGGUNG_STATUS == "in") {
                            var tr = "table-success"
                            var masuk = data[i].PANGGUNG_JUMLAH
                            var keluar = 0
                            total += parseInt(data[i].PANGGUNG_JUMLAH)
                            total_masuk += parseInt(data[i].PANGGUNG_JUMLAH)
                        } else {
                            var tr = "table-danger"
                            var masuk = 0
                            var keluar = data[i].PANGGUNG_JUMLAH
                            total -= parseInt(data[i].PANGGUNG_JUMLAH)
                            total_keluar += parseInt(data[i].PANGGUNG_JUMLAH)
                        }
                        if (data[i].PANGGUNG_STATUS_ISI == "1") {
                            var volume = "Isi"
                        } else {
                            var volume = "Kosong"
                        }
                        $("tbody#zone_data").append("<tr class='" + tr + "'>" +
                            "<td>" + no++ + ".</td>" +
                            "<td><b>" + data[i].TANGGAL + "</b><br>" + data[i].NAMA_BARANG[0].MASTER_BARANG_NAMA + " (<small>" + data[i].PANGGUNG_STATUS_KEPEMILIKAN + "</small>)</td>" +
                            "<td>" + relasi + "</td>" +
                            "<td>" + supplier + "</td>" +
                            "<td>" + data[i].PANGGUNG_STATUS + "</td>" +
                            "<td>" + volume + "</td>" +
                            "<td>" + masuk + "</td>" +
                            "<td>" + keluar + "</td>" +
                            "<td>" + total + "</td>" +
                            "<td>" + data[i].PANGGUNG_KETERANGAN + "</td>" +
                            "</td>" +
                            "</tr>");
                    }
                    $("tbody#zone_data").append("<tr><td colspan='6' align='right'><b>Total</b></td><td><b>" + total_masuk + "</b></td><td><b>" + total_keluar + "</b></td><td><b>" + (total_masuk - total_keluar) + "</b></td><td><small class='text-muted'></small></td></tr>")

                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    // $('#tabung_filter,#status_filter, #relasi_filter,#supplier_filter, #in_out_filter,#isi_kosong_filter').change(function() {
    //     memuat()
    //     jurnal_tabung_list()
    // });

    $('.filter_tanggal').on("click", function() {
        memuat()
        jurnal_tabung_list()
    });

    // setInterval(function() {
    //     memuat()
    //     jurnal_tabung_list()
    // }, 30000);
</script>