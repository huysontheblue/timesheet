<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
// if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
// }
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo $_SESSION['system']['name'] ?></title>
<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    position: fixed;
	    top:0;
	    left: 0
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		display: flex;
	}

</style>

<body class="bg-dark">
  	<main id="main" >
  		<div class="align-self-center w-100">
			<h4 class="text-white text-center"><b> Hệ thống chấm công thực tập</b></h4>
			<div id="login-center" class="bg-dark row justify-content-center">
				<div class="card col-md-4">
					<div class="card-body">
						<form id="login-form" >
							<div class="form-group">
								<label for="username" class="control-label">Tài khoản</label>
								<input type="text" id="username" name="username" class="form-control">
							</div>
							<div class="form-group">
								<label for="password" class="control-label">Mật khẩu</label>
								<input type="password" id="password" name="password" class="form-control">
							</div>
							<div class="form-group">
								<label for="password" class="control-label">Loại người dùng</label>
								<select name="type" id="" class="custom-select">
									<option value="1">Admin</option>
									<option value="2">Sinh viên</option>
								</select>
							</div>
							<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Đăng nhập</button></center>
						</form>
					</div>
				</div>
			</div>
  		</div>
  	</main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Đăng nhập...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Đăng nhập');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Tên đăng nhập hoặc tài khoản của bạn không chính xác.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Đăng nhâp');
				}
			}
		})
	})
	$('.number').on('input',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9 \,]/, '');
        $(this).val(val)
    })
</script>	
</html>