<div class="modal fade" id="hargaModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Hutang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit">
                    <div class="form-group">
                        <input type="hidden" class="form-control id_karyawan" name="id_karyawan" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nominal</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" class="form-control harga" name="harga" autocomplete="off">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Akun</label>
                        <select name="akun" id="akun" class="form-control akun select2" style="width: 100%;" required>
                            <option value="">-- Akun --</option>
                            <?php foreach (akun_list() as $row) {
                            ?>
                                <option value="<?= $row->AKUN_ID; ?>"><?= $row->AKUN_NAMA; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Keterangan</label>
                        <input type="text" class="form-control keterangan" name="keterangan" autocomplete="off">
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
                    <h1 class="m-0"><?= $this->lang->line('Karyawan'); ?></h1>
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

                    <table id="example2" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?= $this->lang->line('nama'); ?></th>
                                <th>Jabatan</th>
                                <th>Total Hutang</th>
                                <th></th>
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
    $(".btn_karyawan").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $(".jabatan").val("").trigger("change")
        $("#karyawanModal").modal("show")
    })
    $(function() {
        $(".harga").mask("#.##0", {
            reverse: true
        });
        karyawan_list();
    });

    function karyawan_list() {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() ?>index.php/karyawan/hutang/list",
            async: false,
            dataType: 'json',
            data: {
                bulan: $(".bulan").val(),
                tahun: $(".tahun").val()
            },
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    var no = 1
                    var total_seluruh = 0
                    for (i = 0; i < data.length; i++) {
                        total_seluruh += data[i].TOTAL
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_KARYAWAN_NAMA + "</td>" +
                            "<td>" + data[i].MASTER_KARYAWAN_JABATAN + "</td>" +
                            "<td>Rp. " + number_format(data[i].TOTAL) + "</td>" +
                            "<td> " +
                            "<td> <a class = 'btn btn-success btn-sm addHarga-btn' id_karyawan = '" + data[i].MASTER_KARYAWAN_ID + "' > <i class = 'fas fa-tag'> </i> Tambah Hutang</a> </td>" +
                            "</tr>");
                    }
                    $("tbody#zone_data").append("<tr><td colspan='3'style='text-align:right'>Total</td><td>Rp. " + number_format(total_seluruh) + "</td></tr>")
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    $("tbody#zone_data").on("click", "a.addHarga-btn", function() {
        $("#submit").trigger("reset");
        $(".id_karyawan").val($(this).attr("id_karyawan"))
        $("#hargaModal").modal("show")
    })
    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/karyawan/hutang/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                karyawan_list();
                Swal.fire('Berhasil', 'Hutang berhasil ditambahkan', 'success')
                $("#hargaModal").modal("hide")
            }
        });
    })

    $('.bulan, .tahun').change(function() {
        memuat()
        karyawan_list()
    });
</script>