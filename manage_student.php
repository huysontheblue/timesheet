<?php include "db_connect.php" ?>
<?php 
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM students where id = ".$_GET['id']);
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-student">
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-6 border-right">
					<b class="text-muted">Thông tin sinh viên</b>
					<div class="form-group">
						<label class="label control-label">Mã số sinh viên</label>
						<input type="text" class="form-control form-control-sm w-100" name="id_no" required="" value="<?php echo isset($id_no) ? $id_no : '' ?>">
					</div>
					<div class="form-group">
						<label class="label control-label">Tên</label>
						<input type="text" class="form-control form-control-sm w-100" name="name" required="" value="<?php echo isset($name) ? $name : '' ?>">
					</div>
					<div class="form-group">
						<label class="label control-label">Liên hệ</label>
						<input type="text" class="form-control form-control-sm w-100" name="contact" required="" value="<?php echo isset($contact) ? $contact : '' ?>">
					</div>
					<div class="form-group">
						<label class="label control-label">Địa chỉ</label>
						<textarea name="address" id="" cols="30" rows="3" class="form-control" required=""><?php echo isset($address) ? $address : '' ?></textarea>
					</div>
					<div class="form-group">
						<label class="label control-label">Khóa thực tập</label>
						<select name="course_id" id="" class="custom-select custom-select-sm select2" required>
							<option value=""></option>
							<?php
							$courses = $conn->query("SELECT * FROM courses order by course asc");
							while($row= $courses->fetch_assoc()):
							?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($course_id) && $course_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['course']) ?></option>
						<?php endwhile; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<b class="text-muted">Chi tiết thực tập</b>
					<div class="form-group">
						<label class="label control-label">Công ty</label>
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
					<div class="form-group">
						<label class="label control-label">Thời lượng yêu cầu(giờ)</label>
						<input type="text" class="form-control form-control-sm w-100" name="required_duration" value="<?php echo isset($required_duration) ? $required_duration : '' ?>">
					</div>
					<b class="text-muted">Thông tin đăng nhập hệ thống</b>
					<div class="form-group">
						<label class="label control-label">Mật khẩu</label>
						<input type="password" class="form-control form-control-sm w-100" name="password" <?php echo isset($id) ? 'required' : '' ?>>
						<?php if(isset($id)): ?>
						<small>Để trống nếu bạn không muốn thay đổi mật khẩu</small>
						<?php endif; ?>
					</div>
					<div class="form-group">
						<label class="label control-label">Xác nhận mật khẩu</label>
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
				$('#pass_match').attr('data-status','1').html('<i class="text-success">Mật khẩu phù hợp.</i>')
			}else{
				$('#pass_match').attr('data-status','2').html('<i class="text-danger">Mật khẩu không hợp lệ.</i>')
			}
		}
	})
	$('#manage-student').submit(function(e){
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
			url:'ajax.php?action=save_student',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast('Lưu thành công',"success");
					setTimeout(function(){
						location.reload()
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Mã sinh viên đã tồn tại.</div>");
					$('[name="id_no"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>