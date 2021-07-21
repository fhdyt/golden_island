<div class="modal fade" id="kontrol_tabungModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Saldo Tabung</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit">
                    <div class="form-group">
                        <input type="hidden" class="form-control id_detail" name="id_detail" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= $this->lang->line('tanggal'); ?></label>
                        <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tabung</label>
                        <select name="tabung" id="tabung" class="form-control tabung select2" style="width: 100%;" required>
                            <option value="">-- Tabung --</option>
                            <?php
                            foreach (tabung() as $row) {
                            ?>
                                <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Quantity Kirim</label>
                        <input type="text" class="form-control kirim" name="kirim" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Quantity Kembali</label>
                        <input type="text" class="form-control kembali" name="kembali" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kepemilikan</label>
                        <select name="status" id="status" class="form-control status select2" style="width: 100%;">
                            <option value="MP">MP</option>
                            <option value="MR">MR</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Gambar</label>
                        <input type="file" name="userfile" class="form-control">
                        <small class="text-muted"><a href="" target="_blank" class="link_dokument"></a></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= $this->lang->line('keterangan'); ?></label>
                        <input type="text" class="form-control keterangan" name="keterangan" autocomplete="off" value="Saldo Awal (Manual)">
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Kontrol Tabung <br><b><?= $relasi[0]->MASTER_RELASI_NAMA; ?></b></h1>
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
                        <div class="col-md-8">
                            <select name="tabung_filter" id="tabung_filter" class="form-control tabung_filter select2" style="width: 100%;">
                                <option value="">-- Jenis Tabung --</option>
                                <?php
                                foreach (tabung($relasi[0]->MASTER_RELASI_ID) as $row) {
                                ?>
                                    <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="status_filter" id="status_filter" class="form-control status_filter select2" style="width: 100%;">
                                <option value=""><?= $this->lang->line('semua'); ?></option>
                                <option value="MP">MP</option>
                                <option value="MR">MR</option>
                            </select>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('tanggal'); ?></th>
                                <th>Kirim</th>
                                <th>Kembali</th>
                                <th>Saldo</th>
                                <th><?= $this->lang->line('keterangan'); ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                            </tr>
                        </tbody>
                        <tbody id="total_zone_data">
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
    $(".btn_kontrol_tabung").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#kontrol_tabungModal").modal("show")
    })

    $(function() {
        $(".harga").mask("#.##0", {
            reverse: true
        });
        kontrol_tabung_list();
    });

    function kontrol_tabung_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/manajemen_tabung/kontrol_tabung/kontrol_tabung_list/<?= $relasi[0]->MASTER_RELASI_ID; ?>?tabung=" + $(".tabung_filter").val() + "&status=" + $(".status_filter").val(),
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var total = 0
                    for (i = 0; i < data.length; i++) {
                        total += data[i].TOTAL
                        if (data[i].JURNAL_TABUNG_FILE == "empty")
                            var img = ""
                        else {
                            var img = "<img src='<?= base_url(); ?>uploads/kontrol_tabung/" + data[i].JURNAL_TABUNG_FILE + "' width='50'><br><a href='<?= base_url(); ?>uploads/kontrol_tabung/" + data[i].JURNAL_TABUNG_FILE + "' target='_blank'> Buka Gambar</a>"
                        }
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].TANGGAL + "<br><small>" + data[i].JURNAL_TABUNG_STATUS + "</small></td>" +
                            "<td>" + data[i].JURNAL_TABUNG_KIRIM + "</td>" +
                            "<td>" + data[i].JURNAL_TABUNG_KEMBALI + "</td>" +
                            "<td>" + total + "</td>" +
                            "<td>" + data[i].JURNAL_TABUNG_KETERANGAN + "</td>" +
                            "<td>" + img + "</td>" +
                            // "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].JURNAL_TABUNG_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            // "</td>" +
                            "</tr>");
                    }
                    $("tbody#zone_data").append("<tr><td colspan='4' align='right'><b>Total</b></td><td colspan='3'><b>" + total + "</b></td></tr>")

                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    $("tbody#zone_data").on("click", "a.addHarga-btn", function() {
        $("#submit").trigger("reset");
        $(".id_detail").val($(this).attr("detail_id"))
        $("#hargaModal").modal("show")
    })

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/master/relasi/add_kontrol_tabung/<?= $relasi[0]->MASTER_RELASI_ID; ?>',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                kontrol_tabung_list();
                Swal.fire('Berhasil', 'Harga berhasil ditambahkan', 'success')
                $("#kontrol_tabungModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/master/relasi/hapus_kontrol_tabung/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            kontrol_tabung_list();
                            Swal.fire('Berhasil', 'Jenis Barang Berhasil dihapus', 'success')
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

    $('#tabung_filter,#status_filter').change(function() {
        memuat()
        kontrol_tabung_list()
    });
</script>