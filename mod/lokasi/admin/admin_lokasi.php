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
$admin .='<h4 class="page-header">Administrasi Departemen</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
		$error 	= 'Error terdapat FK';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
	$hasil = $koneksi_db->sql_query("DELETE FROM `departemen` WHERE `replid`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Lokasi berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=lokasi&mod=yes" />';    
	}
}
}

if($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$kepsek 		= $_POST['kepsek'];
	$alamat 		= $_POST['alamat'];
	$telepon 		= $_POST['telepon'];
	$jenjang 		= $_POST['jenjang'];	
	$error 	= '';	
	if ($error){
		$tengah .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `departemen` SET `nama`='$nama' ,`kepsek`='$kepsek',`alamat`='$alamat',`telepon`='$telepon',`keterangan`='$jenjang' WHERE `replid`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=lokasi&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `departemen` WHERE `replid`='$id'");
$data 		= mysql_fetch_array($query);
	$nama 		= $data['nama'];
	$kepsek 		= $data['kepsek'];
	$alamat 		= $data['alamat'];
	$telepon 		= $data['telepon'];
	$jenjang 		= $data['keterangan'];
$nama     		= !isset($nama) ? '' : $nama;
$kepsek     		= !isset($kepsek) ? '' : $kepsek;
$alamat     		= !isset($alamat) ? '' : $alamat;
$telepon     		= !isset($telepon) ? '' : $telepon;
$jenjang     		= !isset($jenjang) ? '' : $jenjang;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .='<tr>
		<td>Nama Sekolah</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
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
$admin .='<tr>
		<td>Alamat</td>
		<td>:</td>
		<td><input type="text" name="alamat" value="'.$alamat.'" size="30" class="form-control"required></td>
	</tr>
		<tr>
		<td>Telepon</td>
		<td>:</td>
		<td><input type="text" name="telepon" value="'.$telepon.'" size="30" class="form-control"required></td>
	</tr>';
$admin .= '<tr>
	<td>Kepala Sekolah</td>
		<td>:</td>
	<td><select name="kepsek" class="form-control" id="kepsek"required>';
$idjabatan = getidjabatan('kepala sekolah');
$hasilj = $koneksi_db->sql_query("SELECT * FROM hrd_karyawan where jabatan='$idjabatan' ORDER BY nama asc");
$admin .= '<option value="">== Kepala Sekolah ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['id']==$kepsek)?"selected":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihan.'>'.$datasj['nama'].' ('.$datasj['nip'].')</option>';
}
$admin .='</select></td>
</tr>';
$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=lokasi&amp;mod=yes"><span class="btn btn-warning">Batal</span></a>
		</td>
	</tr>
</table>
</form></div>
';	
}

if($_GET['aksi']==""){
if(isset($_POST['submit'])){
	$nama 		= $_POST['nama'];
	$kepsek 		= $_POST['kepsek'];
	$alamat 		= $_POST['alamat'];
	$telepon 		= $_POST['telepon'];
	$jenjang 		= $_POST['jenjang'];
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `departemen`(nama,kepsek,alamat,telepon,keterangan) VALUES ('$nama','$kepsek','$alamat','$telepon','$jenjang')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($nama);
		unset($kepsek);
		unset($alamat);
		unset($telepon);
		unset($jenjang);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=lokasi&mod=yes" />';  
	}

}
$nama     		= !isset($nama) ? '' : $nama;
$kepsek     		= !isset($kepsek) ? '' : $kepsek;
$alamat     		= !isset($alamat) ? '' : $alamat;
$telepon     		= !isset($telepon) ? '' : $telepon;
$jenjang     		= !isset($jenjang) ? '' : $jenjang;
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">';
$admin .='<tr>
		<td>Nama Sekolah</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="30" class="form-control"required></td>
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
$admin .='<tr>
		<td>Alamat</td>
		<td>:</td>
		<td><input type="text" name="alamat" value="'.$alamat.'" size="30" class="form-control"required></td>
	</tr>
		<tr>
		<td>Telepon</td>
		<td>:</td>
		<td><input type="text" name="telepon" value="'.$telepon.'" size="30" class="form-control"required></td>
	</tr>';
$admin .= '<tr>
	<td>Kepala Sekolah</td>
		<td>:</td>
	<td><select name="kepsek" class="form-control" id="kepsek"required>';
$idjabatan = getidjabatan('kepala sekolah');
$hasilj = $koneksi_db->sql_query("SELECT * FROM hrd_karyawan where jabatan='$idjabatan' ORDER BY nama asc");
$admin .= '<option value="">== Kepala Sekolah ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['id']==$kepsek)?"selected":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihan.'>'.$datasj['nama'].' ('.$datasj['nip'].')</option>';
}
$admin .='</select></td>
</tr>';
$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=lokasi&amp;mod=yes"><span class="btn btn-warning">Batal</span></a>
		</td>
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
            <th>Nama</th>
            <th>Jenjang</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Kepala Sekolah</th>
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM departemen order by replid asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$nama=$data['nama'];
$jenjang=$data['keterangan'];
$kepsek=$data['kepsek'];
$alamat=$data['alamat'];
$telepon=$data['telepon'];
$admin .='<tr>
<td>'.$nama.'</td>
<td>'.getjenjang($jenjang).'</td>
<td>'.$alamat.'</td>
<td>'.$telepon.'</td>
<td>'.getdataguru('nama',$kepsek).'</td>
<td><a href="?pilih=lokasi&amp;mod=yes&amp;aksi=del&amp;id='.$data['replid'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=lokasi&amp;mod=yes&amp;aksi=edit&amp;id='.$data['replid'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';

/************************************/
}
echo $admin;

?>