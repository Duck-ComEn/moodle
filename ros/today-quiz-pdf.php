<?php
require_once('Connections/file.php');
if(!isset($_SESSION)){
session_start();
}
	switch($_SESSION['MM_UserRight']){
		case "admin" || "superadmin" : 
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
 $strSelectDate=$_GET['str'];

require("FPDF/ThaiPDF.class.php");
$pdf = new ThaiPDF();
$pdf->AddThaiFont("cordia");
$pdf->AddPage();
$pdf->SetFont("cordia", '', 22);
$pdf->setx(60);
$pdf->writehtml("<b>Report Recertification day:$strSelectDate</b>");
$pdf->SetFont("cordia", '', 12);
$pdf->SetPageNo('left', 'Page: ', '/', 
 					'', 'I', '12');
$pdf->AddPageNo();




						if($_GET[sup]=='All' || $_GET[sup]==''){
						// notshow								
						$result1=mysql_query("SELECT
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
						
						
						$result=mysql_query("SELECT DISTINCT
						mdl_user.idnumber,
						mdl_user.firstname,
						mdl_user.lastname,
						mdl_quiz_attempts.attempt,
						mdl_course.fullname,
						mdl_course.idnumber AS courseid,
						mdl_quiz.sumgrades AS fullgrade,
						mdl_quiz_attempts.sumgrades,
						mdl_quiz_attempts.timefinish,
						mdl_quiz_attempts.id,
						mdl_user.institution,
						math_course_owner.courseowner
						from
						mdl_quiz_attempts ,
						mdl_user,
						mdl_course,
						mdl_quiz,
						math_course_owner
						where 
						mdl_quiz_attempts.userid=mdl_user.id and
						mdl_quiz_attempts.quiz=mdl_quiz.id and
						mdl_quiz.course=mdl_course.id and
						mdl_course.fullname=math_course_owner.course
						order by  mdl_user.idnumber,mdl_quiz_attempts.timefinish asc
						");
										
										
										
										
										
						
														
						
							}else {
							
							}
							
							
							@$num_rows=mysql_num_rows($result);
							if(!$num_rows){
						//	echo "can not connect database";
							}
							$p=1;
							$t=0;
							
							$i=0;
					while($data=mysql_fetch_array($result)){
					$a[$i][0]=$data['idnumber'];
					$a[$i][1]=$data['firstname'].' '.$data['lastname'];
					$a[$i][2]=$data['fullname'];
					$a[$i][3]=$data['timefinish'];
					$a[$i][4]=$data['sumgrades'];
					$a[$i][5]=$data['institution'];
					//$a[$i][8]=$data['shortname'];
					$a[$i][8]=$data['courseid'];
					$a[$i][9]=$data['fullgrade'];
					$a[$i][10]=$data['attempt'];
					$a[$i][11]=$data['courseowner'];
					
					$i++;
					}
					
					
					
					
					$u=1;
						//head table
						$table.="<br><br><br><table border=1><tr><td width=25 bgcolor=#cccccc align=center><b>No.</td><td width=45 bgcolor=#cccccc align=center>E/N</td><td width=140 bgcolor=#cccccc align=center>Name</td><td width=35 bgcolor=#cccccc align=center>Score</td><td width=45	 bgcolor=#cccccc align=center>Percent</td><td width=160 bgcolor=#cccccc align=center>Course Name</td><td width=140 bgcolor=#cccccc align=center>Course Owner</b></td><td width=140 bgcolor=#cccccc align=center>Supervisor Name</b></td><td width=60 bgcolor=#cccccc align=center>Date</b></td></tr>";

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
						
				//		$table.="<tr><td width=45 align=center>".($u++).".</td><td width=50 align=center>{$data1['idnumber']}</td><td>".$data1['firstname'].' '.$data1['lastname']."</td><td width=300>{$data1['fullname']}</td><td width=100 align=center>expire</td><td width=60 align=center>{$data1['remark']}</td></tr>";
						$i++;
						}
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
				//		$table.="<tr><td width=45 align=center>".($u++).".</td><td width=50 align=center>{$data2['idnumber']}</td><td>".$data2['firstname'].' '.$data2['lastname']."</td><td width=300>{$data2['subject']}</td><td width=100 align=center>expire</td><td width=60 align=center>{$data2['remark']}</td></tr>";
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
							
							//$nextyear  = mktime(0, 0, 0, $today['mon'],$today['mday'],   $today['year']+1);
							//$today = getdate($nextyear);
							if(strlen($today['mon'])<=1){
								$today['mon']='0'.$today['mon'];
							}
							if(strlen($today['mday'])<=1){
								$today['mday']='0'.$today['mday'];
							}
							$a[$i][3]=$today['mon'].'/'.$today['mday'].'/'.$today['year'];
							//$a[$i][4]=duration($today['year'].'-'.$today['mon'].'-'.$today['mday'] ."00:00:01",date("Y-m-d H:i:s"));
	
						

							if($_GET['str']==$a[$i][3]){
							//detail
							$table.="<tr><td width=25 align=center>".$u++.".</td><td width=45 align=right> ".$a[$i][0]."</td><td width=140>".$a[$i][1]."</td><td width=35 align=center>".number_format($a[$i][4], 0, '.', ' ')."</td><td width=45 align=right>".number_format(($a[$i][4]*100)/$a[$i][9], 0, '.', ' ')." % </td><td width=160 align=center>".$a[$i][2]."</td><td width=140>".$a[$i][11]."</td><td width=140>".$a[$i][5]."</td><td align=center width=60>".$a[$i][3]."</td></tr>";
							}
						}
//$table="<br><br><br><table border=1>";
//$table.="<tr><td width=58 bgcolor=#cccccc align=center>E/N</td><td width=200 bgcolor=#cccccc>Name</td><td width=330 bgcolor=#cccccc>Course</td><td width=80 bgcolor=#cccccc align=center>Time</td><td width=100 bgcolor=#cccccc align=center>Remain Time</td></tr>";
//for($j=0;$j<$t;$j++){
//$table.="<tr><td width=58>{$a[$j][0]}</td><td width=200>{$a[$j][1]}</td><td width=330>{$a[$j][2]}</td><td width=80 align=center>{$a[$j][3]}</td><td width=100 align=center>{$a[$j][4]}</td></tr>";
//}
$table.="</table>";


$pdf->writehtml($table);

$pdf->Output();
}
?>