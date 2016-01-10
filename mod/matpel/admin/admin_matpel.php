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
$JS_SCRIPT.= <<<js
<script>
$("#series").chained("#mark");
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
	$tunjangan 		= $_POST['tunjangan'];

	$error 	= '';
	if (!$nama)  	$error .= "Error: Silahkan Isi Nama jabatan<br />";
	if (!$tunjangan)  	$tunjangan ='0';	
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `hrd_jabatan` SET `nama`='$nama' ,`tunjangan`='$tunjangan' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=jabatan&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `hrd_jabatan` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Edit</h3></div>';
$admin .= '
<form method="post" action=""class="form-inline">
<table  class="table table-striped table-hover">
	<tr>
		<td>Nama jabatan</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$data['nama'].'" size="25" class="form-control"></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success" ></td>
	</tr>
</table>
</form>
</div>';
}

if($_GET['aksi']==""){
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$tunjangan 		= $_POST['tunjangan'];
	
	$error 	= '';
	if (!$nama)  	$error .= "Error: Silahkan Isi Nama jabatan<br />";
	if (!$tunjangan)  	$tunjangan ='0';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `hrd_jabatan` (`nama` ,`tunjangan`) VALUES ('$nama','$tunjangan')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($nama);
		unset($tunjangan);
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
<table class="table table-striped table-hover">
	<tr>
		<td>Nama Mata Pelajaran</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"></td>
	</tr>
	<tr>
		<td>SKS</td>
		<td>:</td>
		<td><input type="text" name="sks" value="'.$sks.'" size="30" class="form-control"></td>
	</tr>
	<tr>
		<td>Slot</td>
		<td>:</td>
		<td><input type="text" name="slot" value="'.$slot.'" size="30" class="form-control"></td>
	</tr>
<tr>
	<td>Jenjang</td>
		<td>:</td>
	<td><select name="jenjang" class="form-control" id="jenjang"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tingkat ORDER BY tingkat asc");
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
	$admin .='<select name="tingkat" class="form-control" id="tingkat" required>';

$hasilj = $koneksi_db->sql_query("SELECT aka_subtingkat.replid,aka_subtingkat.subtingkat, aka_subtingkat.tingkat FROM aka_subtingkat INNER JOIN aka_tingkat ON aka_subtingkat.tingkat = aka_tingkat.replid ORDER BY subtingkat asc");
$admin .= '<option value="" >== Sub TIngkat ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tingkat)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.' class="'.$datasj['tingkat'].'">'.$datasj['subtingkat'].'</option>';
}

$admin .='</select>';
$admin .='</td>
</tr>
	<tr>
		<td>Kuota</td>
		<td>:</td>
		<td><input type="text" name="kuota" value="'.$kuota.'" size="30" class="form-control"></td>
	</tr>
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
<td>'.$jenjang.'</td>
<td>'.$tingkat.'</td>
<td>'.$kuota.'</td>
<td><a href="?pilih=matpel&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=matpel&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';
$admin .= '
<select id="mark" name="mark">
  <option value="">--</option>
  <option value="bmw">BMW</option>
  <option value="audi">Audi</option>
</select>
<select id="series" name="series">
  <option value="">--</option>
  <option value="series-3" class="bmw">3 series</option>
  <option value="series-5" class="bmw">5 series</option>
  <option value="series-6" class="bmw">6 series</option>
  <option value="a3" class="audi">A3</option>
  <option value="a4" class="audi">A4</option>
  <option value="a5" class="audi">A5</option>
</select>';
/************************************/
}
echo $admin;

?>