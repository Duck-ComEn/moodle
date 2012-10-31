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
	<script language="javascript">
	function fncAlert(name)
	{
	alert('หัวหน้างานของพนักงานคนนี้คือ : คุณ '+name);
	}
	</script>
	<link type="text/css" href="jquery-ui-1.7.2.custom/css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="jquery-ui-1.7.2.custom/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="jquery-ui-1.7.2.custom/js/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });
	
				// Tabs
				$('#tabs').tabs();
	

				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
		</script>
		<style type="text/css">
			/*demo page css*/
			body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 50px;}
			.demoHeaders { margin-top: 2em; }
			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
		</style>	
	<?php
		switch($_SESSION['MM_UserRight']){
		case "superadmin" : 
	?>
	<title>Benchmark Garde - SuperAdministrator::แจ้งเตือน 14 วัน</title>
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
			<div class="head">Welcome <?php print ucfirst($_SESSION['MM_FirstName']).' '.ucfirst($_SESSION['MM_LastName']) ;?></div>
			<div class="body_textarea">
				<div align="justify" style="font-size: 16pt">แจ้งเตือนเหลืออีก 14 วันวิชาสอบหมดอายุ</div>
				<div align="justify">
				  <p>แสดงรายชื่อพนักงานทั้งหมดที่มีอยู่ในฐานข้อมูล</p>
				  <p>&nbsp;</p>
				  <form id="form1" name="form1" method="get" action="super_admin-warn-14day.php">
				                    <strong>แสดงเฉพาะ Supervisor</strong>
						<label><?php
												$sql = "SELECT DISTINCT
														mdl_user.institution
														FROM
														mdl_user
														WHERE
														mdl_user.institution <> ''
														ORDER BY
														mdl_user.institution ASC";
														$query = mysql_query($sql);
														echo "<select id='sel_product' name='sel_product'>";
														echo "<option>All</option>";
														while($rs = mysql_fetch_array($query)){
														$data = $rs['0'];
														echo "<option>$data</option>";
														}
														echo "</select>"; 
						?></label>
						<label>
							<input type="submit" name="Query" value=" Query " />
						</label>
				  </form>
			    </div>
			</div>
			<div class="body_textarea">
			<?php
	  echo "<center><div class=sending>";
		

			$i=0;
			$p=0;
			$r=0;
			list($firstname, $lastname) = split(' ', $_GET['mail']);
			if($_GET['mail']=='' || $_GET['mail']=='All'){
			$result=mysql_query("SELECT
										ros_user_admin.firstname,
										ros_user_admin.lastname,
										ros_user_admin.email
								FROM
										ros_user_admin
								WHERE
										ros_user_admin.user_right = 'super'");
			while($value=mysql_fetch_array($result)){
			$array_mail[$i++]=$value['email'];
			$array_name[$p++]=$value['firstname'].' '.$value['lastname'];
			$gen=getdate();
			$enscri='mail-link-14.php?id='.md5($gen[0].'BenchMark Electronic.'.$i);
			$result1=mysql_query("insert into ros_mail(link,sup,time) values('".$enscri."','".$value['firstname'].' '.$value['lastname']."',".$gen[0].")");
			$enscri1[$r++]='mail-link-14.php?id='.md5($gen[0].'BenchMark Electronic.'.$i);
			}
			
			
			
			$n=0;
			$m=0;
			$t=0;
			$mm=0;
			$nn=0;
			$numrows=mysql_num_rows($result);
			while($n<$numrows){
			$to = $array_mail[$n++];
			$subject = 'Auto mail Alert Certificate from Traning';
			$message = "<img src=".$ipserver_path."images/search_strip.jpg><h3>เรียน คุณ ".ucwords($array_name[$m++])."</h3><br>".$messagefile.'<br>';
			$message.="<br><a href=".$ipserver_path.$enscri1[$t++].">click</a><img src=".$ipserver_path."images/Excel2007Logo.png height=50 width=50>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=".$ipserver_path."><img src=".$ipserver_path."images/registration.png height=50 width=50></a>";
			$header = "From: ".$mailsender."\r\n";
			$header .="MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html; charset=UTF-8\r\n" ;
  
			if( @mail( $to , $subject , $message , $header ) ){
				echo "<font color=green>Mail Complete </font>to ".ucwords($array_name[$mm++])."<br>";
				echo "<meta http-equiv='refresh' content=5;URL=super_admin-warn-14day.php>";
			}else{
				echo "<font color=red>Mail Incomplete</font> to ".ucwords($array_name[$mm++])."<br>";
				echo "<meta http-equiv='refresh' content=5;URL=super_admin-warn-14day.php>";
			}
			}
		
			
			}
			else{
			$result=mysql_query("SELECT DISTINCT
										ros_user_admin.firstname,
										ros_user_admin.lastname,
										ros_user_admin.email
								FROM
										ros_user_admin
								WHERE
										ros_user_admin.firstname = '".$firstname."' AND
										ros_user_admin.lastname ='".$lastname."'");
			
										
			$mail=mysql_fetch_array($result);
			$gen=getdate();
			$enscri='mail-link-14.php?id='.md5($gen[0].'BenchMark Electronic.');
			//echo $enscri;
			$result1=mysql_query("insert into ros_mail(link,sup,time) values('".$enscri."','".$firstname.' '.$lastname."',".$gen[0].")");
$to = $mail['email'];
$subject = 'Auto Mail Alert Certificate from Traning';
$message = "<img src=".$ipserver_path."images/search_strip.jpg><h3>เรียน คุณ ".ucfirst($firstname).' '.ucfirst($lastname)."</h3><br>".$messagefile.'<br>';
$message.="<br><a href=".$ipserver_path.$enscri.">click</a><img src=".$ipserver_path."images/Excel2007Logo.png height=50 width=50>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=".$ipserver_path."><img src=".$ipserver_path."images/registration.png height=50 width=50></a>";
$header = "From: ".$mailsender."\r\n";
$header .="Cc:nuttawut_to33@hotmail.com"."\r\n";
$header .="MIME-Version: 1.0\r\n";
$header .="Content-type: text/html; charset=UTF-8\r\n" ;
  
			if( @mail( $to , $subject , $message , $header ) ){
				echo "<font color=green>Mail Complete </font>to ".ucwords($firstname." ".$lastname)."<br>";
				echo "<meta http-equiv='refresh' content=5;URL=super_admin-warn-14day.php>";
			}else{
				echo "<font color=red>Mail Incomplete</font> to ".ucwords($firstname." ".$lastname)."<br>";
				echo "<meta http-equiv='refresh' content=5;URL=super_admin-warn-14day.php>";
			}
			}
			
			//echo $mail['email'];
			//echo $mail['email'].'55555555';
			//echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			//echo "<script language='javascript'>alert('ส่ง E-mail ถึง supervisor เรียบร้อยแล้ว');</script>";
			//echo "<meta http-equiv='refresh' content='0;URL=mail.php'>";
	
	
echo"</div>";
echo "</div>";
?>

<?php
	break ;
	default : echo"<center><h2>หน้านี้อนุญาติให้ผู้ดูแลระบบเข้าใช้เท่านั้น</h2></center><bt><br>";
	echo"<center><h4>ระบบจะพาท่านกลับสู่หน้าหลัก ภายใน 3 วินาที</h4></center>";
	echo "<meta http-equiv='refresh' content=3;URL=index.php>";
	break ; }
?>
		
		</div>
	</div>

	<!-- Fotter area-->
	<?php
		require_once('footer.php'); 
	?>
</html>

	