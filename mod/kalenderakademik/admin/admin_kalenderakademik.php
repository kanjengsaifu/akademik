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
$JS_SCRIPT.= <<<js
<script type="text/javascript">
  $(function() {
$( "#tgl1" ).datepicker({ dateFormat: "yy-mm-dd" } );
$( "#tgl2" ).datepicker({ dateFormat: "yy-mm-dd" } );
  });
  </script>
js;

$script_include[] = $JS_SCRIPT;
$admin .='<h4 class="page-header">Administrasi Kalender Akademik</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_kalender` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Kalender Akademik berhasil dihapus! .</div>';    
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kalenderakademik&mod=yes" />';    
	}
}

if($_GET['aksi']=="edit"){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
$lokasi     		= $_POST['lokasi'];
$tgl1     		= $_POST['tgl1'];
$tgl2     		= $_POST['tgl2'];
$nama     		= $_POST['nama'];

	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `akad_kalender` SET `lokasi`='$lokasi' ,`tgl1`='$tgl1',`tgl2`='$tgl2',`nama`='$nama' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kalenderakademik&amp;mod=yes" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
		unset($lokasi);
		unset($tgl1);
		unset($tgl2);
		unset($nama);
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kalenderakademik&mod=yes" />';  
	}

}
$query 		= mysql_query ("SELECT * FROM `akad_kalender` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
$lokasi     		= $data['lokasi'];
$tgl1     		= $data['tgl1'];
$tgl2     		= $data['tgl2'];
$nama     		= $data['nama'];

$lokasi     		= !isset($lokasi) ? '' : $lokasi;
$tgl1     		= !isset($tgl1) ? '' : $tgl1;
$tgl2     		= !isset($tgl2) ? '' : $tgl2;
$nama     		= !isset($nama) ? '' : $nama;

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

$admin .='<tr>
		<td>Tgl Mulai</td>
		<td>:</td>
		<td><input type="text" name="tgl1" id="tgl1" value="'.$tgl1.'"  size="30" class="form-control"required>&nbsp;</td>
	</tr>
	<tr>
		<td>Tgl Akhir</td>
		<td>:</td>
		<td><input type="text" name="tgl2" id="tgl2" value="'.$tgl2.'" size="30" class="form-control"required>&nbsp;</td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="50" class="form-control"required></td>
	</tr>';

$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=kalenderakademik&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';	



}



if($_GET['aksi']==""){
if(isset($_POST['submit'])){
$lokasi     		= $_POST['lokasi'];
$tgl1     		= $_POST['tgl1'];
$tgl2     		= $_POST['tgl2'];
$nama     		= $_POST['nama'];
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_kalender`  VALUES ('','$lokasi','$tgl1','$tgl2','$nama')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($lokasi);
		unset($tgl1);
		unset($tgl2);
		unset($nama);

		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=kalenderakademik&mod=yes" />';  
	}

}

$lokasi     		= !isset($lokasi) ? '' : $lokasi;
$tgl1     		= !isset($tgl1) ? '' : $tgl1;
$tgl2     		= !isset($tgl2) ? '' : $tgl2;
$nama     		= !isset($nama) ? '' : $nama;

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

$admin .='<tr>
		<td>Tgl Mulai</td>
		<td>:</td>
		<td><input type="text" name="tgl1" id="tgl1" value="'.$tgl1.'"  size="30" class="form-control"required>&nbsp;</td>
	</tr>
	<tr>
		<td>Tgl Akhir</td>
		<td>:</td>
		<td><input type="text" name="tgl2" id="tgl2" value="'.$tgl2.'" size="30" class="form-control"required>&nbsp;</td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td>:</td>
		<td><input type="text" name="nama" value="'.$nama.'" size="50" class="form-control"required></td>
	</tr>';

$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=kalenderakademik&amp;mod=yes"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form></div>
';	

}
/********************************************************/
if($_GET['aksi']=="" or $_GET['aksi']=="edit"){
	if (isset($_POST['lihatdata'])){
	
$lokasi = $_POST['lokasi'];
$bulan = $_POST['bulan'];
$tahun = $_POST['tahun'];
if($lokasi==''){
         $wherelokasi="";
}else{
         $wherelokasi="where lokasi='$lokasi'";
}
if($bulan==''){
         $wherebulan="";
}else{
         $wherebulan="and (MONTH(tgl1)='$bulan')";
}
if($tahun==''){
         $wheretahun="";
}else{
         $wheretahun="and (YEAR(tgl1)='$tahun')";
}
}

$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Daftar Kegiatan Akademik</h3></div>';
$admin.='<form class="form-inline" method="post" action="" enctype ="multipart/form-data" id="posts">';
$admin.='
<table>';
$admin .= '<tr>
	<td><select name="lokasi" class="form-control" id="lokasi"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM departemen ORDER BY urut asc");
$admin .= '<option value="">== Lokasi ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$lokasi)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['nama'].'</option>';
}
$admin .='</select></td>';
$admin .='
		<td> <select name="bulan" class="form-control"required>';
		$admin .= '<option value="">== Bulan ==</option>';
		for ($i= 1; $i <= 12; $i++)
{
			$pilihan = ($i==$bulan)?"selected":'';
$admin .= '<option value="'.$i.'"'.$pilihan.'>'.$i.'</option>';	
}
$admin .='</select></td>';
$admin .='
		<td> <select name="tahun" class="form-control"required>';
		$admin .= '<option value="">== Tahun ==</option>';
		for ($i= 2010; $i <= 2050; $i++)
{
			$pilihan = ($i==$tahun)?"selected":'';
$admin .= '<option value="'.$i.'"'.$pilihan.'>'.$i.'</option>';	
}
$admin .='</select></td>';
$admin .= '
		<td>&nbsp;&nbsp;<a href="./fullcalendar/" target="_blank" class="btn btn-primary">Lihat Versi kalender</a>&nbsp;&nbsp;<input type="submit" value="Lihat" name="lihatdata" class="btn btn-success"></td>
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
            <th>Tgl Mulai</th>
            <th>Tgl Akhir</th>
            <th>Kegiatan</th>			
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_kalender $wherelokasi $wherebulan $wheretahun order by tgl1 asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$lokasi=$data['lokasi'];
$tgl1=$data['tgl1'];
$tgl2=$data['tgl2'];
$nama=$data['nama'];
$admin .='<tr>
<td>'.getfieldtabel('nama','departemen','replid',$lokasi).'</td>
<td>'.$tgl1.'</td>
<td>'.$tgl2.'</td>
<td>'.$nama.'</td>
<td><a href="?pilih=kalenderakademik&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=kalenderakademik&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';
$admin .= '</div>';
}
/************************************/
}
echo $admin;

?>