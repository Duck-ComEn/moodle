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
	<script language="javascript">
	function fncAlert(name)
	{
	alert('หัวหน้างานของพนักงานคนนี้คือ : คุณ '+name);
	}
	</script>
	<link type="text/css" href="jquery-ui-1.7.2.custom/css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="jquery-ui-1.7.2.custom/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="jquery-ui-1.7.2.custom/js/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });
	
				// Tabs
				$('#tabs').tabs();
	

				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
		</script>
		<style type="text/css">
			/*demo page css*/
			body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 50px;}
			.demoHeaders { margin-top: 2em; }
			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
		</style>	
	<?php
		switch($_SESSION['MM_UserRight']){
		case "super" : 
	?>
	<title>Benchmark Garde - Supervisor::แจ้งเตือน 7 วัน</title>
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
											ros_menu.`mode` = 'super'
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
			<div class="head">Welcome <?php print ucfirst($_SESSION['MM_FirstName']).' '.ucfirst($_SESSION['MM_LastName']) ;?></div>
			<div class="body_textarea">
				<div align="justify" style="font-size: 16pt">แจ้งเตือนเหลืออีก 7 วันวิชาสอบหมดอายุ</div>
				<div align="justify">
				  <p>แสดงรายชื่อพนักงานทั้งหมดที่มีอยู่ในฐานข้อมูล</p>
				  <p>&nbsp;</p>
				  </div>
				<div><a href="super-pdf-7.php?sup=<?php echo $_GET[sel_product]?>" target="_blank"><img src="images\PDF_Logo.png" align="right" border="0" width="64" height="64"></a><a href="super-exl-7.php?sup=<?php echo $_GET[sel_product]?>" target="_blank"><img src="images\Excel2007Logo.png" align="right" border="0" width="60" height="64"></a></div>
			</div>
			<div class="body_textarea">
				<div id="mytable">
				 <table id="mytable"  cellspacing="0">
					 <?php
					 
					 $_SESSION['$viewbysup'] = $_GET[sel_product];
					 $_GET[sel_product]=$_SESSION['MM_FirstName'].' '.$_SESSION['MM_LastName'];
						function duration($begin,$end){
    						$thisday=getdate();
							$remain=intval(strtotime($begin)-$thisday[0]);
							$wan=floor($remain/86400)+1;
							$l_wan=$remain%86400;
							$hour=floor($l_wan/3600);
							$l_hour=$l_wan%3600;
							$minute=floor($l_hour/60);
							$second=$l_hour%60;
							if($second<0){
								return "expire";
							}else return $wan."วัน";
						}
						/*$result1=mysql_query("SELECT
												ros_remark.atid,
												ros_remark.remark,
												ros_remark.date,
												ros_remark.notvisible,
												ros_remark.id,
												ros_remark.manual
											FROM
												ros_remark
											WHERE ros_remark.atid <> ''");
						@$num_rows1=mysql_num_rows($result1);
						$r=1;
						while($remark=mysql_fetch_array($result1)){
						$not.="'$remark[atid]'";
		
						if($r!=$num_rows1){
						$not.=',';
						}
						$r++;
						}
						if($not!=''){
						$not="and mdl_quiz_attempts.id NOT IN(".$not.")";
						}

						
						
						$result3=mysql_query("SELECT
													ros_remark.atid,
													ros_remark.remark,
													ros_remark.date,
													ros_remark.notvisible,
													ros_remark.id,
													ros_remark.manual
												FROM
													ros_remark
												WHERE
													ros_remark.manual <> ''");
						@$num_rows3=mysql_num_rows($result3);
						$r=1;
						while($remark1=mysql_fetch_array($result3)){
						$not1.="'$remark1[manual]'";
		
						if($r!=$num_rows3){
						$not1.=',';
						}
						$r++;
						}

						if($not1!=''){
						$not1="AND ros_score.id NOT IN (".$not1.")";
						}
						*/
			
						// notshow								
							$result1=mysql_query("SELECT
													ros_remark.atid,
													ros_remark.remark,
													ros_remark.date,
													ros_remark.notvisible,
													ros_remark.id,
													ros_remark.manual,
													mdl_user.idnumber
											FROM
													ros_remark
											INNER JOIN mdl_quiz_attempts ON ros_remark.atid = mdl_quiz_attempts.id
											INNER JOIN mdl_user ON mdl_quiz_attempts.userid = mdl_user.id
											WHERE
													ros_remark.atid <> '' AND
													mdl_user.institution = '".$_GET[sel_product]."'");
						@$num_rows1=mysql_num_rows($result1);
						$r=1;
						while($remark=mysql_fetch_array($result1)){
						$not.="'$remark[atid]'";
		
						if($r!=$num_rows1){
						$not.=',';
						}
						$r++;
						}
						if($not!=''){
						$not="and mdl_quiz_attempts.id NOT IN(".$not.")";
						}
						
						
						$result3=mysql_query("SELECT
													ros_remark.atid,
													ros_remark.remark,
													ros_remark.date,
													ros_remark.notvisible,
													ros_remark.id,
													ros_remark.manual
											FROM
													ros_remark
											INNER JOIN ros_score ON ros_remark.manual = ros_score.id
											INNER JOIN mdl_user ON ros_score.uid = mdl_user.id
											WHERE
													ros_remark.manual <> '' AND
													mdl_user.institution = '".$_GET[sel_product]."'");
						@$num_rows3=mysql_num_rows($result3);
						$r=1;
						while($remark1=mysql_fetch_array($result3)){
						$not1.="'$remark1[manual]'";
		
						if($r!=$num_rows3){
						$not1.=',';
						}
						$r++;
						}

						if($not1!=''){
						$not1="AND ros_score.id NOT IN (".$not1.")";
						}					
						
							$result=mysql_query("SELECT
													mdl_user.idnumber,
													mdl_user.firstname,
													mdl_user.lastname,
													mdl_quiz_attempts.attempt,
													mdl_course.fullname,
													mdl_quiz_attempts.sumgrades,
													mdl_quiz_attempts.timefinish,
													mdl_quiz_attempts.id,
													mdl_user.institution
											FROM
													mdl_quiz_attempts
											INNER JOIN mdl_user ON mdl_user.id = mdl_quiz_attempts.userid
											INNER JOIN mdl_quiz ON mdl_quiz_attempts.quiz = mdl_quiz.id
											INNER JOIN mdl_course ON mdl_quiz.course = mdl_course.id
											WHERE
													mdl_quiz_attempts.sumgrades = mdl_quiz.sumgrades and
													mdl_course.visible = 1 and
													mdl_user.institution = '".$_GET[sel_product]."'
													".$not."
											GROUP BY
													mdl_user.id,
													mdl_quiz_attempts.quiz
											union all SELECT
														mdl_user.idnumber,
														mdl_user.firstname,
														mdl_user.lastname,
														ros_score.added,
														ros_score.`subject`,
														ros_score.max,
														ros_score.date_time,
														CONCAT('m',ros_score.id,'&fname=',mdl_user.firstname,'&lname=',mdl_user.lastname,'&subject=',REPLACE(ros_score.`subject`, ' ', '+')) AS id,
														mdl_user.institution
										FROM
														ros_score
										INNER JOIN mdl_user ON ros_score.uid = mdl_user.id
										INNER JOIN ros_subject ON ros_subject.`name` = ros_score.`subject`
										WHERE
													mdl_user.institution = '".$_GET[sel_product]."' AND
													ros_score.max = ros_score.added AND
													ros_subject.vision = 1 ".$not1."
										ORDER BY 7");
						
						
										
						
						
						//don't show remark moodle
						$result1=mysql_query("SELECT
												mdl_user.idnumber,
												mdl_user.firstname,
												mdl_user.lastname,
												ros_remark.remark,
												mdl_course.fullname,
												mdl_quiz_attempts.timefinish,
												mdl_quiz_attempts.id,
												ros_remark.date,
												mdl_user.institution
											FROM
												ros_remark
												INNER JOIN mdl_quiz_attempts ON ros_remark.atid = mdl_quiz_attempts.id
												INNER JOIN mdl_quiz ON mdl_quiz_attempts.quiz = mdl_quiz.id
												INNER JOIN mdl_user ON mdl_quiz_attempts.userid = mdl_user.id
												INNER JOIN mdl_course ON mdl_quiz.course = mdl_course.id
											WHERE
												mdl_user.institution = '".$_GET[sel_product]."' and
												mdl_course.visible = 1");
						//dot't view moodle
						$resultnot=mysql_query("SELECT
														mdl_user.idnumber,
														mdl_user.firstname,
														mdl_user.lastname,
														ros_remark.remark,
														mdl_course.fullname,
														mdl_quiz_attempts.timefinish,
														mdl_quiz_attempts.id,
														ros_remark.date,
														ros_warn_notshow.atid
												FROM
														ros_remark
												INNER JOIN mdl_quiz_attempts ON ros_remark.atid = mdl_quiz_attempts.id
												INNER JOIN mdl_quiz ON mdl_quiz_attempts.quiz = mdl_quiz.id
												INNER JOIN mdl_user ON mdl_quiz_attempts.userid = mdl_user.id
												INNER JOIN mdl_course ON mdl_quiz.course = mdl_course.id
												INNER JOIN ros_warn_notshow ON mdl_quiz_attempts.id = ros_warn_notshow.atid
												WHERE
														mdl_user.institution = '".$_GET[sel_product]."'");
												
						//don't show remark manual
						$result2=mysql_query("SELECT
												mdl_user.firstname,
												mdl_user.lastname,
												ros_score.`subject`,
												ros_remark.remark,
												ros_remark.date,
												ros_score.next_date,
												mdl_user.idnumber,
												ros_remark.manual,
												mdl_user.institution
											FROM
												ros_remark
											INNER JOIN ros_score ON ros_remark.manual = ros_score.id
											INNER JOIN mdl_user ON ros_score.uid = mdl_user.id
											INNER JOIN ros_subject ON ros_subject.`name` = ros_score.`subject`
											WHERE
												ros_subject.vision = 1
												mdl_user.institution = '".$_GET[sel_product]."'");
											
						//don't view manual 					
						$resultnot1=mysql_query("SELECT
														mdl_user.firstname,
														mdl_user.lastname,
														ros_score.`subject`,
														ros_remark.remark,
														ros_remark.date,
														ros_score.next_date,
														mdl_user.idnumber,
														ros_remark.manual
												FROM
														ros_remark
												INNER JOIN ros_score ON ros_remark.manual = ros_score.id
												INNER JOIN mdl_user ON ros_score.uid = mdl_user.id
												INNER JOIN ros_warn_notshow ON ros_warn_notshow.manual = ros_score.id
												WHERE
														mdl_user.institution = '".$_GET[sel_product]."'");
						
							
							
							@$num_rows=mysql_num_rows($result);
							if(!$num_rows){
							echo "can not connect database";
							}
							$p=1;
							$t=0;
							
							$i=0;
					while($data=mysql_fetch_array($result)){
					$a[$i][0]=$data['idnumber'];
					$a[$i][1]=$data['firstname'].' '.$data['lastname'];
					$a[$i][2]=$data['fullname'];
					$a[$i][3]=$data['timefinish'];
					$a[$i][5]=$data['institution'];
					$i++;
					}
					
					
					
					
					$u=1;
						echo"<tr><th>No.</th><th>E/N</th><th>Name</th><th>Course</th><th>Time/(status)</th><th>RemainTime/remark/sup</th></tr>";
				/*		$result1=mysql_query("SELECT
												mdl_user.idnumber,
												mdl_user.firstname,
												mdl_user.lastname,
												ros_remark.remark,
												mdl_course.fullname,
												mdl_quiz_attempts.timefinish,
												mdl_quiz_attempts.id,
												ros_remark.date
											FROM
												ros_remark
												INNER JOIN mdl_quiz_attempts ON ros_remark.atid = mdl_quiz_attempts.id
												INNER JOIN mdl_quiz ON mdl_quiz_attempts.quiz = mdl_quiz.id
												INNER JOIN mdl_user ON mdl_quiz_attempts.userid = mdl_user.id
												INNER JOIN mdl_course ON mdl_quiz.course = mdl_course.id");
												
						$resultnot=mysql_query("SELECT
														mdl_user.idnumber,
														mdl_user.firstname,
														mdl_user.lastname,
														ros_remark.remark,
														mdl_course.fullname,
														mdl_quiz_attempts.timefinish,
														mdl_quiz_attempts.id,
														ros_remark.date,
														ros_warn_notshow.atid
												FROM
														ros_remark
												INNER JOIN mdl_quiz_attempts ON ros_remark.atid = mdl_quiz_attempts.id
												INNER JOIN mdl_quiz ON mdl_quiz_attempts.quiz = mdl_quiz.id
												INNER JOIN mdl_user ON mdl_quiz_attempts.userid = mdl_user.id
												INNER JOIN mdl_course ON mdl_quiz.course = mdl_course.id
												INNER JOIN ros_warn_notshow ON mdl_quiz_attempts.id = ros_warn_notshow.atid");*/
						$i=0;
						while(@$datanot=mysql_fetch_array($resultnot)){
						$notshow[$i]=$datanot['id'];
						$i++;
						
						}
						$i=0;	
						while(@$data1=mysql_fetch_array($result1)){
						$idat=mysql_result($result1,$i,6);
						$dateremark=mysql_result($result1,$i,7);
						$p=getdate($data1['timefinish']);
						$p=$p[mon].'/'.$p[mday].'/'.$p[year];
						$q=getdate($data1['timefinish']);
						$qn=duration($q['year'].'-'.$q['mon'].'-'.$q['mday'] ."00:00:01",date("Y-m-d H:i:s"));
						if(strlen($q['mon'])<=1){
								$q['mon']='0'.$q['mon'];
							}
							if(strlen($q['mday'])<=1){
								$q['mday']='0'.$q['mday'];
							}
						$q=$q[mon].'/'.$q[mday].'/'.$q[year];
						
						if(@in_array($idat, $notshow)){
						continue;
						}
				//		echo"<tr><td align=center>".($u++).".</td><td>{$data1['idnumber']}</td><td>".$data1['firstname'].' '.$data1['lastname']."</td><td>{$data1['fullname']}&nbsp;&nbsp;<img src=images/ICON_Remark/".$data1['remark']."_x20.gif></td><td>".$q."</td><td>expire</td></tr>";
						$i++;
						}
					/*	$result2=mysql_query("SELECT
												mdl_user.firstname,
												mdl_user.lastname,
												ros_score.`subject`,
												ros_remark.remark,
												ros_remark.date,
												ros_score.next_date,
												mdl_user.idnumber,
												ros_remark.manual
											FROM
												ros_remark
											INNER JOIN ros_score ON ros_remark.manual = ros_score.id
											INNER JOIN mdl_user ON ros_score.uid = mdl_user.id");
											
											
						$resultnot1=mysql_query("SELECT
														mdl_user.firstname,
														mdl_user.lastname,
														ros_score.`subject`,
														ros_remark.remark,
														ros_remark.date,
														ros_score.next_date,
														mdl_user.idnumber,
														ros_remark.manual
												FROM
														ros_remark
												INNER JOIN ros_score ON ros_remark.manual = ros_score.id
												INNER JOIN mdl_user ON ros_score.uid = mdl_user.id
												INNER JOIN ros_warn_notshow ON ros_warn_notshow.manual = ros_score.id");*/
						$i=0;
						while(@$datanot1=mysql_fetch_array($resultnot1)){
						$notshow1[$i]=$datanot1['manual'];
						$i++;
						}										
											
						$i=0;	
						while(@$data2=mysql_fetch_array($result2)){
						$today = getdate($data2['next_date']);
							if(strlen($today['mon'])<=1){
								$today['mon']='0'.$today['mon'];
							}
							if(strlen($today['mday'])<=1){
								$today['mday']='0'.$today['mday'];
							}
							$next_date=$today[mon].'/'.$today[mday].'/'.$today[year];
							
						if(@in_array($data2['manual'], $notshow1)){
						continue;
						}
						
			//			echo"<tr><td align=center>".($u++).".</td><td>{$data2['idnumber']}</td><td>".$data2['firstname'].' '.$data2['lastname']."</td><td>{$data2['subject']}&nbsp;&nbsp;<img src=images/ICON_Remark/".$data2['remark']."_x20.gif></td><td>".$next_dat."</td><td>expire</td></tr>";
						$i++;
						}
												
						//create link not show moodle
						$resultnot3=mysql_query("SELECT
														ros_warn_notshow.id,
														ros_warn_notshow.atid,
														ros_warn_notshow.manual,
														ros_warn_notshow.`none`
												FROM
														ros_warn_notshow
												WHERE
														ros_warn_notshow.atid <> 0 ");
														
						@$num_resultnot3=mysql_num_rows($resultnot3);		

						if(!$num_resultnot3){
						$notshow3[0]="55";
						}
						
						$i=0;									
						
						while(@$datanot3=mysql_fetch_array($resultnot3)){
						$notshow3[$i]=$datanot3['atid'];
						$i++;
						}
					
						
						//create link not show manual
						$resultnot4=mysql_query("SELECT
														ros_warn_notshow.id,
														ros_warn_notshow.atid,
														ros_warn_notshow.manual,
														ros_warn_notshow.`none`,
														mdl_user.firstname,
														mdl_user.lastname,
														ros_score.`subject`
												FROM
														ros_warn_notshow
												INNER JOIN ros_score ON ros_warn_notshow.manual = ros_score.id
												INNER JOIN mdl_user ON mdl_user.id = ros_score.uid
												WHERE
														ros_warn_notshow.manual <> 0");
						$i=0;									
						while(@$datanot4=mysql_fetch_array($resultnot4)){
						$vowels = array(" ");
						$onlyconsonants = str_replace($vowels, "+", 'm'.$datanot4['manual'].'&fname='.$datanot4['firstname'].'&lname='.$datanot4['lastname'].'&subject='.$datanot4['subject']);		
						@array_push($notshow3,$onlyconsonants);
						$i++;
						}
						
						
						
						for($i=0;$i<$num_rows;$i++){
						$idat=mysql_result($result,$i,7);
						
							$today = getdate($a[$i][3]);
							
							$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
							$today = getdate($nextyear);
							if(strlen($today['mon'])<=1){
								$today['mon']='0'.$today['mon'];
							}
							if(strlen($today['mday'])<=1){
								$today['mday']='0'.$today['mday'];
							}
							$a[$i][3]=$today['mon'].'/'.$today['mday'].'/'.$today['year'];
							$a[$i][4]=duration($today['year'].'-'.$today['mon'].'-'.$today['mday'] ."00:00:01",date("Y-m-d H:i:s"));
							
							if(@in_array($idat, $notshow3)){
							continue;
							}
							if($a[$i][4]>7||$a[$i][4]=='expire'){
							continue;
						}
	
							echo"<tr><td align=center>".$u++.".</td><td>".$a[$i][0]."</td><td>{$a[$i][1]}</td><td>{$a[$i][2]}</td><td>".$a[$i][3]."</td><td>{$a[$i][4]}</td></tr>";
						}
					
					if($u==1){
					echo "<caption align=\"bottom\">No data </caption>";
					}else{
					echo "<caption align=\"bottom\">result : ".($u-1)." </caption>";}
					?>
				</table>
			
				
				
				
				</div>
			</div>
			<!-- remark detail-->
			<?php
			
				require_once('remark_detail.php');
			?>
		</div>
	</div>

	<!-- Fotter area-->
	<?php
		require_once('footer.php'); 
	?>
</html>
<?php
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้หัวหน้างานเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>