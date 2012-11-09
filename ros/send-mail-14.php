<?php
	require_once('Connections/file.php'); 
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

			$i=0;
			$p=0;
			$r=0;
			list($firstname, $lastname) = split(' ', $_GET['mail']);
			if($_GET['mail']=='' || $_GET['mail']=='All'){
			$result=mysql_query("SELECT
										ros_user_admin.firstname,
										ros_user_admin.lastname,
										ros_user_admin.email
								FROM
										ros_user_admin
								WHERE
										ros_user_admin.user_right = 'super'");
			while($value=mysql_fetch_array($result)){
			$array_mail[$i++]=$value['email'];
			$array_name[$p++]=$value['firstname'].' '.$value['lastname'];
			$gen=getdate();
			$enscri='mail-link-14.php?id='.md5($gen[0].'BenchMark Electronic.'.$i);
			$result1=mysql_query("insert into ros_mail(link,sup,time) values('".$enscri."','".$value['firstname'].' '.$value['lastname']."',".$gen[0].")");
			$enscri1[$r++]='mail-link-14.php?id='.md5($gen[0].'BenchMark Electronic.'.$i);
			}
			
			
			
			$n=0;
			$m=0;
			$t=0;
			$mm=0;
			$nn=0;
			$numrows=mysql_num_rows($result);
			while($n<$numrows){
			$to = $array_mail[$n++];
			$subject = 'Auto mail Alert Certificate from Traning';
			$message = "<img src=".$ipserver_path."images/search_strip.jpg><h3>เรียน คุณ ".ucwords($array_name[$m++])."</h3><br>".$messagefile.'<br>';
			$message.="<br><a href=".$ipserver_path.$enscri1[$t++]."><img src=".$ipserver_path."images/Excel2007Logo.png height=50 width=50></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=".$ipserver_path."><img src=".$ipserver_path."images/registration.png height=50 width=50></a>";
			$header = "From: ".$mailsender."\r\n";
			$header .="MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html; charset=UTF-8\r\n" ;
 
			if( @mail( $to , $subject , $message , $header ) ){
				echo "Mail Complete to ".ucwords($array_name[$mm++])."<br>";
				echo "<meta http-equiv='refresh' content=3;URL=main-warn-14day.php>";
			}else{
				echo "Mail Incomplete to ".ucwords($array_name[$mm++])."<br>";
				echo "<meta http-equiv='refresh' content=3;URL=main-warn-14day.php>";
			}
			}
			
			
			}
			else{
			$result=mysql_query("SELECT DISTINCT
										ros_user_admin.firstname,
										ros_user_admin.lastname,
										ros_user_admin.email
								FROM
										ros_user_admin
								WHERE
										ros_user_admin.firstname = '".$firstname."' AND
										ros_user_admin.lastname ='".$lastname."'");
			
										
			$mail=mysql_fetch_array($result);
			$gen=getdate();
			$enscri='mail-link-14.php?id='.md5($gen[0].'BenchMark Electronic.');
			//echo $enscri;
			$result1=mysql_query("insert into ros_mail(link,sup,time) values('".$enscri."','".$firstname.' '.$lastname."',".$gen[0].")");
$to = $mail['email'];
$subject = 'Auto Mail Alert Certificate from Traning';
$message = "<img src=".$ipserver_path."images/search_strip.jpg><h3>เรียน คุณ ".ucfirst($firstname).' '.ucfirst($lastname)."</h3><br>".$messagefile.'<br>';
$message.="<br><a href=".$ipserver_path.$enscri."><img src=".$ipserver_path."images/Excel2007Logo.png height=50 width=50></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=".$ipserver_path."><img src=".$ipserver_path."images/registration.png height=50 width=50></a>";
$header = "From: ".$mailsender."\r\n";
$header .="MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html; charset=UTF-8\r\n" ;
 
			if( @mail( $to , $subject , $message , $header ) ){
				echo "Mail Complete to ".ucwords($_GET['mail'])."<br>";
				echo "<meta http-equiv='refresh' content=3;URL=main-warn-14day.php?sel_product=".$firstname."+".$lastname.">";
			}else{
				echo "Mail Incomplete to ".ucwords($_GET['mail'])."<br>";
				echo "<meta http-equiv='refresh' content=3;URL=main-warn-14day.php?sel_product=".$firstname."+".$lastname.">";
			}
			}
			
			//echo $mail['email'];
			//echo $mail['email'].'55555555';
			//echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			//echo "<script language='javascript'>alert('ส่ง E-mail ถึง supervisor เรียบร้อยแล้ว');</script>";
			//echo "<meta http-equiv='refresh' content='0;URL=mail.php'>";
	
	

?>
<?php
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>