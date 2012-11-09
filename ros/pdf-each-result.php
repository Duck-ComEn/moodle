<?php
require_once('Connections/ros.php');
if(!isset($_SESSION)){
session_start();
}
	switch($_SESSION['MM_UserRight']){
		case "admin"  : 
require("FPDF/ThaiPDF.class.php");
$pdf = new ThaiPDF();
$pdf->AddThaiFont("cordia");
$pdf->AddPage();
$pdf->SetFont("cordia", '', 22);
$pdf->setx(70);
$pdf->write(11,"Examination Report");

$pdf->SetFont("cordia", '', 16);
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

$html = "<br><br><br><br>
 <table border=0 align=center>
      <tr>
	  <td width=84>&nbsp;</td>
        <td width=84><b>Name</b></td>
        <td width=300><u>{$rowLogin['firstname']}</u></td>
        <td width=84><b>Lastname</b></td>
        <td width=300><u>{$rowLogin['lastname']}</u></td>
      </tr>
      <tr>
	  <td width=84>&nbsp;</td>
        <td width=84><b>E/N</b></td>
        <td width=300><u>{$rowLogin['idnumber']}</u></td>
        <td width=84><b>Department</b></td>
        <td width=300><u>{$rowLogin['department']}</u></td>
      </tr>
      <tr>
	  <td width=84>&nbsp;</td>
        <td width=84><b>Supervisor</b></td>
        <td width=300><u>{$rowLogin['institution']}</u></td>
		<td width=84><b>Branch<b></td>
		<td width=300><u>{$rowLogin['city']}</u></td>
      </tr>
      <tr>
	  <td width=84>&nbsp;</td>
        <td width=84><b>E-mail</b></td>
        <td width=300><u>{$rowLogin['email']}</u></td>
      </tr>
</table>";
$pdf->WriteHTML($html);
require_once('Connections/ros.php');
//mysql_connect('localhost','root','');
//mysql_select_db("moodle");
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
									mdl_user.idnumber ='".$_GET['idnumber']."' and
									mdl_course.visible = 1 AND
									mdl_quiz_attempts.timefinish <> 0
								ORDER BY
									mdl_quiz_attempts.timestart ASC");
$num_rows=mysql_num_rows($result);
$p=1;
$t=0;
for($i=0;$i<$num_rows;$i++){
$cf=mysql_result($result,$i,0);
@$cs=mysql_result($result,$i+1,0);
if($cf==$cs){
$p++;
continue;
   }
   $a[$t][0]=$cf;
    if($p==3){
@$a1=mysql_result($result,$e,1);
if($a1==1){
$a[$t][1]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}else if($a1==2){
$a[$t][1]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}else if ($a1==3){
$a[$t][1]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}
//echo" col2 ";
@$a1=mysql_result($result,$e,1);
if($a1==1){
$a[$t][2]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}else if($a1==2){
$a[$t][2]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}else if ($a1==3){
$a[$t][2]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}
//echo" col3 ";
@$a1=mysql_result($result,$e,1);
if($a1==1){
$a[$t][3]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}else if($a1==2){
$a[$t][3]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}else if ($a1==3){
$a[$t][3]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}
$fday = getdate(mysql_result($result,$e-1,3));
if(strlen($fday['mon'])<=1){
													$fday['mon']='0'.$fday['mon'];
												}
												if(strlen($fday['mday'])<=1){
													$fday['mday']='0'.$fday['mday'];
												}
$day= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
$a[$t][4]=$day;
$today = getdate(mysql_result($result,$e-1,3));
$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
$today = getdate($nextyear);
if(strlen($today['mon'])<=1){
													$today['mon']='0'.$today['mon'];
												}
												if(strlen($today['mday'])<=1){
													$today['mday']='0'.$today['mday'];
												}
$a[$t][5]=$today['mon'].'/'.$today['mday'].'/'.$today['year'];

}else if($p==2){
@$a1=mysql_result($result,$e,1);
if($a1==1){
$a[$t][1]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}else if($a1==2){
$a[$t][1]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}else if ($a1==3){
$a[$t][1]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}
//echo" col3 ";
@$a1=mysql_result($result,$e,1);
if($a1==1){
$a[$t][2]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}else if($a1==2){
$a[$t][2]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}else if ($a1==3){
$a[$t][2]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}$a[$t][3]="-";
$fday = getdate(mysql_result($result,$e-1,3));
if(strlen($fday['mon'])<=1){
													$fday['mon']='0'.$fday['mon'];
												}
												if(strlen($fday['mday'])<=1){
													$fday['mday']='0'.$fday['mday'];
												}
$day= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
$a[$t][4]=$day;
$today = getdate(mysql_result($result,$e-1,3));
$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
$today = getdate($nextyear);
if(strlen($today['mon'])<=1){
													$today['mon']='0'.$today['mon'];
												}
												if(strlen($today['mday'])<=1){
													$today['mday']='0'.$today['mday'];
												}
$a[$t][5]=$today['mon'].'/'.$today['mday'].'/'.$today['year'];

}else if($p==1){
@$a1=mysql_result($result,$e,1);
if($a1==1){
$a[$t][1]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}else if($a1==2){
$a[$t][1]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}else if ($a1==3){
$a[$t][1]=round((mysql_result($result,$e,2)/mysql_result($result,$e,4)),2)*100 ."%";
$e++;
}$a[$t][2]="-";$a[$t][3]="-";
$fday = getdate(mysql_result($result,$e-1,3));
if(strlen($fday['mon'])<=1){
													$fday['mon']='0'.$fday['mon'];
												}
												if(strlen($fday['mday'])<=1){
													$fday['mday']='0'.$fday['mday'];
												}
$day= $fday['mon'].'/'.$fday['mday'].'/'.$fday['year'];
$a[$t][4]=$day;
$today = getdate(mysql_result($result,$e-1,3));
$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
$today = getdate($nextyear);
if(strlen($today['mon'])<=1){
													$today['mon']='0'.$today['mon'];
												}
												if(strlen($today['mday'])<=1){
													$today['mday']='0'.$today['mday'];
												}
$a[$t][5]=$today['mon'].'/'.$today['mday'].'/'.$today['year'];
}
$p=1;
$t++;
}
$table="<br><table border=1>
<tr><td width=500 bgcolor=#cccccc align=center>course</td><td width=45 bgcolor=#cccccc align=center>1</td><td width=45 bgcolor=#cccccc align=center>2</td><td width=45 bgcolor=#cccccc align=center>3</td><td width=80 bgcolor=#cccccc align=center>time</td></tr>";
for($i=0;$i<$t;$i++){
$table.="<tr><td width=500>{$a[$i][0]}</td><td width=45 align=center>{$a[$i][1]}</td><td width=45 align=center>{$a[$i][2]}</td><td width=45 align=center>{$a[$i][3]}</td><td width=80 align=center>{$a[$i][4]}</td></tr>";
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
																mdl_user.idnumber = '".$_GET['idnumber']."' AND
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
										$table.="<tr><td width=500>{$data['subject']}</td><td align=center width=45>";if($data['time1']=='0'){ $table.= "-";}else {$table.= round(($data['time1']/$data['max']),2)*100 .'%';} $table.="</td><td align=center width=45>";if($data['time2']=='0'){ $table.= "-";}else {$table.= round(($data['time2']/$data['max']),2)*100 .'%';} $table.="</td><td align=center width=45>";if($data['time3']=='0'){ $table.= "-";}else {$table.= round(($data['time3']/$data['max']),2)*100 .'%';} $table.="</td><td align=center width=80>{$day1}</td></tr>";
										}




$table.="</table>";

$pdf->writehtml($table);

$pdf->Output();
}
?>
									