<?php

if (!defined('AURACMS_admin')) {
    Header("Location: ../index.php");
    exit;
}

if (!cek_login()){
    header("location: index.php");
    exit;
} else{
$JS_SCRIPT.= <<<js
<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
    $('#example').dataTable();
} );

</script>
js;
$script_include[] = $JS_SCRIPT;	
//$index_hal=1;	
$admin .= '<script type="text/javascript" language="javascript">
   function GP_popupConfirmMsg(msg) { //v1.0
  document.MM_returnValue = confirm(msg);
}
</script>';
$admin  .='<legend>SETTING DEFAULT</legend>';

######################################
# Edit User
######################################
if ($_GET['aksi'] == ''){
if(isset($_POST['submit'])){
	$tahunajaranaktif 		= $_POST['tahunajaranaktif'];
	$semesteraktif 		= $_POST['semesteraktif'];
	
	$error 	= '';	
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `akad_setting` SET `tahunajaranaktif`='$tahunajaranaktif' ,`semesteraktif`='$semesteraktif'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
	//		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=setting&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
	
$id = int_filter($_GET['id']);
$s = mysql_query ("SELECT * FROM `akad_setting`");	
$data = mysql_fetch_array($s);
$semesteraktif = $data['semesteraktif'];	
$tahunajaranaktif = $data['tahunajaranaktif'];	

	
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Edit User</h3></div>';

$admin .= '<form method="post" action="">
<table class="table table-striped">
';
$admin .= '<tr>
	<td>Tahun Ajaran Aktif</td>
		<td>:</td>
	<td><select name="tahunajaranaktif" class="form-control" id="tahunajaranaktif"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tahunajaran ORDER BY tahunajaran asc");
$admin .= '<option value="">== Tahun Ajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tahunajaranaktif)?"selected":'';
				$aktif = ($datasj['replid']==$tahunajaranaktif)?"(Aktif)":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tahunajaran'].' '.$aktif.'</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>Semester Aktif</td>
		<td>:</td>
	<td><select name="semesteraktif" class="form-control" id="semesteraktif"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_semester ORDER BY id asc");
$admin .= '<option value="">== Semester ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['id']==$semesteraktif)?"selected":'';
				$aktif = ($datasj['id']==$semesteraktif)?"(Aktif)":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihan.'>'.$datasj['nama'].' '.$aktif.'</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>&nbsp;</td>
    <td><input type="submit" value="Simpan" name="submit" class="btn btn-success"></td>
  </tr>
</table></form>';
$admin .= '</div>';
}


}

echo $admin;

?>