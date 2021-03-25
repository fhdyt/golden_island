<!-- Content Wrapper. Contains page content -->
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
      <div class="card card-default color-palette-box">
        <div class="card-body">
          <div class="row mb-4">
            <div class="col-md-12" style="display: flex; align-items: center; justify-content: center;">
              <img src="<?php echo base_url(); ?>assets/header.png" height="200px">
            </div>
          </div>

        </div>
        <!-- /.card-body -->
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  function copyToClipboard(elem) {
    var $temp = $("<input>");
    //alert("Copied");
    $("body").append($temp);
    $temp.val(elem).select();
    document.execCommand("copy");
    $temp.remove();
  }

  $(".copy").on("click", function() {
    var elem = $(".link_undangan").val()
    Swal.fire('Berhasil', 'Link berhasil disalin', 'success')
    copyToClipboard(elem)
  })
</script>

<script type="text/javascript">
  var qrcode = new QRCode(document.getElementById("qrcode"), {
    width: 200,
    height: 200,
    colorDark: "#000000",
    colorLight: "#ffffff",
  });

  function makeCode() {
    var elText = document.getElementById("link_undangan");

    if (!elText.value) {
      alert("Input a text");
      elText.focus();
      return;
    }

    qrcode.makeCode(elText.value);
  }

  makeCode();

  $("#link_undangan").
  on("blur", function() {
    makeCode();
  }).
  on("keydown", function(e) {
    if (e.keyCode == 13) {
      makeCode();
    }
  });
</script>