<?php include 'db_connect.php' ?>
<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    top: 0;
}
.imgs{
		margin: .5em;
		max-width: calc(100%);
		max-height: calc(100%);
	}
	.imgs img{
		max-width: calc(100%);
		max-height: calc(100%);
		cursor: pointer;
	}
	#imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
		height: 60vh !important;background: black;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
	}
	#imagesCarousel img{
		width: auto!important;
		height: auto!important;
		max-height: calc(100%)!important;
		max-width: calc(100%)!important;
	}
</style>
<?php 
$time = $conn->query("SELECT t.*,s.name as sname FROM timesheets t inner join students s on s.id = t.student_id");
$data = array();
while($row=$time->fetch_assoc()){
  $row['time_start'] = date("H:i",strtotime($row['date'].' '.$row['time_start']));
  $row['time_end'] = $row['time_end'] == '00:00:00' ? '' : date("H:i",strtotime($row['date'].' '.$row['time_end']));
  $row['sname'] = ucwords($row['sname']);
  $row['remarks'] = str_replace(array("\n", "\r"), " ", $row['remarks']);
  $data[] = $row;
}
?>
<div class="containe-fluid">
	<div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php echo "Chào mừng ". $_SESSION['login_name']."!"  ?>
                    <hr>
                    <div id="calendar"></div>
                </div>
            </div>      			
        </div>
    </div>
</div>
<script>
var calendarEl = document.getElementById('calendar');
var calendar;
 var data = '<?php echo json_encode($data) ?>';
 var evt = [];
    data = JSON.parse(data)
      if(Object.keys(data).length > 0){
         Object.keys(data).map(k=>{
                var obj = {};
                  if(data[k].timer_status == 1)
                    obj['title']=data[k].sname+" - Started Time of Current Timer";
                  else
                    obj['title']=data[k].sname+' - '+data[k].remarks;
                  obj['start']=data[k].date+'T'+data[k].time_start;
                  if(data[k].time_end != '')
                  obj['end']=data[k].date+'T'+data[k].time_end;
                  evt.push(obj)
         })
      }
 document.addEventListener('DOMContentLoaded', function() {
        calendar = new FullCalendar.Calendar(calendarEl, {
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
          },
          initialView: 'timeGridDay',
          initialDate: '<?php echo date('Y-m-d') ?>',
          weekNumbers: true,
          navLinks: true, // can click day/week names to navigate views
          editable: false,
          selectable: true,
          nowIndicator: true,
          dayMaxEvents: true, // allow "more" link when too many events
          events: evt
        });
        calendar.render();
     

  });
</script>