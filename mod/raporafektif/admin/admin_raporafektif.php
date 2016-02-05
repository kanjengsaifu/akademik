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
$admin .='<h4 class="page-header">Administrasi Rapor</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_raporafektif` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Rapor Afektif berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=raporafektif&mod=yes" />';    
	}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
	$lokasi 		= $_POST['lokasi'];
	$jenjang 		= $_POST['jenjang'];
	$tahunajaran 		= $_POST['tahunajaran'];
	$semester 		= $_POST['semester'];	

$error 	= '';	
		if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM akad_raporafektif WHERE jenjang='$jenjang' and lokasi = '$lokasi' and tahunajaran = '$tahunajaran' and semester = '$semester'"))  > 0) $error .= "Error: Terdapat duplikasi data, silahkan ulangi.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `akad_raporafektif` SET `lokasi`='$lokasi' ,`jenjang`='$jenjang',`tahunajaran`='$tahunajaran',`semester`='$semester' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=raporafektif&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `akad_raporafektif` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
$lokasi 		= $data['lokasi'];
$jenjang 		= $data['jenjang'];
$tahunajaran 		= $data['tahunajaran'];	
$semester 		= $data['semester'];	
$lokasi     		= !isset($lokasi) ? '' : $lokasi;
$jenjang     		= !isset($jenjang) ? '' : $jenjang;
$tahunajaran     		= !isset($tahunajaran) ? '' : $tahunajaran;
$semester     		= !isset($semester) ? '' : $semester;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .= '<tr>
	<td>Lokasi</td>
		<td>:</td>
	<td><select name="lokasi" class="form-control" id="lokasi"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM departemen ORDER BY replid asc");
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
	<td>Semester</td>
		<td>:</td>
	<td><select name="semester" class="form-control" id="semester"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_semester ORDER BY nama asc");
$admin .= '<option value="">== Semester ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['id']==$semester)?"selected":'';
		$aktif = ($datasj['id']==$semesteraktif)?"(Aktif)":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihan.'>'.$datasj['nama'].' '.$aktif.'</option>';
}
$admin .='</select></td></tr>';	
$admin .= '<tr>
	<td>Tahun Ajaran</td>
		<td>:</td>
	<td><select name="tahunajaran" class="form-control" id="tahunajaran"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tahunajaran ORDER BY tahunajaran desc");
$admin .= '<option value="">== Tahun Ajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tahunajaran)?"selected":'';
		$aktif = ($datasj['replid']==$tahunajaranaktif)?"(Aktif)":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tahunajaran'].' '.$aktif.'</option>';
}
$admin .='</select></td></tr>';	

$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=raporafektif&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';	
}

if($_GET['aksi']==""){
if(isset($_POST['submit'])){
	$lokasi 		= $_POST['lokasi'];
	$jenjang 		= $_POST['jenjang'];
	$tahunajaran 		= $_POST['tahunajaran'];
	$semester 		= $_POST['semester'];	
	$error 	= '';	
	if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM akad_raporafektif WHERE jenjang='$jenjang' and lokasi = '$lokasi' and tahunajaran = '$tahunajaran' and semester = '$semester'")) > 0) $error .= "Error: Terdapat duplikasi data, silahkan ulangi.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_raporafektif` VALUES ('','$lokasi','$jenjang','$tahunajaran','$semester')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
					unset($lokasi);
		unset($jenjang);
		unset($tahunajaran);
		unset($semester);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=raporafektif&mod=yes" />';  
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}

	}

}
$lokasi     		= !isset($lokasi) ? '' : $lokasi;
$jenjang     		= !isset($jenjang) ? '' : $jenjang;
$tahunajaran     		= !isset($tahunajaran) ? '' : $tahunajaran;
$semester     		= !isset($semester) ? '' : $semester;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .= '<tr>
	<td>Lokasi</td>
		<td>:</td>
	<td><select name="lokasi" class="form-control" id="lokasi"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM departemen ORDER BY replid asc");
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
	<td>Semester</td>
		<td>:</td>
	<td><select name="semester" class="form-control" id="semester"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_semester ORDER BY nama asc");
$admin .= '<option value="">== Semester ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['id']==$semester)?"selected":'';
		$aktif = ($datasj['id']==$semesteraktif)?"(Aktif)":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihan.'>'.$datasj['nama'].' '.$aktif.'</option>';
}
$admin .='</select></td></tr>';	
$admin .= '<tr>
	<td>Tahun Ajaran</td>
		<td>:</td>
	<td><select name="tahunajaran" class="form-control" id="tahunajaran"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tahunajaran ORDER BY tahunajaran desc");
$admin .= '<option value="">== Tahun Ajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tahunajaran)?"selected":'';
		$aktif = ($datasj['replid']==$tahunajaranaktif)?"(Aktif)":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tahunajaran'].' '.$aktif.'</option>';
}
$admin .='</select></td></tr>';	

$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=raporafektif&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';	
}

if($_GET['aksi']=="" or $_GET['aksi']=="edit"){
/************************************/
$admin.='
<table id="example"class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Lokasi</th>
            <th>Jenjang</th>
            <th>Tahun Ajaran</th>
            <th>Semester</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_raporafektif order by jenjang asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$lokasi=$data['lokasi'];
$jenjang=$data['jenjang'];
$tahunajaran=$data['tahunajaran'];
$semester=$data['semester'];
$admin .='<tr>
<td>'.getlokasi($lokasi).'</td>
<td>'.getjenjang($jenjang).'</td>
<td>'.gettahunajaran($tahunajaran).'</td>
<td>'.getsemester($semester).'</td>
<td><a href="?pilih=raporafektif&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=raporafektif&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a> <a href="?pilih=raporafektif&amp;mod=yes&amp;aksi=addafektifkat&amp;idrapor='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menambah kategori Penilaian ?\')"><span class="btn btn-primary">Penilaian</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}

/*********************** AFEKTIF **********************/
if($_GET['aksi'] == 'addafektifkat'){
$idrapor = int_filter ($_GET['idrapor']);
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$rapor 		= $_POST['rapor'];
$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_afektifkat` VALUES ('','$rapor','$nama')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=raporafektif&amp;mod=yes&aaksi=addafektifkat&idrapor=$idrapor" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `akad_raporafektif` WHERE `id`='$idrapor'");
$data 		= mysql_fetch_array($query);
$lokasi 		= $data['lokasi'];
$jenjang 		= $data['jenjang'];
$tahunajaran 		= $data['tahunajaran'];	
$semester 		= $data['semester'];	

$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .= '<tr>
	<td>Lokasi</td>
		<td>:</td>
	<td>'.getlokasi($lokasi).'</td>
</tr>';
$admin .= '<tr>
	<td>Jenjang</td>
		<td>:</td>
	<td>'.getjenjang($jenjang).'</td>
</tr>';
$admin .= '<tr>
	<td>Semester</td>
		<td>:</td>
		<td>'.getsemester($semester).'</td></tr>';	
$admin .= '<tr>
	<td>Tahun Ajaran</td>
		<td>:</td>
	<td>'.gettahunajaran($tahunajaran).'</td></tr>';	

$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>&nbsp;
		<a href="?pilih=raporafektif&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';	
}


}
echo $admin;

?>