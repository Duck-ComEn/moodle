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
		case "super" : 
	?>
	<title>Benchmark Garde - Supervisor::ผลการสอบของพนักงานที่มีคะแนน</title>
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
			    <a href="main-super.php" class="left_menu">Home</a><br />
				<a href="main-super-warn.php" class="left_menu">แจ้งเตือนทั้งหมด</a><br />
				<a href="main-super-warn-7day.php" class="left_menu">แจ้งเตือน 7 วัน</a><br />
				<a href="main-super-warn-14day.php" class="left_menu">แจ้งเตือน 14 วัน</a><br />
				<a href="main-super-en.php" class="left_menu">พนักงานในสังกัด</a><br />
				<a href="main-super-en-result.php" class="left_menu">ผลสอบทั้งหมด</a><br />
				<a href="find-result-some.php" class="left_menu">ผลสอบที่มีคะแนน</a><br />
				<a href="logout.php" class="left_menu">ออกจากระบบ</a><br /></div>
			</div>
		</div>
		
		<div class="midarea">
			<div class="head">Welcome <?php print ucfirst($_SESSION['MM_FirstName']).' '.ucfirst($_SESSION['MM_LastName']) ;?></div>
			<div class="body_textarea">
				<div align="justify" style="font-size: 16pt">ผลการสอบของพนักงานที่มีคะแนน</div>
				<div id="mytable">
				<table id="mytable" cellspacing="0">
					<?php
						require_once('Connections/ros.php');
						$result=mysql_query("SELECT DISTINCT
							mdl_user.idnumber,
							mdl_user.firstname,
							mdl_user.lastname
						FROM
							mdl_user
							INNER JOIN mdl_quiz_attempts ON mdl_quiz_attempts.userid = mdl_user.id
						WHERE
							mdl_user.institution = '".$_SESSION['MM_FirstName'].' '.$_SESSION['MM_LastName']."'");
						@$num_rows=mysql_num_rows($result);
						if(!$num_rows){
							echo "<meta http-equiv='refresh' content=0;URL=find-result-some.php>";
						}
						echo"<caption align=\"bottom\">result $num_rows E/N </caption>";
						echo"<tr><th>E/N</th><th>FirstName</th><th>LastName</th></tr>";
						while($data = mysql_fetch_array($result)){
							echo"<tr>";
							print"<td><a href='find-result.php?idnumber=".$data['idnumber']."'>".$data['idnumber']."</a></td><td>{$data['firstname']}</td><td>{$data['lastname']}</td>";
							echo"</tr>";
						}
						echo"</table>";

					?>
				</table>
				</div>
			</div>
		</div>
	</div>
	<?php
	require_once('footer.php'); 
	?>	
	
</html>
<?php
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้หัวหน้า่งานเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>