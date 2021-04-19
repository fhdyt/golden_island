<div class="modal fade" id="uploadModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="submit">
                    <div class="row">
                        <div class="col-md-10 mb-2">
                            <input type="hidden" class="form-control nama_input">
                            <input type="file" name="userfile" class="form-control" accept="image/png, image/jpeg, image/jpg">
                        </div>
                        <div class="col-md-2 mb-2">
                            <button type="submit" class="btn btn-primary btn-block upload_gambar">Upload</button>
                        </div>
                        <div class="col-md-12">
                            <ul>
                                <li>Format Gambar .jpg, .jpeg, dan .png</li>
                                <li>Maksimal ukuran 700kb</li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.modal-content -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2021 <a href="https://adminlte.io">Golden Island Group</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->



</body>
<script>
    $(".btn_upload").on("click", function() {
        $(".nama_input").val($(this).attr("nama_input"))
        $("#uploadModal").modal("show")
    })

    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })

    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    $('#submitUpload').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/upload/simpan',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function(data) {
                Swal.fire({
                    title: 'Berhasil',
                    icon: 'success',
                })
                console.log(data)
            }
        });
    })

    function memuat() {
        $('div#loader-wrapper').fadeToggle()
    }

    function ganti_bahasa(lang) {
        $.ajax({
            type: 'ajax',
            url: '<?php echo base_url() ?>index.php/sistem/user/ganti_bahasa/<?= $this->session->userdata('USER_ID') ?>?lang=' + lang,
            dataType: 'json',
            beforeSend: function() {
                memuat()
            },
            success: function(data) {
                location.reload(true);
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
</script>

</html>