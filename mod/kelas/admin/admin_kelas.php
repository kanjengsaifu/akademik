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

$JS_SCRIPT.= <<<js

<script type="text/javascript" src="js/chained/jquery.chained.min.js"></script>
js;
$JS_SCRIPT.= <<<js
<script language="JavaScript" type="text/javascript">
$(function() {
$("#tingkat").chained("#jenjang"); /* or $("#series").chainedTo("#mark"); */
} );
</script>
js;

$JS_SCRIPT .= <<<js
<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
    $('#example').dataTable();
} );
</script>
js;


$script_include[] = $JS_SCRIPT;
$admin .='<h4 class="page-header">Administrasi Kelas</h4>';
$admin  .= '<div class="border2">
<table  ><tr align="center">
<td>
<a href="admin.php?pilih=kelas&mod=yes">Lihat</a>&nbsp;&nbsp;-&nbsp;&nbsp;
</td>
<td>
<a href="admin.php?pilih=kelas&mod=yes&aksi=add">Tambah</a>&nbsp;&nbsp;
</td>
</tr></table>
</div>';
if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_kelas` WHERE `replid`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Kelas berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kelas&mod=yes" />';    
	}
}
if($_GET['aksi']=="edit"){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
$lokasi     		= $_POST['lokasi'];
$jenjang     		= $_POST['jenjang'];
$tingkat     		= $_POST['tingkat'];
$tahunajaran     		= $_POST['tahunajaran'];
$kelas     		= $_POST['kelas'];
$kapasitas     		= $_POST['kapasitas'];
$keterangan     		= $_POST['keterangan'];
$walikelas     		= $_POST['walikelas'];
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `akad_kelas` SET `departemen`='$lokasi' ,`subtingkat`='$tingkat',`tahunajaran`='$tahunajaran',`kelas`='$kelas',`kapasitas`='$kapasitas',`keterangan`='$keterangan',`walikelas`='$walikelas' WHERE `replid`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kelas&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
		unset($lokasi);
		unset($jenjang);
		unset($tingkat);
		unset($tahunajaran);
		unset($walikelas);
		unset($kelas);
		unset($kapasitas);
		unset($keterangan);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kelas&mod=yes" />';  
	}

}
$query 		= mysql_query ("SELECT * FROM `akad_kelas` WHERE `replid`='$id'");
$data 		= mysql_fetch_array($query);
$lokasi     		= $data['lokasi'];
$jenjang     		= $data['jenjang'];
$tingkat     		= $data['subtingkat'];
$tahunajaran     		= $data['tahunajaran'];
$kelas     		= $data['kelas'];
$kapasitas     		= $data['kapasitas'];
$keterangan     		= $data['keterangan'];
$walikelas     		= $data['walikelas'];
$jenjang = getfieldtabel('tingkat','aka_subtingkat','replid',$tingkat);
/*
$lokasi     		= !isset($lokasi) ? '' : $lokasi;
$jenjang     		= !isset($jenjang) ? '' : $jenjang;
$tingkat     		= !isset($tingkat) ? '' : $tingkat;
$tahunajaran     		= !isset($tahunajaran) ? '' : $tahunajaran;
$walikelas     		= !isset($walikelas) ? '' : $walikelas;
$kelas     		= !isset($kelas) ? '' : $kelas;
$kapasitas     		= !isset($kapasitas) ? '' : $kapasitas;
$keterangan     		= !isset($keterangan) ? '' : $keterangan;
*/
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .= '<tr>
	<td>Lokasi</td>
		<td>:</td>
	<td><select name="lokasi" class="form-control" id="lokasi"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM departemen ORDER BY urut asc");
$admin .= '<option value="">== Lokasi ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$lokasi)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['nama'].'</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>Jenjang</td>
		<td>:</td>
	<td><select name="jenjang" class="form-control" id="jenjang">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tingkat ORDER BY urutan asc");
$admin .= '<option value="">== Jenjang ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$jenjang)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tingkat'].'</option>';
}
$admin .='</select></td></tr>';
$admin .= '<tr>
	<td>Tingkat</td>
		<td>:</td>
	<td><select name="tingkat" class="form-control" id="tingkat">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_subtingkat ORDER BY subtingkat asc");
$admin .= '<option value="">== Tingkat ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tingkat)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'class="'.$datasj['tingkat'].'">'.$datasj['subtingkat'].'</option>';
}
$admin .='</select></td></tr>';
$admin .= '<tr>
	<td>Tahun Ajaran</td>
		<td>:</td>
	<td><select name="tahunajaran" class="form-control" id="tahunajaran">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tahunajaran ORDER BY tahunajaran desc");
$admin .= '<option value="">== Tahun Ajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tahunajaran)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'">'.$datasj['tahunajaran'].'</option>';
}
$admin .='</select></td></tr>';
$admin .= '<tr>
	<td>Wali Kelas</td>
		<td>:</td>
	<td><select name="walikelas" class="form-control" id="walikelas">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM hrd_karyawan ORDER BY nama asc");
$admin .= '<option value="">== Wali Kelas ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['id']==$walikelas)?"selected":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihan.'">'.$datasj['nama'].' ('.$datasj['nip'].')</option>';
}
$admin .='</select></td></tr>';
$admin .='<tr>
		<td>Kelas</td>
		<td>:</td>
		<td><input type="text" name="kelas" value="'.$kelas.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Kapasitas</td>
		<td>:</td>
		<td><input type="text" name="kapasitas" value="'.$kapasitas.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:</td>
		<td><input type="text" name="keterangan" value="'.$keterangan.'"  class="form-control"required></td>
	</tr>';

$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=jam&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';	


}


if($_GET['aksi']=="add"){
if(isset($_POST['submit'])){
$lokasi     		= $_POST['lokasi'];
$jenjang     		= $_POST['jenjang'];
$tingkat     		= $_POST['tingkat'];
$tahunajaran     		= $_POST['tahunajaran'];
$kelas     		= $_POST['kelas'];
$kapasitas     		= $_POST['kapasitas'];
$keterangan     		= $_POST['keterangan'];
$walikelas     		= $_POST['walikelas'];
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_kelas` (`departemen` ,`kelas`,`subtingkat`,`kapasitas`,`keterangan`,`tahunajaran`,`walikelas`) VALUES ('$departemen','$kelas','$tingkat','$kapasitas','$keterangan','$tahunajaran','$walikelas')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($lokasi);
		unset($jenjang);
		unset($tingkat);
		unset($tahunajaran);
		unset($walikelas);
		unset($kelas);
		unset($kapasitas);
		unset($keterangan);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kelas&mod=yes" />';  
	}

}
$lokasi     		= !isset($lokasi) ? '' : $lokasi;
$jenjang     		= !isset($jenjang) ? '' : $jenjang;
$tingkat     		= !isset($tingkat) ? '' : $tingkat;
$tahunajaran     		= !isset($tahunajaran) ? '' : $tahunajaran;
$walikelas     		= !isset($walikelas) ? '' : $walikelas;
$kelas     		= !isset($kelas) ? '' : $kelas;
$kapasitas     		= !isset($kapasitas) ? '' : $kapasitas;
$keterangan     		= !isset($keterangan) ? '' : $keterangan;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .= '<tr>
	<td>Lokasi</td>
		<td>:</td>
	<td><select name="lokasi" class="form-control" id="lokasi"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM departemen ORDER BY urut asc");
$admin .= '<option value="">== Lokasi ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$lokasi)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['nama'].'</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>Jenjang</td>
		<td>:</td>
	<td><select name="jenjang" class="form-control" id="jenjang">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tingkat ORDER BY urutan asc");
$admin .= '<option value="">== Jenjang ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$jenjang)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tingkat'].'</option>';
}
$admin .='</select></td></tr>';
$admin .= '<tr>
	<td>Tingkat</td>
		<td>:</td>
	<td><select name="tingkat" class="form-control" id="tingkat">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_subtingkat ORDER BY subtingkat asc");
$admin .= '<option value="">== Tingkat ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tingkat)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'class="'.$datasj['tingkat'].'">'.$datasj['subtingkat'].'</option>';
}
$admin .='</select></td></tr>';
$admin .= '<tr>
	<td>Tahun Ajaran</td>
		<td>:</td>
	<td><select name="tahunajaran" class="form-control" id="tahunajaran">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tahunajaran ORDER BY tahunajaran desc");
$admin .= '<option value="">== Tahun Ajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tahunajaran)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'">'.$datasj['tahunajaran'].'</option>';
}
$admin .='</select></td></tr>';
$admin .= '<tr>
	<td>Wali Kelas</td>
		<td>:</td>
	<td><select name="walikelas" class="form-control" id="walikelas">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM hrd_karyawan ORDER BY nama asc");
$admin .= '<option value="">== Wali Kelas ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['id']==$walikelas)?"selected":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihan.'">'.$datasj['nama'].' ('.$datasj['nip'].')</option>';
}
$admin .='</select></td></tr>';
$admin .='<tr>
		<td>Kelas</td>
		<td>:</td>
		<td><input type="text" name="kelas" value="'.$kelas.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Kapasitas</td>
		<td>:</td>
		<td><input type="text" name="kapasitas" value="'.$kapasitas.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:</td>
		<td><input type="text" name="keterangan" value="'.$keterangan.'"  class="form-control"required></td>
	</tr>';

$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=jam&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';	


}

if($_GET['aksi']==""){

/********************************************************/
	if (isset($_POST['lihatdata'])){
	
$lokasi = $_POST['lokasi'];
$jenjang = $_POST['jenjang'];	
$tingkat = $_POST['tingkat'];
if($lokasi==''){
         $wherelokasi="";
}else{
         $wherelokasi="where departemen='$lokasi'";
}
if($tingkat==''){
         $wheretingkat="";
}else{
         $wheretingkat="and subtingkat='$tingkat'";
}
}

$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Daftar Kelas</h3></div>';
$admin.='<form class="form-inline" method="post" action="" enctype ="multipart/form-data" id="posts">';
$admin.='
<table class="table">';
$admin .= '<tr>
	<td><select name="lokasi" class="form-control" id="lokasi"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM departemen ORDER BY urut asc");
$admin .= '<option value="">== Lokasi ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$lokasi)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['nama'].'</option>';
}
$admin .='</select></td>';
$admin .= '
	<td><select name="jenjang" class="form-control" id="jenjang">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tingkat ORDER BY urutan asc");
$admin .= '<option value="">== Jenjang ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$jenjang)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tingkat'].'</option>';
}
$admin .='</select></td>';

$admin .= '
	<td><select name="tingkat" class="form-control" id="tingkat">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_subtingkat ORDER BY subtingkat asc");
$admin .= '<option value="">== Tingkat ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tingkat)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'class="'.$datasj['tingkat'].'">'.$datasj['subtingkat'].'</option>';
}
$admin .='</select></td>';
$admin .= '
	<td><select name="tahunajaran" class="form-control" id="tahunajaran">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tahunajaran ORDER BY tahunajaran desc");
$admin .= '<option value="">== Tahun Ajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tingkat)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tahunajaran'].'</option>';
}
$admin .='</select></td>';
$admin .= '
		<td><input type="submit" value="Lihat" name="lihatdata" class="btn btn-success"></td>
</tr>
';
$admin.='
</table>';
$admin .='</form>';
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

$admin.='
<table id="example"class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Nama Kelas</th>
            <th>Wali Kelas</th>
            <th>Kapasitas</th>
            <th>Terisi</th>
            <th>Keterangan</th>			
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_kelas $wherelokasi $wheretingkat order by replid asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$kelas=$data['kelas'];
$walikelas=$data['walikelas'];
$kapasitas=$data['kapasitas'];
$replid=$data['replid'];
$keterangan=$data['keterangan'];
$admin .='<tr>
<td>'.$kelas.'</td>
<td>'.getfieldtabel('nama','hrd_karyawan','id',$walikelas).'</td>
<td>'.$kapasitas.'</td>
<td></td>
<td>'.$keterangan.'</td>
<td><a href="?pilih=kelas&amp;mod=yes&amp;aksi=del&amp;id='.$data['replid'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=kelas&amp;mod=yes&amp;aksi=edit&amp;id='.$data['replid'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';
$admin .= '</div>';
}
/************************************/
}
echo $admin;

?>