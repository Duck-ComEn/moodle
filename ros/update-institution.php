<html>
<body background=#7FD4FF>
<?php
require_once('Connections/ros.php');
echo "step 1 delete old database<br>";
//delete database ros_user_admin
$sql = "DELETE FROM ros_user_admin
        WHERE ros_user_admin.user_right='super'";

$retval = mysql_query($sql)or die (mysql_error());
if(! $retval )
{
  die('Could not delete data: ' . mysql_error());
}
else{
echo "Deleted data successfully\n";
}

echo "<br><br>step 2 update database<br>";

//select last id_number (primarykey)
$sql2="select id from ros_user_admin";
$res=mysql_query($sql2)or die(mysql_error());
$i=mysql_num_rows($res);




$str="SELECT				DISTINCT
						mdl_user.institution
						FROM
							mdl_user
				";
$result=mysql_query($str);
while($data = mysql_fetch_array($result)){
	$t=explode(' ',$data[0]);
	$str2="INSERT INTO ros_user_admin(id,firstname,lastname,username,password,email,user_right)
	VALUES(".++$i.",'".$t[0]."','".$t[1]."','".$t[0]."','e10adc3949ba59abbe56e057f20f883e','".$t[0].".".$t[1]."@bench.com','super') ";
	mysql_query($str2)or die(mysql_error());

}
echo "Complete<br>";
echo "<a href=http://krt-lms/moodle/ros/>goto home page</a>";

?>
</body>
</html>