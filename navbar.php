<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		/*background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important*/
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark' >	
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home">
					<span class='icon-field'>
						<i class="fa fa-tachometer-alt "></i>
					</span> Dashboard
				</a>
				<a href="index.php?page=internship_attendance" class="nav-item nav-internship_attendance">
					<span class='icon-field'>
						<i class="fa fa-clipboard-list "></i>
					</span> Danh sách thực tập
				</a>
				<a href="index.php?page=students" class="nav-item nav-students">
					<span class='icon-field'>
						<i class="fa fa-users "></i>
					</span> Sinh viên
				</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<div class="mx-2 text-white">Danh sách chính</div>
				<a href="index.php?page=courses" class="nav-item nav-courses">
					<span class='icon-field'>
						<i class="fa fa-scroll "></i>
					</span> Khóa tham gia
				</a>
				<a href="index.php?page=companies" class="nav-item nav-companies">
					<span class='icon-field'>
						<i class="fa fa-building "></i>
					</span> Công ty
				</a>
				<?php endif; ?>
				<div class="mx-2 text-white">Báo cáo</div>
				<a href="index.php?page=rendered_report" class="nav-item nav-rendered_report">
					<span class='icon-field'>
						<i class="fa fa-th-list"></i>
					</span> Báo cáo thực tập
				</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<div class="mx-2 text-white">Hệ thống</div>
				<a href="index.php?page=users" class="nav-item nav-users">
					<span class='icon-field'>
						<i class="fa fa-users "></i>
					</span>Tài khoản
				</a>
				<a href="index.php?page=site_settings" class="nav-item nav-site_settings">
					<span class='icon-field'>
						<i class="fa fa-cogs"></i>
					</span> Cài đặt hệ thống
				</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
