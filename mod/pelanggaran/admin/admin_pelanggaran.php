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
$admin .='<h4 class="page-header">Administrasi Pelanggaran</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_pelanggaran` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Pelanggaran berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=pelanggaran&mod=yes" />';    
	}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$point 		= $_POST['point'];
	$hukuman 		= $_POST['hukuman'];

	$error 	= '';	
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `akad_pelanggaran` SET `nama`='$nama' ,`point`='$point',`hukuman`='$hukuman' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=pelanggaran&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `akad_pelanggaran` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
	$nama 		= $data['nama'];
	$point 		= $data['point'];	
	$hukuman 		= $data['hukuman'];	
$nama     		= !isset($nama) ? '' : $nama;
$point     		= !isset($point) ? '' : $point;
$hukuman     		= !isset($hukuman) ? '' : $hukuman;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .='<tr>
		<td>Nama Pelanggaran</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Point</td>
		<td>:</td>
		<td><input type="text" name="point" value="'.$point.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Hukuman</td>
		<td>:</td>
		<td><input type="text" name="hukuman" value="'.$hukuman.'" size="30" class="form-control"required></td>
	</tr>';

$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success"></td>
	</tr>
</table>
</form></div>
';	
}

if($_GET['aksi']==""){
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$point 		= $_POST['point'];
	$hukuman 		= $_POST['hukuman'];	
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_pelanggaran` VALUES ('','$nama','$point','$hukuman')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($nama);
		unset($point);
		unset($hukuman);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=pelanggaran&mod=yes" />';  
	}

}
$nama     		= !isset($nama) ? '' : $nama;
$point     		= !isset($point) ? '' : $point;
$hukuman     		= !isset($hukuman) ? '' : $hukuman;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .='<tr>
		<td>Nama Pelanggaran</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Point</td>
		<td>:</td>
		<td><input type="text" name="point" value="'.$point.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Hukuman</td>
		<td>:</td>
		<td><input type="text" name="hukuman" value="'.$hukuman.'" size="30" class="form-control"required></td>
	</tr>';

$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success"></td>
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
            <th>Nama Pelanggaran</th>
            <th>Point</th>
            <th>Hukuman</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_pelanggaran" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$nama=$data['nama'];
$point=$data['point'];
$hukuman=$data['hukuman'];
$admin .='<tr>
<td>'.$nama.'</td>
<td>'.$point.'</td>
<td>'.$hukuman.'</td>
<td><a href="?pilih=pelanggaran&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=pelanggaran&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}
echo $admin;

?>