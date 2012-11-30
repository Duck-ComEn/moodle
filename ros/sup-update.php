<?php
	require_once('Connections/ros.php'); 
	if(!isset($_SESSION)){
	@session_start();
	}
	
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

			$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

			switch ($theType) {
				case "text":
					$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;    
				case "long":
				case "int":
					$theValue = ($theValue != "") ? intval($theValue) : "NULL";
				break;
				case "double":
					$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
				break;
				case "date":
					$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
				case "defined":
					$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				break;
			}
			return $theValue;
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
	<title>Benchmark Garde - SuperAdministrator::อัพเดท Supervisor</title>
	<link rel="shortcut icon" href="BEI_icon.ico" type="image/x-icon" />
	<link rel="icon" href="BEI_icon.ico" type="image/x-icon" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link href="styles_table.css" rel="stylesheet" type="text/css" />
	<SCRIPT Language="JavaScript">

</SCRIPT>
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
				<div align="justify"><h3>Supervisor Up to Date</h3>
				<br><font color="red">  </font>
				  <p>&nbsp;</p>
				  <p><br>
			        <?php
					mysql_query("DELETE FROM ros_user_admin
										 WHERE 
											 ros_user_admin.user_right = 'super'");
					
					
					
					$result=mysql_query("SELECT DISTINCT
												mdl_user.institution
											FROM
												mdl_user
											ORDER BY
												mdl_user.institution ASC");
												
												
											
												
												
												
					
					while($value=mysql_fetch_array($result)){	
						$name = explode(" ",$value[0]);
						$email = $name[0].'.'.$name[1].'@bench.com';
						$username = substr($name[1],0,5).substr($name[0],0,1);
						$insertSQL = sprintf("INSERT INTO ros_user_admin (firstname, lastname, username, password, email, user_right) VALUES (%s, %s, %s, %s, %s, \"super\")",
						GetSQLValueString($name[0], "text"),
						GetSQLValueString($name[1], "text"),
						GetSQLValueString($username, "text"),
						GetSQLValueString(md5('Welcome123'), "text"),
						GetSQLValueString($email, "text"),
						GetSQLValueString("super", "text"));
						//	mysql_select_db($database_ros, $ros);
						mysql_query($insertSQL) or die(mysql_error());
					
					
					
					}
						$result1 = mysql_query("SELECT DISTINCT ros_user_admin.firstname,ros_user_admin.lastname,ros_user_admin.email
										FROM ros_user_admin
										WHERE
											ros_user_admin.user_right = 'super'
										ORDER BY
											ros_user_admin.firstname ASC");
					
					$u=1;
					echo"<table border=1 align=center>";
					echo"<tr><th>No.</th><th>Name</th><th>E-mail</th></tr>";
					while($value=mysql_fetch_array($result1)){
						$fullname  = $value['firstname'].' '.$value['lastname'];
					echo"<tr><td>".$u++."</td><td>{$fullname}</td><td>{$value['email']}</td></tr>";
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
	default : echo"<center><h2>หน้านี้อนุญาติให้หผู้ดูแลระบบสูงสุดเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>