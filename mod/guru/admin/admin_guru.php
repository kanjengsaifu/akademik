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
<script language="JavaScript" type="text/javascript">
$(function() {
	$("#lokasi").chained("#jenjang");
$("#tingkat").chained("#jenjang");

} );
</script>
js;
$script_include[] = $JS_SCRIPT;
$admin .='<h4 class="page-header">Administrasi Guru</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_guru` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Guru berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=guru&mod=yes" />';    
	}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
	$jenjang 		= $_POST['jenjang'];
	$tingkat 		= $_POST['tingkat'];
	$lokasi 		= $_POST['lokasi'];
	$matpel 		= $_POST['matpel'];
	$guru 		= $_POST['guru'];
	$sks 		= $_POST['sks'];
	$status 		= $_POST['status'];	

	$error 	= '';	
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `akad_guru` SET `tingkat`='$tingkat' ,`jenjang`='$jenjang' ,`lokasi`='$lokasi' ,`matpel`='$matpel',`guru`='$guru',`sks`='$sks',`status`='$status' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=guru&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `akad_guru` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
$jenjang 		= $data['jenjang'];
$tingkat 		= $data['tingkat'];
$lokasi 		= $data['lokasi'];
	$matpel 		= $data['matpel'];
	$guru 		= $data['guru'];
	$sks 		= $data['sks'];
	$status 		= $data['status'];	
$jenjang     		= !isset($jenjang) ? '' : $jenjang;
$tingkat     		= !isset($tingkat) ? '' : $tingkat;
$lokasi     		= !isset($lokasi) ? '' : $lokasi;
$matpel     		= !isset($matpel) ? '' : $matpel;
$guru     		= !isset($guru) ? '' : $guru;
$sks     		= !isset($sks) ? '' : $sks;
$status     		= !isset($status) ? '' : $status;
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
$admin .= '<tr>
	<td>Tingkat</td>
		<td>:</td>
	<td><select name="tingkat" class="form-control" id="tingkat"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_subtingkat ORDER BY subtingkat asc");
$admin .= '<option value="">== Tingkat ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tingkat)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"class="'.$datasj['tingkat'].'"'.$pilihan.'>'.$datasj['subtingkat'].'</option>';
}
$admin .='</select></td>
</tr>';
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
	<td>Mata Pelajaran</td>
		<td>:</td>
	<td><select name="matpel" class="form-control" id="matpel"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_matpel ORDER BY nama asc");
$admin .= '<option value="">== Mata Pelajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['id']==$matpel)?"selected":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihan.'>'.$datasj['nama'].'</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>Guru</td>
		<td>:</td>
	<td><select name="guru" class="form-control" id="guru"required>';
	$idjabatan = getidjabatan('guru');
$hasilj = $koneksi_db->sql_query("SELECT * FROM hrd_karyawan where jabatan='$idjabatan'  ORDER BY nama asc");
$admin .= '<option value="">== Nama Guru ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['id']==$guru)?"selected":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihan.'>'.$datasj['nama'].' ('.$datasj['nip'].')</option>';
}
$admin .='</select></td>
</tr>';
$admin .='
	<tr>
		<td>SKS Max Per Minggu</td>
		<td>:</td>
		<td><input type="text" name="sks" value="'.$sks.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Status</td>
		<td>:</td>
		<td><input type="text" name="status" value="'.$status.'" size="30" class="form-control"required></td>
	</tr>';

$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=guru&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';	
}

if($_GET['aksi']==""){
if(isset($_POST['submit'])){
	$jenjang 		= $_POST['jenjang'];
	$tingkat 		= $_POST['tingkat'];
	$lokasi 		= $_POST['lokasi'];
	$matpel 		= $_POST['matpel'];
	$guru 		= $_POST['guru'];
	$sks 		= $_POST['sks'];
	$status 		= $_POST['status'];
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_guru` (`jenjang` ,`tingkat` ,`lokasi` ,`matpel`,`guru`,`sks`,`status`) VALUES ('$jenjang','$tingkat','$lokasi','$matpel','$guru','$sks','$status')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($jenjang);
		unset($tingkat);
		unset($lokasi);
		unset($matpel);
		unset($guru);
		unset($sks);
		unset($status);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=guru&mod=yes" />';  
	}

}
$jenjang     		= !isset($jenjang) ? '' : $jenjang;
$tingkat     		= !isset($tingkat) ? '' : $tingkat;
$lokasi     		= !isset($lokasi) ? '' : $lokasi;
$matpel     		= !isset($matpel) ? '' : $matpel;
$guru     		= !isset($guru) ? '' : $guru;
$sks     		= !isset($sks) ? '' : $sks;
$status     		= !isset($status) ? '' : $status;
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
$admin .= '<tr>
	<td>Departemen</td>
		<td>:</td>
	<td><select name="lokasi" class="form-control" id="lokasi"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM departemen ORDER BY urut asc");
$admin .= '<option value="">== Departemen ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$lokasi)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"class="'.$datasj['keterangan'].'"'.$pilihan.'>'.$datasj['nama'].'</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>Tingkat</td>
		<td>:</td>
	<td><select name="tingkat" class="form-control" id="tingkat"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_subtingkat ORDER BY subtingkat asc");
$admin .= '<option value="">== Tingkat ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tingkat)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"class="'.$datasj['tingkat'].'"'.$pilihan.'>'.$datasj['subtingkat'].'</option>';
}
$admin .='</select></td>
</tr>';

$admin .= '<tr>
	<td>Mata Pelajaran</td>
		<td>:</td>
	<td><select name="matpel" class="form-control" id="matpel"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_matpel ORDER BY nama asc");
$admin .= '<option value="">== Mata Pelajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['id']==$matpel)?"selected":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihan.'>'.$datasj['nama'].'</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>Guru</td>
		<td>:</td>
	<td><select name="guru" class="form-control" id="guru"required>';
	$idjabatan = getidjabatan('guru');
$hasilj = $koneksi_db->sql_query("SELECT * FROM hrd_karyawan where jabatan='$idjabatan'  ORDER BY nama asc");
$admin .= '<option value="">== Nama Guru ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['id']==$guru)?"selected":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihan.'>'.$datasj['nama'].' ('.$datasj['nip'].')</option>';
}
$admin .='</select></td>
</tr>';
$admin .='
	<tr>
		<td>SKS Max Per Minggu</td>
		<td>:</td>
		<td><input type="text" name="sks" value="'.$sks.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Status</td>
		<td>:</td>
		<td><input type="text" name="status" value="'.$status.'" size="30" class="form-control"required></td>
	</tr>';

$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=guru&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
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
            <th>Departemen</th>
			<th>Jenjang / Tingkat</th>
            <th>Nama Guru</th>
            <th>NIP</th>
            <th>Mata Pelajaran</th>
            <th>SKS</th>
            <th>Status</th>

            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_guru" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
	$jenjang 		= $data['jenjang'];
	$tingkat 		= $data['tingkat'];
	$lokasi 		= $data['lokasi'];
	$matpel 		= $data['matpel'];
	$guru 		= $data['guru'];
	$sks 		= $data['sks'];
	$status 		= $data['status'];
$admin .='<tr>
<td>'.getlokasi($lokasi).'</td>
<td>'.getjenjang($jenjang).' / '.gettingkat($tingkat).'</td>
<td>'.getdataguru("nama",$guru).'</td>
<td>'.getdataguru("nip",$guru).'</td>
<td>'.getmatpel($matpel).'</td>
<td>'.$sks.'</td>
<td>'.$status.'</td>

<td><a href="?pilih=guru&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=guru&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}
echo $admin;

?>