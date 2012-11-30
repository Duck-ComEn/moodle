<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Benchmark Garde - Login</title>
	<link rel="shortcut icon" href="BEI_icon.ico" type="image/x-icon" />
	<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<form id="form1" name="form1" method="post" action="login.php">
	<div id="topheader">
	<div class="logo"></div>
	</div>
	<div id="search_strip"></div>
	
	<div id="body_area">
		<div class="left">
			
			<div class="left_menu_area">

			</div>
		</div>
		
	<div class="midarea">
		<div class="head">Welcome to EGO</div>
		<div class="body_textarea">
			<div align="justify">ระบบรายงานผลและตรวจสอบ Certification Online</div>
		</div>
		<div class="body_textarea">
		 <div class="login_area2">
			<div class="login_top2"></div>
			<div class="login_bodyarea2"><br>
				<div class="comment_head">
					<div align="center">Please Login </div>
				</div><br><br>
				<table align="center" width="400" border="0">
				<tr><td align="right"><div class="right_text">UserName :</div></td>
					<td align="left"><div class="right_textbox">				
					<label>
						<input name="name" id="name" type="text" class="righttextbox" value="" />
					</label>
					</div></td></tr>
				<tr><td align="right"><div class="right_text">Password :</div></td>
					<td align="left"><div class="right_textbox">
					<label>
						<input name="password" id="password" type="password" class="righttextbox" value="" />
					</label>
					</div></td></tr>
				<tr><td align="right"><div class="right_text">Levle :</div></td>
					<td align="left"><label>
					<select name="level" id="level" class="righttextbox">
						<option value="en">Employee</option>
						<option value="super">Supervisor</option>
						<option value="admin">Admin</option>
						<option value="superadmin">SuperAdmin</option>
                    </select>
					</label></td>
				<tr><td><center><div class="right_text"></td>
					<!-- <div align="center"><a href="login.php" class="login" type="submit">Login</a></div> -->
					<td>
					<input type="submit" width="100px" name="login" value=" Login " />
					
			</div></center></tr></td>
				</table>
			</div>
			<div class="login_bottom2"></div>
	    </div>
		</div>
	</div>	
	</div>
	
	<?php
	require_once('footer.php'); 
	?>
	
	</form>
</body>
</html>