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
$admin .='<h4 class="page-header">Administrasi Jam Pelajaran</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_jam` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Jam Pelajaran berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=jam&mod=yes" />';    
	}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$jenjang 		= $_POST['jenjang'];
	$mulai 		= $_POST['mulai'];
	$selesai 		= $_POST['selesai'];	

	$error 	= '';	
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `akad_jam` SET `nama`='$nama' ,`jenjang`='$jenjang',`mulai`='$mulai',`selesai`='$selesai' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=jam&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `akad_jam` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
$nama 		= $data['nama'];
	$jenjang 		= $data['jenjang'];
	$mulai 		= $data['mulai'];	
	$selesai 		= $data['selesai'];	
$nama     		= !isset($nama) ? '' : $nama;
$jenjang     		= !isset($jenjang) ? '' : $jenjang;
$mulai     		= !isset($mulai) ? '' : $mulai;
$selesai     		= !isset($selesai) ? '' : $selesai;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .= '<tr>
	<td>Jenjang</td>
		<td>:</td>
	<td><select name="jenjang" class="form-control" id="jenjang"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tingkat ORDER BY urutan asc");
$admin .= '<option value="">== Jenjang ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$jenjang)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tingkat'].'</option>';
}
$admin .='</select></td>
</tr>';
$admin .='<tr>
		<td>Jam Mata Pelajaran</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Mulai</td>
		<td>:</td>
		<td><input type="text" name="mulai" value="'.$mulai.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Selesai</td>
		<td>:</td>
		<td><input type="text" name="selesai" value="'.$selesai.'" size="30" class="form-control"required></td>
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
	$jenjang 		= $_POST['jenjang'];
	$mulai 		= $_POST['mulai'];
	$selesai 		= $_POST['selesai'];	
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_jam` (`nama` ,`jenjang`,`mulai`,`selesai`) VALUES ('$nama','$jenjang','$mulai','$selesai')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($nama);
		unset($jenjang);
		unset($mulai);
		unset($selesai);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=jam&mod=yes" />';  
	}

}
$nama     		= !isset($nama) ? '' : $nama;
$jenjang     		= !isset($jenjang) ? '' : $jenjang;
$mulai     		= !isset($mulai) ? '' : $mulai;
$selesai     		= !isset($selesai) ? '' : $selesai;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .= '<tr>
	<td>Jenjang</td>
		<td>:</td>
	<td><select name="jenjang" class="form-control" id="jenjang"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tingkat ORDER BY urutan asc");
$admin .= '<option value="">== Jenjang ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$jenjang)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tingkat'].'</option>';
}
$admin .='</select></td>
</tr>';
$admin .='<tr>
		<td>Jam Mata Pelajaran</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Mulai</td>
		<td>:</td>
		<td><input type="text" name="mulai" value="'.$mulai.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Selesai</td>
		<td>:</td>
		<td><input type="text" name="selesai" value="'.$selesai.'" size="30" class="form-control"required></td>
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
            <th>Jam Pelajaran</th>
            <th>Jenjang</th>
            <th>Mulai</th>
            <th>Selesai</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_jam" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$nama=$data['nama'];
$jenjang=$data['jenjang'];
$mulai=$data['mulai'];
$selesai=$data['selesai'];
$admin .='<tr>
<td>'.$nama.'</td>
<td>'.getjenjang($jenjang).'</td>
<td>'.$mulai.'</td>
<td>'.$selesai.'</td>
<td><a href="?pilih=jam&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=jam&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}
echo $admin;

?>