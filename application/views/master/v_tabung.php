<div class="modal fade" id="tabungModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Tabung</h4>
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
                        <label for="exampleInputEmail1">Jenis Tabung</label>
                        <select name="tabung" id="tabung" class="form-control tabung select2" style="width: 100%;" required>
                            <option value="">-- Jenis --</option>
                            <?php foreach (tabung() as $row) {
                            ?>
                                <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jumlah Tabung</label>
                        <input type="text" class="form-control jumlah" name="jumlah" autocomplete="off" value="1" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Tabung</label>
                        <input type="text" class="form-control kode" name="kode" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nomor Tabung</label>
                        <input type="text" class="form-control kode_lama" name="kode_lama" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kode Produksi</label>
                        <input type="text" class="form-control kode_produksi" name="kode_produksi" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tahun</label>
                        <input type="text" class="form-control tahun" name="tahun" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kepemilikan</label>
                        <select name="kepemilikan" id="kepemilikan" class="form-control kepemilikan select2" style="width: 100%;" required>
                            <option value="MP">MP</option>
                            <option value="MR">MR</option>
                        </select>
                        <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Tabung'); ?></h1>
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
                    <div class="row">
                        <div class="col-md-2">
                            <button type="button" class="btn btn-secondary btn_tabung mb-2 btn-block">Tambah Tabung</button>
                        </div>
                        <div class="col-md-2">
                            <a target="_blank" href="<?= base_url(); ?>cetak/tabung" class="btn btn-block btn-success mb-2"><i class="fas fa-qrcode"></i> Cetak Qrcode</a>
                        </div>
                        <div class="col-md-8">
                            <select name="tabung_filter" id="tabung_filter" class="form-control tabung_filter select2" style="width: 100%;" required>
                                <option value="">-- Semua --</option>
                                <?php foreach (tabung() as $row) {
                                ?>
                                    <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Jenis Barang</th>
                                <th></th>
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
    $(".btn_tabung").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $(".tabung").val("").trigger("change")
        $("#tabungModal").modal("show")
    })
    $(function() {
        tabung_list();
    });

    function tabung_list(id) {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/master/tabung/list?tabung=" + $(".tabung_filter").val() + "",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'>Tidak ada data</td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        //console.log()
                        if (data[i].RIWAYAT.length < 1) {
                            var status = "<p class='text-danger'><b><i>Riwayat Tabung<br>tidak ditemukan</i></b></p>"
                        } else {
                            if (data[i].RIWAYAT[0].RIWAYAT_TABUNG_STATUS == "0") {
                                var status = "<p class='text-muted'>Kosong</p>"
                            } else if (data[i].RIWAYAT[0].RIWAYAT_TABUNG_STATUS == "1") {
                                var status = "<p class='text-success'>Isi</p>"
                            } else {
                                var status = "<p>Tidak diketahui</p>"
                            }
                        }
                        if (data[i].MASTER_TABUNG_KEPEMILIKAN == null) {
                            var kepemilikan = "-"

                        } else {
                            var kepemilikan = data[i].MASTER_TABUNG_KEPEMILIKAN
                        }
                        if (data[i].MASTER_TABUNG_KODE_LAMA == null) {
                            var kode_lama = "-"

                        } else {
                            var kode_lama = data[i].MASTER_TABUNG_KODE_LAMA
                        }
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_TABUNG_KODE + " (" + kepemilikan + ")<br><small class='text-muted'>Nomor Tabung : " + kode_lama + "</small>" + status + "</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].MASTER_TABUNG_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "<a class='btn btn-warning btn-sm' onclick='detail(\"" + data[i].MASTER_TABUNG_ID + "\")'><i class='fas fa-edit'></i></a> " +
                            "<a class='btn btn-success btn-sm' href='<?= base_url(); ?>master/tabung/riwayat_tabung/" + data[i].MASTER_TABUNG_ID + "'><i class='fas fa-list'></i></a></td>" +
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
            url: '<?php echo base_url(); ?>index.php/master/tabung/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                tabung_list();
                Swal.fire('Berhasil', 'Tabung berhasil ditambahkan', 'success')
                $("#tabungModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/master/tabung/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            tabung_list();
                            Swal.fire('Berhasil', 'Tabung Berhasil dihapus', 'success')
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
            url: '<?php echo base_url() ?>index.php/master/tabung/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $(".id").val(data[0].MASTER_TABUNG_ID)
                $(".kode").val(data[0].MASTER_TABUNG_KODE)
                $(".jumlah").val("1")
                $(".kode_lama").val(data[0].MASTER_TABUNG_KODE_LAMA)
                $(".kode_produksi").val(data[0].MASTER_TABUNG_KODE_PRODUKSI)
                $(".tahun").val(data[0].MASTER_TABUNG_TAHUN)
                $(".tabung").val(data[0].MASTER_BARANG_ID).trigger('change')
                $(".kepemilikan").val(data[0].MASTER_TABUNG_KEPEMILIKAN).trigger('change')

                $("#tabungModal").modal("show")
            },
            error: function(x, e) {} //end error
        });
    }

    $('.tabung_filter').change(function() {
        memuat()
        var id = $(".tabung_filter").val()
        tabung_list(id)
    });
</script>