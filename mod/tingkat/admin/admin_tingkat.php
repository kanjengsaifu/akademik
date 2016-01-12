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
$admin .='<h4 class="page-header">Administrasi Tingkat</h4>';
$admin  .= '<div class="border2">
<table  ><tr align="center">
<td>
<a href="admin.php?pilih=jenjang&mod=yes">Jenjang</a>&nbsp;&nbsp;-&nbsp;&nbsp;
</td>
<td>
<a href="admin.php?pilih=tingkat&mod=yes">Tingkat</a>&nbsp;&nbsp;
</td>
</tr></table>
</div>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
		$error 	= 'Error terdapat FK';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
	$hasil = $koneksi_db->sql_query("DELETE FROM `aka_subtingkat` WHERE `replid`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Tingkat berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=tingkat&mod=yes" />';    
	}
}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
$tingkat=$_POST['tingkat'];
$subtingkat=$_POST['subtingkat'];
$keterangan=$_POST['keterangan'];
	
	$error 	= '';	
if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT tingkat,subtingkat FROM aka_subtingkat WHERE tingkat='$tingkat' and subtingkat='$subtingkat' ")) > 1) $error .= "Error: Kode ".$kode." sudah terdaftar , silahkan ulangi.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `aka_subtingkat` SET `tingkat`='$tingkat' ,`subtingkat`='$subtingkat',`keterangan`='$keterangan' WHERE `replid`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=tingkat&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `aka_subtingkat` WHERE `replid`='$id'");
$data 		= mysql_fetch_array($query);
	$tingkat 		= $data['tingkat'];
	$subtingkat 		= $data['subtingkat'];
	$keterangan 		= $data['keterangan'];

$tingkat     		= !isset($tingkat) ? '' : $tingkat;
$subtingkat     		= !isset($subtingkat) ? '' : $subtingkat;
$keterangan     		= !isset($keterangan) ? '' : $keterangan;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .= '<tr>
	<td>Jenjang</td>
		<td>:</td>
	<td><select name="tingkat" class="form-control" id="tingkat"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tingkat ORDER BY urutan asc");
$admin .= '<option value="">== Jenjang ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tingkat)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tingkat'].'</option>';
}
$admin .='</select></td>
</tr>';
$admin .='<tr>
		<td>Tingkat</td>
		<td>:</td>
		<td><input type="text" name="subtingkat" value="'.$subtingkat.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:</td>
		<td><input type="text" name="keterangan" value="'.$keterangan.'" size="30" class="form-control"required></td>
	</tr>';
$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=jenjang&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';			
}

if($_GET['aksi']==""){
if(isset($_POST['submit'])){
$tingkat=$_POST['tingkat'];
$subtingkat=$_POST['subtingkat'];
$keterangan=$_POST['keterangan'];
	$error 	= '';	
if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT tingkat,subtingkat FROM aka_subtingkat WHERE tingkat='$tingkat' and subtingkat='$subtingkat' ")) > 0) $error .= "Error: Kode ".$kode." sudah terdaftar , silahkan ulangi.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `aka_subtingkat` VALUES ('','$subtingkat','$tingkat','$keterangan')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($tingkat);
		unset($subtingkat);
		unset($keterangan);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=tingkat&mod=yes" />';  
	}

}
$tingkat     		= !isset($tingkat) ? '' : $tingkat;
$subtingkat     		= !isset($subtingkat) ? '' : $subtingkat;
$keterangan     		= !isset($keterangan) ? '' : $keterangan;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .= '<tr>
	<td>Jenjang</td>
		<td>:</td>
	<td><select name="tingkat" class="form-control" id="tingkat"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tingkat ORDER BY urutan asc");
$admin .= '<option value="">== Jenjang ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tingkat)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tingkat'].'</option>';
}
$admin .='</select></td>
</tr>';
$admin .='<tr>
		<td>Tingkat</td>
		<td>:</td>
		<td><input type="text" name="subtingkat" value="'.$subtingkat.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:</td>
		<td><input type="text" name="keterangan" value="'.$keterangan.'" size="30" class="form-control"required></td>
	</tr>';
$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=jenjang&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';	
}

/************************************/
$admin.='
<table id="example"class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Jenjang</th>
            <th>Tingkat</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM aka_subtingkat order by tingkat asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$tingkat=$data['tingkat'];
$subtingkat=$data['subtingkat'];
$keterangan=$data['keterangan'];
$admin .='<tr>
<td>'.getfieldtabel('tingkat','aka_tingkat','replid',$tingkat).'</td>
<td>'.$subtingkat.'</td>
<td>'.$keterangan.'</td>
<td><a href="?pilih=tingkat&amp;mod=yes&amp;aksi=del&amp;id='.$data['replid'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=tingkat&amp;mod=yes&amp;aksi=edit&amp;id='.$data['replid'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}
echo $admin;

?>