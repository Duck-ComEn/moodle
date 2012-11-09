<?php
	require_once('Connections/ros.php');
	if(!isset($_SESSION)){
	@session_start(); 
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		switch($_SESSION['MM_UserRight']){
		case "en" : 
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Benchmark Garde - Empolyee::ผลคะแนนสอบ</title>
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
											ros_menu.`mode` = 'en'
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
			<div align="justify" style="font-size: 16pt">รายงานผลการสอบ<br>
			<a href="en-pdf-result.php" target="_blank"><img src="images/PDF_Logo.png" width="64" height="64" border="0" align="right"></a></div>
			</div>
			<div class="body_textarea">
			<div id="mytable">
			<table id="mytable" cellspacing="0">
				<tbody>
				<tr>
					<th width="88"><div align="left"><strong>คุณชื่อ</strong></div></td>
					<td width="208"><?php echo $_SESSION['MM_FirstName'];?></td>
					<th width="84"><div align="left"><strong>นามสกุล</strong></div></td>
					<td width="275"><?php echo $_SESSION['MM_LastName'] ;?></td>
				</tr>
				<tr>
					<th><div align="left"><strong>E/N</strong></div></td>
					<td><?php echo $_SESSION['MM_Idnumber'];?></td>
					<th><div align="left"><strong>แผนก</strong></div></td>
					<td><?php echo strtoupper($_SESSION['MM_Department']);?></td>
				</tr>
				<tr>
					<th><div align="left"><strong>หัวหน้างาน</strong></div></td>
					<td colspan="3"><?php echo ucwords($_SESSION['MM_Institution']);?></td>
				</tr>
				<tr>
					<th><div align="left"><strong>สาขา</strong></div></td>
					<td colspan="3"><?php echo ucwords($_SESSION['MM_City']);?></td>
				</tr>
				<tr>
					<th><strong>E-mail</strong></td>
					<td colspan="3"><?php echo $_SESSION['MM_Email'];?></td>
				</tr>
				</tbody>
			</table>
			</div>
			<br>
			<div id="mytable">
			<table id="mytable" cellspacing="0">
				<?php 

					$result=mysql_query("SELECT
									mdl_course.fullname,
									mdl_quiz_attempts.attempt,
									mdl_quiz_attempts.sumgrades,
									mdl_quiz_attempts.timefinish,
									mdl_quiz.grade
								FROM
									mdl_quiz_attempts
									INNER JOIN mdl_user ON mdl_quiz_attempts.userid = mdl_user.id
									INNER JOIN mdl_quiz ON mdl_quiz_attempts.quiz = mdl_quiz.id
									INNER JOIN mdl_course ON mdl_quiz.course = mdl_course.id
								WHERE
									mdl_user.username ='".$_SESSION['MM_UserName']."' AND
									mdl_course.visible = 1 AND
									mdl_quiz_attempts.timefinish <> 0
								ORDER BY
									mdl_quiz_attempts.timestart ASC");
					$p=1;
					@$num_rows=mysql_num_rows($result);
					echo"<tr><th><center>course</center></th><th width=40><center>1</center></th><th width=40><center>2</center></th><th width=40><center>3</center></th><th><center>Latest Time</center></th></tr>";
					for($i=0;$i<$num_rows;$i++){
						echo"<tr>";
						$cf=mysql_result($result,$i,0);
						@$cs=mysql_result($result,$i+1,0);
						if($cf==$cs){
							$p++;
							continue;
						}
						echo"<td>$cf</td> ";
						if($p==3){
							@$a1=mysql_result($result,$e,1);
							if($a1==1){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else if($a1==2){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else if ($a1==3){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else {print "<td>None</td>";
								$e++; 
							}
							//echo" col2 ";
							@$a1=mysql_result($result,$e,1);
							if($a1==1){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else if($a1==2){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else if ($a1==3){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else {print "<td>None</td>";
								$e++; 
							}
							//echo" col3 ";
							@$a1=mysql_result($result,$e,1);
							if($a1==1){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else if($a1==2){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else if ($a1==3){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else {print "<td>None></td>";
							}
							$fday = getdate(mysql_result($result,$e-1,3));
							if(strlen($fday['mon'])<=1){
													$fday['mon']='0'.$fday['mon'];
												}
												if(strlen($fday['mday'])<=1){
													$fday['mday']='0'.$fday['mday'];
												}
							$day= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
							print "<td align=center>".$day."</td>";
							$today = getdate(mysql_result($result,$e-1,3));
							$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
							$today = getdate($nextyear);
							if(strlen($today['mon'])<=1){
													$today['mon']='0'.$today['mon'];
												}
												if(strlen($today['mday'])<=1){
													$today['mday']='0'.$today['mday'];
												}
			//				echo "<td align=center>".$today['mon'].'/'.$today['mday'].'/'.$today['year']."</td>";
						}else if($p==2){
							@$a1=mysql_result($result,$e,1);
							if($a1==1){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else if($a1==2){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else if ($a1==3){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else {print "<td>None</td>";
								$e++; 
							}
							//echo" col3 ";
							@$a1=mysql_result($result,$e,1);
							if($a1==1){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else if($a1==2){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else if ($a1==3){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else {print "<td>None</td> ";
							}echo"<td align='center'>-</td>";
							$fday = getdate(mysql_result($result,$e-1,3));
							if(strlen($fday['mon'])<=1){
													$fday['mon']='0'.$fday['mon'];
												}
												if(strlen($fday['mday'])<=1){
													$fday['mday']='0'.$fday['mday'];
												}
							$day= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
							print "<td align=center>".$day."</td>";
							$today = getdate(mysql_result($result,$e-1,3));
							$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
							$today = getdate($nextyear);
							if(strlen($today['mon'])<=1){
													$today['mon']='0'.$today['mon'];
												}
												if(strlen($today['mday'])<=1){
													$today['mday']='0'.$today['mday'];
												}
				//			echo "<td align=center>".$today['mon'].'/'.$today['mday'].'/'.$today['year']."</td>";
						}else if($p==1){
							@$a1=mysql_result($result,$e,1);
							if($a1==1){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else if($a1==2){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else if ($a1==3){
								print "<td width=40 align=center>".round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%</td>";
								$e++;
							}else {print "<td>None</td>";
								//$e++; 
							}echo "<td align='center'>-</td><td align='center'>-</td> ";
							$fday = getdate(mysql_result($result,$e-1,3));
							if(strlen($fday['mon'])<=1){
													$fday['mon']='0'.$fday['mon'];
												}
												if(strlen($fday['mday'])<=1){
													$fday['mday']='0'.$fday['mday'];
												}
							$day= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
							print "<td align=center>".$day."</td>";
							$today = getdate(mysql_result($result,$e-1,3));
							$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
							$today = getdate($nextyear);
							if(strlen($today['mon'])<=1){
													$today['mon']='0'.$today['mon'];
												}
												if(strlen($today['mday'])<=1){
													$today['mday']='0'.$today['mday'];
												}
				//			echo "<td align=center>".$today['mon'].'/'.$today['mday'].'/'.$today['year']."</td>";
						}
						echo" </tr>";
						$p=1;
						}
						$result2=mysql_query("SELECT
																ros_score.`subject`,
																ros_score.time1,
																ros_score.time2,
																ros_score.time3,
																ros_score.date_time,
																ros_score.next_date,
																ros_score.max
															FROM
																ros_score
															INNER JOIN mdl_user ON ros_score.uid = mdl_user.id
															INNER JOIN ros_subject ON ros_score.`subject` = ros_subject.`name`
															WHERE
																mdl_user.username ='".$_SESSION['MM_UserName']."' and
																ros_subject.vision = 1
																ORDER BY
																ros_score.`subject` ASC");
										while($data=mysql_fetch_array($result2)){
										$daydate = getdate($data['date_time']);
											if(strlen($daydate['mon'])<=1){
													$daydate['mon']='0'.$daydate['mon'];
												}
												if(strlen($daydate['mday'])<=1){
													$daydate['mday']='0'.$daydate['mday'];
												}
											$day1= $daydate['mon'].'/'.$daydate['mday'].'/'.$daydate['year'];
										$fday = getdate($data['next_date']);
											if(strlen($fday['mon'])<=1){
													$fday['mon']='0'.$fday['mon'];
												}
												if(strlen($fday['mday'])<=1){
													$fday['mday']='0'.$fday['mday'];
												}
											$day2= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
										echo"<tr><td>{$data['subject']}</td><td align=center>";if($data['time1']=='0'){ echo "-";}else {echo round(($data['time1']/$data['max']),2)*100 .'%';} echo"</td><td align=center>";if($data['time2']=='0'){ echo "-";}else {echo round(($data['time2']/$data['max']),2)*100 .'%';} echo"</td><td align=center>";if($data['time3']=='0'){ echo "-";}else {echo round(($data['time3']/$data['max']),2)*100 .'%';} echo"</td><td align=center>{$day1}</td></tr>";
										}
					
				?>			
			</table>
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
	default : echo"<center><h2>หน้านี้อนุญาติให้พนักงานข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>