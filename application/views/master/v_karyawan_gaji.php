<style>
    .table {
        font-size: 14px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Perhitungan</h1>
                    <p class="nama_karyawan">Loading...</p>
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                    </div>
                    <hr>
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label text-right">
                            <h3>Gaji Pokok</h3>
                        </label>
                        <div class="col-sm-10">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control gaji_pokok form-control-lg" name="gaji_pokok" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label text-right">Tunjangan</label>
                        <div class="col-sm-10">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control tunjangan" name="tunjangan" value="0" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label text-right">Bonus</label>
                        <div class="col-sm-10">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control bonus" name="bonus" value="0" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label text-right">Potongan</label>
                        <div class="col-sm-10">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control potongan" name="potongan" value="0" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="pengantaran" name="pengantaran">
                                        <label for="pengantaran">
                                            Pengantaran
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="produksi" name="produksi">
                                        <label for="produksi">
                                            Produksi
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="penjualan" name="penjualan">
                                        <label for="penjualan">
                                            Penjualan
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="pengantaran mb-3" hidden>
                        <h4><b>Premi Pengantaran</b></h4>
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Nomor Surat Jalan</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Tanggal</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Relasi</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Supplier</th>
                                    <th colspan="3" style="text-align: center; vertical-align: middle;">Quantity Surat Jalan</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Total</th>
                                </tr>
                                <tr>
                                    <th>Isi</th>
                                    <th>Kosong</th>
                                    <th>Klaim</th>
                                </tr>
                            </thead>
                            <tbody id="zone_data_sj">
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-4 row">
                            <label class="col-sm-2 col-form-label text-right">Premi Pengantaran</label>
                            <div class="col-sm-3">
                                <select name="premi_pengantaran" id="premi_pengantaran" class="form-control premi_pengantaran select2" style="width: 100%;" required>
                                    <option value="0" nilai="0">0</option>
                                    <?php foreach (premi() as $row) {
                                    ?>
                                        <option value="<?= $row->PREMI_ID; ?>" nilai="<?= $row->PREMI_NILAI; ?>"><?= $row->PREMI_NAMA; ?> - Rp. <?= $row->PREMI_NILAI; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control total_sj" name="total_sj" onkeyup="kalkulasi_sj()" readonly>
                                <small class="text-muted">Total Pengantaran Surat Jalan</small>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control rupiah_pengantaran" name="rupiah_pengantaran" readonly>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="produksi" hidden>
                        <h4><b>Premi Produksi</b></h4>
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Nomor Produksi</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Tanggal</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Total</th>
                                </tr>
                            </thead>
                            <tbody id="zone_data_produksi">
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-4 row">
                            <label class="col-sm-2 col-form-label text-right">Premi Produksi</label>
                            <div class="col-sm-3">
                                <select name="premi_produksi" id="premi_produksi" class="form-control premi_produksi select2" style="width: 100%;" required>
                                    <option value="0" nilai="0">0</option>
                                    <?php foreach (premi() as $row) {
                                    ?>
                                        <option value="<?= $row->PREMI_ID; ?>" nilai="<?= $row->PREMI_NILAI; ?>"><?= $row->PREMI_NAMA; ?> - Rp. <?= $row->PREMI_NILAI; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control total_produksi" name="total_produksi" onkeyup="kalkulasi_produksi()" readonly>
                                <small class="text-muted">Total Pengantaran Surat Jalan</small>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control rupiah_produksi" name="rupiah_produksi" readonly>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="penjualan" hidden>
                        <h4><b>Premi Penjualan</b></h4>
                        <div class="mb-4 row">
                            <label class="col-sm-2 col-form-label text-right">Premi Penjualan</label>
                            <div class="col-sm-3">
                                <select name="premi_penjualan" id="premi_penjualan" class="form-control premi_penjualan select2" style="width: 100%;" required>
                                    <option value="0" nilai="0">0</option>
                                    <?php foreach (premi() as $row) {
                                    ?>
                                        <option value="<?= $row->PREMI_ID; ?>" nilai="<?= $row->PREMI_NILAI; ?>"><?= $row->PREMI_NAMA; ?> - Rp. <?= $row->PREMI_NILAI; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">No</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Jenis</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Total</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Rupiah</th>
                                </tr>
                            </thead>
                            <tbody id="zone_data_penjualan">
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-4 row">
                            <label class="col-sm-2 col-form-label text-right">Persentase</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control persentase" name="persentase" onkeyup="kalkulasi_penjualan()">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control total_penjualan" name="total_penjualan" onkeyup="kalkulasi_penjualan()" readonly>
                                <small class="text-muted">Total Penjualan</small>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control rupiah_penjualan" name="rupiah_penjualan" readonly>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $('#pengantaran').change(function() {
        if (this.checked) {
            $("div.pengantaran").attr("hidden", false)
            surat_jalan_list()
        } else {
            $("div.pengantaran").attr("hidden", true)
            $("tbody#zone_data_sj").empty();
        }
    });
    $('#produksi').change(function() {
        if (this.checked) {
            $("div.produksi").attr("hidden", false)
            produksi_list()
        } else {
            $("div.produksi").attr("hidden", true)
            $("tbody#zone_data_produksi").empty();
        }
    });
    $('#penjualan').change(function() {
        if (this.checked) {
            $("div.penjualan").attr("hidden", false)
            //penjualan_list()
        } else {
            $("div.penjualan").attr("hidden", true)
            $("tbody#zone_data_penjualan").empty();
        }
    });

    $(function() {
        //surat_jalan_list()
        detail()
        $(".rupiah").mask("#.##0", {
            reverse: true
        });
    })

    function surat_jalan_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/master/karyawan/surat_jalan_list",
            async: false,
            dataType: 'json',
            data: {
                id: "<?= $this->uri->segment("4"); ?>",
                bulan: $(".bulan").val(),
                tahun: $(".tahun").val()
            },
            success: function(data) {
                $("tbody#zone_data_sj").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data_sj").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var saldo = 0
                    var total_sj = 0

                    for (i = 0; i < data.length; i++) {
                        if (data[i].RELASI == "") {
                            var relasi = "-"
                        } else {
                            var relasi = data[i].RELASI[0].MASTER_RELASI_NAMA
                        }
                        if (data[i].SUPPLIER == "") {
                            var supplier = "-"
                        } else {
                            var supplier = data[i].SUPPLIER[0].MASTER_SUPPLIER_NAMA
                        }
                        total = (parseInt(data[i].BARANG[0].ISI) + parseInt(data[i].BARANG[0].KOSONG)) - parseInt(data[i].BARANG[0].KLAIM)
                        total_sj += total
                        $(".total_sj").val(total_sj)
                        $("tbody#zone_data_sj").append("<tr class=''>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + data[i].SURAT_JALAN_NOMOR + "</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + relasi + "</td>" +
                            "<td>" + supplier + "</td>" +
                            "<td>" + data[i].BARANG[0].ISI + "</td>" +
                            "<td>" + data[i].BARANG[0].KOSONG + "</td>" +
                            "<td>" + data[i].BARANG[0].KLAIM + "</td>" +
                            "<td>" + total + "</td>" +
                            "</tr>");
                    }
                    kalkulasi_sj()
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function produksi_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/master/karyawan/produksi_list",
            async: false,
            dataType: 'json',
            data: {
                id: "<?= $this->uri->segment("4"); ?>",
                bulan: $(".bulan").val(),
                tahun: $(".tahun").val()
            },
            success: function(data) {
                $("tbody#zone_data_produksi").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data_produksi").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var saldo = 0
                    var total_produksi = 0

                    for (i = 0; i < data.length; i++) {

                        total = parseInt(data[i].PRODUKSI_KARYAWAN_TOTAL)
                        total_produksi += total
                        $(".total_produksi").val(total_produksi)
                        $("tbody#zone_data_produksi").append("<tr class=''>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + data[i].PRODUKSI_NOMOR + "</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].PRODUKSI_KARYAWAN_TOTAL + "</td>" +
                            "</tr>");
                    }
                    kalkulasi_produksi()
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function penjualan_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/master/karyawan/penjualan_list",
            async: false,
            dataType: 'json',
            data: {
                id: "<?= $this->uri->segment("4"); ?>",
                bulan: $(".bulan").val(),
                tahun: $(".tahun").val()
            },
            success: function(data) {
                $("tbody#zone_data_penjualan").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data_penjualan").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var total = 0
                    for (i = 0; i < data.gas.length; i++) {
                        var premi = parseInt($(".premi_penjualan").find('option:selected').attr('nilai'))
                        var rupiah = parseInt(data.gas[i].TOTAL) * premi
                        total += rupiah
                        $("tbody#zone_data_penjualan").append("<tr class=''>" +
                            "<td>" + no++ + "</td>" +
                            "<td>Penjualan Gas</td>" +
                            "<td>" + data.gas[i].TOTAL + "</td>" +
                            "<td>" + number_format(rupiah) + "</td>" +
                            "</tr>");
                    }

                    for (i = 0; i < data.liquid.length; i++) {
                        var premi = parseInt($(".premi_penjualan").find('option:selected').attr('nilai'))
                        var tabung = parseInt(data.liquid[i].TOTAL) / 6
                        var rupiah = (parseInt(data.liquid[i].TOTAL) / 6) * premi
                        total += rupiah
                        $("tbody#zone_data_penjualan").append("<tr class=''>" +
                            "<td>" + no++ + "</td>" +
                            "<td>Penjualan Liquid</td>" +
                            "<td>" + data.liquid[i].TOTAL + " (" + tabung + ")</td>" +
                            "<td>" + number_format(rupiah) + "</td>" +
                            "</tr>");
                    }
                    $(".total_penjualan").val(number_format(total))
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
            url: '<?php echo base_url(); ?>index.php/akuntansi/piutang/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                relasi_list();
                Swal.fire('Berhasil', '', 'success')
                $("#akunModal").modal("hide")
            }
        });
    })
    $('#submit_saldo_piutang').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/akuntansi/piutang/add_saldo',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                relasi_list();
                Swal.fire('Berhasil', '', 'success')
                $("#akunModal").modal("hide")
            }
        });
    })

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/master/karyawan/detail/<?= $this->uri->segment("4"); ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                memuat()
                if (data.length == 0) {} else {
                    $("p.nama_karyawan").html(data[0].MASTER_KARYAWAN_NAMA)
                    $(".gaji_pokok").val(number_format(data[0].MASTER_KARYAWAN_GAJI_POKOK))
                }


            },
            error: function(x, e) {} //end error
        });
    }

    $(".premi_pengantaran").on("change", function() {
        kalkulasi_sj()
    })
    $(".premi_produksi").on("change", function() {
        kalkulasi_produksi()
    })

    $(".premi_penjualan").on("change", function() {
        penjualan_list()
    })

    function kalkulasi_sj() {
        var total_sj = parseInt($(".total_sj").val())
        var premi = parseInt($(".premi_pengantaran").find('option:selected').attr('nilai'))
        var rupiah_pengantaran = total_sj * premi
        console.log(rupiah_pengantaran)
        $(".rupiah_pengantaran").val(number_format(rupiah_pengantaran))
    }

    function kalkulasi_produksi() {
        var total_produksi = parseInt($(".total_produksi").val())
        var premi = parseInt($(".premi_produksi").find('option:selected').attr('nilai'))
        var rupiah_produksi = total_produksi * premi
        console.log(rupiah_produksi)
        $(".rupiah_produksi").val(number_format(rupiah_produksi))
    }

    function kalkulasi_penjualan() {
        var total_penjualan = parseInt($(".total_penjualan").val().split('.').join(""))
        var persentase = parseInt($(".persentase").val()) / 100
        var rupiah_penjualan = total_penjualan * persentase
        console.log(rupiah_penjualan)
        $(".rupiah_penjualan").val(number_format(rupiah_penjualan))
    }

    $('.bulan, .tahun').change(function() {
        memuat()
        surat_jalan_list()
    });
</script>