<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?= $this->lang->line('Hutang'); ?></h1>
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
                            <a href="<?= base_url() ?>akuntansi/hutang/laporan" class="btn btn-secondary mb-2">Laporan Hutang Bulanan</a>
                        </div>
                        <div class="col-md-7">
                            <select name="supplier" id="supplier" class="form-control supplier select2" style="width: 100%;" required>
                                <option value="">-- Pilih Supplier --</option>
                                <?php foreach (supplier_list() as $row) {
                                ?>
                                    <option value="<?= $row->MASTER_SUPPLIER_ID; ?>"><?= $row->MASTER_SUPPLIER_NAMA; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-outline-secondary btn_akun mb-2 rincian_hutang">Rincian Hutang</a>
                        </div>
                    </div>
                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Supplier</th>
                                <th>Saldo</th>
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
    $(".btn_akun").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")

        if ($(".supplier").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Silahkan pilih Supplier terlebih dahulu'
            })
        } else {
            $("#akunModal").modal("show")
        }


    })
    $(function() {
        hutang_list();
        $(".rupiah").mask("#.##0", {
            reverse: true
        });
    });

    $(".rincian_hutang").on("click", function() {
        window.location.href = '<?= base_url(); ?>akuntansi/hutang/hutang/' + $(".supplier").val() + ''
    })

    function hutang_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/akuntansi/hutang/supplier_list",
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
                    var total_saldo = 0
                    for (i = 0; i < data.length; i++) {
                        total_saldo += parseInt(data[i].SALDO)
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + "</td>" +
                            "<td>" + data[i].MASTER_SUPPLIER_NAMA + "</td>" +
                            "<td>" + number_format(data[i].SALDO) + "</td>" +
                            "<td><a class='btn btn-primary btn-sm' href='<?= base_url(); ?>akuntansi/hutang/hutang/" + data[i].MASTER_SUPPLIER_ID + "' >Rincian Hutang</a> " +
                            "<a class='btn btn-success btn-sm' href='<?= base_url(); ?>akuntansi/hutang/pembayaran/" + data[i].MASTER_SUPPLIER_ID + "' >Rincian Pembayaran</a></td>" +
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

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/akuntansi/hutang/add?supplier=' + $(".supplier").val() + '&pi=' + $(".pi").val() + '',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                hutang_list();
                Swal.fire('Berhasil', '', 'success')
                $("#akunModal").modal("hide")
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
                    url: '<?php echo base_url() ?>index.php/akuntansi/akun/hapus/' + id,
                    beforeSend: function() {
                        memuat()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {} else {
                            akun_list();
                            Swal.fire('Berhasil', 'Akun Berhasil dihapus', 'success')
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
            url: '<?php echo base_url() ?>index.php/akuntansi/akun/detail/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $(".id").val(data[0].AKUN_ID)
                $(".nama").val(data[0].AKUN_NAMA)
                $(".akun").val(data[0].AKUN_KATEGORI)

                $("#akunModal").modal("show")
            },
            error: function(x, e) {} //end error
        });
    }

    function pi_list(id) {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/akuntansi/hutang/pi_list/' + id,
            beforeSend: function() {
                memuat()
            },
            dataType: 'json',
            success: function(data) {
                memuat()
                $(".pi").empty()

                for (i = 0; i < data.length; i++) {
                    $(".pi").append("<option value='" + data[i].PI_ID + "'>" + data[i].PEMBELIAN_NOMOR + "</option>");
                }
                hutang_list()

            },
            error: function(x, e) {} //end error
        });
    }

    // $('.supplier').change(function() {
    //     memuat()
    //     var id = $(".supplier").val()
    //     pi_list(id)
    // });

    $('.pi').change(function() {
        memuat()
        hutang_list()
    });
</script>