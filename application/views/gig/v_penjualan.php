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
                        <div class="col-md-6">
                            <select name="perusahaan" id="perusahaan" class="form-control perusahaan select2" style="width: 100%;" required>
                                <option value="">-- Perusahaan --</option>
                                <?php
                                foreach (perusahaan() as $row) {
                                ?>
                                    <option value="<?= $row->PERUSAHAAN_KODE; ?>"><?= $row->PERUSAHAAN_NAMA; ?> (<?= $row->PERUSAHAAN_KODE; ?>)</option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
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
                                <th style="text-align: center; vertical-align: middle;">Quantity<br><small class="text-muted">Quantity Isi - Quantity Klaim</small></th>
                                <th style="text-align: center; vertical-align: middle;">Harga</th>
                                <th style="text-align: center; vertical-align: middle;">Total Perbarang</th>
                                <th style="text-align: center; vertical-align: middle;">Total Bayar</th>
                                <th style="text-align: center; vertical-align: middle;">Terbayar</th>
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
                            var terbayar = data[i].TERBAYAR[0].FAKTUR_TRANSAKSI_GRAND_TOTAL;
                            var piutang = parseInt(data[i].TOTAL) - parseInt(terbayar)
                            if (piutang < 0) {
                                piutang = 0
                            } else {
                                piutang = piutang
                            }
                        }
                        total_terbayar += parseInt(terbayar)
                        total_piutang += parseInt(piutang)
                        tableContent += "<tr><td rowspan=" + parseInt(1 + rowspan) + ">" + no++ + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + ">" + data[i].SURAT_JALAN_NOMOR + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + ">" + data[i].RELASI[0].MASTER_RELASI_NAMA + "</td>" +
                            "<td></td>" +
                            "<td></td>" +
                            "<td></td>" +
                            "<td></td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + ">" + number_format(data[i].TOTAL) + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + ">" + number_format(terbayar) + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + ">" + number_format(piutang) + "</td>" +
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
                                var harga = data[i].BARANG[j].HARGA_BARANG[0].FAKTUR_BARANG_HARGA
                                var terbayar = 0

                            } else {
                                var quantity = 0
                                var harga = 0
                            }
                            var total_harga = quantity * harga
                            tableContent += "<tr>" +
                                "<td>" + data[i].BARANG[j].NAMA_BARANG[0].MASTER_BARANG_NAMA + "</td>" +
                                "<td>" + quantity + "</td>" +
                                "<td>" + number_format(harga) + "</td>" +
                                "<td>" + number_format(total_harga) + "</td>" +
                                "</tr>";
                        }
                    }
                    $("tbody#zone_data").append(tableContent);
                    $("tbody#zone_data_total").append("<tr><td colspan='8' style='text-align:right'><b>Total</b></td><td>" + number_format(total_terbayar) + "</td><td>" + number_format(total_piutang) + "</td></tr>");
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
        }

    });
</script>