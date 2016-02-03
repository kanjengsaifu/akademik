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
$admin .='<h4 class="page-header">Administrasi Links Sites</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_linkssites WHERE id=$id" );
$data = mysql_fetch_array($hasil);
$tempnews 	= 'mod/linkssites/images/normal/';
$namagambar =  $data['gambar'];
$uploaddir = $tempnews . $namagambar; 
if($namagambar!=""){
unlink($uploaddir);
}
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_linkssites` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Links Sites berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=linkssites&mod=yes" />';    
	}
}


if($_GET['aksi']==""){
if(isset($_POST['submit'])){
	define("GIS_GIF", 1);
define("GIS_JPG", 2);
define("GIS_PNG", 3);
define("GIS_SWF", 4);

include "includes/hft_image.php";
	$nama 		= $_POST['nama'];
	$url 		= $_POST['url'];	
	$namafile_name 	= $_FILES['gambar']['name'];
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		if (!empty ($namafile_name)){
	$files = $_FILES['gambar']['name'];
$tmp_files = $_FILES['gambar']['tmp_name'];

$tempnews 	= 'mod/linkssites/images/temp/';
$namagambar = md5 (rand(1,100).$files) .'.jpg';
$uploaddir = $tempnews . $namagambar; 
$uploads = move_uploaded_file($tmp_files, $uploaddir);
if (file_exists($uploaddir)){
@chmod($uploaddir,0644);
}
	
$gnews 		= 'mod/linkssites/images/normal/';
$nsmall = $gnews . $namagambar;

create_thumbnail ($uploaddir, $nsmall, $new_width = 100, $new_height = 100, $quality = 100);
		
		$hasil  = mysql_query( "INSERT INTO `akad_linkssites` (`nama` ,`url`,`gambar`) VALUES ('$nama','$url','$namagambar')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($nama);
		unset($url);
		unset($gambar);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=linkssites&mod=yes" />';  
		unlink($uploaddir);
	}

}
}
$nama     		= !isset($nama) ? '' : $nama;
$url     		= !isset($url) ? '' : $url;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline" enctype ="multipart/form-data">
<table class="table table-striped table-hover">';
$admin .='<tr>
		<td>Nama</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Url</td>
		<td>:</td>
		<td><input type="text" name="url" value="'.$url.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
	<td>Gambar</td>
			<td>:</td>
	<td><input type="file" name="gambar" size="30"><p class="help-block">Extensi Gambar harus JPG</p></td>
</tr>';

$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=linkssites&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
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
            <th>Nama</th>
            <th>Url</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_linkssites" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$nama=$data['nama'];
$url=$data['url'];
$gambar=$data['gambar'];
$admin .='<tr>
<td>'.$nama.'</td>
<td>'.$url.'</td>
<td><img src="mod/linkssites/images/normal/'.$gambar.'" width="50px"></td>
<td><a href="?pilih=linkssites&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}
echo $admin;

?>