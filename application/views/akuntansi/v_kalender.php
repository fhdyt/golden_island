<link rel="stylesheet" href="<?php echo base_url(); ?>assets/theme/plugins/fullcalendar/main.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Kalender Jatuh Tempo</h1>
                    <p class="">Hutang Piutang</p>
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
                    <div id="calendar"></div>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="<?php echo base_url(); ?>assets/theme/plugins/fullcalendar/main.js"></script>

<script>
    $(function() {

        memuat()
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()
        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;

        var containerEl = document.getElementById('external-events');
        var checkbox = document.getElementById('drop-remove');
        var calendarEl = document.getElementById('calendar');
        var calendar = new Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'bootstrap',
            //Random default events
            events: [
                <?php foreach ($calender['piutang'] as $row) { ?> {
                        title: 'Piutang : <?= $row->RELASI[0]->MASTER_RELASI_NAMA  ?>',
                        start: '<?= $row->PIUTANG_TANGGAL_TEMPO ?>',
                        backgroundColor: '#007bff', //red
                        borderColor: '#007bff', //red
                        allDay: true
                    },
                <?php } ?>
                <?php foreach ($calender['hutang'] as $row) { ?> {
                        title: 'Hutang : <?= $row->SUPPLIER[0]->MASTER_SUPPLIER_NAMA  ?>',
                        start: '<?= $row->HUTANG_TANGGAL_TEMPO ?>',
                        backgroundColor: '#dc3545', //red
                        borderColor: '#dc3545', //red
                        allDay: true
                    },
                <?php } ?>

            ],
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function(info) {
                // is the "remove after drop" checkbox checked?
                if (checkbox.checked) {
                    // if so, remove the element from the "Draggable Events" list
                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                }
            }
        });

        calendar.render();
        // $('#calendar').fullCalendar()
    })
</script>