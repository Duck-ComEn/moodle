<?php
require_once('Connections/ros.php');
if(!isset($_SESSION)){
session_start();
}
		switch($_SESSION['MM_UserRight']){
		case "super"  : 
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
	}else return $wan;
}
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="report-warnning-all.xls"');
$_GET[sel_product]=$_SESSION['MM_FirstName'].' '.$_SESSION['MM_LastName'];
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
													WHERE
														mdl_user.institution = '".$_GET[sel_product]."' and
														ros_score.max = ros_score.added ".$not1."
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
						echo"<table border=1><tr><th>No.</th><th>E/N</th><th>Name</th><th>Course</th><th>Time</th><th>RemainTime</th><th>Supervisor</th></tr>";
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
						
			//			echo"<tr><td align=center>".($u++).".</td><td>{$data1['idnumber']}</td><td>".$data1['firstname'].' '.$data1['lastname']."</td><td>{$data1['fullname']}</td><td>".$q."</td><td>expire</td><td>".ucwords($data1['institution'])."</td></tr>";
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
				//		echo"<tr><td align=center>".($u++).".</td><td>{$data2['idnumber']}</td><td>".$data2['firstname'].' '.$data2['lastname']."</td><td>{$data2['subject']}</td><td>".$next_date."</td><td>expire</td><td>".ucwords($data2['institution'])."</td></tr>";
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
						if($a[$i][4]>14||$a[$i][4]=='expire'){
							continue;
						}
						if(@in_array($idat, $notshow3)){
							continue;
						}
							echo"<tr><td align=center>".$u++.".</td><td>".$a[$i][0]."</td><td>{$a[$i][1]}</td><td>{$a[$i][2]}</td><td>".$a[$i][3]."</td><td>{$a[$i][4]}</td><td>".ucwords($a[$i][5])."</td></tr>";
						}
					
				echo"</table>";
				}
?>