<?php
	require_once('Connections/ros.php'); 
		
		if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
				
		mysql_query("UPDATE mdl_user SET mdl_user.institution = '".$_POST['newsup']."'
						WHERE mdl_user.idnumber = '".$_POST['idnumber']."'") or die(mysql_error());
		
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
  	  		echo "<script language='javascript'>alert('แก้ไขเสร็จเรียบร้อยแล้ว');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=edit-sup.php'>";
		
		
		}
?>