<div class="modal fade" id="bantuanModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>PT. Golden Island Group <br><small>Divisi Technology Informastion</small></h3>

                        <p>0823 8254 7870</p>
                    </div>
                    <div class="icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Hubungi <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
        <b>Version</b> 1.3.0 |
        Page Rendered<b> {elapsed_time}</b> seconds.
    </div>

    <strong>Copyright &copy; 2021 <a href="https://adminlte.io">Golden Island Group</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->



</body>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('1b15b42882162825307f', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');

    channel.bind('my-event', function(data) {
        $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Golden Island',
            subtitle: 'Notifikasi',
            body: JSON.stringify(data.message)
        })

        if (window.Notification) {
            Notification.requestPermission(function(status) {
                var options = {
                    body: JSON.stringify(data.message),
                    dir: 'ltr',
                    image: '<?= base_url(); ?>/assets/header.png'

                }

                var n = new Notification('Golden Island', options);
            });
        } else {
            console.log('Your browser doesn\'t support notifications.');
        }
    });
</script>

<script>
    // $(function() {
    //     $("#example1").DataTable({
    //         "responsive": true,
    //         "lengthChange": false,
    //         "autoWidth": false,
    //         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    //     $('#example2').DataTable({
    //         "paging": true,
    //         "lengthChange": false,
    //         "searching": false,
    //         "ordering": true,
    //         "info": true,
    //         "autoWidth": false,
    //         "responsive": true,
    //     });
    // });

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

    $(".btn-bantuan").on("click", function() {
        $("#bantuanModal").modal("show")
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
        $('.modal').modal('hide');
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