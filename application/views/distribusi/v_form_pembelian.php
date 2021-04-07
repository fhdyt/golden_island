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
                    <h1 class="m-0">Form Pembelian</h1>
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
                        <input type="hidden" class="form-control id" name="id" value="<?= $id; ?>" autocomplete="off">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nomor Surat</label>
                                    <input type="text" class="form-control nomor_surat" name="nomor_surat" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal</label>
                                    <input type="date" class="form-control tanggal" name="tanggal" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Supplier</label>
                                    <select name="supplier" id="supplier" class="form-control supplier">
                                        <option value="">--Pilih Supplier--</option>
                                        <?php foreach ($supplier as $row) {
                                        ?>
                                            <option value="<?= $row->MASTER_SUPPLIER_ID; ?>"><?= $row->MASTER_SUPPLIER_NAMA; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Jenis Pembelian</label>
                                    <select name="jenis_pembelian" id="jenis_pembelian" class="form-control jenis_pembelian">
                                        <option value="gas">Gas</option>
                                        <option value="liquid">Liquid</option>
                                        <option value="tabung">Tabung</option>
                                        <option value="non">Non</option>
                                        <option value="tangki">Tangki</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Quantity</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control quantity" autocomplete="off" onkeyup="kalkulasi_total_bayar()">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Harga</label>
                                    <input type="text" name="harga" id="harga" class="form-control harga" autocomplete="off" onkeyup="kalkulasi_total_bayar()">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Total</label>
                                    <input type="text" name="total" id="total" class="form-control total" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bayar</label>
                                    <input type="text" name="bayar" id="bayar" class="form-control bayar" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Sisa Bayar</label>
                                    <input type="text" name="sisa_bayar" id="sisa_bayar" class="form-control sisa_bayar" autocomplete="off" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control keterangan"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-lg">Simpan</button>
                            </div>
                        </div>
                    </form>
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
        // $(".harga").mask("#.##0", {
        //     reverse: true
        // });
        detail()
    });
    $('#submit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/distribusi/pembelian/add',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                Swal.fire('Berhasil', 'Pembelian berhasil ditambahkan', 'success')
            }
        });
    })

    function detail() {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/distribusi/pembelian/detail/<?= $id; ?>',
            async: false,
            dataType: 'json',
            success: function(data) {
                if (data.length == 0) {

                } else {
                    $(".nomor_surat").val(data[0].PEMBELIAN_NOMOR_SURAT)
                    $(".tanggal").val(data[0].PEMBELIAN_TANGGAL)
                    $(".supplier").val(data[0].MASTER_SUPPLIER_ID)
                    $(".jenis_pembelian").val(data[0].PEMBELIAN_JENIS)
                    $(".keterangan").val(data[0].PEMBELIAN_KETERANGAN)
                    $(".quantity").val(data[0].PEMBELIAN_QUANTITY)
                    $(".harga").val(number_format(data[0].PEMBELIAN_HARGA))
                    $(".total").val(number_format(data[0].PEMBELIAN_TOTAL))
                    $(".bayar").val(number_format(data[0].PEMBELIAN_BAYAR))
                    $(".sisa_bayar").val(number_format(data[0].PEMBELIAN_SISA_BAYAR))
                    $(".keterangan").val(data[0].PEMBELIAN_KETERANGAN)

                }


            },
            error: function(x, e) {} //end error
        });
    }

    function kalkulasi_total_bayar() {
        var quantity = $(".quantity").val()
        var harga = $(".harga").val()
        var total = parseInt(quantity) * parseInt(harga)
        $(".total").val(total)

    }
</script>