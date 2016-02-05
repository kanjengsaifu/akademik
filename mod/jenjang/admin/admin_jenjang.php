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
$admin .='<h4 class="page-header">Administrasi Jenjang</h4>';
$admin  .= '<div class="border2">
<table  ><tr align="center">
<td>
<a href="admin.php?pilih=jenjang&mod=yes">Jenjang</a>&nbsp;&nbsp;-&nbsp;&nbsp;
</td>
<td>
<a href="admin.php?pilih=tingkat&mod=yes">Tingkat</a>&nbsp;&nbsp;
</td>
</tr></table>
</div>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
		$error 	= 'Error terdapat FK';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
	$hasil = $koneksi_db->sql_query("DELETE FROM `aka_tingkat` WHERE `replid`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Jenjang berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=jenjang&mod=yes" />';    
	}
}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
$tingkat=$_POST['tingkat'];
$kode=$_POST['kode'];
//$tahunajaran=$_POST['tahunajaran'];
	
	$error 	= '';	
	if (cekkodesama('kode','aka_tingkat',$kode) > 1) $error .= "Error: Kode ".$kode." sudah terdaftar , silahkan ulangi.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `aka_tingkat` SET `tingkat`='$tingkat' ,`kode`='$kode' WHERE `replid`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=lokasi&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `aka_tingkat` WHERE `replid`='$id'");
$data 		= mysql_fetch_array($query);
	$tingkat 		= $data['tingkat'];
	$kode 		= $data['kode'];
	$tahunajaran 		= $data['tahunajaran'];

$tingkat     		= !isset($tingkat) ? '' : $tingkat;
$kode     		= !isset($kode) ? '' : $kode;
$tahunajaran     		= !isset($tahunajaran) ? '' : $tahunajaran;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .='<tr>
		<td>Nama</td>
		<td>:</td>
		<td><input type="text" name="tingkat" value="'.$tingkat.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Kode</td>
		<td>:</td>
		<td><input type="text" name="kode" value="'.$kode.'" size="30" class="form-control"required></td>
	</tr>';
	/*
$admin .= '<tr>
	<td>Tahun Ajaran</td>
		<td>:</td>
	<td><select name="tahunajaran" class="form-control" id="tahunajaran"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tahunajaran ORDER BY tahunajaran asc");
$admin .= '<option value="">== Tahun Ajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tahunajaran)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tahunajaran'].'</option>';
}
$admin .='</select></td>
</tr>';*/
$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=jenjang&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';			
}

if($_GET['aksi']==""){
if(isset($_POST['submit'])){
$tingkat=$_POST['tingkat'];
$kode=$_POST['kode'];
//$tahunajaran=$_POST['tahunajaran'];
	$error 	= '';	
	if (cekkodesama('kode','aka_tingkat',$kode) > 0) $error .= "Error: Kode ".$kode." sudah terdaftar , silahkan ulangi.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `aka_tingkat`(tingkat,kode) VALUES ('$tingkat','$kode')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($tingkat);
		unset($kode);
		unset($tahunajaran);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=jenjang&mod=yes" />';  
	}

}
$tingkat     		= !isset($tingkat) ? '' : $tingkat;
$kode     		= !isset($kode) ? '' : $kode;
$tahunajaran     		= !isset($tahunajaran) ? '' : $tahunajaran;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .='<tr>
		<td>Nama</td>
		<td>:</td>
		<td><input type="text" name="tingkat" value="'.$tingkat.'" size="30" class="form-control"required></td>
	</tr>
	<tr>
		<td>Kode</td>
		<td>:</td>
		<td><input type="text" name="kode" value="'.$kode.'" size="30" class="form-control"required></td>
	</tr>';
	/*
$admin .= '<tr>
	<td>Tahun Ajaran</td>
		<td>:</td>
	<td><select name="tahunajaran" class="form-control" id="tahunajaran"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_tahunajaran ORDER BY tahunajaran asc");
$admin .= '<option value="">== Tahun Ajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tahunajaran)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['tahunajaran'].'</option>';
}
$admin .='</select></td>
</tr>';*/
$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=jenjang&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
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
            <th>Kode</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM aka_tingkat order by urutan asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$tingkat=$data['tingkat'];
$kode=$data['kode'];
$idtahunajaran=$data['tahunajaran'];
$admin .='<tr>
<td>'.$kode.'</td>
<td>'.$tingkat.'</td>
<td><a href="?pilih=jenjang&amp;mod=yes&amp;aksi=del&amp;id='.$data['replid'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=jenjang&amp;mod=yes&amp;aksi=edit&amp;id='.$data['replid'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}
echo $admin;

?>