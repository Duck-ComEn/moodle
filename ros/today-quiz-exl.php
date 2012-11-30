<?php
require_once('Connections/ros.php');
if(!isset($_SESSION)){
session_start();
}
	
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
header('Content-Disposition: attachment; filename="report-quiz-all.xls"');
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
					echo "<table>";
						echo"<table border=1>
						<caption align=top><b><font size=4>Report Recertification day:".$_GET['str']."</font></b></caption>
						<tr bgcolor=#cccccc><th>No.</th>
						<th>E/N</th><th>Name</th>
						<th>Attempt</th><th>Score</th>
						<th>Percent</th><th>Course Name</th>
						<th>Course Owner</th>
						<th>Supervisor Name</th>
						<th>Date</th></tr>";
						
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
			//			echo"<tr><td align=center>".($u++).".</td><td>{$data2['idnumber']}</td><td>".$data2['firstname'].' '.$data2['lastname']."</td><td>{$data2['subject']}</td><td>".$next_date."</td><td>expire</td><td>".ucwords($data2['institution'])."</td></tr>";
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
							echo"<tr><td align=center>".$u++.".</td><td>".$a[$i][0]."</td><td>{$a[$i][1]}</td><td align=center>{$a[$i][10]}</td><td align=center>".number_format($a[$i][4], 2, '.', ' ')."</td><td align=right>".number_format(($a[$i][4]*100)/$a[$i][9], 0, '.', ' ')."%</td><td>{$a[$i][2]}</td><td>{$a[$i][11]}</td><td>{$a[$i][5]}</td><td>".$a[$i][3]."</td></tr>";
							}
					
				
				}
				echo"</table>";
?>