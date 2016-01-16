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
$("#kelas").chained("#subtingkat"); /* or $("#series").chainedTo("#mark"); */
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
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=jadwal&mod=yes" />';    
	}
}


if($_GET['aksi']==""){
	
/************************************/
/********************************************************/
	if (isset($_POST['lihatdata'])){
	
$lokasi = $_POST['lokasi'];
$jenjang = $_POST['jenjang'];	
$tingkat = $_POST['tingkat'];
$kelas = $_POST['kelas'];
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
$admin .='</div>';
/************************************/
/*******************/
$sql2 = "SELECT * FROM `akad_hari` order by id asc";
$query2 = mysql_query( $sql2 );
while ($data2 = mysql_fetch_array($query2)) { 
$nama = $data2['nama'];
$id = $data2['id'];
$namahari.='<td>'.$nama.'</td>';

}
/*********************/
$admin.='
<table class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr><td></td>
            '.$namahari.'
        </tr>
    </thead>';
	$jam=1;
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_jam" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$idjam=$data['id'];
$namajam=$data['nama'];

$admin .='<tr><td>'.$namajam.'</td>';
/***************************/
$hasil3 = $koneksi_db->sql_query( "SELECT * FROM akad_hari order by id asc" );
while ($data3 = $koneksi_db->sql_fetchrow($hasil3)) {
$idhari = $data3['id'];
$admin.='<td><a href="#popup"> idhari:'.$idhari.', idjam:'.$idjam.'</td>';	
}
/*************************/
$admin .='</tr>';
$jam++;
}
$admin .= '</tbody></table>';
}
/************************************/
}
$admin .= '
<div class="popup-wrapper" id="popup">
	<div class="popup-container">
		<form action="http://www.syakirurohman.net/2015/01/tutorial-membuat-popup-tanpa-javascript-jquery.html#" method="post" class="popup-form">
			<h2>Ikuti Update !!</h2>
			<p>Daripada hanya melihat demo untuk popup-nya saja, lebih baik masukkan juga email anda agar mendapatkan pemberitahuan saat ada update posting menarik lain seperti ini.<br/>
			<strong>Percayalah, saya hanya akan mengirim sesuatu yang bermanfaat untuk anda :)</strong></p>
			<div class="input-group">
				<p><input type="email" name="email" placeholder="Email Address"></p>
				<p> 
				<input type="hidden" name="action" value="subscribe"> 
				<input type="hidden" name="source" value="http://www.syakirurohman.net/2015/01/tutorial-membuat-popup-tanpa-javascript-jquery.html"> 
				<input type="hidden" name="sub-type" value="widget"> 
				<input type="hidden" name="redirect_fragment" value="blog_subscription-2"> 
				<input type="hidden" id="_wpnonce" name="_wpnonce" value="aaf0b68fcd"> 
				<input type="submit" value="Submit" name="jetpack_subscriptions_widget">
				</p>
			</div>
		</form>
		<a class="popup-close" href="#closed">X</a>
	</div>
</div>';

echo $admin;

?>