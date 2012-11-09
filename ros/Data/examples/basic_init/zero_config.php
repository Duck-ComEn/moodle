<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<?php
	require_once('Connections/ros.php');
	if(!isset($_SESSION)){
	@session_start();
	}
?>
	<head>
			<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico" />
		
		<title>DataTables example</title>
		<style type="text/css" title="currentStyle">
			@import "../../media/css/demo_page.css";
			@import "../../media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="../../media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../../media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable();
			} );
		</script>
	</head>
	<body id="dt_example">
		<div id="container">
			<div class="full_width big">
				<i>DataTables</i> zero configuration example
			</div>
			
			<h1>Preamble</h1>
			<p><i>DataTables</i> has most features enabled by default, so all you need to do to use it with one of your own tables is to call the construction function (as shown below).</p>
			
			<h1>Live example</h1>
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
							if($wan<=0){
								return "expire";
							}else return $wan;
						}
						if($_GET[sel_product]=='All' || $_GET[sel_product]==''){
						$result=mysql_query("SELECT
							mdl_user.idnumber,
							mdl_quiz_attempts.attempt,
							mdl_user.firstname,
							mdl_user.lastname,
							mdl_course.fullname,
							mdl_quiz_attempts.sumgrades,
							mdl_quiz_attempts.timefinish
						FROM
							mdl_quiz_attempts
							INNER JOIN mdl_user ON mdl_quiz_attempts.userid = mdl_user.id
							INNER JOIN mdl_quiz ON mdl_quiz_attempts.quiz = mdl_quiz.id
							INNER JOIN mdl_course ON mdl_quiz.course = mdl_course.id
						WHERE
							mdl_quiz_attempts.timefinish <> 0 AND
							mdl_user.idnumber <> '' AND
							mdl_course.visible = 1 and
							mdl_quiz_attempts.attempt = 1
					union ALL
						SELECT
							mdl_user.idnumber,
							ros_score.added,
							mdl_user.firstname,
							mdl_user.lastname,
							ros_score.`subject`,
							ros_score.max,
							ros_score.date_time
						FROM
							ros_score
						INNER JOIN mdl_user ON ros_score.uid = mdl_user.id ORDER BY 7");
							}else {
							$result=mysql_query("SELECT
							mdl_user.idnumber,
							mdl_quiz_attempts.attempt,
							mdl_user.firstname,
							mdl_user.lastname,
							mdl_course.fullname,
							mdl_quiz_attempts.sumgrades,
							mdl_quiz_attempts.timefinish
						FROM
							mdl_quiz_attempts
							INNER JOIN mdl_user ON mdl_quiz_attempts.userid = mdl_user.id
							INNER JOIN mdl_quiz ON mdl_quiz_attempts.quiz = mdl_quiz.id
							INNER JOIN mdl_course ON mdl_quiz.course = mdl_course.id
						WHERE
							mdl_quiz_attempts.timefinish <> 0 AND
							mdl_user.idnumber <> '' AND
							mdl_course.visible = 1 and
							mdl_quiz_attempts.attempt = 1 AND
							mdl_user.institution = '".$_GET[sel_product]."'
					union ALL
						SELECT
							mdl_user.idnumber,
							ros_score.added,
							mdl_user.firstname,
							mdl_user.lastname,
							ros_score.`subject`,
							ros_score.max,
							ros_score.date_time
						FROM
							ros_score
						INNER JOIN mdl_user ON ros_score.uid = mdl_user.id
						where mdl_user.institution = '".$_GET[sel_product]."'
						ORDER BY 7");
							}
							@$num_rows=mysql_num_rows($result);
							if(!$num_rows){
							echo "can not connect database";
							}
							$p=1;
							$t=0;
					for($i=0;$i<$num_rows;$i++){
						@$name2=mysql_result($result,$i+1,2)." ".mysql_result($result,$i+1,3);
						@$name=mysql_result($result,$i,2)." ".mysql_result($result,$i,3);
						$id=mysql_result($result,$i,0);
						$cf=mysql_result($result,$i,4);
						@$cs=mysql_result($result,$i+1,4);
						if($cf==$cs && $name==$name2){
							$p++;
							continue;
   						}
 						$a[$t][0]=$id;$a[$t][1]=$name;$a[$t][2]=$cf;
   						if($p==3){
							@$a1=mysql_result($result,$e,1);
							if($a1==1){
								$e++;
							}else if($a1==2){
								$e++;
							}else if ($a1==3){
								$e++;
							}else {
								$e++; 
							}
							//echo" col2 ";
							@$a1=mysql_result($result,$e,1);
							if($a1==1){
								$e++;
							}else if($a1==2){
								$e++;
							}else if ($a1==3){
								$e++;
							}else {
								$e++; 
							}
							//echo" col3 ";
							@$a1=mysql_result($result,$e,1);
							if($a1==1){
								$e++;
							}else if($a1==2){
								$e++;
							}else if ($a1==3){
								$e++;
							}else {
							}

							$today = getdate(mysql_result($result,$e-1,6));
							$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
							$today = getdate($nextyear);
								if(strlen($today['mon'])<=1){
									$today['mon']='0'.$today['mon'];
								}
								if(strlen($today['mday'])<=1){
									$today['mday']='0'.$today['mday'];
								}
							$a[$t][3]=$today['mon'].'/'.$today['mday'].'/'.$today['year'];
							$fday = getdate(mysql_result($result,$e-1,6));
							$day= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
							$a[$t][4]=duration($today['year'].'-'.$today['mon'].'-'.$today['mday'] ."00:00:01",date("Y-m-d H:i:s"));
						}else if($p==2){
							@$a1=mysql_result($result,$e,1);
							if($a1==1){
								$e++;
							}else if($a1==2){
								$e++;
							}else if ($a1==3){
								$e++;
							}else {
								$e++; 
							}
							//echo" col3 ";
							@$a1=mysql_result($result,$e,1);
							if($a1==1){
								$e++;
							}else if($a1==2){
								$e++;
							}else if ($a1==3){
								$e++;
							}else {
							}
							$today = getdate(mysql_result($result,$e-1,6));
							$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
							$today = getdate($nextyear);
								if(strlen($today['mon'])<=1){
									$today['mon']='0'.$today['mon'];
								}
								if(strlen($today['mday'])<=1){
									$today['mday']='0'.$today['mday'];
								}
							$a[$t][3]=$today['mon'].'/'.$today['mday'].'/'.$today['year'];
							$fday = getdate(mysql_result($result,$e-1,6));
							$day= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
							$a[$t][4]=duration($today['year'].'-'.$today['mon'].'-'.$today['mday'] ."00:00:01",date("Y-m-d H:i:s"));
						}else if($p==1){
							@$a1=mysql_result($result,$e,1);
							if($a1==1){
								$e++;
							}else if($a1==2){
								$e++;
							}else if ($a1==3){
								$e++;
							}else {
								//$e++; 
							}
							$today = getdate(mysql_result($result,$e-1,6));
							$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
							$today = getdate($nextyear);
								if(strlen($today['mon'])<=1){
									$today['mon']='0'.$today['mon'];
								}
								if(strlen($today['mday'])<=1){
									$today['mday']='0'.$today['mday'];
								}
							$a[$t][3]=$today['mon'].'/'.$today['mday'].'/'.$today['year'];
							$fday = getdate(mysql_result($result,$e-1,6));
							$day= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
							$a[$t][4]=duration($today['year'].'-'.$today['mon'].'-'.$today['mday'] ."00:00:01",date("Y-m-d H:i:s"));
						}
						$p=1;
						$t++;
					}
					$n=0;
					for($j=0;$j<$t;$j++){
						if($a[$j][4]){
							$b[$n++]=$j;
						}
					}
					
					?>
			
			<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th>Rendering engine</th>
			<th>Browser</th>
			<th>Platform(s)</th>
			<th>Engine version</th>
			<th>CSS grade</th>
		</tr>
	</thead>
	<tbody>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Epiphany 2.20</td>
			<td>Gnome</td>
			<td class="center">1.8</td>
			<td class="center">A</td>
		</tr>
		<?php
		for($i=0;$i<$n;$i++){
		$val=intval($a[$b[$i]][4]);
		if(strlen($val)==1){
		$val='--'.$val;
		}else if(strlen($val)==2){
		$val=' '.$val;
		}
			
							echo"<tr class=\"gradeA\"><td>{$a[$b[$i]][0]}</td><td>{$a[$b[$i]][1]}</td><td>{$a[$b[$i]][2]}</td><td>{$a[$b[$i]][3]}</td><td>".$val."</td></tr>";
						}
		?>
		
					
		
	</tbody>
	<tfoot>
		<tr>
			<th>Rendering enginee</th>
			<th>Browser</th>
			<th>Platform(s)</th>
			<th>Engine version</th>
			<th>CSS grade</th>
		</tr>
		
	</tfoot>
</table>
			</div>
			<div class="spacer"></div>
			
			<div id="footer" style="text-align:center;">
				<span style="font-size:10px;">
					DataTables &copy; Allan Jardine 2008-2010.
				</span>
			</div>
		</div>
	</body>
</html>