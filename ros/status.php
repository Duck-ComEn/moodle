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
	<title>Benchmark Garde - Administrator::ปิดรายวิชาที่มีอายุเกิน 1 ปีอัตโนมัต</title>
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
				<div align="justify"><h3>ระบบปิดรายวิชาที่มีอายุเกิน 1 ปีอัตโนมัต</h3>
				  <p>&nbsp;</p>
				  <p><br>
			        <?php
				function duration($begin,$end){
    						$thisday=getdate();
							$remain=intval(strtotime($begin)-$thisday[0]);
							$wan=floor($remain/86400)+1;
							$l_wan=$remain%86400;
							$hour=floor($l_wan/3600);
							$l_hour=$l_wan%3600;
							$minute=floor($l_hour/60);
							$second=$l_hour%60;
							return $wan;
						}
					
					$result=mysql_query("SELECT
												mdl_course.id,
												mdl_course.timecreated,
												mdl_course.visible,
												mdl_course.shortname,
												mdl_course.fullname
										FROM
												mdl_course
										WHERE
												mdl_course.timecreated <> 0
										ORDER BY
												mdl_course.timecreated ASC");
					$u=1;
					echo"<table border=1 align=center>";
					echo"<tr><th>No.</th><th>รหัสวิชา</th><th>วิชา</th><th>วันที่สร้างวิชา</th><th>อายุวิชา</th><th>สถานะ</th></tr>";
					while($value=mysql_fetch_array($result)){	
					$q=getdate($value['timecreated']);
					$remove= duration($q['year']+1 .'-'.$q['mon'].'-'.$q['mday'] ."00:00:01",date("Y-m-d H:i:s")).'<br>';
					
					//mysql_query("update mdl_course
					//set visible='0'
					//where id=".$value['id']);
							if(strlen($q['mon'])<=1){
								$q['mon']='0'.$q['mon'];
							}
							if(strlen($q['mday'])<=1){
								$q['mday']='0'.$q['mday'];
							}
					if($remove<0){
					echo"<tr><td>".$u++."</td><td>{$value['shortname']}</td><td>{$value['fullname']}</td><td align=center>".$q['mon'].'/'.$q['mday'].'/'.$q['year']."</td><td align=center>".$remove."</td><td align=center>";if(!$value['visible']){echo"<a href=show-c.php?id=".$value['id']."><img src=images/show1.gif></a>";}else{echo"<a href=notshow-c.php?id=".$value['id']."><img src=images/hide1.gif></a>";}echo"</td></tr>";
					}
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