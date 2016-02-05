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
	$style_include[] = '
<style type="text/css">
/* untuk pemakaian di blog/website anda, yang di copy hanya css di bawah ini*/
	/* style untuk link popup */
	a.popup-link {
		padding:17px 0;
		text-align: center;
		margin:7% auto;
		position: relative;
		width: 300px;
		color: #fff;
		text-decoration: none;
		background-color: #FFBA00;
		border-radius: 3px;
		box-shadow: 0 5px 0px 0px #eea900;
		display: block;
	}
	a.popup-link:hover {
		background-color: #ff9900;
		box-shadow: 0 3px 0px 0px #eea900;
		-webkit-transition:all 1s;
		-moz-transition:all 1s;
		transition:all 1s;
	}
	/* end link popup*/

	/*style untuk popup */	
	#popup {
		visibility: hidden;
		opacity: 0;
		margin-top: -200px;
	}
	#popup:target {
		visibility:visible;
		opacity: 1;
		background-color: rgba(255,255,255,0.8);
		position: fixed;
		top:0;
		left:0;
		right:0;
		bottom:0;
		margin:0;
		z-index: 99999999999;
		-webkit-transition:all 1s;
		-moz-transition:all 1s;
		transition:all 1s;
	}

	@media (min-width: 768px){
		.popup-container {
			width:600px;
		}
	}
	@media (max-width: 767px){
		.popup-container {
			width:100%;
		}
	}
	.popup-container {
		position: relative;
		margin:7% auto;
		padding:30px 50px;
		background-color: #333;
		color:#fff;
		border-radius: 3px;
	}

	a.popup-close {
		position: absolute;
		top:3px;
		right:3px;
		background-color: #fff;
		padding:7px 10px;
		font-size: 20px;
		text-decoration: none;
		line-height: 1;
		color:#333;
	}

	/* style untuk isi popup */


	.popup-form {
		margin:10px auto;
	}
		.popup-form h2 {
			margin-bottom: 5px;
			font-size: 37px;
			text-transform: uppercase;
		}
		.popup-form .input-group {
			margin:10px auto;
		}
			.popup-form .input-group input {
				padding:17px;
				text-align: center;
				margin-bottom: 10px;
				border-radius:3px;
				font-size: 16px; 
				display: block;
				width: 100%;
			}
			.popup-form .input-group input:focus {
				outline-color:#FB8833; 
			}
			.popup-form .input-group input[type="email"] {
				border:0px;
				position: relative;
			}
			.popup-form .input-group input[type="submit"] {
				background-color: #FB8833;
				color: #fff;
				border: 0;
				cursor: pointer;
			}
			.popup-form .input-group input[type="submit"]:focus {
				box-shadow: inset 0 3px 7px 3px #ea7722;
			}
	/* end isi form */
	</style>';
	
$admin .= '<script lnguage="javascript"> function redir(mylist){ if (newurl=mylist.options[mylist.selectedIndex].value)
document.location=newurl;}</script>';

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
$("#tingkat").chained("#jenjang");
$("#kelas").chained("#tingkat"); 
$("#guru").chained("#matpel");/* or $("#series").chainedTo("#mark"); */
} );
</script>
js;

$script_include[] = $JS_SCRIPT;
$admin .='<h4 class="page-header">Administrasi Jadwal Pelajaran</h4>';

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_jadwal` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Jadwal Pelajaran berhasil dihapus! .</div>';   
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=jadwal&mod=yes&lokasi='.$lokasi.'&jenjang='.$jenjang.'&tingkat='.$tingkat.'&kelas='.$kelas.'&tahunajaran='.$tahunajaran.'" />';  		
	}
}


if($_GET['aksi']==""){
$lokasi = $_GET['lokasi'];
$jenjang = $_GET['jenjang'];	
$tingkat = $_GET['tingkat'];
$kelas = $_GET['kelas'];
$tahunajaran = $_GET['tahunajaran'];	
$hari = $_GET['hari'];	
$jamke = $_GET['jamke'];	
/************************************/
/********************************************************/
	if (isset($_GET['lihatdata'])){
	
$lokasi = $_GET['lokasi'];
$jenjang = $_GET['jenjang'];	
$tingkat = $_GET['tingkat'];
$kelas = $_GET['kelas'];
$tahunajaran = $_GET['tahunajaran'];
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
if($kelas==''){
         $wherekelas="";
}else{
         $wherekelas="and kelas='$kelas'";
}
if($tahunajaran==''){
         $wheretahunajaran="";
}else{
         $wheretahunajaran="and tahunajaran='$tahunajaran'";
}

}

$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Daftar Kelas</h3></div>';
$admin.='<form class="form-inline" method="get" action="" enctype ="multipart/form-data" id="posts">';
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
$admin .= '<option value="'.$datasj['replid'].'"class="'.$datasj['tingkat'].'"'.$pilihan.'>'.$datasj['subtingkat'].'</option>';
}
$admin .='</select></td>';
$admin .= '
	<td><select name="kelas" class="form-control" id="kelas">';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_kelas ORDER BY kelas asc");
$admin .= '<option value="">== Kelas ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$kelas)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"class="'.$datasj['subtingkat'].'"'.$pilihan.'>'.$datasj['kelas'].'</option>';
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
		<td><input type="hidden" name="pilih" value="jadwal" size="30" class="form-control">
		<input type="hidden" name="mod" value="yes" size="30" class="form-control">
		<input type="submit" value="Lihat" name="lihatdata" class="btn btn-success"></td>
</tr>
';
$admin.='
</table>';
$admin .='</form>';
$admin .='</div>';
/************************************/
/*******************/
$sql2 = "SELECT * FROM `akad_hari` order by id asc";
$query2 = mysql_query( $sql2 );
while ($data2 = mysql_fetch_array($query2)) { 
$nama = $data2['nama'];
$id = $data2['id'];
$namahari.='<td width="250px"  align="center">'.$nama.'</td>';

}
/*********************/
$admin.='
<table class="table table-bordered">
    <thead>
        <tr><td width="200px" align="center">Jam - Hari</td>
            '.$namahari.'
        </tr>
    </thead>';
	$jam=1;
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_jam" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$idjam=$data['id'];
$namajam=$data['nama'];
$mulai=$data['mulai'];
$selesai=$data['selesai'];
$admin .='<tr><td  align="center">'.$namajam.' ('.$mulai.'-'.$selesai.')</td>';
/***************************/
if (isset($_GET['lihatdata'])or isset($_GET['kelas'])){
$hasil3 = $koneksi_db->sql_query( "SELECT * FROM akad_hari order by id asc" );
while ($data3 = $koneksi_db->sql_fetchrow($hasil3)) {
$idhari = $data3['id'];
$cekajar = cekajar($lokasi,$kelas,$idhari,$idjam);
if($cekajar>0){
$getjadwal	=getjadwal($lokasi,$kelas,$idhari,$idjam);
//$namaguru = 	getdataguru('nama',getjadwal($lokasi,$kelas,$idhari,$idjam));
	$admin.='<td>
	<a href="admin.php?pilih=jadwal&mod=yes&lokasi='.$lokasi.'&jenjang='.$jenjang.'&tingkat='.$tingkat.'&kelas='.$kelas.'&tahunajaran='.$tahunajaran.'&hari='.$idhari.'&jamke='.$idjam.'&aksi=del&id='.$getjadwal['id'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"class="btn btn-warning">
	'.getdataguru('nama',$getjadwal['guru']).'<br>(
	'.getmatpel($getjadwal['matpel']).')</a>
	</td>';
}else{
$admin.='<td align="center"><a href="admin.php?pilih=jadwal&mod=yes&lokasi='.$lokasi.'&jenjang='.$jenjang.'&tingkat='.$tingkat.'&kelas='.$kelas.'&tahunajaran='.$tahunajaran.'&hari='.$idhari.'&jamke='.$idjam.'&popup#popup"class="btn btn-primary">Tambah</a></td>';	
}
}
}
/*************************/
$admin .='</tr>';
$jam++;
}
$admin .= '</tbody></table>';
}
/************************************/
$admin .= '
<div class="popup-wrapper" id="popup">
	<div class="popup-container">';
	if (isset($_POST['submit'])){

$lokasi = $_POST['lokasi'];
$jenjang = $_POST['jenjang'];	
$tingkat = $_POST['tingkat'];
$kelas = $_POST['kelas'];
$tahunajaran = $_POST['tahunajaran'];
$hari = $_POST['hari'];
$jam = $_POST['jam'];	
$guru = $_POST['guru'];	
$matpel = $_POST['matpel'];	
	if (cekjadwaldobelguru($guru,$hari,$jam) > 0) $error .= "Error: Terdapat duplikasi data mengajar, silahkan memilih Guru lain atau Batal.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_jadwal` VALUES ('','$lokasi','$jenjang','$tahunajaran','$tingkat','$kelas','$matpel','$guru','$hari','$jam')" );
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=jadwal&mod=yes&lokasi='.$lokasi.'&jenjang='.$jenjang.'&tingkat='.$tingkat.'&kelas='.$kelas.'&tahunajaran='.$tahunajaran.'" />'; 
				}
	}

$admin .= '
<form method="post" action="" class="form-inline">
<table class="table">';
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
<td>Tahun Ajaran</td>
		<td>:</td>
		<td>'.gettahunajaran($tahunajaran).'</td>
</tr>';
$admin .= '<tr>
<td>Tingkat</td>
		<td>:</td>
		<td>'.gettingkat($tingkat).'</td>
</tr>';
$admin .= '<tr>
<td>Kelas</td>
		<td>:</td>
		<td>'.getkelas($kelas).'</td>
</tr>';
$admin .= '<tr>
<td>Hari</td>
		<td>:</td>
		<td>'.gethari($hari).'</td>
</tr>';
$admin .= '<tr>
<td>Jam Ke</td>
		<td>:</td>
		<td>'.getjam($jamke).'</td>
</tr>';
$admin .='
	<tr>
		<td>Mata Pelajaran</td>
		<td>:</td>
<td><select name="matpel" class="form-control" id="matpel" required>';
$hasilj = $koneksi_db->sql_query("SELECT *FROM akad_guru where tingkat = '$tingkat' ORDER BY id asc");
$admin .= '<option value="">== Pilih Mata Pelajaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$admin .= '<option value="'.$datasj['matpel'].'">'.getmatpel($datasj['matpel']).'</option>';
}
$admin .='</select></td>
	</tr>';
$admin .='
	<tr>
		<td>Guru</td>
		<td>:</td>
<td><select name="guru" class="form-control" id="guru" required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_guru  ORDER BY id asc");
$admin .= '<option value="">== Pilih Guru ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$admin .= '<option value="'.$datasj['guru'].'"class="'.$datasj['matpel'].'"'.$pilihan.'>'.getdataguru('nama',$datasj['guru']).'</option>';
}
$admin .='</select></td>
	</tr>';


$admin .='
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="hidden" name="lokasi" value="'.$lokasi.'">
<input type="hidden" name="jenjang" value="'.$jenjang.'">
<input type="hidden" name="tingkat" value="'.$tingkat.'">
<input type="hidden" name="kelas" value="'.$kelas.'">
<input type="hidden" name="tahunajaran" value="'.$tahunajaran.'">
<input type="hidden" name="hari" value="'.$hari.'">
<input type="hidden" name="jam" value="'.$jamke.'">
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="admin.php?pilih=jadwal&mod=yes&lokasi='.$lokasi.'&jenjang='.$jenjang.'&tingkat='.$tingkat.'&kelas='.$kelas.'&tahunajaran='.$tahunajaran.'"><span class="btn btn-warning">Batal</span></a></td>
	</tr>
</table>
</form>';

$admin.='<a class="popup-close" href="#closed">X</a>
	</div>
</div>';
}
echo $admin;

?>