<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Kontrol Tabung'); ?></h1>
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
                                <option value=""><?= $this->lang->line('semua'); ?></option>
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
                            <select name="status_filter" id="status_filter" class="form-control status_filter select2" style="width: 100%;">
                                <option value=""><?= $this->lang->line('semua'); ?></option>
                                <option value="MP">MP</option>
                                <option value="MR">MR</option>
                            </select>
                            <small class="text-muted">Status Kepemilikan Tabung</small>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th><?= $this->lang->line('Relasi'); ?></th>
                                <th>Kirim</th>
                                <th>Kembali</th>
                                <th>Total</th>
                                <th>Keterangan</th>
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
        kontrol_tabung_list();
    });

    function kontrol_tabung_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/laporan/kontrol_tabung/list?relasi=" + $(".relasi_filter").val() + "&tabung=" + $(".tabung_filter").val() + "&status=" + $(".status_filter").val(),
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
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
                            "<td><b>" + data[i].TANGGAL + "</b><br>" + data[i].NAMA_BARANG[0].MASTER_BARANG_NAMA + " (<small>" + data[i].JURNAL_TABUNG_STATUS + "</small>)</td>" +
                            "<td>" + data[i].MASTER_RELASI_NAMA + "</td>" +
                            "<td>" + data[i].JURNAL_TABUNG_KIRIM + "</td>" +
                            "<td>" + data[i].JURNAL_TABUNG_KEMBALI + "</td>" +
                            "<td>" + total + "</td>" +
                            "<td>" + data[i].JURNAL_TABUNG_KETERANGAN + "</td>" +
                            "</td>" +
                            "</tr>");
                    }
                    $("tbody#zone_data").append("<tr><td colspan='5' align='right'><b>Total</b></td><td colspan='4'><b>" + total + "</b></td></tr>")

                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    $('#tabung_filter,#status_filter, #relasi_filter').change(function() {
        memuat()
        kontrol_tabung_list()
    });
</script>