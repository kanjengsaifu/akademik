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
$admin .='<h4 class="page-header">Administrasi Mata Pelajaran</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_matpel` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">MataPelajaran berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=matpel&mod=yes" />';    
	}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
$nama 		= $_POST['nama'];
	$sks 		= $_POST['sks'];
	$slot 		= $_POST['slot'];
	$jenjang 		= $_POST['jenjang'];
	$tingkat 		= $_POST['tingkat'];
	$kuota 		= $_POST['kuota'];	

	$error 	= '';	
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `akad_matpel` SET `nama`='$nama' ,`sks`='$sks',`slot`='$slot',`jenjang`='$jenjang',`tingkat`='$tingkat',`kuota`='$kuota' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=matpel&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `akad_matpel` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
$nama 		= $data['nama'];
	$sks 		= $data['sks'];
	$slot 		= $data['slot'];
	$jenjang 		= $data['jenjang'];
	$tingkat 		= $data['tingkat'];
	$kuota 		= $data['kuota'];	
	$nama     		= !isset($nama) ? '' : $nama;
$sks     		= !isset($sks) ? '0' : $sks;
$slot     		= !isset($slot) ? '' : $slot;
$jenjang     		= !isset($jenjang) ? '' : $jenjang;
$tingkat     		= !isset($tingkat) ? '' : $tingkat;
$kuota     		= !isset($kuota) ? '' : $kuota;
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
</tr>
<tr>
	<td>Tingkat</td>
		<td>:</td>
	<td>';
	$admin .='<input type="text" name="tingkat" value="'.$tingkat.'" size="30" class="form-control"required>';
$admin .='</td>
</tr>';
$admin .='<tr>
		<td>Nama Mata Pelajaran</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>SKS</td>
		<td>:</td>
		<td><input type="text" name="sks" value="'.$sks.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Slot</td>
		<td>:</td>
		<td><input type="text" name="slot" value="'.$slot.'" size="30" class="form-control"required></td>
	</tr>';

$admin .='<tr>
		<td>Kuota</td>
		<td>:</td>
		<td><input type="text" name="kuota" value="'.$kuota.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=matpel&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';	
}

if($_GET['aksi']==""){
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$sks 		= $_POST['sks'];
	$slot 		= $_POST['slot'];
	$jenjang 		= $_POST['jenjang'];
	$tingkat 		= $_POST['tingkat'];
	$kuota 		= $_POST['kuota'];	
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_matpel` (`nama` ,`sks`,`slot`,`jenjang`,`tingkat`,`kuota`) VALUES ('$nama','$sks','$slot','$jenjang','$tingkat','$kuota')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($nama);
		unset($sks);
		unset($slot);
		unset($jenjang);
		unset($tingkat);
		unset($kuota);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=matpel&mod=yes" />';  
	}

}
$nama     		= !isset($nama) ? '' : $nama;
$sks     		= !isset($sks) ? '0' : $sks;
$slot     		= !isset($slot) ? '' : $slot;
$jenjang     		= !isset($jenjang) ? '' : $jenjang;
$tingkat     		= !isset($tingkat) ? '' : $tingkat;
$kuota     		= !isset($kuota) ? '' : $kuota;
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
</tr>
<tr>
	<td>Tingkat</td>
		<td>:</td>
	<td>';
	$admin .='<input type="text" name="tingkat" value="'.$tingkat.'" size="30" class="form-control"required>';
$admin .='</td>
</tr>';
$admin .='<tr>
		<td>Nama Mata Pelajaran</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>SKS</td>
		<td>:</td>
		<td><input type="text" name="sks" value="'.$sks.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Slot</td>
		<td>:</td>
		<td><input type="text" name="slot" value="'.$slot.'" size="30" class="form-control"required></td>
	</tr>';

$admin .='<tr>
		<td>Kuota</td>
		<td>:</td>
		<td><input type="text" name="kuota" value="'.$kuota.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=matpel&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
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
            <th>Mata Pelajaran</th>
            <th>SKS</th>
            <th>Slot</th>
            <th>Jenjang</th>
            <th>Tingkat</th>
            <th>Kuota</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_matpel" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$nama=$data['nama'];
$sks=$data['sks'];
$slot=$data['slot'];
$jenjang=$data['jenjang'];
$tingkat=$data['tingkat'];
$kuota=$data['kuota'];
$admin .='<tr>
<td>'.$nama.'</td>
<td>'.$sks.'</td>
<td>'.$slot.'</td>
<td>'.getjenjang($jenjang).'</td>
<td>'.$tingkat.'</td>
<td>'.$kuota.'</td>
<td><a href="?pilih=matpel&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=matpel&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}
echo $admin;

?>