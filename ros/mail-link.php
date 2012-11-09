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
	$i=0;
			$result=mysql_query("SELECT
									ros_mail.link,
									ros_mail.sup
								FROM
									ros_mail");
			$mail=mysql_fetch_array($result);
			while($data=mysql_fetch_array($result)){
			if(substr($data[link],17)==$_GET['id']){
			$_SESSION['MM_UserRight']='super';
			echo "<meta http-equiv='refresh' content=0;URL=super-xls-all.php?sup=.php>";
			}
			}


	//echo "<meta http-equiv='refresh' content='0;URL=main-super-warn-7day.php'>";
	
?>