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
$admin .='<h4 class="page-header">Administrasi Tahun Ajaran</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
		$error 	= 'Error terdapat FK';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
	$hasil = $koneksi_db->sql_query("DELETE FROM `aka_tahunajaran` WHERE `replid`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Tahun Ajaran berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=tahunajaran&mod=yes" />';    
	}
}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
$keterangan=$_POST['keterangan'];
$tahunajaran=$_POST['tahunajaran'];
	$error 	= '';	
		if (cekkodesama('tahunajaran','aka_tahunajaran',$tahunajaran) > 1) $error .= "Error: Tahun Ajaran ".$tahunajaran." sudah terdaftar , silahkan ulangi.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `aka_tahunajaran` SET `keterangan`='$keterangan',`tahunajaran`='$tahunajaran' WHERE `replid`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=tahunajaran&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `aka_tahunajaran` WHERE `replid`='$id'");
$data 		= mysql_fetch_array($query);
$keterangan 		= $data['keterangan'];
$tahunajaran 		= $data['tahunajaran'];

$tahunajaran     		= !isset($tahunajaran) ? '' : $tahunajaran;
$keterangan     		= !isset($keterangan) ? '' : $keterangan;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .='<tr>
		<td>Tahun Ajaran</td>
		<td>:</td>
		<td><input type="text" name="tahunajaran" value="'.$tahunajaran.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:</td>
		<td><input type="text" name="keterangan" value="'.$keterangan.'" size="30" class="form-control"></td>
	</tr>';
$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=tahunajaran&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';	
}

if($_GET['aksi']==""){
if(isset($_POST['submit'])){
$tahunajaran=$_POST['tahunajaran'];
$keterangan=$_POST['keterangan'];
	$error 	= '';	
		if (cekkodesama('tahunajaran','aka_tahunajaran',$tahunajaran) > 0) $error .= "Error: Tahun Ajaran ".$tahunajaran." sudah terdaftar , silahkan ulangi.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `aka_tahunajaran`(tahunajaran,keterangan) VALUES ('$tahunajaran','$keterangan')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b>'.mysql_error().'</div>';
		}
		unset($keterangan);
		unset($tahunajaran);
	//	$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=tahunajaran&mod=yes" />';  
	}

}
$tahunajaran     		= !isset($tahunajaran) ? '' : $tahunajaran;
$keterangan     		= !isset($keterangan) ? '' : $keterangan;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .='<tr>
		<td>Tahun Ajaran</td>
		<td>:</td>
		<td><input type="text" name="tahunajaran" value="'.$tahunajaran.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:</td>
		<td><input type="text" name="keterangan" value="'.$keterangan.'" size="30" class="form-control"></td>
	</tr>';
$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=tahunajaran&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
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
            <th>Tahun Ajaran</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM aka_tahunajaran order by tahunajaran asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$tahunajaran=$data['tahunajaran'];
$keterangan=$data['keterangan'];
$admin .='<tr>
<td>'.$tahunajaran.'</td>
<td>'.$keterangan.'</td>
<td><a href="?pilih=tahunajaran&amp;mod=yes&amp;aksi=del&amp;id='.$data['replid'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=tahunajaran&amp;mod=yes&amp;aksi=edit&amp;id='.$data['replid'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}
echo $admin;

?>