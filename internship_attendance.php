<?php include('db_connect.php');?>
<style>
	input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.3); /* IE */
  -moz-transform: scale(1.3); /* FF */
  -webkit-transform: scale(1.3); /* Safari and Chrome */
  -o-transform: scale(1.3); /* Opera */
  transform: scale(1.3);
  padding: 10px;
  cursor:pointer;
}
</style>
<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Danh sách list học sinh</b>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Ngày tháng</th>
									<th class="">Thông tin sinh viên.</th>
									<th class="">Công ty</th>
									<th class="">Thời gian</th>
									<th class="">Khoảng thời gian</th>
									<th class="">Nhận xét</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$cname[0] = "Not Set";
								$companies = $conn->query("SELECT * FROM companies ");
								while($row = $companies->fetch_assoc()){
									$cname[$row['id']] = ucwords($row['name']);
								}
								$order = $conn->query("SELECT t.*,s.name as sname,s.id_no,s.company_id,c.course FROM timesheets t inner join students s on s.id = t.student_id inner join courses c on c.id = s.course_id order by abs(t.id) desc");
								while($row=$order->fetch_assoc()):
									$rendered = 0;
									if($row['timer_status'] == 0){
									    $dif = strtotime($row['date'].' '.$row['time_end']) - strtotime($row['date'].' '.$row['time_start']);
									    $rendered += abs($dif/(60*60));
								  	}
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<p> <b><?php echo date("M d,Y",strtotime($row['date'])) ?></b></p>
									</td>
									<td>
										<p class="">ID: <b><?php echo $row['id_no'] ?></b></p>
										<p class="">Tên: <b><?php echo ucwords($row['sname']) ?></b></p>
										<p class="">Khóa: <b><?php echo ucwords($row['course']) ?></b></p>
									</td>
									<td>
										<p class=""> <b><?php echo $cname[$row['company_id']] ?></b></p>
									</td>
									<td>
										<p> <b><?php echo date("h:i A",strtotime($row['date'].' '.$row['time_start'])).' - '.date("h:i A",strtotime($row['date'].' '.$row['time_end'])) ?></b></p>
									</td>
									<td>
										<p class="text-right"> <b><?php echo number_format($rendered,2) ?> hr/s.</b></p>
									</td>
									<td class="text-center">
										<small><i><b><?php echo $row['remarks'] ?></b></i></small>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	$('#new_order').click(function(){
		uni_modal("New order ","manage_order.php","mid-large")
		
	})
	$('.view_order').click(function(){
		uni_modal("Order  Details","view_order.php?id="+$(this).attr('data-id'),"mid-large")
		
	})
	$('.delete_order').click(function(){
		_conf("Are you sure to delete this order ?","delete_order",[$(this).attr('data-id')])
	})
	function delete_order($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_order',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>