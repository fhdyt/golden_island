<!-- Content Wrapper. Contains page content -->
<style>
  .bg-info {
    background-color: #343A40 !important;
  }
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-info">
              <h3 class="widget-user-username"><?= $this->session->userdata('USER_NAMA') ?> (<?= $this->session->userdata('USER_USERNAME') ?>)</h3>
              <h5 class="widget-user-desc"><?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?></h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle elevation-2" src="<?php echo base_url(); ?>assets/img/user.jpg" alt="User Avatar">
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <!-- <h5 class="description-header"><?= $this->lang->line('dashboard'); ?></h5> -->
                    <span class="description-text"></span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header"></h5>
                    <span class="description-text"></span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header"></h5>
                    <span class="description-text"></span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>

        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Catatan <b><?= detail_perusahaan()[0]->PERUSAHAAN_NAMA; ?></b></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="submit">
              <div class="card-body">
                <div class="form-group">
                  <textarea name="catatan" class="form-control" rows="3" placeholder="Tambah Catatan Perusahaan" required></textarea>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
              </div>
              <div class="card-footer card-comments list_catatan">
                <p>Loading ...</p>
              </div>
            </form>
          </div>
        </div>
        <!-- <div class="col-md-12">
          <div class="card card-default color-palette-box">
            <div class="card-body">
              <div class="row mb-4">
                <div class="col-md-12" style="display: flex; align-items: center; justify-content: center;">
                  <img src="<?php echo base_url(); ?>assets/header.png" height="200px">
                </div>
              </div>

            </div>
          </div>
        </div> -->
      </div>

    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(function() {
    list()
  })

  function list() {
    $.ajax({
      type: 'POST',
      url: "<?php echo base_url() ?>index.php/dashboard/list_catatan",
      async: false,
      dataType: 'json',
      success: function(data) {
        $(".list_catatan").empty();
        memuat()
        console.log(data)
        var no = 1
        for (i = 0; i < data.length; i++) {

          if (data[i].ENTRI_USER == "<?= $this->session->userdata('USER_ID') ?>") {
            var hapus = "<a class='ml-2' onclick='hapus(\"" + data[i].CATATAN_ID + "\")'><i class='fas fa-trash'></i></a>"
          } else {
            var hapus = ""
          }
          $(".list_catatan").append("<div class='card-comment'>" +
            " <img class='img-circle img-sm' src='<?php echo base_url(); ?>assets/img/user.jpg' alt='User Image'>" +
            "<div class='comment-text'>" +
            "<span class='username'>" +
            data[i].USER[0].USER_NAMA +
            hapus +
            " <span class='text-muted float-right'>" + data[i].TANGGAL + "</span>" +
            " </span>" +
            data[i].CATATAN + "</div>" +
            " </div>")
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
      url: '<?php echo base_url(); ?>index.php/dashboard/add',
      type: "post",
      data: new FormData(this),
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function() {
        memuat()
      },
      success: function(data) {
        list();
        Swal.fire('Berhasil', 'Catatan berhasil ditambahkan', 'success')
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
          url: '<?php echo base_url() ?>index.php/dashboard/hapus/' + id,
          beforeSend: function() {
            memuat()
          },
          dataType: 'json',
          success: function(data) {
            if (data.length === 0) {} else {
              list();
              Swal.fire('Berhasil', 'Catatan Berhasil dihapus', 'success')
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
</script>