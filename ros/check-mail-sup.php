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
		case "admin" || "superadmin" : 
	?>
	<title>Benchmark Garde - Administrator::CheckMail เป็น Sup</title>
	<link rel="shortcut icon" href="BEI_icon.ico" type="image/x-icon" />
	<link rel="icon" href="BEI_icon.ico" type="image/x-icon" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link href="styles_table.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="topheader">
	<div class="logo"></div>
	</div>
	<div id="search_strip"></div>
	
	<div id="body_area">
		<div class="left">
			<div class="left_menutop"></div>
			<div class="left_menu_area">
			<div align="right">
				<?php
				//import menu from database
					$result=mysql_query("SELECT
											ros_menu.`name`,
											ros_menu.link
										FROM
											ros_menu
										WHERE
											ros_menu.`mode` = 'admin'
										ORDER BY
											ros_menu.sort ASC");
						@$num_rows=mysql_num_rows($result);
						if(!$num_rows){
							echo "Can not connect Database";
						}
						while($data = mysql_fetch_array($result)){
						?>
						<a href="<?php echo $data['link'] ;?>" class="left_menu"><?php echo $data['name']; ?></a><br />
						<?php
						}
						
						?>
						</div>
			</div>
		</div>
		
		<div class="midarea">
			<div class="head">Welcome <?php echo ucfirst($_SESSION['MM_FirstName']).' '.ucfirst($_SESSION['MM_LastName']) ;?></div>
			<div class="body_textarea">
				<div align="justify"><h3>รายละเอียดการอ่าน mail ของ Supervisor : <?php echo ucwords($_GET['sup'])?></h3><br>
<?php
$result=mysql_query("SELECT
							ros_mail.id,
							ros_mail.link,
							ros_mail.sup,
							ros_mail.time,
							ros_mail.`status`,
							ros_mail.remark
					FROM
							ros_mail
					WHERE
							ros_mail.sup = '".$_GET['sup']."'
					ORDER BY
							ros_mail.remark DESC");
echo"<table>";
list($firstname, $lastname) = split(' ', $_GET['sup']);
$c=1;
echo"<tr><th>ลำดับ</th><th>เวลาที่ส่ง</th><th>จำนวนครั้งที่อ่าน</th><th>เวลาที่อ่านล่าสุด</th><th>Del</th></tr>";
while($data=mysql_fetch_array($result)){
$stime=getdate($data['time']);
$sent_time=$stime['mon'].'/'.$stime['mday'].'/'.$stime['year'].' '.$stime['hours'].':'.$stime['minutes'].':'.$stime['seconds'];
$rtime=getdate($data['remark']);
if($data['remark']==0){
$rev_time='-';
}else{
$rev_time=$rtime['mon'].'/'.$rtime['mday'].'/'.$rtime['year'].' '.$rtime['hours'].':'.$rtime['minutes'].':'.$rtime['seconds'];
}
echo"<tr><td>".$c++."</td><td>".$sent_time."</td><td align=center>";if($data['status']==0){echo"-";}else{echo $data['status'];}echo"</td><td>".$rev_time."</td><td><a href=del-mail.php?id=".$data['id']."&sup=".$firstname.'+'.$lastname.">Del</a></td></tr>";
}
echo"</table>";


?>				
				
				
				</div>
			</div>
		</div>
	</div>
	<?php
	require_once('footer.php'); 
	?>
	
</body>	
</html>
<?php
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>