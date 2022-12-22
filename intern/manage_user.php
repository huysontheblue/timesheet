<?php 
include('../db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM students where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Tên</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required readonly>
		</div>
		<div class="form-group">
			<label for="password">Mật khẩu</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			<?php if(isset($meta['id'])): ?>
			<small><i>Để trống nếu bạn không muốn thay đổi mật khẩu.</i></small>
		<?php endif; ?>
		</div>
		

	</form>
</div>
<script>
	
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'../ajax.php?action=save_student',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Đã lưu dữ liệu thành công",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">Tên người dùng đã tồn tại</div>')
					end_load()
				}
			}
		})
	})

</script>