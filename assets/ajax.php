<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'update_account'){
	$save = $crud->update_account();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_course"){
	$save = $crud->save_course();
	if($save)
		echo $save;
}
if($action == "delete_course"){
	$delete = $crud->delete_course();
	if($delete)
		echo $delete;
}
if($action == "save_company"){
	$save = $crud->save_company();
	if($save)
		echo $save;
}
if($action == "delete_company"){
	$delete = $crud->delete_company();
	if($delete)
		echo $delete;
}
if($action == "save_student"){
	$save = $crud->save_student();
	if($save)
		echo $save;
}
if($action == "delete_student"){
	$delete = $crud->delete_student();
	if($delete)
		echo $delete;
}

if($action == "save_manager"){
	$save = $crud->save_manager();
	if($save)
		echo $save;
}
if($action == "delete_manager"){
	$delete = $crud->delete_manager();
	if($delete)
		echo $delete;
}
if($action == "start_time"){
	$save = $crud->start_time();
	if($save)
		echo $save;
}
if($action == "save_end"){
	$save = $crud->save_end();
	if($save)
		echo $save;
}
ob_end_flush();
?>
