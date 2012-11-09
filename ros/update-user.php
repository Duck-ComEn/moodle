<?php require_once('Connections/ros.php'); 
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
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
		$updateSQL = sprintf("UPDATE ros_user_admin SET firstname=%s, lastname=%s, password=%s, email=%s WHERE username=%s",
			GetSQLValueString($_POST['name'], "text"),
			GetSQLValueString($_POST['lastname'], "text"),
			GetSQLValueString($_POST['pass'], "text"),
			GetSQLValueString($_POST['email'], "text"),
			GetSQLValueString($_POST['username'], "text"));
	//	mysql_select_db($database_ros);
		$Result1 = mysql_query($updateSQL) or die(mysql_error());
		$updateGoTo = "main-edit.php";
		if (isset($_SERVER['QUERY_STRING'])) {
			$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
			$updateGoTo .= $_SERVER['QUERY_STRING'];
		}
		@header(sprintf("Location: %s", $updateGoTo));
	}
	$name_Recordset1 = "null";
	if (isset($_GET['user'])) {
		$name_Recordset1 = $_GET['user'];
	}
	//mysql_select_db($database_ros, $ros);
	$query_Recordset1 = sprintf("SELECT ros_user_admin.username, ros_user_admin.firstname, ros_user_admin.lastname, ros_user_admin.password, ros_user_admin.email FROM ros_user_admin WHERE ros_user_admin.username = %s", GetSQLValueString($name_Recordset1, "text"));
	$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
		switch($_SESSION['MM_UserRight']){
		case "admin" || "superadmin" : 
	?>

	<title>Benchmark Garde - Administrator::แก้ไขสมาชิก</title>
	<link rel="shortcut icon" href="BEI_icon.ico" type="image/x-icon" />
	<link rel="icon" href="BEI_icon.ico" type="image/x-icon" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	<!-- <link href="styles_table.css" rel="stylesheet" type="text/css" /> -->
	<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
	<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
	<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
<!--
.style1 {color: #FF0000}
-->
    </style>
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
			<div class="head">Welcome <?php echo $_SESSION['MM_FirstName'].' '.$_SESSION['MM_LastName'] ;?></div>
			<div class="body_textarea">
				<div align="justify">แก้ไขสมาชิก</div>
				<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
				<table id="rounded-corner" width="495" border="0">
					<tr>
						<td colspan="2"><div align="right"><span class="style1">ช่องที่มี * ต้องกรอกข้อมูล</span></div></td>
					</tr>
					<tr>
						<td width="162"><div align="right">* FirstName :</div></td>
						<td width="323"><span id="sprytextfield1">
						<label>
							<input name="name" type="text" id="name" value="<?php echo $row_Recordset1['firstname']; ?>" />
						</label>
						<span class="textfieldRequiredMsg"> จำเป็นต้องกรอกข้อมูล </span></span>
						<input name="hf" type="hidden" id="hf" value="<?php echo $row_Recordset1['username']; ?>" /></td>
					</tr>
					<tr>
						<td><div align="right">* LastName :</div></td>
						<td><span id="sprytextfield2">
						<label>
							<input name="lastname" type="text" id="lastname" value="<?php echo $row_Recordset1['lastname']; ?>" />
						</label>
						<span class="textfieldRequiredMsg"> จำเป็นต้องกรอกข้อมูล </span></span></td>
					</tr>
					<tr>
						<td><div align="right"><span class="style1">Username</span> :</div></td>
						<td><span id="sprytextfield3">
						<label>
							<input name="username" type="text" id="username" value="<?php echo $row_Recordset1['username']; ?>" disabled/>
						</label>
						<span class="textfieldRequiredMsg"> จำเป็นต้องกรอกข้อมูล </span></span></td>
					</tr>
					<tr>
						<td><div align="right">* Password :</div></td>
						<td><span id="sprytextfield4">
						<label>
							<input name="pass" type="password" id="pass" value="<?php echo $row_Recordset1['password']; ?>" />
						</label>
						<span class="textfieldRequiredMsg"> จำเป็นต้องกรอกข้อมูล </span></span></td>
					</tr>
					<tr>
						<td><div align="right">* E-mail :</div></td>
						<td><span id="sprytextfield6">
						<label>
							<input name="email" type="text" id="email" value="<?php echo $row_Recordset1['email']; ?>" />
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
						<td><input type="submit" name="add" id="add" value=" บันทึกการเปลี่ยนแปลง " /></td>
					</tr>
				</table>      
				<input type="hidden" name="MM_update" value="form1" />
				</form>
			</div>
		</div>
	</div>
	
	<?php
	require_once('footer.php'); 
	?>	

</body>
 
<script type="text/javascript">
	var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
	var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"]});
	var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
	var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
	var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur"]});
	var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
	var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "email", {validateOn:["blur"]});
</script>

</html>
<?php
	mysql_free_result($Recordset1);
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>