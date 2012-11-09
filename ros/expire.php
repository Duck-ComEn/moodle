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
		case "admin" : 
	?>
	<title>Benchmark Garde - Administrator::Home</title>
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
						if($_GET['id'][0]=='m'){
							$_SESSION['atid']=$_GET['id'];
							$fname=$_GET['fname'];
							$lname=$_GET['lname'];
							$subject=$_GET['subject'];
							}else {$result=mysql_query("SELECT
												mdl_user.idnumber,
												mdl_quiz_attempts.attempt,
												mdl_user.firstname,
												mdl_user.lastname,
												mdl_course.fullname,
												mdl_quiz_attempts.sumgrades,
												mdl_quiz_attempts.timefinish,
												mdl_quiz_attempts.id
											FROM
												mdl_quiz_attempts
											INNER JOIN mdl_user ON mdl_quiz_attempts.userid = mdl_user.id
											INNER JOIN mdl_quiz ON mdl_quiz_attempts.quiz = mdl_quiz.id
											INNER JOIN mdl_course ON mdl_quiz.course = mdl_course.id
											INNER JOIN mdl_quiz_grades ON mdl_quiz_grades.quiz = mdl_quiz.id AND mdl_quiz_grades.userid = mdl_user.id
											WHERE
												mdl_quiz_attempts.timefinish <> 0 AND
												mdl_user.idnumber <> '' AND
												mdl_course.visible = 1 AND
												mdl_quiz_grades.grade = mdl_quiz.grade AND
												mdl_quiz_attempts.id =".$_GET['id']);
						
							
	
							@$num_rows=mysql_num_rows($result);
							if(!$num_rows){
							echo "can not connect database";
							}
							$rowLogin = mysql_fetch_array($result);
							$_SESSION['atid']=$rowLogin['id'];
							$fname=$rowLogin['firstname'];
							$lname=$rowLogin['lastname'];
							$subject=$rowLogin['fullname'];
							}
						?>
						</div>
			</div>
		</div>
		
		<div class="midarea">
			<div class="head">Welcome <?php echo ucfirst($_SESSION['MM_FirstName']).' '.ucfirst($_SESSION['MM_LastName']) ;?></div>
			<div class="body_textarea">
				<div align="justify">
				  <h2>หมายเหตุการหมดอายุ</h2>
				  <p>&nbsp;</p>
				  <form id="form1" name="form1" method="POST" action="remark-expire.php">
				    <table width="435" border="0">
                      <tr>
                        <td><div align="right">ชื่อ :</div></td>
                        <td><?php echo $fname.' '.$lname; ?></td>
                      </tr>
                      <tr>
                        <td><div align="right">วิชา :</div></td>
                        <td><?php echo $subject; ?></td>
                      </tr>
                      <tr>
                        <td><div align="right">หมายเหตุ :</div></td>
                        <td><label>
                          <select name="remark" id="remark">
                            <option value="D1">D1</option>
                            <option value="D2">D2</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="D5">D5</option>
                            <option value="D6">D6</option>
                            <option value="D7">D7</option>
                            <option value="D8">D8</option>
                                </select>
                        </label></td>
                      </tr>
                      <tr>
                        <td><div align="right">วันที่ :</div></td>
                        <td><link rel="stylesheet" type="text/css" href="jquery-ui-1.7.2.custom/css/smoothness/jquery-ui-1.7.2.custom.css">
							<script type="text/javascript" src="jquery-ui-1.7.2.custom/js/jquery-1.3.2.min.js"></script>
							<script type="text/javascript" src="jquery-ui-1.7.2.custom/js/jquery-ui-1.7.2.custom.min.js"></script>
							<script type="text/javascript">
							$(function(){
	
							$("#dateInput").datepicker();
							});
							</script>
<input type="text" name="dateInput" id="dateInput" />  </td>
                      </tr>
                      <tr>
                        <td width="135">&nbsp;</td>
<td width="290"><label>
  <input type="submit" name="submit" id="submit" value="Submit" />
</label></td>
</tr>
                    </table>
         </form>         
                  
				  <p>&nbsp;</p>
	  <p>&nbsp;</p>
			  </div>
			</div>
            <!-- remark detail-->
			<?php
			
				require_once('remark_detail.php');
			?>
		</div>
	</div>
	<?php
	require_once('footer.php'); 
	?>
	
</body>	
</html>
<?php
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>