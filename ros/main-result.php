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
	<title>Benchmark Garde - Administrator::ผลสอบพนักงาน</title>
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
				<div align="justify" style="font-size: 16pt">ผลสอบพนักงาน</div><br>
				<form id="form1" name="form1" method="get" action="main-result.php">
				                    <strong>แสดงเฉพาะ Supervisor</strong>
						<label><?php
												$sql = "SELECT DISTINCT
														mdl_user.institution
														FROM
														mdl_user
														WHERE
														mdl_user.institution <> ''
														ORDER BY
														mdl_user.institution ASC";
														$query = mysql_query($sql);
														echo "<select id='sel_product' name='sel_product'>";
														echo "<option>All</option>";
														while($rs = mysql_fetch_array($query)){
														$data = $rs['0'];
														echo "<option>$data</option>";
														}
														echo "</select>"; 
						?></label>
						<label>
							<input type="submit" name="Query" value=" Query " />
						</label>
				  </form>
				<div id="mytable">
				<table id="mytable" cellspacing="0">
					<?php
					if($_GET[sel_product]=='All' || $_GET[sel_product]==''){
						$result=mysql_query("SELECT DISTINCT
							mdl_user.idnumber,
							mdl_user.firstname,
							mdl_user.lastname
						FROM
							mdl_user
						WHERE
							mdl_user.idnumber <> ''");
							
						}else {
						$result=mysql_query("SELECT DISTINCT
							mdl_user.idnumber,
							mdl_user.firstname,
							mdl_user.lastname
						FROM
							mdl_user
						WHERE
							mdl_user.idnumber <> '' AND
							mdl_user.institution = '".$_GET[sel_product]."'");
						echo"<br><center><h3>แสดงในสังกัดคุณ ".ucwords($_GET[sel_product])."</h3></center><br>";
						
						}
						@$num_rows=mysql_num_rows($result);
						if(!$num_rows){
						//	echo "<meta http-equiv='refresh' content=0;URL=main-result.php>";
						}
						echo"<caption align=\"bottom\">result $num_rows E/N </caption>";
						echo"<tr><th>E/N</th><th>FirstName</th><th>LastName</th></tr>";
						while($data = mysql_fetch_array($result)){
							echo"<tr>";
							print"<td><a href='main-find-result.php?idnumber=".$data['idnumber']."'>".$data['idnumber']."</a></td><td>{$data['firstname']}</td><td>{$data['lastname']}</td>";
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
	
	<script type="text/javascript">
		<!--
		var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
		//-->
	</script>
	
</body>	
</html>
<?php
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>