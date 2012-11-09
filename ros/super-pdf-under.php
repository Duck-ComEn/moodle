<?php
require_once('Connections/file.php');
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
	}else return $wan." Days";
}
 

require("FPDF/ThaiPDF.class.php");
$pdf = new ThaiPDF();
$pdf->AddThaiFont("cordia");
$pdf->SetLeftMargin(60);
$pdf->AddPage();

$pdf->SetFont("cordia", '', 22);
$pdf->setx(55);
$pdf->write(11,"All Employee of K.".ucfirst($_SESSION['MM_FirstName']).' '.ucfirst($_SESSION['MM_LastName']));
$pdf->SetFont("cordia", '', 16);
$pdf->SetPageNo('left', 'Page: ', '/', 
 					'', 'I', '12');
$pdf->AddPageNo();


 

//mysql_connect('localhost','root','');
//mysql_select_db("moodle");
$result=mysql_query("SELECT
								mdl_user.idnumber,
								mdl_user.firstname,
								mdl_user.lastname
							FROM
								mdl_user
							WHERE
								mdl_user.institution = '".$_SESSION['MM_FirstName'].' '.$_SESSION['MM_LastName']."' ORDER BY
								mdl_user.idnumber ASC");
@$num_rows=mysql_num_rows($result);
if(!$num_rows){
echo "can not connect database";
}
$i=1;
$table="<br><br><br><table border=1>";
							$table.="<tr><td width=30 align=center bgcolor=#cccccc>No.</td><td width=60 align=center bgcolor=#cccccc>E/N</td><td width=150 bgcolor=#cccccc>FirstName</td><td width=150 bgcolor=#cccccc>LastName</td></tr>";
							while($data = mysql_fetch_array($result)){
								$table.="<tr>";
								$table.="<td width=30 align=center>".$i++.".</td><td width=60>".$data['idnumber']."</td><td width=150>{$data['firstname']}</td><td width=150>{$data['lastname']}</td>";
								$table.="</tr>";
							}
							$table.="</table>";


$pdf->writehtml($table);

$pdf->Output();
}
?>