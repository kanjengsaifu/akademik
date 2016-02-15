<?php

require_once("mysqlminang.php");
$p=new Mysqlminang("sister_siadu","localhost","root","");
//$lokasi = $_GET['lokasi'];

$sql="Select * from akad_kalender";
$data=array();
foreach($p->GetAllRows($sql) as $row)
{
	$data[]=array(
				'title'=>$row->nama,
				'start'=>$row->tgl1,
				'end'=>$row->tgl2,
			'lokasi'=>$row->lokasi,
				);
}
	echo json_encode($data);
?>