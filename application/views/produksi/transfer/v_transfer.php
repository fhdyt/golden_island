<style>
    .table {
        font-size: small;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Transfer</h1>
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
                        <div class="col-md-5">
                            <a href="<?= base_url(); ?>produksi/transfer/form" class="btn btn-secondary mb-2 btn-form mr-2">Tambah Transfer</a>
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                        <div class="col-md-1">
                            <button class="btn btn-success filter_tanggal"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nomor Produksi Transfer</th>
                                <th>Tanggal</th>
                                <th></th>
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
        produksi_list();
    });

    function produksi_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/produksi/transfer/list",
            async: false,
            dataType: 'json',
            data: {
                bulan: $(".bulan").val(),
                tahun: $(".tahun").val()
            },
            success: function(data) {
                $("tbody#zone_data").empty();
                $("tbody#zone_data_total").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    for (i = 0; i < data.length; i++) {

                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].PRODUKSI_NOMOR + "</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td><a class='btn btn-primary btn-block  btn-xs mb-2' href='<?= base_url(); ?>produksi/transfer/form/" + data[i].PRODUKSI_ID + "/'>Lihat</a> " +
                            "<a class='btn btn-success  btn-block btn-xs ' href='<?= base_url(); ?>cetak/produksi/" + data[i].PRODUKSI_ID + "/'>Cetak</a> " +
                            "</td>" +
                            "</tr>");
                    }
                    $("tbody#zone_data_total").append('<tr><td colspan="6" style="text-align:right">Total</td><td>' + total_gl + '</td><td>' + total_terpakai + '</td><td>' + total_tabung + '</td><td></td></tr>')
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    $('.filter_tanggal').on("click", function() {
        memuat()
        produksi_list()
    });
</script>