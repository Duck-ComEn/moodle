<?php require_once('Connections/ros.php'); ?>
<?php
if(!isset($_SESSION)){
session_start();
}
switch($_SESSION['MM_UserRight']){
case "superadmin" : 

	$queryLogin = "delete from ros_user_admin where username='".$_GET['user']."'"; 
	$rcsLogin = mysql_query($queryLogin);
		echo "<meta http-equiv='refresh' content='0;URL=super_admin-edit.php'>";
	

break ;
default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบเข้าใช้เท่านั้น</h2></center><bt><br>";
echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
echo "<meta http-equiv='refresh' content=3;URL=index.php>";
break ; }
?>