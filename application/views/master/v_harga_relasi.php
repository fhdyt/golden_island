<div class="modal fade" id="hargaModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Harga</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit">
                    <div class="form-group">
                        <input type="hidden" class="form-control id_detail" name="id_detail" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Harga</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" class="form-control harga" name="harga" autocomplete="off">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jaminan</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="text" class="form-control jaminan" name="jaminan" autocomplete="off">
                        </div>

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
                    <h1 class="m-0">Harga Relasi <br><b><?= $relasi[0]->MASTER_RELASI_NAMA; ?></b></h1>
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
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jaminan</th>
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
    $(function() {
        $(".harga").mask("#.##0", {
            reverse: true
        });
        $(".jaminan").mask("#.##0", {
            reverse: true
        });
        harga_relasi_list();
    });

    function harga_relasi_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/master/relasi/harga_list/<?= $relasi[0]->MASTER_RELASI_ID; ?>",
            async: false,
            dataType: 'json',
            success: function(data) {
                $("tbody#zone_data").empty();
                memuat()
                console.log(data)
                if (data.length === 0) {
                    $("tbody#zone_data").append("<td colspan='10'><?= $this->lang->line('tidak_ada_data'); ?></td>")
                } else {
                    // var tableContent = "";
                    // var no = 1
                    // for (i = 0; i < data.length; i++) {
                    //     var rowspan = 0;
                    //     var detailLength = data[i].DETAIL.length;
                    //     rowspan += detailLength;
                    //     tableContent += "<tr><td rowspan=" + parseInt(1 + rowspan) + ">" + no++ + "</td><td rowspan=" + parseInt(1 + rowspan) + ">" + data[i].MASTER_JENIS_BARANG_NAMA + "</td></tr>";
                    //     console.log(detailLength)
                    //     var relasiLength = 0;
                    //     for (var j = 0; j < detailLength; j++) {
                    //         if (data[i].DETAIL[j].HARGA[0].MASTER_HARGA_HARGA == undefined) {
                    //             var harga = 0
                    //         } else {
                    //             var harga = number_format(data[i].DETAIL[j].HARGA[0].MASTER_HARGA_HARGA)
                    //         }
                    //         tableContent += "<tr><td rowspan=" + parseInt(1 + relasiLength) + ">" +
                    //             data[i].DETAIL[j].MASTER_JENIS_BARANG_DETAIL_KAPASITAS + "</td><td rowspan=" + parseInt(1 + relasiLength) + ">" +
                    //             data[i].DETAIL[j].MASTER_JENIS_BARANG_DETAIL_SATUAN + "</td><td>" + harga + "</td><td><a class='btn btn-success btn-sm addHarga-btn' detail_id='" + data[i].DETAIL[j].MASTER_JENIS_BARANG_DETAIL_ID + "'><i class='fas fa-tag'></i> Tambah Harga</a></td></tr>";
                    //     }
                    // }
                    // $("tbody#zone_data").append(tableContent);

                    var no = 1
                    for (i = 0; i < data.length; i++) {
                        if (data[i].HARGA[0].MASTER_HARGA_HARGA == undefined) {
                            var harga = 0
                        } else {
                            var harga = number_format(data[i].HARGA[0].MASTER_HARGA_HARGA)
                        }
                        if (data[i].HARGA[0].MASTER_HARGA_JAMINAN == undefined) {
                            var jaminan = 0
                        } else {
                            var jaminan = number_format(data[i].HARGA[0].MASTER_HARGA_JAMINAN)
                        }
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].MASTER_BARANG_NAMA + "</td>" +
                            "<td>" + harga + "</td>" +
                            "<td>" + jaminan + "</td>" +
                            "<td> <a class = 'btn btn-success btn-sm addHarga-btn' detail_id = '" + data[i].MASTER_BARANG_ID + "' harga='" + harga + "' jaminan='" + jaminan + "' > <i class = 'fas fa-tag'> </i> Tambah Harga</a> </td>" +
                            "</tr>");
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }

    $("tbody#zone_data").on("click", "a.addHarga-btn", function() {
        $("#submit").trigger("reset");
        $(".id_detail").val($(this).attr("detail_id"))
        $(".harga").val($(this).attr("harga"))
        $(".jaminan").val($(this).attr("jaminan"))
        $("#hargaModal").modal("show")
    })

    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/master/relasi/add_harga/<?= $relasi[0]->MASTER_RELASI_ID; ?>',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                harga_relasi_list();
                Swal.fire('Berhasil', 'Harga berhasil ditambahkan', 'success')
                $("#hargaModal").modal("hide")
            }
        });
    })
</script>