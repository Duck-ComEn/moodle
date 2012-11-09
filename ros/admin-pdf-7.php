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
													ros_score.max = ros_score.added AND
													ros_subject.vision = 1
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
											where mdl_course.visible = 1");
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
												INNER JOIN ros_warn_notshow ON mdl_quiz_attempts.id = ros_warn_notshow.atid");
												
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
											ORDER BY 7");
											
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
												INNER JOIN ros_warn_notshow ON ros_warn_notshow.manual = ros_score.id");
														
														
														
							}else {
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
													mdl_user.institution = '".$_GET[sup]."'");
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
													mdl_user.institution = '".$_GET[sup]."'");
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
													mdl_user.institution = '".$_GET[sup]."'
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
													mdl_user.institution = '".$_GET[sup]."' AND
													ros_score.max = ros_score.added AND
													ros_subject.vision = 1
													".$not1."
										ORDER BY 7
");
						
						
										
						
						
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
												mdl_user.institution = '".$_GET[sup]."' and
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
														mdl_user.institution = '".$_GET[sup]."'");
												
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
												mdl_user.institution = '".$_GET[sup]."'");
											
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
														mdl_user.institution = '".$_GET[sup]."'");
						
						
						
						
						
							}
							
							
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
						$table.="<br><br><br><table border=1><tr><td width=45 bgcolor=#cccccc align=center>No.</td><td width=50 bgcolor=#cccccc align=center>E/N</td><td width=200 bgcolor=#cccccc align=center>Name</td><td width=300 bgcolor=#cccccc align=center>Course</td><td width=100 bgcolor=#cccccc align=center>Remain Time</td><td width=60 bgcolor=#cccccc align=center>Remark</td></tr>";
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
	
						if($a[$i][4]>7||$a[$i][4]=='expire'){
							continue;
						}
	
							if(@in_array($idat, $notshow3)){
							continue;
							}
							$table.="<tr><td width=45 align=center>".$u++.".</td><td width=50 align=center>".$a[$i][0]."</td><td>{$a[$i][1]}</td><td width=300>{$a[$i][2]}</td><td width=100 align=center>{$a[$i][4]}</td><td align=center width=60>-</td></tr>";
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