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
$admin .='<h4 class="page-header">Administrasi Kegiatan Non Akademik</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_kegiatannon` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Kegiatan Non Akademik berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kegiatannon&mod=yes" />';    
	}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$sks 		= $_POST['sks'];
	$thnajar 		= $_POST['thnajar'];
	
	$error 	= '';	
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `akad_kegiatannon` SET `nama`='$nama' ,`sks`='$sks',`thnajar`='$thnajar' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kegiatannon&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `akad_kegiatannon` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
	$nama 		= $data['nama'];
	$sks 		= $data['sks'];
	$thnajar 		= $data['thnajar'];

$nama     		= !isset($nama) ? '' : $nama;
$sks     		= !isset($sks) ? '' : $sks;
$thnajar     		= !isset($thnajar) ? '' : $thnajar;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';

$admin .='<tr>
		<td>Nama Kegiatan</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>SKS</td>
		<td>:</td>
		<td><input type="text" name="sks" value="'.$sks.'" size="30" class="form-control"required></td>
	</tr>
	
	';
$admin .= '<tr>
	<td>Tahun Ajaran</td>
		<td>:</td>
	<td><select name="thnajar" class="form-control" id="thnajar"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tahunajaran ORDER BY tahunajaran asc");
$admin .= '<option value="">== Tahun Ajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$thnajar)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.getthnajar($datasj['replid']).'</option>';
}
$admin .='</select></td>
</tr>';
$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=kegiatannon&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';	
}

if($_GET['aksi']==""){
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$sks 		= $_POST['sks'];
	$thnajar 		= $_POST['thnajar'];
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_kegiatannon` VALUES ('','$nama','$sks','$thnajar')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($nama);
		unset($sks);
		unset($thnajar);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kegiatannon&mod=yes" />';  
	}

}
$nama     		= !isset($nama) ? '' : $nama;
$sks     		= !isset($sks) ? '' : $sks;
$thnajar     		= !isset($thnajar) ? '' : $thnajar;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';

$admin .='<tr>
		<td>Nama Kegiatan</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>SKS</td>
		<td>:</td>
		<td><input type="text" name="sks" value="'.$sks.'" size="30" class="form-control"required></td>
	</tr>
	
	';
$admin .= '<tr>
	<td>Tahun Ajaran</td>
		<td>:</td>
	<td><select name="thnajar" class="form-control" id="thnajar"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tahunajaran ORDER BY tahunajaran asc");
$admin .= '<option value="">== Tahun Ajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$thnajar)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.getthnajar($datasj['replid']).'</option>';
}
$admin .='</select></td>
</tr>';
$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=kegiatannon&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
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
            <th>Nama Kegiatan</th>
            <th>SKS</th>
            <th>Tahun Ajaran</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_kegiatannon" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$nama=$data['nama'];
$sks=$data['sks'];
$thnajar=$data['thnajar'];
$admin .='<tr>
<td>'.$nama.'</td>
<td>'.$sks.'</td>
<td>'.getthnajar($thnajar).'</td>
<td><a href="?pilih=kegiatannon&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=kegiatannon&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}
echo $admin;

?>