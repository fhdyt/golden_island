<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="m-0">Realisasi</h1>
                    <p class="driver_nama">Loading...</p>
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
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;">No.</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Nomor Surat Jalan</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Jenis Barang</th>
                                <th colspan="3" style="text-align: center; vertical-align: middle;">Quantity</th>
                                <th rowspan="2" style="text-align: center; vertical-align: middle;">Total</th>
                            </tr>
                            <tr>
                                <th>Isi</th>
                                <th>Kosong</th>
                                <th>Klaim</th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                            </tr>
                        </tbody>
                        <tfoot id="total_data">

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
        realisasi_list();
        detail_driver()
    });

    function realisasi_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/distribusi/realisasi_sj/list_realisasi?driver=<?= $this->uri->segment("4"); ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                $("tfoot#total_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {


                    var tableContent = "";
                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        var rowspan = 0;
                        var detailLength = data[i].BARANG.length;
                        rowspan += detailLength;
                        tableContent += "<tr><td rowspan=" + parseInt(1 + rowspan) + ">" + no++ + "</td>" +
                            "<td rowspan=" + parseInt(1 + rowspan) + ">" + data[i].SURAT_JALAN_NOMOR + "</td></tr>";
                        console.log(detailLength)
                        var barangLlength = 0;
                        var total_qty = 0
                        for (var j = 0; j < detailLength; j++) {
                            total_qty += data[i].BARANG[j].TOTAL
                            tableContent += "<tr>" +
                                "<td rowspan=" + parseInt(1 + barangLlength) + ">" + data[i].BARANG[j].MASTER_BARANG_NAMA + "<br><small class='text-muted'>" + data[i].BARANG[j].SURAT_JALAN_BARANG_JENIS + "</small></td>" +
                                "<td rowspan=" + parseInt(1 + barangLlength) + ">" + data[i].BARANG[j].SURAT_JALAN_BARANG_QUANTITY + "</td>" +
                                "<td rowspan=" + parseInt(1 + barangLlength) + ">" + data[i].BARANG[j].SURAT_JALAN_BARANG_QUANTITY_KOSONG + "</td>" +
                                "<td rowspan=" + parseInt(1 + barangLlength) + ">" + data[i].BARANG[j].SURAT_JALAN_BARANG_QUANTITY_KLAIM + "</td>" +
                                "<td rowspan=" + parseInt(1 + barangLlength) + ">" + data[i].BARANG[j].TOTAL + "</td>" +

                                "</tr>";
                        }
                    }
                    $("tbody#zone_data").append(tableContent);
                    $("tfoot#total_data").append("<tr><td colspan='6' align='right'><b>Total</b></td><td><b>" + total_qty + "</b></td></tr>")
                    console.log(total_qty)
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function detail_driver() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/distribusi/realisasi_sj/detail_driver?driver=<?= $this->uri->segment("4"); ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                if (data.length == 0) {
                    console.log(data)
                } else {
                    console.log(data)
                    $("p.driver_nama").html(data[0].MASTER_KARYAWAN_NAMA)
                }


            },
            error: function(x, e) {} //end error
        });
    }
</script>