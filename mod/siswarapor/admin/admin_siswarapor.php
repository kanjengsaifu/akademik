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
$admin .='<h4 class="page-header">Administrasi Siswa - Rapor</h4>';
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
		
		<a href="?pilih=siswarapor&amp;mod=yes"><span class="btn btn-warning">Kembali</span></a></td>
	</tr>
</table>
</div>
';
if($_GET['detail']=="hapussiswa"){
	$idkelas 		= $_GET['idkelas'];
$idsiswa 		= $_GET['idsiswa'];	
$hasil = $koneksi_db->sql_query("DELETE FROM `akad_siswaraporaf` WHERE `siswa`='$idsiswa'");    
	if($hasil){    
		$admin.='<div class="sukses">Rapor Siswa tersebut berhasil dihapus! .</div>';   
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=siswarapor&mod=yes&aksi=addsiswa&idkelas='.$idkelas.'" />';  		
	}
}
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
<td><a href="?pilih=siswarapor&amp;mod=yes&amp;aksi=addsiswa&amp;idkelas='.$idkelas.'&amp;detail=hapussiswa&amp;idsiswa='.$idsiswa.'"onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a>&nbsp;<a href="?pilih=siswarapor&amp;mod=yes&amp;aksi=addsiswa&amp;idkelas='.$idkelas.'&amp;detail=tambahrapor&amp;idsiswa='.$idsiswa.'&popup#popup"onclick="return confirm(\'Apakah Anda Yakin Ingin Menambah Data ?\')"><span class="btn btn-success">Tambah</span></a></td>
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
	<td><select name="jenjang" class="form-control" id="jenjang" required>';
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
	<td><select name="tingkat" class="form-control" id="tingkat" required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_subtingkat ORDER BY subtingkat asc");
$admin .= '<option value="">== Tingkat ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['replid']==$tingkat)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"class="'.$datasj['tingkat'].'"'.$pilihan.'>'.$datasj['subtingkat'].'</option>';
}
$admin .='</select></td>';
$admin .= '
	<td><select name="tahunajaran" class="form-control" id="tahunajaran" required>';
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
	if (isset($_POST['lihatdata'])){
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
<td><a href="?pilih=siswarapor&amp;mod=yes&amp;aksi=addsiswa&amp;idkelas='.$data['replid'].'"><span class="btn btn-warning">Lihat Siswa</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';
$admin .= '</div>';
}
}
/************************************/
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
$idkelas = int_filter ($_GET['idkelas']);
$idsiswa = int_filter ($_GET['idsiswa']);
$query 		= mysql_query ("SELECT * FROM `akad_kelas` WHERE `replid`='$idkelas'");
$data 		= mysql_fetch_array($query);
$jenjang     		= $data['jenjang'];
$departemen     		= $data['departemen'];
$tahunajaran     		= $data['tahunajaran'];
$datarapor = getidraporafkelas($jenjang,$departemen,$tahunajaran);
$idrapor     		= $datarapor['id'];
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table">';
$admin .= '<tr>
<td>Kelas</td>
		<td>:</td>
		<td>'.getkelas($idkelas).'</td>
</tr>';
$admin .= '<tr>
<td>Nama Siswa</td>
		<td>:</td>
		<td>'.getsiswa($idsiswa).'</td>
</tr>
</table>';
/*******************************/
$no=1;
$admin .='<table class="table" width="100%">
<tr>
<td width="5%">No</td>
<td>Master '.$idrapor.'</td>
<td colspan="2" width="10%">Nilai</td>
</tr>';
$selectgrade ='<select name="grade" class="form-control" required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_gradeafektif ORDER BY id asc");
$selectgrade .= '<option value="">== Grade ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$selectgrade .='<option value="'.$datasj['id'].'">'.$datasj['nama'].'</option>';
}
$selectgrade .='</select>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_afektifkat where master='0' and rapor='$idrapor' ORDER BY urut asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$idmaster = $data['id'];
$admin .='<tr>
<td>'.$no.'</td>
<td>'.$data['nama'].'</td>
<td></td>
</tr>';
$no++;

$hasil2 = $koneksi_db->sql_query( "SELECT * FROM akad_afektifkat where master='$idmaster' ORDER BY nama asc" );
while ($data2 = $koneksi_db->sql_fetchrow($hasil2)) {
$admin .='<tr>
<td></td>
<td>'.$data2['nama'].'</td>
<td>'.$selectgrade.'</td>
</tr>';	
}

}
$admin .='</table>';
$admin .='<table>
	<tr>
		<td></td>
		<td></td>
		<td>
		<input type="hidden" name="idrapor" value="'.$idrapor.'">
<input type="hidden" name="idkelas" value="'.$idkelas.'">
<input type="hidden" name="idsiswa" value="'.$idsiswa.'">
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=siswarapor&amp;mod=yes&amp;aksi=addsiswa&amp;idkelas='.$idkelas.'&amp;idsiswa='.$idsiswa.'"><span class="btn btn-warning">Batal</span></a></td>
	</tr></table>';
$admin .='
</form>';

$admin.='<a class="popup-close" href="#closed">X</a>
	</div>
</div>';
/*************************************/
}
echo $admin;

?>