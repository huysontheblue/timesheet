<?php include "db_connect.php" ?>
<?php 
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM managers where id = ".$_GET['id']);
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-manager">
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-6 border-right">
					<b class="text-muted">Manager Informations</b>
					<div class="form-group">
						<label class="label control-label">Name</label>
						<input type="text" class="form-control form-control-sm w-100" name="name" required="" value="<?php echo isset($name) ? $name : '' ?>">
					</div>
					<div class="form-group">
						<label class="label control-label">Contact</label>
						<input type="text" class="form-control form-control-sm w-100" name="contact" required="" value="<?php echo isset($contact) ? $contact : '' ?>">
					</div>
					<div class="form-group">
						<label class="label control-label">Company</label>
						<select name="company_id" id="" class="custom-select custom-select-sm select2" required>
							<option value=""></option>
							<?php
							$companies = $conn->query("SELECT * FROM companies order by name asc");
							while($row= $companies->fetch_assoc()):
							?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($company_id) && $company_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
						<?php endwhile; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<b class="text-muted">System Credential</b>
					<div class="form-group">
						<label class="label control-label">Email</label>
						<input type="email" class="form-control form-control-sm w-100" name="email" required="" value="<?php echo isset($email) ? $email : '' ?>">
					</div>
					<div class="form-group">
						<label class="label control-label">Password</label>
						<input type="password" class="form-control form-control-sm w-100" name="password" <?php echo isset($id) ? 'required' : '' ?>>
						<?php if(isset($id)): ?>
						<small>Leave this blank if you don't want to change the password</small>
						<?php endif; ?>
					</div>
					<div class="form-group">
						<label class="label control-label">Confirm Password</label>
						<input type="password" class="form-control form-control-sm w-100" name="cpass" <?php echo isset($id) ? 'required' : '' ?>>
						<small id="pass_match" data-status=''></small>
					</div>
					<div id="msg" class="form-group"></div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	$('[name="password"],[name="cpass"]').keyup(function(){
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cpass"]').val()
		if(cpass == '' ||pass == ''){
			$('#pass_match').attr('data-status','')
		}else{
			if(cpass == pass){
				$('#pass_match').attr('data-status','1').html('<i class="text-success">Password Matched.</i>')
			}else{
				$('#pass_match').attr('data-status','2').html('<i class="text-danger">Password does not match.</i>')
			}
		}
	})
	$('#manage-manager').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		if($('#pass_match').attr('data-status') != 1){
			if($("[name='password']").val() !=''){
				$('[name="password"],[name="cpass"]').addClass("border-danger")
				end_load()
				return false;
			}
		}
		$.ajax({
			url:'ajax.php?action=save_manager',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.reload()
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>ID Number already exist.</div>");
					$('[name="id_no"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>