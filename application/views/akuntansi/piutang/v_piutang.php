<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Piutang'); ?></h1>
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
                            <a href="<?= base_url() ?>akuntansi/piutang/laporan" class="btn btn-secondary btn_akun mb-2">Laporan Piutang Bulanan</a>
                        </div>
                        <div class="col-md-7">
                            <select name="relasi" id="relasi" class="form-control relasi select2" style="width: 100%;" required>
                                <option value="">-- Pilih Relasi --</option>
                                <?php foreach (relasi_list() as $row) {
                                ?>
                                    <option value="<?= $row->MASTER_RELASI_ID; ?>" id_relasi="<?= $row->MASTER_RELASI_QR_ID; ?>"><?= $row->MASTER_RELASI_NAMA; ?> - <?= $row->MASTER_RELASI_QR_ID; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-outline-secondary btn_akun mb-2 rincian_hutang">Rincian Piutang</a>
                        </div>
                    </div>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Relasi</th>
                                <th>Saldo Piutang</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                            </tr>
                        </tbody>
                        <tfoot id="total_zone_data">
                        </tfoot>
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
        relasi_list()
    })

    $(".rincian_hutang").on("click", function() {
        window.location.href = '<?= base_url(); ?>akuntansi/piutang/hutang/' + $(".relasi").val() + ''
    })

    function relasi_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/akuntansi/piutang/relasi_list",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                // console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var saldo = 0
                    var total_saldo = 0
                    data = jQuery.grep(data, function(value) {
                        return value.SALDO != "0";
                    });
                    console.log(data)
                    for (i = 0; i < data.length; i++) {
                        total_saldo += parseInt(data[i].SALDO)
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + data[i].MASTER_RELASI_NAMA + "</td>" +
                            "<td>" + number_format(data[i].SALDO) + "</td>" +
                            "<td><a class='btn btn-primary btn-sm' href='<?= base_url(); ?>akuntansi/piutang/hutang/" + data[i].MASTER_RELASI_ID + "' >Rincian Piutang</a> " +
                            "<a class='btn btn-success btn-sm' href='<?= base_url(); ?>akuntansi/piutang/pembayaran/" + data[i].MASTER_RELASI_ID + "' >Rincian Pembayaran</a></td>" +
                            "</tr>");
                    }
                    $("tfoot#total_zone_data").append("<tr><td colspan='2' style='text-align:right; vertical-align:middle;'><b>Total</b></td><td>" + number_format(total_saldo) + "</td></tr>")
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }
</script>