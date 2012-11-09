<?php
	require_once('Connections/ros.php'); 
	if(!isset($_SESSION)){
	@session_start();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
		switch($_SESSION['MM_UserRight']){
		case "admin" : 
			if($_GET['id'][0]=='m'){
			$_GET['id']=substr($_GET['id'],1);
			$result=mysql_query("insert into ros_warn_notshow(manual) values(".$_GET['id'].")");
			echo "<meta http-equiv='refresh' content='0;URL=main-warn-7day.php?sel_product=".$_SESSION['$viewbysup']."'>";
			
			}else {
			$result=mysql_query("insert into ros_warn_notshow(atid) values(".$_GET['id'].")");
			echo "<meta http-equiv='refresh' content='0;URL=main-warn-7day.php?sel_product=".$_SESSION['$viewbysup']."'>";
			
			
			}
	
	
	
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>