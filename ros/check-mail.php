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
	<title>Benchmark Garde - SuperAdministrator::CheckMail</title>
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
				<div align="justify"><h3>ตรวจสอบการอ่านเมล์ของ Supervisor (จะแสดงรายชื่อเฉพาะที่ส่งเมล์ไปแล้ว)</h3><br>
<?php
$result1=mysql_query("SELECT 
												ros_mail.sup,
												ros_mail.link,
												ros_mail.id,
												ros_mail.time,
												ros_mail.`status`,
												ros_mail.remark
										FROM
												ros_mail
										GROUP BY
												ros_mail.sup");
echo"<br><br><table>";
echo"<tr><th>Name</th></tr>";
while($list=mysql_fetch_array($result1)){
$day=getdate($list['time']);

echo"<tr><td><a href='check-mail-sup.php?sup={$list['sup']}'>".ucwords($list['sup'])."</a></td></tr>";
}
$numrows=mysql_num_rows($result1);
if(!$numrows){
echo "<h3>No data</h3>";
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