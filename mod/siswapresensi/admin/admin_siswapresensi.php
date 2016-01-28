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
$admin .='<h4 class="page-header">Administrasi Absensi Siswa</h4>';

if($_GET['aksi']== 'cetak'){ 
$idsiswa     = int_filter($_GET['idsiswa']);
if(isset($_POST['cetak'])){

$admin .= '<script language=javascript>
window.open("./cetaksiswaabsen.php?idsiswa='.$idsiswa.'", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=200, width=800, height=600");
</script>';

}
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Cari Siswa</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline"id="posts">
<table class="table table-striped table-hover">
	<tr>
		<td>Siswa</td>
		<td>:</td>
		<td><select name="idsiswa" id="combobox" required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_siswa ORDER BY nama asc");
$admin .= '<option value="">== Siswa ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$pilihanj = ($datasj['replid']==$idsiswa)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihanj.'>('.$datasj['nis'].') '.$datasj['nama'].'</option>';
}
$admin .='</select>&nbsp;&nbsp;<input type="submit" value="Cetak" name="cetak"class="btn btn-success" ></td>
		</tr>
		</table></form></div>';
}

if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']);    
	$idsiswa     = int_filter($_GET['idsiswa']);
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_siswaabsen` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">Absensi Siswa berhasil dihapus! .</div>';    
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=siswapresensi&amp;mod=yes&aksi=lihat&idsiswa='.$idsiswa.'" />';   
	}
}

if($_GET['aksi']==""){

/************************************/
$admin.='
<table id="example"class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>NIS</th>
            <th>Nama</th>
            <th>Jumlah Bulan Presensi</th>
            <th width="15%">Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM aka_siswa order by nis asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$idsiswa=$data['replid'];
$nama=$data['nama'];
$nis=$data['nis'];
$admin .='<tr>
<td>'.$nis.'</td>
<td>'.$nama.'</td>
<td>'.cekabsenbulansiswa($idsiswa).'</td>
<td><a href="?pilih=siswapresensi&amp;mod=yes&amp;aksi=lihat&amp;idsiswa='.$data['replid'].'"><span class="btn btn-primary">Lihat</span></a>&nbsp;&nbsp;<a href="?pilih=siswapresensi&amp;mod=yes&amp;aksi=cetak&amp;idsiswa='.$data['replid'].'"><span class="btn btn-success">Cetak</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';


}

if($_GET['aksi']=="edit"){
$id = $_GET['id'];
$idsiswa = $_GET['idsiswa'];	
$kelasaktif = getkelassiswa($idsiswa,$tahunajaranaktif);
if(isset($_POST['submit'])){
$siswa 		= $_POST['idsiswa'];
$semester 		= $_POST['semester'];
$kelas 		= $_POST['kelas'];
$bulan 		= $_POST['bulan'];
$tahun 		= $_POST['tahun'];	
$hadir 		= $_POST['hadir'];
$sakit 		= $_POST['sakit'];
$ijin 		= $_POST['ijin'];
$alpa 		= $_POST['alpa'];
$cuti 		= $_POST['cuti'];
	$error 	= '';	
		if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM akad_siswaabsen WHERE siswa='$idsiswa' and semester = '$semester'and bulan = '$bulan' and tahun = '$tahun'")) > 0) $error .= "Error: Terdapat duplikasi data, silahkan ulangi.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "UPDATE `akad_siswaabsen` SET `hadir`='$hadir' ,`sakit`='$sakit',`ijin`='$ijin',`alpa`='$alpa',`cuti`='$cuti' WHERE `id`='$id'" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Update.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=siswapresensi&amp;mod=yes&aksi=lihat&idsiswa='.$idsiswa.'" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$query 		= mysql_query ("SELECT * FROM `akad_siswaabsen` WHERE `id`='$id'");
$data 		= mysql_fetch_array($query);
$semester 		= $data['semester'];
$kelas 		= $data['kelas'];
$bulan 		= $data['bulan'];
$tahun 		= $data['tahun'];
$hadir 		= $data['hadir'];
$sakit 		= $data['sakit'];
$ijin 		= $data['ijin'];
$alpa 		= $data['alpa'];
$cuti 		= $data['cuti'];

	
$semester     		= !isset($semester) ? $semesteraktif : $semester;
$kelas     		= !isset($kelas) ? $kelasaktif : $kelas;
$bulan     		= !isset($bulan) ? $bulanskrg : $bulan;
$tahun     		= !isset($tahun) ? $tahunaktif : $tahun;
$hadir     		= !isset($hadir) ? '0' : $hadir;
$sakit     		= !isset($sakit) ? '0' : $sakit;
$ijin     		= !isset($ijin) ? '0' : $ijin;
$alpa     		= !isset($alpa) ? '0' : $alpa;
$cuti     		= !isset($cuti) ? '0' : $cuti;
$query 		= mysql_query ("SELECT * FROM `aka_siswa` WHERE `replid`='$idsiswa'");
$data 		= mysql_fetch_array($query);
$replid     		= $data['replid'];
$nis     		= $data['nis'];
$nama     		= $data['nama'];	

$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Data Siswa</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">
<input type="hidden" name="idsiswa" value="'.$replid.'">
<input type="hidden" name="idsiswa" value="'.$replid.'">
<input type="hidden" name="idsiswa" value="'.$replid.'">
<input type="hidden" name="idsiswa" value="'.$replid.'">
<input type="hidden" name="idsiswa" value="'.$replid.'">
';

$admin .= '<tr>
	<td>NIS</td>
		<td>:</td>
	<td>'.$nis.'</td>
</tr>';
$admin .= '<tr>
	<td>Nama</td>
		<td>:</td>
	<td>'.$nama.'</td></tr>';
$admin .= '<tr>
	<td>Kelas</td>
		<td>:</td>
	<td>'.getkelas($kelas).'</td></tr>';	
$admin .= '<tr>
	<td>Semester</td>
		<td>:</td>
	<td>'.getsemester($semester).'</td></tr>';	
$admin .= '<tr>
	<td>Bulan</td>
		<td>:</td>
	<td>'.getbulan($bulan).'</td></tr>';	
$admin .= '<tr>
	<td>Tahun</td>
		<td>:</td>
	<td>'.$tahun.'</td></tr>';	
$admin .='
	<tr>
		<td>Hadir</td>
		<td>:</td>
		<td><input type="text" name="hadir" value="'.$hadir.'" size="30" class="form-control"required></td>
	</tr>';
	$admin .='
	<tr>
		<td>Sakit</td>
		<td>:</td>
		<td><input type="text" name="sakit" value="'.$sakit.'" size="30" class="form-control"required></td>
	</tr>';
	$admin .='
	<tr>
		<td>Ijin</td>
		<td>:</td>
		<td><input type="text" name="ijin" value="'.$ijin.'" size="30" class="form-control"required></td>
	</tr>';
	$admin .='
	<tr>
		<td>Alpa</td>
		<td>:</td>
		<td><input type="text" name="alpa" value="'.$alpa.'" size="30" class="form-control"required></td>
	</tr>';
	$admin .='
	<tr>
		<td>Cuti</td>
		<td>:</td>
		<td><input type="text" name="cuti" value="'.$cuti.'" size="30" class="form-control"required></td>
	</tr>';
$admin .='<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Simpan" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=siswapresensi&amp;mod=yes&aksi=edit&idsiswa='.$replid.'"><span class="btn btn-warning">Batal</span></a>&nbsp;
		<a href="?pilih=siswapresensi&amp;mod=yes"><span class="btn btn-danger">Kembali</span></a>
		</td>
	</tr>
</table>
</form></div>
';

}


if($_GET['aksi']=="lihat"){
$idsiswa = $_GET['idsiswa'];	
$kelasaktif = getkelassiswa($idsiswa,$tahunajaranaktif);
if(isset($_POST['submit'])){
$siswa 		= $_POST['idsiswa'];
$semester 		= $_POST['semester'];
$kelas 		= $_POST['kelas'];
$bulan 		= $_POST['bulan'];
$tahun 		= $_POST['tahun'];	
$hadir 		= $_POST['hadir'];
$sakit 		= $_POST['sakit'];
$ijin 		= $_POST['ijin'];
$alpa 		= $_POST['alpa'];
$cuti 		= $_POST['cuti'];
	$error 	= '';	
		if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT * FROM akad_siswaabsen WHERE siswa='$idsiswa' and semester = '$semester'and bulan = '$bulan' and tahun = '$tahun'")) > 0) $error .= "Error: Terdapat duplikasi data, silahkan ulangi.<br />";
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_siswaabsen`VALUES ('','$semester','$bulan','$tahun','$kelas','$siswa','$hadir','$sakit','$ijin','$alpa','$cuti')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Presensi Berhasil di Tambah.</b></div>';
			$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=siswapresensi&amp;mod=yes&aksi=lihat&idsiswa='.$siswa.'" />';	
		}else{
			$admin .= '<div class="error"><b>Gagal di Update.</b></div>';
		}
	}

}
$semester     		= !isset($semester) ? $semesteraktif : $semester;
$kelas     		= !isset($kelas) ? $kelasaktif : $kelas;
$bulan     		= !isset($bulan) ? $bulanskrg : $bulan;
$tahun     		= !isset($tahun) ? $tahunaktif : $tahun;
$hadir     		= !isset($hadir) ? '0' : $hadir;
$sakit     		= !isset($sakit) ? '0' : $sakit;
$ijin     		= !isset($ijin) ? '0' : $ijin;
$alpa     		= !isset($alpa) ? '0' : $alpa;
$cuti     		= !isset($cuti) ? '0' : $cuti;
$query 		= mysql_query ("SELECT * FROM `aka_siswa` WHERE `replid`='$idsiswa'");
$data 		= mysql_fetch_array($query);
$replid     		= $data['replid'];
$nis     		= $data['nis'];
$nama     		= $data['nama'];	

$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Data Siswa</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline">
<table class="table table-striped table-hover">
<input type="hidden" name="idsiswa" value="'.$replid.'">
';

$admin .= '<tr>
	<td>NIS</td>
		<td>:</td>
	<td>'.$nis.'</td>
</tr>';
$admin .= '<tr>
	<td>Nama</td>
		<td>:</td>
	<td>'.$nama.'</td></tr>';
$admin .= '<tr>
	<td>Kelas</td>
		<td>:</td>
	<td><select name="kelas" class="form-control" id="kelas"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_kelas ORDER BY kelas asc");
$admin .= '<option value="">== Kelas ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$pilihan = ($datasj['replid']==$kelas)?"selected":'';
$aktif = ($datasj['replid']==$kelas)?"(Aktif)":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihan.'>'.$datasj['kelas'].' '.$aktif.'</option>';
}
$admin .='</select></td></tr>';	
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
	<td>Bulan</td>
		<td>:</td>
	<td><select name="bulan" class="form-control" id="bulan"required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_bulan ORDER BY id asc");
$admin .= '<option value="">== Bulan ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
		$pilihan = ($datasj['id']==$bulan)?"selected":'';
		$aktif = ($datasj['id']==$bulanskrg)?"(Sekarang)":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihan.'>'.$datasj['nama'].' '.$aktif.'</option>';
}
$admin .='</select></td></tr>';	
$admin .= '<tr>
	<td>Tahun</td>
		<td>:</td>
	<td><select name="tahun" class="form-control" id="tahun"required>';
$admin .= '<option value="">== Tahun ==</option>';
		for ($i= 2010; $i <= 2050; $i++){
		$pilihan = ($i==$tahunskrg)?"selected":'';
		$aktif = ($i==$tahunskrg)?"(Sekarang)":'';
$admin .= '<option value="'.$i.'"'.$pilihan.'>'.$i.' '.$aktif.'</option>';
}
$admin .='</select></td></tr>';	
$admin .='
	<tr>
		<td>Hadir</td>
		<td>:</td>
		<td><input type="text" name="hadir" value="'.$hadir.'" size="30" class="form-control"required></td>
	</tr>';
	$admin .='
	<tr>
		<td>Sakit</td>
		<td>:</td>
		<td><input type="text" name="sakit" value="'.$sakit.'" size="30" class="form-control"required></td>
	</tr>';
	$admin .='
	<tr>
		<td>Ijin</td>
		<td>:</td>
		<td><input type="text" name="ijin" value="'.$ijin.'" size="30" class="form-control"required></td>
	</tr>';

	$admin .='
	<tr>
		<td>Alpa</td>
		<td>:</td>
		<td><input type="text" name="alpa" value="'.$alpa.'" size="30" class="form-control"required></td>
	</tr>';
	$admin .='
	<tr>
		<td>Cuti</td>
		<td>:</td>
		<td><input type="text" name="cuti" value="'.$cuti.'" size="30" class="form-control"required></td>
	</tr>';
$admin .='<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Tambah" name="submit"class="btn btn-success">&nbsp;
		<a href="?pilih=siswapresensi&amp;mod=yes&aksi=lihat&idsiswa='.$replid.'"><span class="btn btn-warning">Batal</span></a>&nbsp;
		<a href="?pilih=siswapresensi&amp;mod=yes"><span class="btn btn-danger">Kembali</span></a>
		</td>
	</tr>
</table>
</form></div>
';

}
/************************************/
if($_GET['aksi']=="lihat" or $_GET['aksi']=="edit"){
	$idsiswa = $_GET['idsiswa'];
/************************************/
$admin.='
<table id="example"class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Tahun</th>
            <th>Bulan</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Hadir</th>
            <th>Sakit</th>
            <th>Ijin</th>
            <th>Alpa</th>
            <th>Cuti</th>
            <th width="13%">Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_siswaabsen where siswa='$idsiswa' order by tahun,bulan,semester asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
	$id=$data['id'];
$tahun=$data['tahun'];
$bulan=$data['bulan'];
$siswa=$data['siswa'];
$hadir=$data['hadir'];
$sakit=$data['sakit'];
$ijin=$data['ijin'];
$alpa=$data['alpa'];
$cuti=$data['cuti'];
$admin .='<tr>
<td>'.$tahun.'</td>
<td>'.getfieldtabel('nama','akad_bulan','id',$bulan).'</td>
<td>'.getfieldtabel('nis','aka_siswa','replid',$siswa).'</td>
<td>'.getfieldtabel('nama','aka_siswa','replid',$siswa).'</td>
<td>'.$hadir.'</td>
<td>'.$sakit.'</td>
<td>'.$ijin.'</td>
<td>'.$alpa.'</td>
<td>'.$cuti.'</td>
<td><a href="?pilih=siswapresensi&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'&idsiswa='.$replid.'"onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a>&nbsp;&nbsp;<a href="?pilih=siswapresensi&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'&idsiswa='.$replid.'"><span class="btn btn-primary">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';
}
}
echo $admin;

?>