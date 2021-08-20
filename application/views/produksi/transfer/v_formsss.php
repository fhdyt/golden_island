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
                    <h1 class="m-0">Form Mulai Produksi</h1>
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
                    <form id="submit">
                        <div class="row">
                            <input type="hidden" class="form-control id" name="id" value="<?= $id; ?>" autocomplete="off">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No Produksi</label>
                                    <input type="text" class="form-control nomor_produksi" name="nomor_produksi" autocomplete="off" readonly>
                                    <small class="text-muted">Nomor Otomatis akan terisi.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?= $this->lang->line('tanggal'); ?></label>
                                    <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off" required value="<?= date("Y-m-d"); ?>" readonly>
                                    <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Jenis Bahan</label>
                                    <select name="jenis" id="jenis" class="form-control jenis select2" style="width: 100%;">
                                        <option value="">-- Jenis Barang --</option>
                                        <?php
                                        foreach (tangki() as $row) {
                                        ?>
                                            <option value="<?= $row->MASTER_BARANG_ID; ?>"><?= $row->MASTER_BARANG_NAMA; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Level Awal <small>Kg</small></label>
                                    <input type="text" class="form-control level_awal" name="level_awal" autocomplete="off">
                                    <small class="text-muted">*<?= $this->lang->line('wajib_isi'); ?>.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Foto Level Awal</label>
                                    <input type="hidden" name="userfile_name" class="form-control userfile_name">
                                    <input type="file" name="userfile" class="form-control userfile">
                                    <small class="text-muted"><a href="" target="_blank" class="link_dokument"></a></small>
                                </div>
                            </div>
                        </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default color-palette-box">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success btn-lg simpan_surat_jalan"><?= $this->lang->line('simpan'); ?></button>
                            </form>
                        </div>
                    </div>
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
    $(function() {
        // memuat()
        detail()
    });

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/produksi/produksi/detail/<?= $id; ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                memuat()
                if (data.length == 0) {} else {
                    $(".nomor_produksi").val(data[0].PRODUKSI_NOMOR)
                    $(".tanggal").val(data[0].TANGGAL)
                    $(".jenis").val(data[0].MASTER_BARANG_ID).trigger('change')
                    $(".level_awal").val(data[0].PRODUKSI_LEVEL_AWAL)
                    if (data[0].PRODUKSI_LEVEL_AWAL_FILE == "") {} else {
                        $(".link_dokument").html("Lihat Dokumen")
                        $(".link_dokument").attr("href", "<?= base_url(); ?>uploads/produksi/" + data[0].PRODUKSI_LEVEL_AWAL_FILE + "")
                    }
                }


            },
            error: function(x, e) {
                console.log('gagag')
            } //end error
        });
    }

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/produksi/produksi/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                detail();
                window.location.href = '<?= base_url(); ?>produksi/produksi/form/<?= $id; ?>'
            }
        });
    })
</script>