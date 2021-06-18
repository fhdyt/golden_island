<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Log Login</h1>
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
                                <th>No.</th>
                                <th>Waktu</th>
                                <th><?= $this->lang->line('nama'); ?></th>
                                <th>OS</th>
                                <th>Platform</th>
                                <th>IP</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody id="zone_data">
                            <tr>
                                <td>
                                </td>
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
    $(".btn_satuan").on("click", function() {
        $("#submit").trigger("reset");
        $(".id").val("")
        $("#satuanModal").modal("show")
    })
    $(function() {
        satuan_list();
    });

    function satuan_list() {
        $.ajax({
            type: 'ajax',
            url: "<?php echo base_url() ?>index.php/sistem/log_login/list",
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
                    for (i = 0; i < data.length; i++) {
                        $("tbody#zone_data").append("<tr class=''>" +
                            "<td>" + no++ + ".</td>" +
                            "<td>" + data[i].LOGIN_LOG_WAKTU + "</td>" +
                            "<td>" + data[i].USER_NAMA[0].USER_NAMA + "</td>" +
                            "<td>" + data[i].LOGIN_LOG_PLATFORM + "</td>" +
                            "<td>" + data[i].LOGIN_LOG_BROWSER + "</td>" +
                            "<td>" + data[i].LOGIN_LOG_IP + "</td>" +
                            "<td>" + data[i].LOGIN_LOG_ALAMAT + "</td>" +
                            "</tr>");
                    }
                }
            },
            error: function(x, e) {
                console.log("Gagal")
            }
        });
    }
</script>