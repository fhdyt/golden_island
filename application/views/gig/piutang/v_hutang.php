<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Rincian Hutang</h1>
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
                                <th>Jatuh Tempo</th>
                                <th>Keterangan</th>
                                <th>Hutang</th>
                                <th colspan="2" align="center">Sisa Hutang</th>
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
        relasi_list()
        detail()
        $(".rupiah").mask("#.##0", {
            reverse: true
        });
    })
    $(".btn_akun").on("click", function() {
        $("#akunModal").modal("show")
    })
    $(".btn_saldo_piutang").on("click", function() {
        $("#saldopiutangModal").modal("show")
    })

    function relasi_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/akuntansi/piutang/list_hutang?id=<?= $this->uri->segment('4') ?>",
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
                    var total_hutang = 0
                    for (i = 0; i < data.length; i++) {
                        total_hutang += parseInt(data[i].PIUTANG_DEBET)
                        if (data[i].STATUS == "CORET") {
                            var del = "del"
                        } else {
                            var del = "p"
                        }
                        if (data[i].PEMBAYARAN == "0") {
                            var tr = "success"
                            var lunas = "<a class='btn btn-success'>LUNAS</a>"
                        } else {
                            var tr = "default"
                            var lunas = ""
                        }
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + data[i].TANGGAL + "</td>" +
                            "<td>" + data[i].TANGGAL_TEMPO + "</td>" +
                            "<td><" + del + ">" + data[i].PIUTANG_KETERANGAN + "</" + del + "></td>" +
                            "<td><" + del + "><a target='_blank' href='<?= base_url() ?>cetak/faktur_penjualan/" + data[i].PIUTANG_REF + "'>" + number_format(data[i].PIUTANG_DEBET) + "</a></" + del + "></td>" +
                            "<td>" + number_format(data[i].PEMBAYARAN) + "</td>" +
                            "<td>" + lunas + "</td>" +
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
            url: '<?php echo base_url(); ?>index.php/akuntansi/piutang/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                relasi_list();
                Swal.fire('Berhasil', '', 'success')
                $("#akunModal").modal("hide")
            }
        });
    })
    $('#submit_saldo_piutang').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/akuntansi/piutang/add_saldo',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                relasi_list();
                Swal.fire('Berhasil', '', 'success')
                $("#akunModal").modal("hide")
            }
        });
    })

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/gig/piutang/detail/<?= $this->uri->segment("4"); ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if (data.length == 0) {} else {
                    $("p.nama_relasi").html(data[0].MASTER_RELASI_NAMA)
                }


            },
            error: function(x, e) {} //end error
        });
    }
</script>