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
$admin .='<h4 class="page-header">Administrasi Kegiatan Akademik</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_kegiatan` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Kegiatan Akademik berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kegiatan&mod=yes" />';    
	}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
$matpel 		= $_POST['matpel'];
$jenis 		= $_POST['jenis'];
$penilaian 		= $_POST['penilaian'];
	
	$error 	= '';	
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `akad_kegiatan` SET `matpel`='$matpel' ,`jenis`='$jenis',`penilaian`='$penilaian' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kegiatan&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `akad_kegiatan` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
	$matpel 		= $data['matpel'];
	$jenis 		= $data['jenis'];
	$penilaian 		= $data['penilaian'];

$matpel     		= !isset($matpel) ? '' : $matpel;
$jenis     		= !isset($jenis) ? '' : $jenis;
$penilaian     		= !isset($penilaian) ? '' : $penilaian;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
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
$admin .='<tr>
		<td>Jenis Kegiatan</td>
		<td>:</td>
		<td><input type="text" name="jenis" value="'.$jenis.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Penilaian</td>
		<td>:</td>
		<td><input type="text" name="penilaian" value="'.$penilaian.'" size="30" class="form-control"required></td>
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
	$matpel 		= $_POST['matpel'];
	$jenis 		= $_POST['jenis'];
	$penilaian 		= $_POST['penilaian'];
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_kegiatan` VALUES ('','$matpel','$jenis','$penilaian')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($matpel);
		unset($jenis);
		unset($penilaian);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kegiatan&mod=yes" />';  
	}

}
$matpel     		= !isset($matpel) ? '' : $matpel;
$jenis     		= !isset($jenis) ? '' : $jenis;
$penilaian     		= !isset($penilaian) ? '' : $penilaian;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
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
$admin .='<tr>
		<td>Jenis Kegiatan</td>
		<td>:</td>
		<td><input type="text" name="jenis" value="'.$jenis.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Penilaian</td>
		<td>:</td>
		<td><input type="text" name="penilaian" value="'.$penilaian.'" size="30" class="form-control"required></td>
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
            <th>Mata Pelajaran</th>
            <th>Jenis Kegiatan</th>
            <th>Penilaian</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_kegiatan" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$matpel=$data['matpel'];
$jenis=$data['jenis'];
$penilaian=$data['penilaian'];
$admin .='<tr>
<td>'.getmatpel($matpel).'</td>
<td>'.$jenis.'</td>
<td>'.$penilaian.'</td>
<td><a href="?pilih=kegiatan&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=kegiatan&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}
echo $admin;

?>