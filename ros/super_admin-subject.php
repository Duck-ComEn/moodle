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
		case "superadmin" : 
	?>
	<title>Benchmark Garde - SuperAdministrator::รายวิชา (Manual)</title>
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
											ros_menu.`mode` = 'superadmin'
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
				<div align="justify">
				  <h2>รายวิชาที่เพิ่มโดยวิธี Manual</h2>
				  <p>&nbsp;</p>
                  <?php
				  $i=1;
				  $result=mysql_query("select id,code,name,vision from ros_subject");
				  echo"<table id='mytable' cellspacing='0'>";
						echo"<tr><th>No.</th><th>code</th><th width=182>name</th><th>status</th><th>Delete</th></tr>";
						while($data = mysql_fetch_array($result)){
						echo "<tr><td>$i</td><td><form action='update-code-menu.php'><input name=\"id\" type=\"hidden\" value=\"{$data['id']}\"><input type=\"text\" name=code value=\"{$data['code']}\"><input type=\"submit\" value=\"แก้ไข\"></form></td><td><form action='update-subname-menu.php'><input name=\"id\" type=\"hidden\" value=\"{$data['id']}\"><input name=\"name1\" type=\"hidden\" value=\"{$data['name']}\"><input type=\"text\" name='name' value=\"{$data['name']}\"><input type=\"submit\" value=\"แก้ไข\"></form></td><td align=center>";if($data['vision']==1){echo"<a href=\"super_admin-del-vision.php?id={$data['id']}\"><img src=\"images/eye1.png\"/></a>";}else{echo"<a href=\"super_admin-del0-vision.php?id={$data['id']}\"><img src=\"images/eye0.png\"/></a>";} echo"</td><td align=center><a href=\"super_admin-del-subject.php?id={$data['id']}\">Delete</a></td></tr>";
						$i++;
						}
						echo"</table>";
				  echo"</table>";
				  ?>
                  
			  <p>&nbsp;</p>
	  <p>&nbsp;</p>
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
	default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบสูงสุดเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>