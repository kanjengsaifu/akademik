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
$admin .='<h4 class="page-header">Administrasi Lomba</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_lomba` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Lomba berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=lomba&mod=yes" />';    
	}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$pic 		= $_POST['pic'];
	$bulan 		= $_POST['bulan'];

	$error 	= '';	
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `akad_lomba` SET `nama`='$nama' ,`pic`='$pic',`bulan`='$bulan' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=lomba&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `akad_lomba` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
	$nama 		= $data['nama'];
	$pic 		= $data['pic'];	
	$bulan 		= $data['bulan'];	
$nama     		= !isset($nama) ? '' : $nama;
$pic     		= !isset($pic) ? '' : $pic;
$bulan     		= !isset($bulan) ? '' : $bulan;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .='<tr>
		<td>Nama Lomba</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>PIC</td>
		<td>:</td>
		<td><input type="text" name="pic" value="'.$pic.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Bulan Lomba</td>
		<td>:</td>
		<td><input type="text" name="bulan" value="'.$bulan.'" size="30" class="form-control"required></td>
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
	$pic 		= $_POST['pic'];
	$bulan 		= $_POST['bulan'];	
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_lomba` VALUES ('','$nama','$pic','$bulan')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($nama);
		unset($pic);
		unset($bulan);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=lomba&mod=yes" />';  
	}

}
$nama     		= !isset($nama) ? '' : $nama;
$pic     		= !isset($pic) ? '' : $pic;
$bulan     		= !isset($bulan) ? '' : $bulan;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .='<tr>
		<td>Nama Lomba</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>PIC</td>
		<td>:</td>
		<td><input type="text" name="pic" value="'.$pic.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Bulan Lomba</td>
		<td>:</td>
		<td><input type="text" name="bulan" value="'.$bulan.'" size="30" class="form-control"required></td>
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
            <th>Nama Lomba</th>
            <th>PIC</th>
            <th>Bulan Lomba</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_lomba" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$nama=$data['nama'];
$pic=$data['pic'];
$bulan=$data['bulan'];
$admin .='<tr>
<td>'.$nama.'</td>
<td>'.$pic.'</td>
<td>'.$bulan.'</td>
<td><a href="?pilih=lomba&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=lomba&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}
echo $admin;

?>