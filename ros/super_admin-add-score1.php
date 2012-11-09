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
		case "superadmin" : 
	?>
	<title>Benchmark Garde - Administrator::เพิ่มคะแนนรายบุคคล</title>
	<link rel="shortcut icon" href="BEI_icon.ico" type="image/x-icon" />
	<link rel="icon" href="BEI_icon.ico" type="image/x-icon" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link href="styles_table.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
<!--
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
    </style>
    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
			<div class="head">Welcome <?php echo ucfirst($_SESSION['MM_FirstName']).' '.ucfirst($_SESSION['MM_LastName']) ;?></div>
			<div class="body_textarea">
				<div align="justify">
				  <h2>เพิ่มคะแนนเป็นรายบุคคล</h2>
				  <p>&nbsp;</p>
				  <form id="form1" name="form1" method="POST" action="">
				    <table width="300" border="0">
                      <tr>
                        <th><div align="center" class="style2">รายละเอียดพนักงาน</div></th>
                        <th><div align="center" class="style2">รายละเอียดผลการสอบ</div></th>
                      </tr>
                      <tr>
                        <td><table width="332" border="0">
                          <tr>
                            <td width="91" height="35"><div align="right">รหัสพนักงาน:</div></td>
                            <td width="252"><?php echo $_SESSION['idnumber'];?> </td>
                          </tr>
                          <tr>
                            <td height="35"><div align="right">ชื่อ:</div></td>
                            <td><?php echo $_SESSION['name'];?></td>
                          </tr>
                          <tr>
                            <td height="35"><div align="right">นามสกุล:</div></td>
                            <td><?php echo $_SESSION['lastname'];?></td>
                          </tr>
                          <tr>
                            <td height="35"><div align="right">แผนก:</div></td>
                            <td><?php echo strtoupper($_SESSION['department']);?></td>
                          </tr>
                          <tr>
                            <td height="35"><div align="right">หัวหน้างาน:</div></td>
                            <td><?php echo ucwords($_SESSION['super']);?></td>
                          </tr>
                          <tr>
                            <td height="35"><div align="right">สาขา:</div></td>
                            <td><?php echo ucwords($_SESSION['city']);?></td>
                          </tr>
                        </table></td>
                        <td><table width="332" border="0">
                          <tr>
                            <td width="120" height="35"><div align="right">ชื่อวิชา:</div></td>
                            <td width="202"><label><?php
												$sql = "SELECT
															ros_subject.`code`,
															ros_subject.`name`
														FROM ros_subject
														WHERE ros_subject.vision = 1
														ORDER BY ros_subject.`name` ASC";
														$query = mysql_query($sql);
														echo "<select id='subject' name='subject'>";
														while($rs = mysql_fetch_array($query)){
														$data = $rs['1'];
														$hid = $rs['2'];
														echo "<option>$data</option>";
														}
														echo "</select>"; 
														$thisdate=getdate();
											?></label></td>
                          </tr>
                          <tr>
                            <td height="35"><div align="right">วันที่สอบ:</div></td>
                            <td>
                      
                            <link rel="stylesheet" type="text/css" href="jquery-ui-1.7.2.custom/css/smoothness/jquery-ui-1.7.2.custom.css" />
                                <script type="text/javascript" src="jquery-ui-1.7.2.custom/js/jquery-1.3.2.min.js"></script>
                                <script type="text/javascript" src="jquery-ui-1.7.2.custom/js/jquery-ui-1.7.2.custom.min.js"></script>
                                <script type="text/javascript">
							$(function(){
	
							$("#dateInput").datepicker();
							});
							</script>
                                <span id="sprytextfield6">
                                <input type="text" name="dateInput" id="dateInput" value="<?php echo $thisdate['mon'].'/'.$thisdate['mday'].'/'.$thisdate['year']; ?><?php echo $date;?>" />
                                <br />
                                <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
                          </tr>
                          <tr>
                            <td height="35"><div align="right">คะแนนเต็ม:</div></td>
                            <td><span id="sprytextfield3">
                            <label>
                            <input type="text" name="max" id="max" />
                            </label>
                            <br /><span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
                          </tr>
                          <tr>
                            <td height="35"><div align="right">ครั้งที่1:</div></td>
                            <td><span id="sprytextfield2">
                            <label>
                            <input type="text" name="1" id="1" />
                            </label>
                            <br /><span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
                          </tr>
                          <tr>
                            <td height="35"><div align="right">ครั้งที่2:</div></td>
                            <td><span id="sprytextfield4">
                            <label>
                            <input type="text" name="2" id="2" />
                            </label>
                            <br /><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
                          </tr>
                          <tr>
                            <td height="35"><div align="right">ครั้งที่3:</div></td>
                            <td><span id="sprytextfield5">
                            <label>
                            <input type="text" name="3" id="3" />
                            </label>
                            <br /><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td colspan="2"><label>
                          <div align="center">
                            <input type="submit" name="add" id="add" value="เพิ่มผลการสอบ" />
                          </div>
                        </label>
                          <label>
                          <div align="center"></div>
                        </label></td>
                      </tr>
                      <tr>
                        <td colspan="2"><div align="center">
                          <label></label>
                          <div align="left">
                            <?php
				$result2=mysql_query("SELECT
											ros_score.`subject`,
											ros_score.time1,
											ros_score.time2,
											ros_score.time3,
											ros_score.date_time,
											ros_score.next_date,
											ros_score.max,
											ros_score.id
									FROM
											ros_score
									INNER JOIN mdl_user ON ros_score.uid = mdl_user.id
									WHERE
											mdl_user.idnumber ='".$_SESSION['idnumber']."' ORDER BY
											ros_score.`subject` ASC");
											@$num_rows=mysql_num_rows($result2);
											if($num_rows<=0){
													echo "No, score from added manual score";
											}else{
											echo"<table>";
											echo"<tr><th width=350><div align=center class=style3>Subject</div></th><th width=30><div align=center class=style3>1</div></th><th width=30><div align=center class=style3>2</div></th><th width=30><div align=center class=style3>3</div></th><th width=50><div align=center class=style3>Date</div></th><th width=50><div align=center class=style3>Delete</div></th></tr>";
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
										//echo"<tr><td>{$data['subject']}</td><td align=center>".round(($data['time1']/$data['max']),2)*100 ."%</td><td align=center>".round(($data['time2']/$data['max']),2)*100 ."%</td><td align=center>".round(($data['time3']/$data['max']),2)*100 ."%</td><td align=center>{$day1}</td><td align=center><a href=\"del-score.php?id={$data['id']}\">Delete</a></td></tr>";
										echo"<tr><td>".$data['subject']."</td><td align=center>";if($data['time1']=='0'){ echo "-";}else {echo round(($data['time1']/$data['max']),2)*100 .'%';} echo"</td><td align=center>";if($data['time2']=='0'){ echo "-";}else {echo round(($data['time2']/$data['max']),2)*100 .'%';} echo"</td><td align=center>";if($data['time3']=='0'){ echo "-";}else {echo round(($data['time3']/$data['max']),2)*100 .'%';} echo"</td><td align=center>{$day1}</td><td align=center><a href=\"del-score.php?id={$data['id']}\">Delete</a></td></tr>";
										}echo"</table>";
										}
				  
				   if($_POST['add']){
				$date = $_POST['dateInput'];
				list($month, $day, $year) = split('[/.-]', $date);
			//	echo "Month: $month; Day: $day; Year: $year<br />\n";
							$years=mktime(0, 0, 0, $month,$day,$year);
							$next=mktime(0, 0, 0, $month,$day,$year+1);
							$max=max($_POST['1'],$_POST['2'],$_POST['3']);
			$result=mysql_query("insert into ros_score(uid,subject,time1,time2,time3,max,date_time,next_date,added) values('".$_SESSION['id']."','".$_POST['subject']."','".$_POST['1']."','".$_POST['2']."','".$_POST['3']."','".$_POST['max']."','".$years."','".$next."',".$max.")");
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
  	  		echo "<script language='javascript'>alert('เพิ่มคะแนนเสร็จเรียบร้อยแล้ว');</script>";
			echo "<meta http-equiv='refresh' content='0;URL=add-score.php'>";
			          }
				

				  ?>
                            </div>
                        </div></td>
                      </tr>
                    </table>
				  </form>
				   
				  <p>&nbsp;</p>
	  <p>&nbsp;</p>
			  </div>
			</div>
		</div>
	</div>
	<?php
	require_once('footer.php'); 
	?>
	
    <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {validateOn:["blur"], hint:"MM/DD/YYYY", format:"mm/dd/yyyy"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {isRequired:false, validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "integer", {validateOn:["blur"], isRequired:false});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "date", {hint:"MM/DD/YYYY", format:"mm/dd/yyyy", validateOn:["blur"]});
//-->
</script>
</body>	
</html>
<?php
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>