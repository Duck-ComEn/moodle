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
	<title>Benchmark Garde - Administrator::เพิ่มคะแนนพนักงาน</title>
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
				  <h2>เพิ่มคะแนนเป็นรายบุคคล</h2>
				  <p>&nbsp;</p>
				  <form id="form1" name="form1" method="POST" action="add-score.php">
				    <table width="469" border="0">
                      <tr>
                        <td width="168">กรุณากรอกรหัสพนักงาน</td>
<td width="175"><label>
                          <input type="text" name="en" id="en" />
                        </label></td>
<td width="112"><label>
                          <input type="submit" name="submit" id="submit" value="Submit" />
                        </label></td>
                      </tr>
                    </table>
				  
				  <?php
				  if($_POST['submit']){
			$queryLogin = "SELECT id,username,firstname,lastname,idnumber,email,institution,department,city FROM mdl_user WHERE idnumber='".$_POST['en']."'"; 
	$rcsLogin = mysql_query($queryLogin);
	$totalRows = mysql_num_rows($rcsLogin);
	$rowLogin = mysql_fetch_array($rcsLogin);
	if($totalRows == 1){ // กรณีที่ชื่อผู้ใช้ และรหัสผ่านถูกต้อง จะกำหนดค่าตัวแปร Session เพื่อให้เรียกใช้ได้ทุกเพจ
		session_start();
		$_SESSION['id'] = $rowLogin['id'];
		$_SESSION['name'] = $rowLogin['firstname'];
		$_SESSION['lastname'] = $rowLogin['lastname'];
		$_SESSION['idnumber'] = $rowLogin['idnumber'];
		$_SESSION['super'] = $rowLogin['institution'];
		$_SESSION['department'] = $rowLogin['department'];
		$_SESSION['city'] = $rowLogin['city'];
		echo "<meta http-equiv='refresh' content='0;URL=add-score1.php'>";
		}else{ // กรณีที่ข้อมูลไม่ถูกต้อง จะแจ้งให้ผู้ใช้ระบบทราบ
  		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
  		echo "<script language='javascript'>alert('ไม่มีรหัสพนักงานนี้ กรุณาตรวจสอบใหม่');</script>";
		}
		}
		
				  ?>
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