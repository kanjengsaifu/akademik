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
	$("#lokasi").chained("#jenjang");
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
$admin .='<h4 class="page-header">Administrasi Siswa - Kelas</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_siswakelas` WHERE `replid`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Siswa Kelas tersebut berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=siswakelas&mod=yes" />';    
	}
}


if($_GET['aksi']=="addsiswa"){
	$idkelas = int_filter ($_GET['idkelas']);
$query 		= mysql_query ("SELECT * FROM `akad_kelas` WHERE `replid`='$idkelas'");
$data 		= mysql_fetch_array($query);
$idkelas     		= $data['replid'];
$lokasi     		= $data['departemen'];
$kelas     		= $data['kelas'];
$tingkat     		= $data['subtingkat'];
$kapasitas     		= $data['kapasitas'];
$keterangan     		= $data['keterangan'];
$ts     		= $data['ts'];
$tahunajaran     		= $data['tahunajaran'];
$walikelas     		= $data['walikelas'];
$jenjang     		= $data['jenjang'];

$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Kelas</h3></div>';
$admin .= '
<table class="table table-striped table-hover">';
$admin .= '<tr>
	<td>Departemen</td>
		<td>:</td>
	<td>'.getlokasi($lokasi).'</td>
</tr>';
$admin .= '<tr>
	<td>Jenjang</td>
		<td>:</td>
	<td>'.getjenjang($jenjang).'</td></tr>';
$admin .= '<tr>
	<td>Tingkat</td>
		<td>:</td>
	<td>'.gettingkat($tingkat).'</td></tr>';
$admin .= '<tr>
	<td>Tahun Ajaran</td>
		<td>:</td>
	<td>'.gettahunajaran($tahunajaran).'</td></tr>';

$admin .='<tr>
		<td>Kelas</td>
		<td>:</td>
		<td>'.$kelas.'</td>
	</tr>
	<tr>
		<td>Kapasitas</td>
		<td>:</td>
		<td>'.$kapasitas.'</td>
	</tr>';

$admin .='<tr>
		<td></td>
		<td></td>
		<td>
		
		<a href="?pilih=siswakelas&amp;mod=yes"><span class="btn btn-warning">Kembali</span></a></td>
	</tr>
</table>
</div>
';
if($_GET['detail']=="hapussiswa"){
	$idkelas 		= $_GET['idkelas'];
$idsiswa 		= $_GET['idsiswa'];	
$hasil = $koneksi_db->sql_query("DELETE FROM `akad_siswakelas` WHERE `id`='$idsiswa'");    
	if($hasil){    
		$admin.='<div class="sukses">Siswa di Kelas tersebut berhasil dihapus! .</div>';   
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=siswakelas&mod=yes&aksi=addsiswa&idkelas='.$idkelas.'" />';  		
	}
}

if(isset($_POST['submitadd'])){
$siswa 		= $_POST['siswa'];	
$idkelas 		= $_POST['idkelas'];	
$tahunajaran 		= $_POST['tahunajaran'];
	if (cekkelasdobelsiswa($tahunajaran,$idkelas,$siswa) > 0) $error .= "Error: Terdapat duplikasi data siswa pada kelas yg sama, silahkan memilih Siswa yang lain.<br />";
		if (cekajardobelsiswa($tahunajaran,$siswa)>0) $error .= "Error: Terdapat duplikasi data siswa pada tahun ajaran yg sama, silahkan memilih Siswa yang lain.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{	
$hasil  = mysql_query( "INSERT INTO `akad_siswakelas` VALUES ('','$tahunajaran','$idkelas','$siswa')" );
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=siswakelas&mod=yes&aksi=addsiswa&idkelas='.$idkelas.'" />'; 
	}
}
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Input Siswa</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline"id="posts">
<input type="hidden" name="idkelas" value="'.$idkelas.'">
<input type="hidden" name="tahunajaran" value="'.$tahunajaran.'">
<table class="table table-striped table-hover">
	<tr>
		<td>Siswa</td>
		<td>:</td>
		<td><select name="siswa" id="combobox" required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_siswa ORDER BY nama asc");
$admin .= '<option value="">== Siswa ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$pilihanj = ($datasj['replid']==$siswa)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihanj.'>('.$datasj['nis'].') '.$datasj['nama'].'</option>';
}
$admin .='</select>&nbsp;&nbsp;<input type="submit" value="Tambah" name="submitadd"class="btn btn-success" ></td>
		</tr></table></form></div>';

$admin.='
<table id="example"class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>NIS</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT ask.id,ask.siswa,aks.nis,aks.nama FROM akad_siswakelas as ask,aka_siswa as aks where ask.kelas='$idkelas' and ask.siswa=aks.replid order by aks.nis asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
	$idsiswa     		= $data['id'];
$siswa     		= $data['siswa'];
$nis     		= $data['nis'];
$nama     		= $data['nama'];
$admin .='<tr>
<td>'.$nis.'</td>
<td>'.$nama.'</td>
<td><a href="?pilih=siswakelas&amp;mod=yes&amp;aksi=addsiswa&amp;idkelas='.$idkelas.'&amp;detail=hapussiswa&amp;idsiswa='.$idsiswa.'"onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus Siswa</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';
}

if($_GET['aksi']==""){

/********************************************************/
	if (isset($_POST['lihatdata'])){
	
$lokasi = $_POST['lokasi'];
$jenjang = $_POST['jenjang'];	
$tingkat = $_POST['tingkat'];
$tahunajaran = $_POST['tahunajaran'];
if($lokasi==''){
         $wherelokasi="";
}else{
         $wherelokasi="where departemen='$lokasi'";
}
if($jenjang==''){
         $wherejenjang="";
}else{
         $wherejenjang="and jenjang='$jenjang'";
}
if($tingkat==''){
         $wheretingkat="";
}else{
         $wheretingkat="and subtingkat='$tingkat'";
}
if($tahunajaran==''){
         $wheretahunajaran="";
}else{
         $wheretahunajaran="and tahunajaran='$tahunajaran'";
}
}

$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Daftar Kelas</h3></div>';
$admin.='<form class="form-inline" method="post" action="" enctype ="multipart/form-data" id="posts">';
$admin.='
<table class="table">';
$admin .= '<tr>';
$admin .= '
	<td><select name="jenjang" class="form-control" id="jenjang">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tingkat ORDER BY urutan asc");
$admin .= '<option value="">== Jenjang ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$jenjang)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tingkat'].'</option>';
}
$admin .='</select></td>';
$admin .= '<td><select name="lokasi" class="form-control" id="lokasi"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM departemen ORDER BY urut asc");
$admin .= '<option value="">== Departemen ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$lokasi)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"class="'.$datasj['keterangan'].'"'.$pilihan.'>'.$datasj['nama'].'</option>';
}
$admin .='</select></td>';


$admin .= '
	<td><select name="tingkat" class="form-control" id="tingkat">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_subtingkat ORDER BY subtingkat asc");
$admin .= '<option value="">== Tingkat ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tingkat)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"class="'.$datasj['tingkat'].'"'.$pilihan.'>'.$datasj['subtingkat'].'</option>';
}
$admin .='</select></td>';
$admin .= '
	<td><select name="tahunajaran" class="form-control" id="tahunajaran">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tahunajaran ORDER BY tahunajaran desc");
$admin .= '<option value="">== Tahun Ajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tahunajaran)?"selected":'';
				$aktif = ($datasj['replid']==$tahunajaranaktif)?"(Aktif)":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tahunajaran'].' '.$aktif.'</option>';
}
$admin .='</select></td>';
$admin .= '
		<td><input type="submit" value="Lihat" name="lihatdata" class="btn btn-success"></td>
</tr>
';
$admin.='
</table>';
$admin .='</form>';
/************************************/

$admin.='
<table id="example"class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Lokasi</th>
            <th>Jenjang</th>
            <th>Tingkat</th>
            <th>TahunAjaran</th>
            <th>Nama Kelas</th>
            <th>Wali Kelas</th>
            <th>Kapasitas</th>
            <th>Terisi</th>
            <th>Keterangan</th>			
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_kelas $wherelokasi $wherejenjang $wheretingkat $wheretahunajaran order by replid asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$lokasi     		= $data['departemen'];
$jenjang     		= $data['jenjang'];
$subtingkat     		= $data['subtingkat'];
$tahunajaran     		= $data['tahunajaran'];
$kelas=$data['kelas'];
$walikelas=$data['walikelas'];
$kapasitas=$data['kapasitas'];
$keterangan=$data['keterangan'];
$terisi=getisikelas($data['replid']);
$admin .='<tr>
<td>'.getfieldtabel('nama','departemen','replid',$lokasi).'</td>
<td>'.getfieldtabel('tingkat','aka_tingkat','replid',$jenjang).'</td>
<td>'.getfieldtabel('subtingkat','aka_subtingkat','replid',$subtingkat).'</td>
<td>'.getfieldtabel('tahunajaran','aka_tahunajaran','replid',$tahunajaran).'</td>
<td>'.$kelas.'</td>
<td>'.getfieldtabel('nama','hrd_karyawan','id',$walikelas).'</td>
<td>'.$kapasitas.'</td>
<td>('.$terisi.')</td>
<td>'.$keterangan.'</td>
<td><a href="?pilih=siswakelas&amp;mod=yes&amp;aksi=addsiswa&amp;idkelas='.$data['replid'].'"><span class="btn btn-warning">Tambah Siswa</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';
$admin .= '</div>';
}
/************************************/
}
echo $admin;

?>