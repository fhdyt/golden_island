<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Rincian Pembayaran</h1>
                    <p class="nama_relasi">Loading...</p>
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
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Pembayaran</th>
                                <th>Total Pembayaran</th>
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
        detail()
        relasi_list()
    })

    function relasi_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/akuntansi/hutang/list_pembayaran?id=<?= $this->uri->segment('4') ?>",
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
                    var saldo = 0
                    var total_pembayaran = 0
                    for (i = 0; i < data.length; i++) {
                        total_pembayaran += parseInt(data[i].HUTANG_KREDIT)
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].HUTANG_KETERANGAN + "</td>" +
                            "<td>" + number_format(data[i].HUTANG_KREDIT) + "</td>" +
                            "<td>" + number_format(total_pembayaran) + "</td>" +
                            "</tr>");
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/gig/hutang/detail/<?= $this->uri->segment("4"); ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if (data.length == 0) {} else {
                    $("p.nama_relasi").html(data[0].MASTER_SUPPLIER_NAMA)
                }


            },
            error: function(x, e) {} //end error
        });
    }
</script>