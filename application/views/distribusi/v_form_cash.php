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
                    <h1 class="m-0">Form Surat Jalan & TTBK (Cash)</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-default color-palette-box">
                    <div class="card-body">
                        <form id="submit">
                            <input type="hidden" class="form-control id" name="id" value="<?= $id; ?>" autocomplete="off">
                            <input type="hidden" class="form-control jenis_sj" name="jenis_sj" value="cash" autocomplete="off">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nomor SJ</label>
                                        <input type="text" class="form-control nomor" name="nomor" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nomor TTBK</label>
                                        <input type="text" class="form-control nomor_ttbk" name="nomor_ttbk" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tanggal</label>
                                        <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group nama_relasi">
                                        <label for="exampleInputEmail1">Nama Relasi</label>
                                        <select name="relasi" id="relasi" class="form-control relasi">
                                            <option value="">--Pilih Relasi--</option>
                                            <?php foreach ($relasi as $row) {
                                            ?>
                                                <option value="<?= $row->MASTER_RELASI_ID; ?>"><?= $row->MASTER_RELASI_NAMA; ?></option>
                                            <?php
                                            }
                                            ?>
                                            <option value="lainnya">Lainnya...</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4 nama_pelanggan" hidden>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Pelanggan</label>
                                        <input type="text" class="form-control pelanggan" name="pelanggan" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Driver</label>
                                        <select name="driver" id="driver" class="form-control driver">
                                            <option value="">--Pilih Driver--</option>
                                            <?php foreach ($driver as $row) {
                                            ?>
                                                <option value="<?= $row->MASTER_DRIVER_ID; ?>"><?= $row->MASTER_DRIVER_NAMA; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Kendaraan</label>
                                        <select name="kendaraan" id="kendaraan" class="form-control kendaraan">
                                            <option value="">--Pilih Kendaraan--</option>
                                            <?php foreach ($kendaraan as $row) {
                                            ?>
                                                <option value="<?= $row->MASTER_KENDARAAN_ID; ?>"><?= $row->MASTER_KENDARAAN_NOMOR; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Keterangan</label>
                                        <textarea class="form-control keterangan" name="keterangan" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleInputEmail1"></label>
                                    <div class="form-group">
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary">
                                                <input type="checkbox" id="ppn" name="ppn">
                                                <label for="ppn">
                                                    PPN
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-3"></h3>
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Barang Kirim</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Tabung Kosong</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="text-align: center; vertical-align:middle">No.</th>
                                                <th rowspan="2" style="text-align: center;  vertical-align:middle">Jenis Barang</th>
                                                <th rowspan="2" style="text-align: center; vertical-align:middle">Kapasitas</th>
                                                <th rowspan="2" style="text-align: center; vertical-align:middle">Harga</th>
                                                <th colspan="3" style="text-align: center; vertical-align:middle">Quantity</th>
                                                <th rowspan="2" style="text-align: center; vertical-align:middle">Total</th>
                                                <th rowspan="2" style="text-align: center; vertical-align:middle"></th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;">Isi</th>
                                                <th style="text-align: center;">Klaim</th>
                                                <th style="text-align: center;">Kosong</th>
                                            </tr>
                                        </thead>
                                        <tbody id="form_barang">
                                            <tr class="table-warning">
                                                <td>
                                                    <select name="kepemilikan" id="kepemilikan" class="form-control kepemilikan">
                                                        <option value="mp">MP</option>
                                                        <option value="mr">MR</option>
                                                    </select>
                                                </td>
                                                <td colspan="2">
                                                    <select name="jenis_barang" id="jenis_barang" class="form-control jenis_barang">
                                                        <option value="">--Pilih Jenis Barang--</option>
                                                        <?php foreach ($jenis_barang as $row) {
                                                        ?>
                                                            <option value="<?= $row->MASTER_JENIS_BARANG_ID; ?>" detail_id="<?= $row->MASTER_JENIS_BARANG_DETAIL_ID; ?>"><?= $row->MASTER_JENIS_BARANG_NAMA; ?> - <?= $row->MASTER_JENIS_BARANG_DETAIL_KAPASITAS; ?> <?= $row->MASTER_JENIS_BARANG_DETAIL_SATUAN; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" class="form-control detail_barang" name="detail_barang" autocomplete="off">
                                                </td>

                                                <td>
                                                    <input type="text" class="form-control harga" name="harga" autocomplete="off" onkeyup="kalkulasi_total()">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty" name="qty" autocomplete="off" value="0" onkeyup="kalkulasi_total()">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty_kosong" name="qty_kosong" autocomplete="off" value="0" onkeyup="kalkulasi_total()">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty_klaim" name="qty_klaim" autocomplete="off" value="0" onkeyup="kalkulasi_total()">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control total" name="total" autocomplete="off">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-secondary btn-sm btn-add-barang">Tambah</button>
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

                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" style="text-align: center; vertical-align:middle">No.</th>
                                                <th rowspan="2" style="text-align: center;  vertical-align:middle">Jenis Barang</th>
                                                <th rowspan="2" style="text-align: center; vertical-align:middle">Kapasitas</th>
                                                <th colspan="2" style="text-align: center; vertical-align:middle">Quantity</th>
                                                <th rowspan="2" style="text-align: center; vertical-align:middle"></th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;">Klaim</th>
                                                <th style="text-align: center;">Kosong</th>
                                            </tr>
                                        </thead>
                                        <tbody id="form_ttbk">
                                            <tr class="table-warning">
                                                <td>
                                                    <select name="kepemilikan_ttbk" id="kepemilikan_ttbk" class="form-control kepemilikan_ttbk">
                                                        <option value="mp">MP</option>
                                                        <option value="mr">MR</option>
                                                    </select>
                                                </td>
                                                <td colspan="2">
                                                    <select name="jenis_barang_ttbk" id="jenis_barang_ttbk" class="form-control jenis_barang_ttbk">
                                                        <option value="">--Pilih Jenis Barang--</option>
                                                        <?php foreach ($jenis_barang as $row) {
                                                        ?>
                                                            <option value="<?= $row->MASTER_JENIS_BARANG_ID; ?>" detail_id="<?= $row->MASTER_JENIS_BARANG_DETAIL_ID; ?>"><?= $row->MASTER_JENIS_BARANG_NAMA; ?> - <?= $row->MASTER_JENIS_BARANG_DETAIL_KAPASITAS; ?> <?= $row->MASTER_JENIS_BARANG_DETAIL_SATUAN; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" class="form-control detail_barang_ttbk" name="detail_barang_ttbk" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty_kosong_ttbk" name="qty_kosong_ttbk" autocomplete="off" value="0" onkeyup="kalkulasi_total()">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control qty_klaim_ttbk" name="qty_klaim_ttbk" autocomplete="off" value="0" onkeyup="kalkulasi_total()">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-secondary btn-sm btn-add-ttbk">Tambah</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody id="zone_data_ttbk">
                                            <tr>
                                                <td colspan="9">
                                                    <center>
                                                        <div class="loader"></div>
                                                    </center>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->

                    </div>
                    <!-- ./card -->
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success btn-lg">Simpan</button>
                </div>
            </div>
            </form>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    $(function() {
        ttbk_list();
        barang_list();
        detail()
    });

    $('select#relasi').on('change', function() {
        relasi_lainnya()
    })

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/distribusi/surat_jalan/detail/<?= $id; ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if (data.length == 0) {

                } else {
                    $(".jenis_sj").val(data[0].SURAT_JALAN_JENIS)
                    $(".nomor").val(data[0].SURAT_JALAN_NOMOR)
                    $(".nomor_ttbk").val(data[0].SURAT_JALAN_TTBK)
                    $(".tanggal").val(data[0].SURAT_JALAN_TANGGAL)
                    $(".relasi").val(data[0].MASTER_RELASI_ID)
                    $(".pelanggan").val(data[0].SURAT_JALAN_NAMA_PELANGGAN)
                    $(".driver").val(data[0].MASTER_DRIVER_ID)
                    $(".kendaraan").val(data[0].MASTER_KENDARAAN_ID)
                    $(".keterangan").val(data[0].SURAT_JALAN_KETERANGAN)
                    if (data[0].SURAT_JALAN_PPN == "on") {
                        $('#ppn').prop('checked', true);
                    }

                    relasi_lainnya()
                }


            },
            error: function(x, e) {} //end error
        });
    }

    function barang_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/distribusi/surat_jalan/barang_list/<?= $id; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'>Tidak ada data</td>")
                } else {
                    var tableContent = "";
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        var rowspan = 0;
                        var detailLength = data[i].DETAIL.length;
                        rowspan += detailLength;
                        tableContent += "<tr><td rowspan=" + parseInt(1 + rowspan) + ">" + no++ + "</td><td rowspan=" + parseInt(1 + rowspan) + ">" + data[i].MASTER_JENIS_BARANG_NAMA + "</td></tr>";
                        console.log(detailLength)
                        var relasiLength = 0;
                        for (var j = 0; j < detailLength; j++) {
                            if (data[i].DETAIL[j].SURAT_JALAN_BARANG_KEPEMILIKAN == "mp") {
                                var kepemilikan = "<br><small class='text-muted'>MP</small>"
                            } else {
                                var kepemilikan = "<br><small class='text-muted'>MR</small>"
                            }
                            tableContent += "<tr>" +
                                "<td rowspan=" + parseInt(1 + relasiLength) + ">" + data[i].DETAIL[j].MASTER_JENIS_BARANG_DETAIL_KAPASITAS + " " + data[i].DETAIL[j].MASTER_JENIS_BARANG_DETAIL_SATUAN + " " + kepemilikan + "</td>" +
                                "<td rowspan=" + parseInt(1 + relasiLength) + ">" + number_format(data[i].DETAIL[j].SURAT_JALAN_BARANG_HARGA) + "</td>" +
                                "<td rowspan=" + parseInt(1 + relasiLength) + ">" + data[i].DETAIL[j].SURAT_JALAN_BARANG_QTY + "</td>" +
                                "<td rowspan=" + parseInt(1 + relasiLength) + ">" + data[i].DETAIL[j].SURAT_JALAN_BARANG_QTY_KOSONG + "</td>" +
                                "<td rowspan=" + parseInt(1 + relasiLength) + ">" + data[i].DETAIL[j].SURAT_JALAN_BARANG_QTY_KLAIM + "</td>" +
                                "<td rowspan=" + parseInt(1 + relasiLength) + ">" + number_format(data[i].DETAIL[j].SURAT_JALAN_BARANG_TOTAL) + "</td>" +
                                "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].DETAIL[j].SURAT_JALAN_BARANG_ID + "\")'><i class='fas fa-trash'></i></a></td>" + "<a class='btn btn-success btn-sm addHarga-btn' detail_id='" + data[i].DETAIL[j].MASTER_JENIS_BARANG_DETAIL_ID + "'><i class='fas fa-tag'></i> Tambah Harga</a></td></tr>";
                        }
                    }
                    $("tbody#zone_data").append(tableContent);
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function ttbk_list() {
        console.log()
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/distribusi/surat_jalan/ttbk_list/<?= $id; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data_ttbk").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data_ttbk").append("<td colspan='10'>Tidak ada data</td>")
                } else {
                    var tableContent = "";
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        var rowspan = 0;
                        var detailLength = data[i].DETAIL.length;
                        rowspan += detailLength;
                        tableContent += "<tr><td rowspan=" + parseInt(1 + rowspan) + ">" + no++ + "</td><td rowspan=" + parseInt(1 + rowspan) + ">" + data[i].MASTER_JENIS_BARANG_NAMA + "</td></tr>";
                        console.log(detailLength)
                        var relasiLength = 0;
                        for (var j = 0; j < detailLength; j++) {
                            tableContent += "<tr>" +
                                "<td rowspan=" + parseInt(1 + relasiLength) + ">" + data[i].DETAIL[j].MASTER_JENIS_BARANG_DETAIL_KAPASITAS + " " + data[i].DETAIL[j].MASTER_JENIS_BARANG_DETAIL_SATUAN + "</td>" +
                                "<td rowspan=" + parseInt(1 + relasiLength) + ">" + data[i].DETAIL[j].TTBK_QTY_KOSONG + "</td>" +
                                "<td rowspan=" + parseInt(1 + relasiLength) + ">" + data[i].DETAIL[j].TTBK_QTY_KLAIM + "</td>" +
                                "<td><a class='btn btn-danger btn-sm' onclick='hapus_ttbk(\"" + data[i].DETAIL[j].TTBK_ID + "\")'><i class='fas fa-trash'></i></a></td>" + "<a class='btn btn-success btn-sm addHarga-btn' detail_id='" + data[i].DETAIL[j].MASTER_JENIS_BARANG_DETAIL_ID + "'><i class='fas fa-tag'></i> Tambah Harga</a></td></tr>";
                        }
                    }
                    $("tbody#zone_data_ttbk").append(tableContent);
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function relasi_lainnya() {
        if ($('select#relasi').val() == "lainnya") {
            $("div.nama_relasi").attr("hidden", false)
            $("div.nama_pelanggan").attr("hidden", false)
        } else if ($('select#relasi').val() == "kirim") {
            $("div.nama_relasi").attr("hidden", false)
            $("div.nama_pelanggan").attr("hidden", true)
            $(".pelanggan").val("")
        } else {
            $("div.nama_relasi").attr("hidden", false)
            $("div.nama_pelanggan").attr("hidden", true)
            $(".pelanggan").val("")
        }
    }

    $('select#jenis_barang_ttbk').on('change', function() {
        var detail_id = $('select#jenis_barang_ttbk option:selected').attr("detail_id")
        $(".detail_barang_ttbk").val(detail_id)
    });

    $('select#jenis_barang').on('change', function() {
        var detail_id = $('select#jenis_barang option:selected').attr("detail_id")
        $(".detail_barang").val(detail_id)

        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/distribusi/surat_jalan/perharga/' + detail_id + '/' + $("#relasi").val(),
            async: false,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if (data.length == 0) {
                    $(".harga").val("0")
                } else {
                    $(".harga").val(data[0].MASTER_HARGA_HARGA)
                }

            },
            error: function(x, e) {} //end error
        });
    });

    // $('#submitbarang').submit(function(e) {
    $('.btn-add-barang').on("click", function(e) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/distribusi/surat_jalan/add_barang',
            dataType: "JSON",
            data: {
                id: "<?= $id; ?>",
                kepemilikan: $('.kepemilikan').val(),
                jenis_barang: $('.jenis_barang').val(),
                detail_barang: $('.detail_barang').val(),
                harga: $('.harga').val(),
                qty: $('.qty').val(),
                qty_kosong: $('.qty_kosong').val(),
                qty_klaim: $('.qty_klaim').val(),
            },
            success: function(data) {
                barang_list();
                $('.qty').val("0")
                $('.qty_kosong').val("0")
                $('.qty_klaim').val("0")
                $('.total').val("0")
            }
        });
    })

    $('.btn-add-ttbk').on("click", function(e) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/distribusi/surat_jalan/add_ttbk',
            dataType: "JSON",
            data: {
                id: "<?= $id; ?>",
                kepemilikan: $('.kepemilikan_ttbk').val(),
                jenis_barang: $('.jenis_barang_ttbk').val(),
                detail_barang: $('.detail_barang_ttbk').val(),
                qty_kosong: $('.qty_kosong_ttbk').val(),
                qty_klaim: $('.qty_klaim_ttbk').val(),
            },
            success: function(data) {
                ttbk_list()
                $('.qty_kosong_ttbk').val("0")
                $('.qty_klaim_ttbk').val("0")
            }
        });
    })

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/distribusi/surat_jalan/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                barang_list();
                Swal.fire('Berhasil', 'Surat Jalan berhasil ditambahkan', 'success')
                window.location.href = "<?= base_url(); ?>/<?= $this->uri->segment('1'); ?>/<?= $this->uri->segment('2'); ?>/<?= $this->uri->segment('3'); ?>/<?= $id; ?>";
            }
        });
    })

    function kalkulasi_total() {
        var harga = parseInt($('.harga').val());
        var qty = parseInt($('.qty').val());
        var total = harga * qty
        if (total == "NaN") {
            var ttotal = "0"
        } else {
            var ttotal = total
        }
        $('.total').val(ttotal)
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
                    url: '<?php echo base_url() ?>index.php/distribusi/surat_jalan/hapus_barang/' + id,
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            barang_list();
                            Swal.fire('Berhasil', 'Barang Berhasil dihapus', 'success')
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
</script>