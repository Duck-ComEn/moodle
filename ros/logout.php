<?php  	// กรณีที่คลิกเมนู "ออกจากระบบ" จะทำลายตัวแปร Session
//@session_start(); 
@session_destroy();
echo "<meta http-equiv='refresh' content='0;URL=index.php'>";  ?>