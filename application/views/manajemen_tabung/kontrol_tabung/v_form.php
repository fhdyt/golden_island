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
                <div class="col-sm-7">
                    <h1 class="m-0">Form Saldo Kontrol Tabung</h1>
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
                        <div class="col-md-12">
                            <form id="submit">
                                <input type="hidden" class="form-control id" name="id" value="<?= $id; ?>" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nomor Surat Jalan</label>
                                            <input type="text" class="form-control surat_jalan_nomor" name="surat_jalan_nomor" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tanggal Kirim</label>
                                            <input type="date" class="form-control tanggal_kirim" name="tanggal_kirim" autocomplete="off" required>
                                            <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nomor TTBK</label>
                                            <input type="text" class="form-control ttbk_nomor" name="ttbk_nomor" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tanggal Kembali</label>
                                            <input type="date" class="form-control tanggal_kembali" name="tanggal_kembali" autocomplete="off" required>
                                            <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Relasi</label>
                                            <select name="relasi" id="relasi" class="form-control relasi select2" style="width: 100%;" required>
                                                <option value="">-- Pilih Relasi --</option>
                                                <?php foreach (relasi_list() as $row) {
                                                ?>
                                                    <option value="<?= $row->MASTER_RELASI_ID; ?>"><?= $row->MASTER_RELASI_NAMA; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?= $this->lang->line('keterangan'); ?></label>
                                            <textarea name="keterangan" id="keterangan" class="form-control keterangan" rows="6">Saldo Awal (Manual)</textarea>
                                            <small class="text-muted">Kosongkan jika tidak diperlukan.</small>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Upload Dokumen</label>
                                <button type="button" nama_input="sampul_tema" class="btn btn-primary btn-block btn_upload">Pilih File</button>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default color-palette-box">
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <th>Kirim</th>
                                        <th>Kembali</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="form_tt">
                                    <tr class="table-secondary">
                                        <td>#</td>
                                        <td>
                                            <select name="tabung" id="tabung" class="form-control form-control-sm tabung select2" style="width: 100%;">
                                                <option value="">-- Tabung --</option>
                                                <?php foreach (tabung() as $row) {
                                                ?>
                                                    <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm kirim" name="kirim" autocomplete="off" value="0">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm kembali" name="kembali" autocomplete="off" value="0">
                                        </td>
                                        <td>
                                            <select name="status" id="status" class="form-control form-control-sm status select2" style="width: 100%;">
                                                <option value="MP">MP</option>
                                                <option value="MR">MR</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-secondary btn-sm btn-add-barang"><i class="nav-icon fas fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody id="zone_data">
                                    <tr>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default color-palette-box">
                    <div class="card-body">
                        <button type="submit" class="btn btn-success btn-lg"><?= $this->lang->line('simpan'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script>
    $(function() {
        barang_list()
    })

    $('.btn-add-barang').on("click", function(e) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/manajemen_tabung/kontrol_tabung/add_jurnal',
            dataType: "JSON",
            beforeSend: function() {
                memuat()
            },
            data: {
                id: "<?= $id; ?>",
                relasi: $('.relasi').val(),
                tabung: $('.tabung').val(),
                kirim: $('.kirim').val(),
                kembali: $('.kembali').val(),
                status: $('.status').val(),
            },
            success: function(data) {
                $('.kirim').val("0")
                $('.kembali').val("0")
                barang_list()
            }
        });
    })

    function barang_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/manajemen_tabung/kontrol_tabung/list_jurnal/<?= $id; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $("tbody#zone_data").empty();
                memuat()
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].NAMA_BARANG[0].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + data[i].JURNAL_TABUNG_KIRIM + "</td>" +
                            "<td>" + data[i].JURNAL_TABUNG_KEMBALI + "</td>" +
                            "<td>" + data[i].JURNAL_TABUNG_STATUS + "</td>" +
                            "<td><a class='btn btn-danger btn-sm' onclick='hapus(\"" + data[i].JURNAL_TABUNG_ID + "\")'><i class='fas fa-trash'></i></a> " +
                            "</tr>");
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function hapus(id) {
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
                    url: '<?php echo base_url() ?>index.php/manajemen_tabung/kontrol_tabung/hapus_jurnal/' + id,
                    dataType: 'json',
                    beforeSend: function() {
                        memuat()
                    },
                    success: function(data) {
                        if (data.length === 0) {} else {
                            Swal.fire('Berhasil', 'Jenis Barang Berhasil dihapus', 'success')
                            barang_list()
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

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/manajemen_tabung/kontrol_tabung/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                window.location.href = '<?= base_url(); ?>index.php/manajemen_tabung/kontrol_tabung'

            }
        });
    })
</script>