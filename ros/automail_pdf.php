<?php
require_once('Connections/file.php');
if(!isset($_SESSION)){
session_start();
}
	switch($_SESSION['MM_UserRight']){
		case "admin" || "superadmin"  : 
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
	}else return $wan." Days";
}
 

require("FPDF/ThaiPDF.class.php");
$pdf = new ThaiPDF();
$pdf->AddThaiFont("cordia");
$pdf->AddPage();
$pdf->SetFont("cordia", '', 22);
$pdf->setx(75);

$pdf->write(11,"Report Recertification Warnning");
$pdf->SetFont("cordia", '', 16);
$pdf->SetPageNo('left', 'Page: ', '/', 
 					'', 'I', '12');
$pdf->AddPageNo();
	
$supName=$_GET['sup'];
$time=$_GET['time'];
$res=mysql_query("select status from ros_mail WHERE ros_mail.link='automail_pdf.php?sup=".$supName."&time=".$time."'");
$data=mysql_fetch_array($res);
$count=$data['status'];
$update=mysql_query("update ros_mail SET ros_mail.`status`=".++$count." WHERE ros_mail.link='automail_pdf.php?sup=".$supName."&time=".$time."'");
$gen=getdate();
$update=mysql_query("update ros_mail SET ros_mail.`remark`=".$gen[0]." WHERE ros_mail.link='automail_pdf.php?sup=".$supName."&time=".$time."'");



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
													mdl_user.institution='".$supName."'
													order by mdl_user.institution
											");
					
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
					$a[$i][5]=ucwords($data['institution']);
					$i++;
					}
					
					$u=1;
						$table.="<br><br><br><table border=1><tr><td width=45 bgcolor=#cccccc align=center>No.</td><td width=60 bgcolor=#cccccc align=center>E/N</td><td width=150 bgcolor=#cccccc align=center>Name</td><td width=200 bgcolor=#cccccc align=center>Course</td><td width=100 bgcolor=#cccccc align=center>Remain Time</td><td width=200 bgcolor=#cccccc align=center>Supervisor Name</td></tr>";
						$i=0;
						while(@$datanot=mysql_fetch_array($resultnot)){
						$notshow[$i]=$datanot['id'];
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
							if($u%2==0){
							$table.="<tr><td width=45 align=center>".$u++.".</td><td width=60 align=center>".$a[$i][0]."</td><td width=150>{$a[$i][1]}</td><td width=200>{$a[$i][2]}</td><td width=100 align=center ><font color=red>{$a[$i][4]}</font></td><td align=center width=200 align=left>".$a[$i][5]."</td></tr>";
							}
							else{
							$table.="<tr ><td width=45 align=center bgcolor=#eeeeee >".$u++.".</td><td width=60 align=center bgcolor=#eeeeee>".$a[$i][0]."</td><td width=150 bgcolor=#eeeeee>{$a[$i][1]}</td><td width=200 bgcolor=#eeeeee>{$a[$i][2]}</td><td width=100 align=center bgcolor=#eeeeee><font color=red>{$a[$i][4]}</font></td><td align=center width=200 align=left bgcolor=#eeeeee>".$a[$i][5]."</td></tr>";
							}
						}

$table.="</table>";


$pdf->writehtml($table);

$pdf->Output();
}
?>