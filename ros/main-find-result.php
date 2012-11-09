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
		case "admin"  : 
	?>
	<title>Benchmark Garde - Administrator::ผลการสอบของพนักงาน</title>
	<link rel="shortcut icon" href="BEI_icon.ico" type="image/x-icon" />
	<link rel="icon" href="BEI_icon.ico" type="image/x-icon" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link href="styles_table.css" rel="stylesheet" type="text/css" />
	<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
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
				<?PHP
					//mysql_select_db($database_ros);
					$queryLogin = "SELECT
						mdl_user.firstname,
						mdl_user.lastname,
						mdl_user.idnumber,
						mdl_user.department,
						mdl_user.institution,
						mdl_user.city,
						mdl_user.email
					FROM
						mdl_user
					WHERE
						mdl_user.idnumber ='".$_GET['idnumber']."'"; 
					$rcsLogin = mysql_query($queryLogin) or die(mysql_error());
					$totalRows = mysql_num_rows($rcsLogin);
					$rowLogin = mysql_fetch_array($rcsLogin);
				?>
				<div align="justify" style="font-size: 16pt">ผลการสอบของพนักงานเป็นรายบุคคล<br>
				<a href="pdf-each.php?idnumber=<?php echo $_GET['idnumber']; ?>" target="_blank"><img src="images\PDF_Logo.png" align="right" border="0" width="64" height="64"></a></div>
		    </div>
			<div class="body_textarea">
				<div id="mytable">
				<table id="mytable" cellspacing="0">
					      <tr>
							<th width="88"><div align="left"><strong>ชื่อ</strong></div></th>
        					<td width="208"><?php echo $rowLogin['firstname'];?></td>
        					<th width="84"><div align="left"><strong>นามสกุล</strong></div></th>
        					<td width="275"><?php echo $rowLogin['lastname'] ;?></td>
      					</tr>
      					<tr>
        					<th><div align="left"><strong>E/N</strong></div></th>
        					<td><?php echo $rowLogin['idnumber'];?></td>
        					<th><div align="left"><strong>แผนก</strong></div></th>
        					<td><?php echo strtoupper($rowLogin['department']);?></td>
      					</tr>
      					<tr>
        					<th><div align="left"><strong>หัวหน้างาน</strong></div></th>
        					<td colspan="3"><?php echo ucwords($rowLogin['institution']);?></td>
      					</tr>
      					<tr>
        					<th><div align="left"><strong>สาขา</strong></div></th>
        					<td colspan="3"><?php echo ucwords($rowLogin['city']);?></td>
      					</tr>
      					<tr>
        					<th><strong>E-mail</strong></th>
        					<td colspan="3"><?php echo $rowLogin['email'];?></td>
      					</tr>
      					<tr>
        					<td colspan="4"><div align="left">
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
									mdl_user.idnumber = '".$_GET['idnumber']."' AND
									mdl_course.visible = 1 AND
									mdl_quiz_attempts.timefinish <> 0
								ORDER BY
									mdl_quiz_attempts.timestart ASC");
								$p=1;
								@$num_rows=mysql_num_rows($result);
								
									echo"<table id='mytable' cellspacing='0'>";
									echo"<tr><th>course</th><th><center>1</center></th><th><center>2<center></th><th><center>3<center></th><th><center>Latest Time<center></th></tr>";
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
											}else {print "<td>None></td>"; }
											$fday = getdate(mysql_result($result,$e-1,3));
											
											$day= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
											print "<td align='center'>".$day."</td>";
											$today = getdate(mysql_result($result,$e-1,3));
											$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
											$today = getdate($nextyear);
											
									//		echo "<td align='center'>".$today['mon'].'/'.$today['mday'].'/'.$today['year']."</td>";
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
											
											$day= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
											print "<td align='center'>".$day."</td>";
											$today = getdate(mysql_result($result,$e-1,3));
											$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
											$today = getdate($nextyear);
											
								//			echo "<td align='center'>".$today['mon'].'/'.$today['mday'].'/'.$today['year']."</td>";
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
											
											$day= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
											print "<td align='center'>".$day."</td>";
											$today = getdate(mysql_result($result,$e-1,3));
											$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
											$today = getdate($nextyear);
												
									//		echo "<td align='center'>".$today['mon'].'/'.$today['mday'].'/'.$today['year']."</td>";
										}
										echo" </tr>";
										$p=1;
										
									}$result2=mysql_query("SELECT
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
																mdl_user.idnumber = '".$_GET['idnumber']."' AND
																ros_subject.vision = 1
														ORDER BY
																ros_score.`subject` ASC");
																
										$num_rows1=mysql_num_rows($result2);						
															
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
									echo"</table>";
								if($num_rows+$num_rows1==0){	
									echo"<br><h2><center>ไม่มีผลสอบ</center></h2>";
								}
							 
							?></div></td>
						</tr>
				</table>				
				</div>
			
			</div>
		</div>
	</div>

	<?php
	require_once('footer.php'); 
	?>	
	
	<script type="text/javascript">
		var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
	</script>

</body>
</html>
<?php
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้หัวหน้า่งานข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>