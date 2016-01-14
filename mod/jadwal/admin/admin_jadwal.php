<?php
if (!defined('AURACMS_admin')) {
	Header("Location: ../index.php");
	exit;
}

//$index_hal = 1;
$admin = '';
if (!cek_login ()){   
	
$admin .='<p class="judul">Access Denied !!!!!!</p>';
}else{
$JS_SCRIPT= <<<js
<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
    $('#example').dataTable();
} );
</script>
js;

$script_include[] = $JS_SCRIPT;
$admin .='<h4 class="page-header">Administrasi Jadwal Pelajaran</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_jadwal` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Jadwal Pelajaran berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=jadwal&mod=yes" />';    
	}
}


if($_GET['aksi']==""){
	
/************************************/
/*******************/
$sql2 = "SELECT * FROM `akad_hari` order by id asc";
$query2 = mysql_query( $sql2 );

while ($data2 = mysql_fetch_array($query2)) { 
$nama = $data2['nama'];
$id = $data2['id'];
$namahari.='<td>'.$nama.'</td>';
$idhari.='<td>'.$id.'</td>';
}
/*********************/
$admin.='
<table class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr><td></td>
            '.$namahari.'
        </tr>
    </thead>';
	$jam=1;
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_jam" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$nama=$data['nama'];
$namajam=''.$nama.'';
$admin .='<tr><td>'.$namajam.'</td>'.$idhari.'
</tr>';
$jam++;
}
$admin .= '</tbody></table>';
}
/************************************/
}
echo $admin;

?>