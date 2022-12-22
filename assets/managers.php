<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Manager List</b>
						<span class="float:right"><a class="btn btn-primary btn-sm col-sm-3 float-right" href="javascript:void(0)" id="new_manager">
			                    <i class="fa fa-plus"></i> New 
			                </a></span>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Company</th>
									<th class="text-center">Name</th>
									<th class="text-center">Details</th>
									<th class="text-center">Action</th>
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
								$manager = $conn->query("SELECT * FROM managers order by id asc");
								while($row=$manager->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><b><?php echo ucwords($cname[$row['company_id']]) ?></b></p>
									</td>
									<td class="">
										<p><b><?php echo $row['name'] ?></b></p>
									</td>
									<td class="">
										<p>Contact #: <b><?php echo $row['contact'] ?></b></p>
										<p><small>Email: <b><?php echo $row['email'] ?></b></small></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_manager" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
										<button class="btn btn-sm btn-danger delete_manager" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
	td p {
		margin:unset;
	}
	.custom-switch{
		cursor: pointer;
	}
	.custom-switch *{
		cursor: pointer;
	}
</style>
<script>
	$('#new_manager').click(function(){
		uni_modal("New Manager","manage_manager.php","mid-large")
	})
	$('.edit_manager').click(function(){
		uni_modal("Manage Manager Data","manage_manager.php?id="+$(this).attr('data-id'),"mid-large")
	})
	$('#manage-manager').on('reset',function(){
		$('input:hidden').val('')
		$('.select2').val('').trigger('change')
	})
	
	$('#manage-manager').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_manager',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.delete_manager').click(function(){
		_conf("Are you sure to delete this manager?","delete_manager",[$(this).attr('data-id')])
	})
	function delete_manager($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_manager',
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
	$('table').dataTable()
</script>