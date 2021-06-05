<div class="modal fade" id="pajakModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pajak</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit">
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <select name="jenis" id="jenis" class="form-control jenis select2" style="width: 100%;" required>
                                <option value=""><?= $this->lang->line('semua'); ?></option>
                                <?php
                                foreach (tabung($relasi[0]->MASTER_RELASI_ID) as $row) {
                                ?>
                                    <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required value="<?= date("Y-m-d"); ?>" required>
                            <small class="text-muted">Tanggal</small>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control total" name="total" autocomplete="off" required>
                            <small class="text-muted">Total</small>
                        </div>
                        <div class="col-md-2">
                            <select name="status" id="status" class="form-control status select2" style="width: 100%;" required>
                                <option value="">-</option>
                                <option value="MP">MP</option>
                                <option value="MR">MR</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary"><?= $this->lang->line('simpan'); ?></button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th><?= $this->lang->line('tanggal'); ?></th>
                                    <th>Jenis</th>
                                    <th>Kepemilikan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="saldo_awal">
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('tutup'); ?></button>
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
                    <h1 class="m-0">Panggung</h1>
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
                            <button type="button" class="btn btn-secondary btn_pajak mb-2">Saldo Panggung</button>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <select name="tabung_filter" id="tabung_filter" class="form-control tabung_filter select2" style="width: 100%;">
                                <option value=""><?= $this->lang->line('semua'); ?></option>
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
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('tanggal'); ?></th>
                                <th><?= $this->lang->line('Relasi'); ?></th>
                                <th>Supplier</th>
                                <th>Kirim</th>
                                <th>Kembali</th>
                                <th>Total</th>
                                <th><?= $this->lang->line('keterangan'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data_saldo_awal">
                            <tr>
                            </tr>
                        </tbody>
                        <tbody id="zone_data_saldo_panggung">
                            <tr>
                            </tr>
                        </tbody>
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
    $(".btn_pajak").on("click", function() {
        $("#pajakModal").modal("show")
        saldo_awal_list()
    })
    $(function() {
        saldo_list();
    });

    function saldo_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/laporan/panggung/list",
            async: false,
            dataType: 'json',
            data: {
                tanggal_dari: $('.tanggal_dari').val(),
                tanggal_sampai: $('.tanggal_sampai').val(),
                tabung: $('.tabung_filter').val(),
            },
            success: function(data) {
                $("tbody#zone_data").empty();
                $("tbody#zone_data_saldo_awal").empty()
                console.log(data['saldo_awal'])
                memuat()
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    if (data['saldo_awal'].length === 0) {
                        var saldo_awal = 0
                    } else {
                        var saldo_awal = data['saldo_awal'][0].JURNAL_TABUNG_KEMBALI
                    }

                    $("tbody#zone_data_saldo_awal").append("<tr class=''>" +
                        "<td colspan='6' style='text-align:right; vertical-align:middle;'><b>Saldo Awal</b></td>" +
                        "<td>" + number_format(saldo_awal) + "</td>" +
                        "</tr>");

                    var no = 1
                    var total = 0 + parseInt(saldo_awal);

                    for (i = 0; i < data['list'].length; i++) {
                        if (data['list'][i].RELASI_NAMA.length == 0) {
                            var relasi = "-"
                        } else {
                            var relasi = data['list'][i].RELASI_NAMA[0].MASTER_RELASI_NAMA
                        }
                        if (data['list'][i].SUPPLIER_NAMA.length == 0) {
                            var supplier = "-"
                        } else {
                            var supplier = data['list'][i].SUPPLIER_NAMA[0].MASTER_SUPPLIER_NAMA
                        }
                        total += data['list'][i].TOTAL
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td><b>" + data['list'][i].TANGGAL + "</b><br>" + data['list'][i].NAMA_BARANG[0].MASTER_BARANG_NAMA + " (<small>" + data['list'][i].JURNAL_TABUNG_STATUS + "</small>)</td>" +
                            "<td>" + relasi + "</td>" +
                            "<td>" + supplier + "</td>" +
                            "<td>" + data['list'][i].JURNAL_TABUNG_KIRIM + "</td>" +
                            "<td>" + data['list'][i].JURNAL_TABUNG_KEMBALI + "</td>" +
                            "<td>" + total + "</td>" +
                            "<td>" + data['list'][i].JURNAL_TABUNG_KETERANGAN + "</td>" +
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

    function saldo_awal_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/laporan/panggung/saldo_awal_list",
            async: false,
            dataType: 'json',
            data: {
                tanggal_dari: $('.tanggal_dari').val(),
                tanggal_sampai: $('.tanggal_sampai').val(),
                jenis: $('.jenis').val(),
            },
            success: function(data) {
                $("tbody#saldo_awal").empty();
                console.log(data)
                if (data.length === 0) {
                    $("tbody#saldo_awal").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        $("tbody#saldo_awal").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + data[i].JURNAL_TABUNG_STATUS + "</td>" +
                            "<td>" + data[i].JURNAL_TABUNG_KEMBALI + "</td>" +
                            "</tr>");
                    }
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
            url: '<?php echo base_url(); ?>index.php/laporan/panggung/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                // memuat()
            },
            success: function(data) {
                //pajak_list();
                //Swal.fire('Berhasil', 'Berhasil ditambahkan', 'success')
                saldo_awal_list()
                // $("#pajakModal").modal("hide")
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

        memuat()
        saldo_list()

    });
</script>