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
</head>

<body>
<div>
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
												mdl_course.visible
										FROM
												mdl_course");
												$i=1;
					while($value=mysql_fetch_array($result)){	
					$q=getdate($value['timecreated']);
					$remove= duration($q['year']+1 .'-'.$q['mon'].'-'.$q['mday'] ."00:00:01",date("Y-m-d H:i:s")).'<br>';
					if($remove<=0){
					mysql_query("update mdl_course
					set visible='0'
					where id=".$value['id']);
					if(mysql_affected_rows()){
					$i++;
					}
					}
					}
					if($i>1){
					echo"<h3><center>ประมวลผลเสร็จสิ้น ได้ปรับปรุงรายที่เกิน 1ปี จำนวน ".$i."</center></h3>";
					}else{
					echo"<h3><center>ยังไม่มีรายวิชาที่มีอายุเกิน 1ปี</h3></center>";
					}
					 
						
						
						
?>
</div>
</body>	
</html>
<?php
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>