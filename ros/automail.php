<?php
require_once('Connections/file.php');
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
	<title>Benchmark Garde - SuperAdministrator::การแจ้งเตือน</title>
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
			<div class="head">Welcome <?php print ucfirst($_SESSION['MM_FirstName']).' '.ucfirst($_SESSION['MM_LastName']) ;?></div>
			<div class="body_textarea">
				<div align="justify" style="font-size: 16pt">แจ้งเตือนทั้งหมด</div>
				<div align="justify">
				  <p>แสดงรายชื่อพนักงานทั้งหมดที่มีอยู่ในฐานข้อมูล</p>
				  <p>&nbsp;</p>
				  <form id="form1" name="form1" method="get" action="super_admin-warn.php">
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
			    </div>
				<div><a href="admin-pdf-all.php?sup=<?php echo $_GET[sel_product]?>" target="_blank"><img src="images/PDF_Logo.png" align="right" border="0" width="64" height="64"></a></div>
			</div>
			<div class="body_textarea">
				<div id="mytable">
				 <table id="mytable"  cellspacing="0">
					 <?php
					 
					 $_SESSION['$viewbysup'] = $_GET[sel_product];
					 
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
													mdl_course.visible = 1
													
											GROUP BY
													mdl_user.institution
											union all select
														mdl_user.idnumber,
														mdl_user.firstname,
														mdl_user.lastname,
														ros_score.added,
														ros_score.`subject`,
														ros_score.max,
														ros_score.date_time,
														CONCAT('m',mdl_user.idnumber,'&fname=',mdl_user.firstname,'&lname=',mdl_user.lastname,'&subject=',REPLACE(ros_score.`subject`, ' ', '+')) AS id,
														mdl_user.institution
													FROM
														ros_score
													INNER JOIN mdl_user ON ros_score.uid = mdl_user.id
													INNER JOIN ros_subject ON ros_subject.`name` = ros_score.`subject`
													WHERE
														ros_score.max = ros_score.added AND
														ros_subject.vision = 1 and
														ros_score.max = ros_score.added ".$not1."
														ORDER BY 7");
					
							@$num_rows=mysql_num_rows($result);
							if(!$num_rows){
							//echo "can not connect database";
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
					
					
					?>
					<form action="super_admin-list_vistion.php" method="POST" name="form1">
					<?php
					
					$u=1;
						echo"<tr><th>No.</th><th>E/N</th><th>Name</th><th>Course</th><th>Time/(status)</th><th>RemainTime/remark/sup</th></tr>";
				
						
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
						
						echo"<tr><td align=center>".($u++).".</td><td>{$data1['idnumber']}</td><td>".$data1['firstname'].' '.$data1['lastname']."</td><td>{$data1['fullname']}&nbsp;&nbsp;<img src=images/ICON_Remark/".$data1['remark']."_x20.gif></td><td>".$q;if(@in_array($idat, $notshow)){ echo"&nbsp;&nbsp;<a href=super_admin-show.php?id=".$idat."><img src=images/show1.gif></a>";}else{echo"&nbsp;&nbsp<a href=super_admin-notshow.php?id=".$idat."><img src=images/hide1.gif></a>";}echo"<input type=checkbox name=cd[] value=".$idat."></td><td>";if($qn=='expire'){echo"<a href=super_admin-update-expire.php?id=".$idat.">expire</a> &nbsp;&nbsp;(".$dateremark.")";}else {echo $qn;};echo"&nbsp;&nbsp;<input name=\"btnButton1\" type=\"button\" value=\"S\" OnClick=\"JavaScript:fncAlert('".ucwords($data1['institution'])."');\"></td></tr>";
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
							if($a[$i][4]<=3 ||$a[$i][4]==7){
							
								//add link to database
								 //by supervisor
								$gen=getdate();
								$enscri='automail_pdf.php?sup='.$a[$i][5].'&time='.$gen[0];
								//echo $enscri;
								$result1=mysql_query("insert into ros_mail(link,sup,time) values('".$enscri."','".$a[$i][5]."',".$gen[0].")");
							echo"<tr><td align=center>".$u++.".</td><td>".$a[$i][0]."</td><td>{$a[$i][1]}</td><td>{$a[$i][2]}</td><td>".$a[$i][3]; if(@in_array($idat, $notshow3)){ echo"&nbsp;&nbsp;<a href=super_admin-show.php?id=".$idat."><img src=images/show1.gif></a>";}else{echo"&nbsp;&nbsp<a href=super_admin-notshow.php?id=".$idat."><img src=images/hide1.gif></a>";}echo" <input type=checkbox name=cd[] value=".$idat."></td><td>";if($a[$i][4]=='expire'){echo "<a href=super_admin-expire.php?id=".$idat.">expire</a>";}else {echo $a[$i][4];}echo"&nbsp;&nbsp;<input name=\"btnButton1\" type=\"button\" value=\"S\" OnClick=\"JavaScript:fncAlert('".ucwords($a[$i][5])."');\"></td></tr>";
								list($f,$l)=explode(' ',$a[$i][5]);
								$to = $f.".".$l.'.bench.com';
								$subject = 'Auto Mail Alert Certificate from Traning';
								$message = "<img src=".$ipserver_path."images/search_strip.jpg><h3>เรียน คุณ ".ucfirst($a[$i][5])."</h3><br>".$messagefile.'<br>';
								$message.="<br><a href=http://krt-lms/moodle/ros/".$enscri."><img src=".$ipserver_path."images/PDF_Logo.png height=50 width=50></a>";
								$header = "From: ".$mailsender."\r\n";
								$header = "Cc: Ped<duck_comen.RecertificationSystem@hotmail.com>\r\n";
								$header.="Return-Receipt-to:master<".$mailsender.">\r\n";
								$header.="Disposition-Notification-to:master<".$mailsender.">\r\n";
								$header .="MIME-Version: 1.0\r\n";
								$header .= "Content-type: text/html; charset=UTF-8\r\n" ;
 
								if( @mail( $to , $subject , $message , $header ) ){
								echo "Mail Complete to ".ucwords($a[$i][5])."<br>";
				
								}else{
								echo "Mail Incomplete to ".ucwords($a[$i][5])."<br>";
				
								}
								
								
							}						
							else{
							continue;
							}
						}
					
					if($u==1){
					
					echo "<caption align=\"bottom\">No data </caption>";
					}else{
					echo "<tr><td colspan=4></td><td><input align=rigth type=submit name=Submit value='Toggle Vistion'></td><td></td></tr>";
					echo "<caption align=\"bottom\">result : ".($u-1)." </caption>";}
					?>
				</table>
			</form>
				
				
				
				</div>
			</div>
			<!-- remark detail-->
			<?php
			
				require_once('remark_detail.php');
			?>
		</div>
	</div>

	<!-- Fotter area-->
	
	
	
	<?php						$to="duck_comen.moodle@hotmail.com";
								$subject ='auto mail Recertification System';
								$message="auto mail start ";
								$header = "From: ".$mailsender."\r\n";	
								$header .="MIME-Version: 1.0\r\n";
								$header .= "Content-type: text/html; charset=UTF-8\r\n" ;
 								if( @mail( $to , $subject , $message , $header ) ){
									}require_once('footer.php'); 
	?>
	
</html>
