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
	<title>Benchmark Garde - Administrator::แก้ไข Supervisor</title>
	<link rel="shortcut icon" href="BEI_icon.ico" type="image/x-icon" />
	<link rel="icon" href="BEI_icon.ico" type="image/x-icon" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link href="styles_table.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
<!--
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
    </style>
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
				<div align="justify">
				  <h2>แก้ไข Supervisor ของพนักงาน</h2>
				  <p>&nbsp;</p>
				  <form id="form1" name="form1" method="POST" action="edit-sup2.php">
				    <table width="300" border="0">
                      <tr>
                        <th><div align="center" class="style2">รายละเอียดพนักงาน</div></th>
                      
                      </tr>
					  
                      <tr>
                        <td><table width="800" border="0">
                          <tr>
                            <td width="91" height="35"><div align="center">รหัสพนักงาน:</div></td>
							<td height="35"><div align="center">ชื่อ:</div></td>
                            <td height="35"><div align="center">นามสกุล:</div></td>
							<td height="35"><div align="center">แผนก:</div></td>
							<td height="35"><div align="center">หัวหน้างาน:</div></td>
							<td height="35"><div align="center">สาขา:</div></td>
                          </tr>
                          <tr>
                            <?php
							$en = $_POST['en'];
							$result=mysql_query("SELECT mdl_user.idnumber,mdl_user.firstname,mdl_user.lastname,mdl_user.department,mdl_user.institution,mdl_user.city
								FROM mdl_user
								WHERE
									mdl_user.idnumber = '".$en."'");
							
							while($data=mysql_fetch_array($result)){
							
							$supsname=$data['institution'];
							?>
							
							<td align="center"><?php echo $data['idnumber'];?> </td>
                            <td align="center"><?php echo $data['firstname'];?></td>
							<td align="center"><?php echo $data['lastname'];?></td>
							<td align="center"><?php echo strtoupper($data['department']);?></td>
							<td align="center"><?php echo strtoupper($data['institution']);?></td>
							
							<td align="center"><?php echo ucwords($data['city']);?></td>
							
							
							<?php
							
							}
							
							?>		
							
							
                          </tr>
                          
						  
                          
						  
                        </table></td>
                       
                      </tr>
					   <tr>
                        <th><div align="center" class="style2">Supervisor</div></th>
                      </tr>
					  
					  <tr>
                        <td align="center"><?php echo strtoupper($supsname);?></td>
                      </tr>
					  
					  <tr>
						<td>Change Supervisor : <input type="text" name ="newsup"></td>
					  </tr>
					  
                      <tr>
                        <td colspan="2"><label>
                          <div align="center">
                            <input type="submit" name="add" id="add" value="Change" />
                          </div>
                        </label>
                          <label>
                          <div align="center"></div>
                        </label></td>
						<input type="hidden" name="MM_update" value="form1" />
						<input type="hidden" name="idnumber" value=<?php echo $en; ?>>
                      </tr>
                      
                    </table>
				  </form>
				   
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
	default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>

