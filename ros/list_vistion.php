
      <?php
	require_once('Connections/ros.php'); 
	if(!isset($_SESSION)){
	@session_start();
	}
	switch($_SESSION['MM_UserRight']){
		case "admin" : 
		
      foreach($_POST['cd'] as $cd) {
	  if($cd[0]=='m'){
		$result1=mysql_query("SELECT
								ros_warn_notshow.id,
								ros_warn_notshow.atid,
								ros_warn_notshow.manual,
								ros_warn_notshow.`none`
						FROM
								ros_warn_notshow");
						@$num_rows1=mysql_num_rows($result1);
						$i=1;
						list($first) = split('&', $cd);
						if($first==''){
						$first=$cd;
						}
						$notshow[0]='bm';
						while($data=mysql_fetch_array($result1)){
						
						$notshow[$i]=$data['manual'];
						$i++;
						}
						

						if(@in_array(substr($first,1), $notshow)){
						
						$result=mysql_query("delete from ros_warn_notshow where manual=".substr($first,1));
						}else{
						$result=mysql_query("insert into ros_warn_notshow(manual) values(".substr($first,1).")");
						}
		

		}
		else {
			
			$result1=mysql_query("SELECT
								ros_warn_notshow.id,
								ros_warn_notshow.atid,
								ros_warn_notshow.manual,
								ros_warn_notshow.`none`
						FROM
								ros_warn_notshow");
						@$num_rows1=mysql_num_rows($result1);
						$i=1;
						while($data=mysql_fetch_array($result1)){
						if($data['atid']==0){
						continue;
						}
						$notshow[0]='bm';
						$notshow[$i]=$data['atid'];
						$i++;
						}
						if(@in_array($cd, $notshow)){
						$result=mysql_query("delete from ros_warn_notshow where atid=".$cd);
						}else{
						$result=mysql_query("insert into ros_warn_notshow(atid) values(".$cd.")");
						}
		}
	  echo "<meta http-equiv='refresh' content='0;URL=main-warn.php?sel_product=".$_SESSION['$viewbysup']."'>";
	  
	  
	  
	  
	  }
}

      ?>