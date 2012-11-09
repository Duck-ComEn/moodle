<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ros = "localhost";
$database_ros = "moodle";
$username_ros = "root";
$password_ros = "";
$ros = mysql_pconnect($hostname_ros, $username_ros, $password_ros) or trigger_error(mysql_error(),E_USER_ERROR); 
?>