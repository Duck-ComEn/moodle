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
	?>
	<title>Benchmark Garde - Administrator::จัดการเมนู</title>
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
				<div align="justify">
				  <h2>จัดการเมนู</h2>
				  <p>&nbsp;</p>
				  <form id="form1" name="form1" method="POST" action="add-menu.php">
				    เพิ่มเมนู 
				    <label>
				    <select name="level" id="level">
				      <option value="admin">admin</option>
				      <option value="super">supervisor</option>
				      <option value="en">employee</option>
			        </select>
				    </label>
                                    <label>
                                    <input type="submit" name="add" id="add" value="add" />
                                    </label>
				  </form>
				  <p>&nbsp;</p>
	  <p><?php
				//import menu from database
					$result=mysql_query("SELECT
											ros_menu.`name`,
											ros_menu.link,
											ros_menu.`mode`,
											ros_menu.`sort`,
											ros_menu.`id`
										FROM
											ros_menu
										ORDER BY
											ros_menu.`mode` ASC,
											ros_menu.sort ASC");
											
						@$num_rows=mysql_num_rows($result);
						if(!$num_rows){
							echo "Can not connect Database";
						}
						echo"<table id='mytable' cellspacing='0'>";
						echo"<tr><th>Name</th><th>Link</th><th>Level</th><th>Sort</th><th>Del</th></tr>";
						while($data = mysql_fetch_array($result)){
						echo "<tr><td><form action='update-name-menu.php'><input name=\"id\" type=\"hidden\" value=\"{$data['id']}\"><input type=\"text\" name=name value=\"{$data['name']}\"><input type=\"submit\" value=\"แก้ไข\"></form></td><td><form action='update-link-menu.php'><input name=\"id\" type=\"hidden\" value=\"{$data['id']}\"><input type=\"text\" name='link' value=\"{$data['link']}\"><input type=\"submit\" value=\"แก้ไข\"></form></td><td>{$data['mode']}</td><td><form action='sort-menu.php'><input name=\"id\" type=\"hidden\" value=\"{$data['id']}\"><input type=\"text\" name=sort size='1' value=\"{$data['sort']}\"><input type=\"submit\" value=\"แก้ไข\"></form></td><td><a href=\"del-menu.php?id={$data['id']}\">Del</a></td></tr>";
						}
						echo"</table>";
						?>
                        </p>
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