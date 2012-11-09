<?php 
	require_once('Connections/ros.php'); 
	if(!isset($_SESSION)){
	@session_start();
	}
?>
<?php
	if (!function_exists("GetSQLValueString")) {
		function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
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
	}
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
		$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		$insertSQL = sprintf("INSERT INTO ros_user_admin (firstname, lastname, username, password, email, user_right) VALUES (%s, %s, %s, %s, %s, \"admin\")",
			GetSQLValueString($_POST['name'], "text"),
			GetSQLValueString($_POST['lastname'], "text"),
			GetSQLValueString($_POST['username'], "text"),
			GetSQLValueString(md5($_POST['pass']), "text"),
			GetSQLValueString($_POST['email'], "text"),
			GetSQLValueString($_POST['user_right'], "text"));
	//	mysql_select_db($database_ros, $ros);
		$Result1 = mysql_query($insertSQL) or die(mysql_error());
		$insertGoTo = "super_admin-add-a.php";
		if (isset($_SERVER['QUERY_STRING'])) {
			$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
			$insertGoTo .= $_SERVER['QUERY_STRING'];
		}
		@header(sprintf("Location: %s", $insertGoTo));
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
	<title>Benchmark Garde - SuperAdministrator::เพิ่ม Admin</title>
	<link rel="shortcut icon" href="BEI_icon.ico" type="image/x-icon" />
	<link rel="icon" href="BEI_icon.ico" type="image/x-icon" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	<!-- <link href="styles_table.css" rel="stylesheet" type="text/css" /> -->
	<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
	<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
	<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
				<div align="justify" style="font-size: 16pt">เพิ่ม Administrator</div><br>
				<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
				<table id="rounded-corner" width="495" border="0">
					<tr>
						<td colspan="2"><div align="right"><span class="style1">ช่องที่มี * ต้องกรอกข้อมูล</span></div></td>
					</tr>
					<tr>
						<td width="162"><div align="right">* FirstName :</div></td>
						<td width="323"><span id="sprytextfield1">
						<label>
							<input type="text" name="name" id="name" />
						</label>
						<span class="textfieldRequiredMsg"> จำเป็นต้องกรอกข้อมูล </span></span></td>
					</tr>
					<tr>
						<td><div align="right">* LastName :</div></td>
						<td><span id="sprytextfield2">
						<label>
							<input type="text" name="lastname" id="lastname" />
						</label>
						<span class="textfieldRequiredMsg"> จำเป็นต้องกรอกข้อมูล </span></span></td>
					</tr>
					<tr>
						<td><div align="right">* Username :</div></td>
						<td><span id="sprytextfield3">
						<label>
							<input type="text" name="username" id="username" />
						</label>
						<span class="textfieldRequiredMsg"> จำเป็นต้องกรอกข้อมูล </span></span></td>
					</tr>
					<tr>
						<td><div align="right">* Password :</div></td>
						<td><span id="sprytextfield4">
						<label>
							<input type="password" name="pass" id="pass" />
						</label>
						<span class="textfieldRequiredMsg"> จำเป็นต้องกรอกข้อมูล </span></span></td>
					</tr>
					<tr>
						<td><div align="right">* E-mail :</div></td>
						<td><span id="sprytextfield6">
						<label>
							<input type="text" name="email" id="email" />
						</label>
						<span class="textfieldInvalidFormatMsg">Invalid format.</span><span class="textfieldRequiredMsg"> จำเป็นต้องกรอกข้อมูล </span></span></td>
					</tr>
					<tr>
						<td><div align="right">
							<label>
								<div align="center"></div>
							</label></div>
							<span id="sprytextfield5">
							<label></label>
							<span class="textfieldRequiredMsg"> จำเป็นต้องกรอกข้อมูล </span></span>
						</td>
						<td><input type="submit" name="add" id="add" value=" เพิ่มข้อมูล " /></td>
					</tr>
				</table>
				<input type="hidden" name="MM_insert" value="form1" />
				</form>
			</div>
		</div>
	</div>
	
	<?php
	require_once('footer.php'); 
	?>

	<script type="text/javascript">
		var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
		var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
		var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
		var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
		var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
		var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
		var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "email", {validateOn:["blur"]});
	</script>
	
</body>
</html>
<?php
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบสูงสุดเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>