<div class="modal fade" id="barangmrModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Tabung</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit_barang_mr">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis</label>
                        <select name="jenis" id="jenis" class="form-control jenis select2" style="width: 100%;" required>
                            <option value="">-- Jenis --</option>

                            <?php
                            foreach (tabung() as $row) {
                            ?>
                                <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jumlah Tabung MP</label>
                        <input type="text" class="form-control jumlah_mp" name="jumlah_mp" id="jumlah_mp" autocomplete="off" value="0" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jumlah Tabung MR</label>
                        <input type="text" class="form-control jumlah_mr" name="jumlah_mr" id="jumlah_mr" autocomplete="off" value="0" required>
                    </div>
                    <div class="form-group">
                        <div class="form-group clearfix">
                            <div class="icheck-primary">
                                <input type="checkbox" id="isi" name="isi">
                                <label for="isi">
                                    ISI
                                </label>
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
<!-- /.modal -->
<div class="modal fade" id="barangscanModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Scan Tabung</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <textarea name="scan_keterangan" id="scan_keterangan" class="form-control scan_keterangan" rows="10"></textarea>
                    <!-- <input type="text" class="form-control scan_keterangan" name="scan_keterangan" id="scan_keterangan" value="" autocomplete="off"> -->
                </div>
                <div class="form-group">
                    <div class="form-group clearfix">
                        <div class="icheck-primary">
                            <input type="checkbox" id="isi_scan" name="isi_scan">
                            <label for="isi_scan">
                                ISI
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('tutup'); ?></button>
                <a class="btn btn-primary btn-scan"><?= $this->lang->line('simpan'); ?></a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="klaimModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Klaim Tabung</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit_klaim">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis</label>
                        <select name="jenis" id="jenis" class="form-control jenis select2" style="width: 100%;" required>
                            <option value="">-- Jenis --</option>

                            <?php
                            foreach (tabung() as $row) {
                            ?>
                                <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jumlah Tabung MP</label>
                        <input type="text" class="form-control jumlah" name="jumlah" id="jumlah" autocomplete="off" value="0" required>
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
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="m-0">Realisasi TTBK</h1>
                    <p class="surat_jalan_nomor">Loading...</p>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content selain_gas">
        <div class="container-fluid">
            <div class="card card-primary card-outline card-outline-tabs">

                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Surat Jalan</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Tabung MP</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-four-mr-tab" data-toggle="pill" href="#custom-tabs-four-mr" role="tab" aria-controls="custom-tabs-four-mr" aria-selected="false">Tabung MR</a>
                        </li> -->
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                            <input type="hidden" class="form-control total_tabung_sj" name="total_tabung_sj" id="total_tabung_sj" value="" autocomplete="off">
                            <input type="hidden" class="form-control total_realisasi" name="total_realisasi" id="total_realisasi" value="" autocomplete="off">
                            <input type="hidden" class="form-control total_tabung_mr" name="total_tabung_mr" id="total_tabung_mr" value="" autocomplete="off">
                            <input type="hidden" class="form-control expired" name="expired" id="expired" value="" autocomplete="off">
                            <div class="alert alert-success alert-dismissible panggung_realisasi" hidden>
                                <p class="panggung_realisasi"></p>
                            </div>
                            <small class="text-muted">*Penagihan Surat Jalan</small>
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;">No.</th>
                                        <th rowspan="2" style=" vertical-align: middle;">Nomor Surat Jalan</th>
                                        <th rowspan="2" style=" vertical-align: middle;">Jenis Barang</th>
                                        <th colspan="3" style="text-align: center; vertical-align: middle;">Quantity Surat Jalan</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Total</th>
                                    </tr>
                                    <tr>
                                        <th>Isi</th>
                                        <th>Kosong</th>
                                        <th>Klaim</th>
                                    </tr>
                                </thead>
                                <tbody id="zone_data">
                                    <tr>
                                    </tr>
                                </tbody>
                                <tfoot id="total_data">

                                </tfoot>
                            </table>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 btn-tambah-realisasi">
                                    <button type="button" class="btn btn-primary btn_barang_mr mb-2 mr-2">Tambah Tabung</button>
                                    <button type="button" class="btn btn-success scan_barang mb-2 mr-2"><i class="fas fa-qrcode"></i> Scan Tabung</button>
                                    <button type="button" class="btn btn-secondary btn_klaim mb-2">Klaim Tabung</button>
                                </div>
                            </div>
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kepemilikan</th>
                                        <th>Jenis</th>
                                        <th>Nomor Tabung</th>
                                        <th>Kode Tabung</th>
                                        <th><a class="btn btn-danger btn_hapus_semua btn-sm">Hapus Semua</a></th>
                                    </tr>
                                </thead>
                                <tbody id="zone_data_tabung_sj">
                                </tbody>
                                <tbody id="zone_data_tabung_sj_selisih">
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">

                            <div class="row">
                                <div class="col-2">
                                    <button type="button" class="btn btn-secondary btn_barang mb-2">Tambah Tabung</button>
                                </div>
                            </div>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Tabung</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="zone_data_realisasi">
                                    <tr>
                                    </tr>
                                </tbody>
                                <tfoot id="total_data_realisasi">

                                </tfoot>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-mr" role="tabpanel" aria-labelledby="custom-tabs-four-mr-tab">

                            <div class="row">
                                <div class="col-2">
                                    <button type="button" class="btn btn-secondary btn_barang_mr mb-2">Tambah Tabung</button>
                                </div>
                            </div>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Jumlah</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="zone_data_realisasi_mr">
                                    <tr>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                            Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                            Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default color-palette-box">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success btn-lg btn-realisasi"><?= $this->lang->line('simpan'); ?></button>
                            </form>
                            <a class="btn btn-outline-secondary btn-lg keatas"><i class='fas fa-chevron-circle-up'></i></a>
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
    $(".btn_barang").on("click", function() {
        var total_tabung_sj = $(".total_tabung_sj").val()
        var total_realisasi = parseInt($(".total_realisasi").val())
        var total_tabung_mr = parseInt($(".total_tabung_mr").val())
        if (total_tabung_sj == (total_realisasi + total_tabung_mr)) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Tidak dapat menambah tabung.'
            })
        } else {
            // $("#submit").trigger("reset");
            $("#barangModal").modal("show")

        }

    })

    $(".btn_barang_mr").on("click", function() {
        $(".jumlah_mp").val("0")
        $(".jumlah_mr").val("0")
        $("#barangmrModal").modal("show")
        // var total_tabung_sj = $(".total_tabung_sj").val()
        // var total_realisasi = parseInt($(".total_realisasi").val())
        // var total_tabung_mr = parseInt($(".total_tabung_mr").val())
        // if (total_tabung_sj == (total_realisasi + total_tabung_mr)) {
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Oops...',
        //         text: 'Tidak dapat menambah tabung.'
        //     })
        // } else {
        //     $(".jumlah_mp").val("0")
        //     $(".jumlah_mr").val("0")
        //     $("#barangmrModal").modal("show")

        // }


    })
    $(".btn_klaim").on("click", function() {
        $("#klaimModal").modal("show")
    })

    $(".scan_barang").on("click", function() {
        $("textarea.scan_keterangan").val("")
        $("#barangscanModal").modal("show", function() {})
        setTimeout(function() {
            $('textarea.scan_keterangan').focus();
        }, 1000);
    })

    $('.btn-scan').on("click", function(e) {
        // e.preventDefault();
        if ($('#isi_scan').is(":checked") == true) {
            var isi_val = "on"
        } else {
            var isi_val = ""
        }
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/distribusi/realisasi_ttbk/add_scan?surat_jalan_id=<?= $this->uri->segment("4"); ?>',
            dataType: "JSON",
            beforeSend: function() {
                memuat()
            },
            data: {
                scan: $(".scan_keterangan").val(),
                isi: isi_val
            },
            success: function(data) {
                realisasi_list()
                memuat()
            }
        });
    })

    $(function() {
        surat_jalan_list()
        panggung_realisasi()
        detail()
    });

    function panggung_realisasi() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/distribusi/realisasi_ttbk/panggung_realisasi?surat_jalan_id=<?= $this->uri->segment('4'); ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if (data.length == 0) {
                    $(".panggung_realisasi").attr("hidden", true)
                } else {
                    var total = 0
                    for (i = 0; i < data.length; i++) {
                        total += parseInt(data[i].PANGGUNG_JUMLAH)
                    }
                    $(".panggung_realisasi").attr("hidden", false)
                    $(".panggung_realisasi").html("Panggung telah direalisasikan sebanyak : <b>" + total + "</b><br><small>Jika total tidak sesuai, harap simpan kembali realisasi anda.</small>")
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function surat_jalan_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/distribusi/realisasi_ttbk/list_realisasi?surat_jalan_id=<?= $this->uri->segment("4"); ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                $("tfoot#total_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {


                    var tableContent = "";
                    var no = 1
                    var total_qty = 0
                    for (i = 0; i < data.length; i++) {
                        if (data[i].SURAT_JALAN_JENIS != "penjualan") {
                            $('#isi').prop('checked', true);
                            $('#isi_scan').prop('checked', true);
                        }
                        if (data[i].EXPIRED == "EXPIRED") {
                            $(".btn-tambah-realisasi").attr("hidden", true)
                            $(".btn-realisasi").attr("hidden", true)
                            $(".expired").val(data[i].EXPIRED)
                        }

                        if (data[i].SURAT_JALAN_STATUS_JENIS != "gas") {
                            $(".selain_gas").attr("hidden", true)
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Penjualan selain Gas tidak memerlukan Realisasi TTBK.'
                            })
                        }

                        var rowspan = 0;
                        var detailLength = data[i].BARANG.length;
                        rowspan += detailLength;
                        tableContent += "<tr><td rowspan=" + parseInt(1 + rowspan) + ">" + no++ + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + ">" + data[i].SURAT_JALAN_NOMOR + "</td></tr>";
                        console.log(detailLength)
                        var barangLlength = 0;

                        for (var j = 0; j < detailLength; j++) {
                            //  $(".jenis").append("<option value='" + data[i].BARANG[j].MASTER_BARANG_ID + "'>" + data[i].BARANG[j].MASTER_BARANG_NAMA + "</option")
                            total_qty += parseInt(data[i].BARANG[j].TOTAL)
                            tableContent += "<tr>" +
                                "<td rowspan=" + parseInt(1 + barangLlength) + ">" + data[i].BARANG[j].MASTER_BARANG_NAMA + "<br><small class='text-muted'>" + data[i].BARANG[j].SURAT_JALAN_BARANG_JENIS + "</small></td>" +
                                "<td rowspan=" + parseInt(1 + barangLlength) + ">" + data[i].BARANG[j].SURAT_JALAN_BARANG_QUANTITY + "</td>" +
                                "<td rowspan=" + parseInt(1 + barangLlength) + ">" + data[i].BARANG[j].SURAT_JALAN_BARANG_QUANTITY_KOSONG + "</td>" +
                                "<td rowspan=" + parseInt(1 + barangLlength) + ">" + data[i].BARANG[j].SURAT_JALAN_BARANG_QUANTITY_KLAIM + "</td>" +
                                "<td rowspan=" + parseInt(1 + barangLlength) + ">" + data[i].BARANG[j].TOTAL + "</td>" +
                                "</tr>";
                        }
                    }
                    $("tbody#zone_data").append(tableContent);
                    $("tfoot#total_data").append("<tr><td colspan='6' align='right'><b>Total</b></td><td><b>" + total_qty + "</b></td></tr>")
                    $(".total_tabung_sj").val(total_qty)

                    realisasi_list()
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function realisasi_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/distribusi/realisasi_ttbk/list_realisasi_tabung?surat_jalan_id=<?= $this->uri->segment('4'); ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data_tabung_sj").empty();
                $("tfoot#zone_data_tabung_sj").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data_tabung_sj").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                    $(".total_realisasi").val("0")
                } else {
                    var no = 1
                    $(".total_realisasi").val(data['mp'].length)
                    $(".total_tabung_mr").val(data['mr'].length)
                    for (i = 0; i < data['mp'].length; i++) {


                        if (data['mp'][i].KODE_TABUNG.length === 0) {
                            var kode_tabung = "-"
                            var kode_tabung_lama = "-"
                        } else {
                            var kode_tabung = data['mp'][i].KODE_TABUNG[0].MASTER_TABUNG_KODE
                            var kode_tabung_lama = data['mp'][i].KODE_TABUNG[0].MASTER_TABUNG_KODE_LAMA
                        }

                        if (data['mp'][i].REALISASI_TTBK_BARANG_STATUS == "1") {
                            var isi_kosong = "<a class='btn btn-success btn-xs'>Isi</a>"
                        } else {
                            var isi_kosong = "<a class='btn btn-danger btn-xs'>Kosong</a>"
                        }

                        $("tbody#zone_data_tabung_sj").append("<tr class='table-primary'>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>MP</td>" +
                            "<td>" + data['mp'][i].MASTER_BARANG_NAMA + "<br>" + isi_kosong + "</td>" +
                            "<td>" + kode_tabung_lama + "</td>" +
                            "<td>" + kode_tabung + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data['mp'][i].REALISASI_TTBK_BARANG_ID + "\")'><i class='fas fa-trash'></i></a></td> " +
                            "</tr>");

                    }
                    for (i = 0; i < data['mr'].length; i++) {
                        if (data['mr'][i].REALISASI_TTBK_BARANG_MR_STATUS == "1") {
                            var isi_kosong = "<a class='btn btn-success btn-xs'>Isi</a>"
                        } else {
                            var isi_kosong = "<a class='btn btn-danger btn-xs'>Kosong</a>"
                        }
                        $("tbody#zone_data_tabung_sj").append("<tr class='table-warning'>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>MR</td>" +
                            "<td>" + data['mr'][i].MASTER_BARANG_NAMA + "<br>" + isi_kosong + "</td>" +
                            "<td>-</td>" +
                            "<td>-</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus_mr(\"" + data['mr'][i].REALISASI_TTBK_BARANG_MR_ID + "\")'><i class='fas fa-trash'></i></a></td> " +
                            "</tr>");

                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function jenis_tabung() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/distribusi/realisasi_ttbk/jenis_tabung?jenis=' + $(".jenis").val() + '',
            async: false,
            dataType: 'json',
            success: function(data) {
                $(".tabung").empty()
                if (data.length == 0) {
                    $(".tabung").append("<option value='baru'>--Tambah Tabung Baru--</option>")
                } else {
                    $(".tabung").append("<option value='baru'>--Tambah Tabung Baru--</option>")
                    for (i = 0; i < data.length; i++) {
                        $(".tabung").append("<option value='" + data[i].MASTER_TABUNG_ID + "'>" + data[i].MASTER_TABUNG_KODE + "</option>")
                    }
                }


            },
            error: function(x, e) {} //end error
        });
    }

    $('.btn-realisasi').on("click", function(e) {

        var total_tabung_sj = parseInt($(".total_tabung_sj").val())
        var total_realisasi = parseInt($(".total_realisasi").val())
        var total_tabung_mr = parseInt($(".total_tabung_mr").val())

        if (total_tabung_sj != total_realisasi + total_tabung_mr) {
            Swal.fire({
                title: 'TTBK tidak Balance ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: `Lanjutkan`,
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url(); ?>index.php/distribusi/realisasi_ttbk/add',
                        dataType: "JSON",
                        beforeSend: function() {
                            memuat()
                        },
                        data: {
                            surat_jalan_id: "<?= $this->uri->segment('4'); ?>",
                            total_realisasi: total_realisasi,
                            total_tabung_mr: total_tabung_mr,
                        },
                        success: function(data) {
                            memuat()
                            panggung_realisasi()
                            Swal.fire('Berhasil', 'Realisasi Tabung Berhasil', 'success')
                        }
                    });

                }
            })
        } else {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>index.php/distribusi/realisasi_ttbk/add',
                dataType: "JSON",
                beforeSend: function() {
                    memuat()
                },
                data: {
                    surat_jalan_id: "<?= $this->uri->segment('4'); ?>",
                    total_realisasi: total_realisasi,
                    total_tabung_mr: total_tabung_mr,
                },
                success: function(data) {
                    memuat()
                    panggung_realisasi()
                    Swal.fire('Berhasil', 'Realisasi Tabung Berhasil', 'success')
                }
            });
        }
    })

    $('#submit_barang_mr').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/distribusi/realisasi_ttbk/add_barang?surat_jalan_id=<?= $this->uri->segment("4"); ?>',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                realisasi_list()
                memuat()
                $("#barangModal").modal("hide")
            }
        });

    })
    $('#submit_klaim').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/distribusi/realisasi_ttbk/klaim_barang?surat_jalan_id=<?= $this->uri->segment("4"); ?>',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                surat_jalan_list()
                $("#klaimModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/distribusi/realisasi_ttbk/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            realisasi_list()
                            memuat()
                            Swal.fire('Berhasil', 'Berhasil dihapus', 'success')
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

    function hapus_mr(id) {
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
                    url: '<?php echo base_url() ?>index.php/distribusi/realisasi_ttbk/hapus_mr/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            realisasi_list()
                            memuat()
                            Swal.fire('Berhasil', 'Berhasil dihapus', 'success')
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

    $(".btn_hapus_semua").on("click", function() {
        Swal.fire({
            title: '<?= $this->lang->line('hapus'); ?> Semua ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `<?= $this->lang->line('hapus'); ?>`,
            denyButtonText: `Batal`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'ajax',
                    url: '<?php echo base_url() ?>index.php/distribusi/realisasi_ttbk/hapus_semua?surat_jalan_id=<?= $this->uri->segment("4"); ?>',
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            realisasi_list()
                            memuat()
                            Swal.fire('Berhasil', 'Berhasil dihapus', 'success')
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

    })
    $('.jenis').change(function() {
        // jenis_tabung()
        // tambah_tabung_baru()
    });
    $('.tabung').change(function() {
        tambah_tabung_baru()
    });

    function tambah_tabung_baru() {
        var tabung = $(".tabung").val()
        if (tabung == "baru") {
            $("div.tambah_baru").attr("hidden", false)
        } else {
            $("div.tambah_baru").attr("hidden", true)
        }
    }

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/distribusi/realisasi_ttbk/detail/<?= $this->uri->segment("4"); ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                if (data.length == 0) {} else {
                    $("p.surat_jalan_nomor").html(data[0].SURAT_JALAN_NOMOR)
                }


            },
            error: function(x, e) {} //end error
        });
    }

    $('.keatas').on('click', function() {
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        return false;
    })
</script>