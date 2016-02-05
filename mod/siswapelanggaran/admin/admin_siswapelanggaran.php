<?php

if (!defined('AURACMS_admin')) {
    Header("Location: ../index.php");
    exit;
}

if (!cek_login()){
    header("location: index.php");
    exit;
} else{
$JS_SCRIPT.= <<<js
<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
    $('#example').dataTable();
} );

</script>
js;
$JS_SCRIPT.= <<<js

<script type="text/javascript" src="js/chained/jquery.chained.min.js"></script>
js;
$JS_SCRIPT.= <<<js
<script language="JavaScript" type="text/javascript">
$(function() {
$("#kelas").chained("#siswa"); /* or $("#series").chainedTo("#mark"); */
$("#pelanggaran").chained("#kategori");
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
//$index_hal=1;	
$admin .= '<script type="text/javascript" language="javascript">
   function GP_popupConfirmMsg(msg) { //v1.0
  document.MM_returnValue = confirm(msg);
}
</script>';
$admin .='<h4 class="page-header">Administrasi Pelanggaran Siswa</h4>';
if($_GET['aksi']== 'del'){    
	global $koneksi_db;    
	$id     = int_filter($_GET['id']); 
$siswa = int_filter ($_GET['siswa']);	
	$hasil = $koneksi_db->sql_query("DELETE FROM `akad_siswapelanggaran` WHERE `id`='$id'");    
	if($hasil){    
		$admin.='<div class="sukses">pelanggaran Siswa berhasil dihapus! .</div>'; 
		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=siswapelanggaran&mod=yes&aksi=add&siswa='.$siswa.'" />';  		
	//	$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=siswapelanggaran&mod=yes" />';    
	}
}
######################################
# Edit
######################################
if ($_GET['aksi'] == 'edit'){
$id = int_filter ($_GET['id']);
if(isset($_POST['submit'])){
$tgl1     		= $_POST['tgl1'];
$siswa     		= $_POST['siswa1'];
$kelas     		= $_POST['kelas'];
$pelanggaran     		= $_POST['pelanggaran'];
$point = getfieldtabel('point','akad_pelanggaran','id',$pelanggaran);
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "update `akad_siswapelanggaran` set tgl='$tgl1',kelas='$kelas',pelanggaran='$pelanggaran',point='$point' ");
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($tgl1);
		unset($kelas);
		unset($pelanggaran);

		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=siswapelanggaran&mod=yes&aksi=add&siswa='.$siswa.'" />';  
	}

}
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_siswapelanggaran  where id='$id'" );
$data = $koneksi_db->sql_fetchrow($hasil);
$tgl1     		= $data['tgl'];
$siswa     		= $data['siswa'];
$kelas     		= $data['kelas'];
$pelanggaran= $data['pelanggaran'];
$kategori = getkatdaripelanggaran($data['pelanggaran']);
$tgl1     		= !isset($tgl1) ? '' : $tgl1;
$siswa     		= !isset($siswa) ? '' : $siswa;
$kelas     		= !isset($kelas) ? '' : $kelas;
$pelanggaran     		= !isset($pelanggaran) ? '' : $pelanggaran;
	
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Siswa Pelanggaran</h3></div>';

$admin .= '<form method="post" action=""class="form-inline">
<table class="table table-striped">
';
$admin .= '
<input type="hidden" name="siswa1" value="'.$siswa.'">';
$admin .= '<tr>
	<td>Nama Siswa</td>
		<td>:</td>
	<td><select name="siswa" id="siswa" class="form-control"  required disabled>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_siswa ORDER BY nama asc");
$admin .= '<option value="">== Siswa ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$pilihanj = ($datasj['replid']==$siswa)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihanj.'>'.$datasj['nama'].'</option>('.$datasj['nis'].') ';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>Kelas Siswa</td>
		<td>:</td>
	<td><select name="kelas" id="kelas"class="form-control" required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_siswakelas ORDER BY tahunajaran desc");
$admin .= '<option value="">== Kelas ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
	$pilihanj = ($datasj['id']==$kelas)?"selected":'';
				$aktif = ($datasj['tahunajaran']==$tahunajaranaktif)?"(Aktif)":'';
$admin .= '<option value="'.$datasj['kelas'].'"class="'.$datasj['siswa'].'"'.$pilihanj.'>'.getkelas($datasj['kelas']).' ('.$aktif.')</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
		<td>Tanggal</td>
		<td>:</td>
		<td><input type="text" name="tgl1" id="tgl1" value="'.$tgl1.'" size="30" class="form-control"required>&nbsp;</td>
	</tr>';
$admin .= '<tr>
	<td>Kategori</td>
		<td>:</td>
	<td><select name="kategori" id="kategori" class="form-control"  required >';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_pelanggarankat ORDER BY id asc");
$admin .= '<option value="">== Kategori ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$pilihanj = ($datasj['id']==$kategori)?"selected":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihanj.'>'.$datasj['nama'].'</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>Pelanggaran</td>
		<td>:</td>
	<td><select name="pelanggaran" id="pelanggaran"class="form-control" required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_pelanggaran ORDER BY point asc");
$admin .= '<option value="">== Pelanggaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$pilihanj = ($datasj['id']==$pelanggaran)?"selected":'';
$admin .= '<option value="'.$datasj['id'].'"class="'.$datasj['kategori'].'"'.$pilihanj .'>'.$datasj['nama'].' ('.$datasj['point'].')</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
    <td><input type="submit" value="Simpan" name="submit" class="btn btn-success">&nbsp;&nbsp;<a href="?pilih=siswapelanggaran&mod=yes" class="btn btn-warning">Batal</a></td>
  </tr>
</table></form>';
$admin .= '</div>';
/******************/
}

######################################
# Add
######################################
if ($_GET['aksi'] == 'add'){
$siswa = int_filter ($_GET['siswa']);
if(isset($_POST['submit'])){
$tgl1     		= $_POST['tgl1'];
$siswa     		= $_POST['siswa1'];
$kelas     		= $_POST['kelas'];
$pelanggaran     		= $_POST['pelanggaran'];
$point = getfieldtabel('point','akad_pelanggaran','id',$pelanggaran);
	$error 	= '';	
	if ($error){
		$admin .= '<div class="error">'.$error.'</div>';
	}else{
		$hasil  = mysql_query( "INSERT INTO `akad_siswapelanggaran`  VALUES ('','$tgl1','$siswa','$kelas','$pelanggaran','$point')" );
		if($hasil){
			$admin .= '<div class="sukses"><b>Berhasil di Buat.</b></div>';
		}else{
			$admin .= '<div class="error"><b> Gagal di Buat.</b></div>';
		}
		unset($tgl1);

		unset($kelas);
		unset($pelanggaran);

		$style_include[] ='<meta http-equiv="refresh" content="1; url=admin.php?pilih=siswapelanggaran&mod=yes&aksi=add&siswa='.$siswa.'" />';  
	}

}

$hasil = $koneksi_db->sql_query( "SELECT * FROM aka_siswa  where replid='$siswa'" );
$data = $koneksi_db->sql_fetchrow($hasil);
$siswa     		= $data['replid'];
	
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Siswa Pelanggaran</h3></div>';

$admin .= '<form method="post" action=""class="form-inline">
<table class="table table-striped">
';
$admin .= '
<input type="hidden" name="siswa1" value="'.$siswa.'">';
$admin .= '<tr>
	<td>Nama Siswa</td>
		<td>:</td>
	<td><select name="siswa" id="siswa" class="form-control"  required disabled>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM aka_siswa ORDER BY nama asc");
$admin .= '<option value="">== Siswa ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$pilihanj = ($datasj['replid']==$siswa)?"selected":'';
$admin .= '<option value="'.$datasj['replid'].'"'.$pilihanj.'>('.$datasj['nis'].') '.$datasj['nama'].'</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>Kelas Siswa</td>
		<td>:</td>
	<td><select name="kelas" id="kelas"class="form-control" required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_siswakelas ORDER BY tahunajaran desc");
$admin .= '<option value="">== Kelas ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$aktif = ($datasj['tahunajaran']==$tahunajaranaktif)?"(Aktif)":'';
$admin .= '<option value="'.$datasj['kelas'].'"class="'.$datasj['siswa'].'">'.getkelas($datasj['kelas']).' '.$aktif.'</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
		<td>Tanggal</td>
		<td>:</td>
		<td><input type="text" name="tgl1" id="tgl1" value="'.$tgl1.'" size="30" class="form-control"required>&nbsp;</td>
	</tr>';
$admin .= '<tr>
	<td>Kategori</td>
		<td>:</td>
	<td><select name="kategori" id="kategori" class="form-control"  required >';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_pelanggarankat ORDER BY id asc");
$admin .= '<option value="">== Kategori ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$pilihanj = ($datasj['id']==$kategori)?"selected":'';
$admin .= '<option value="'.$datasj['id'].'"'.$pilihanj.'>'.$datasj['nama'].'</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>Pelanggaran</td>
		<td>:</td>
	<td><select name="pelanggaran" id="pelanggaran"class="form-control" required>';
$hasilj = $koneksi_db->sql_query("SELECT * FROM akad_pelanggaran ORDER BY point asc");
$admin .= '<option value="">== Pelanggaran ==</option>';
while ($datasj =  $koneksi_db->sql_fetchrow ($hasilj)){
$pilihanj = ($datasj['id']==$pelanggaran)?"selected":'';
$admin .= '<option value="'.$datasj['id'].'"class="'.$datasj['kategori'].'">'.$datasj['nama'].' ('.$datasj['point'].')</option>';
}
$admin .='</select></td>
</tr>';
$admin .= '<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
    <td><input type="submit" value="Simpan" name="submit" class="btn btn-success">&nbsp;&nbsp;<a href="?pilih=siswapelanggaran&mod=yes" class="btn btn-warning">Kembali</a></td>
  </tr>
</table></form>';
$admin .= '</div>';
/******************/
}

if (($_GET['aksi'] == 'add')or($_GET['aksi'] == 'edit')){
		$siswa = int_filter ($_GET['siswa']);
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Siswa Pelanggaran</h3></div>';
$admin.='
<table id="example"class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Siswa</th>
            <th>Kelas</th>
            <th>Pelanggaran</th>
            <th>Point</th>			
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_siswapelanggaran  where siswa='$siswa' order by tgl desc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$tgl1     		= $data['tgl'];
$siswa     		= $data['siswa'];
$kelas     		= $data['kelas'];
$pelanggaran= $data['pelanggaran'];
$point     		= $data['point'];
$admin .='<tr>
<td>'.datetimes($tgl1,false,false).'</td>
<td>'.getsiswa($siswa).'</td>
<td>'.getkelas($kelas).'</td>
<td>'.getpelanggaran($pelanggaran).'</td>
<td>'.$point.'</td>
<td><a href="?pilih=siswapelanggaran&amp;mod=yes&amp;aksi=del&amp;id='.$data['id'].'&siswa='.$siswa.'" onclick="return confirm(\'Apakah Anda Yakin Ingin Menghapus Data Ini ?\')"><span class="btn btn-danger">Hapus</span></a> <a href="?pilih=siswapelanggaran&amp;mod=yes&amp;aksi=edit&amp;id='.$data['id'].'"><span class="btn btn-warning">Edit</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';
$admin .= '</div>';
}

if ($_GET['aksi'] == ''){

$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Daftar Pelanggaran Siswa</h3></div>';
$admin.='
<table id="example"class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>NIS</th>
            <th>NISN</th>
            <th>Nama</th>
            <th>Pelanggaran</th>
			<th>(Total Point)</th>			
            <th>Aksi</th>
        </tr>
    </thead>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM aka_siswa    order by nama asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
	$replid     		= $data['replid'];
$nama     		= $data['nama'];
$nis     		= $data['nis'];
$nisn     		= $data['nisn'];
$datapelanggaran=getpelanggaranpersiswa($replid);
$jumlahpoint = ($datapelanggaran['jumlahpoint'])?$datapelanggaran['jumlahpoint']:'0';
$admin .='<tr>
<td>'.($nama).'</td>
<td>'.($nis).'</td>
<td>'.($nisn).'</td>
<td>'.$datapelanggaran['jumlah'].'</td>
<td>'.$jumlahpoint.'</td>
<td><a href="?pilih=siswapelanggaran&amp;mod=yes&amp;aksi=add&amp;siswa='.$data['replid'].'" onclick="return confirm(\'Apakah Anda Yakin Ingin menambah Pelanggaran ?\')"><span class="btn btn-primary">Tambah</span></a>&nbsp;&nbsp;<a href="?pilih=siswapelanggaran&amp;mod=yes&amp;aksi=cetak&amp;idsiswa='.$data['replid'].'"><span class="btn btn-success">Cetak</span></a></td>
</tr>';
}
$admin .= '</tbody></table>';
$admin .= '</div>';
}

if($_GET['aksi']== 'cetak'){ 
$idsiswa     = int_filter($_GET['idsiswa']);
if(isset($_POST['cetak'])){
$tgl1 		= $_POST['tgl1'];
$tgl2 		= $_POST['tgl2'];
$admin .= '<script language=javascript>
window.open("./cetaksiswapelanggaran.php?idsiswa='.$idsiswa.'&tgl1='.$tgl1.'&tgl2='.$tgl2.'", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=50, left=200, width=800, height=600");
</script>';

}
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Cari Siswa</h3></div>';
$admin .= '
<form method="post" action="" class="form-inline"id="posts"class="form-inline">
<table class="table table-striped table-hover">
	<tr>
		<td>Siswa</td>
		<td>:</td>
		<td>'.getsiswa($idsiswa).'<input type="hidden" name="idsiswa" value="'.$idsiswa.'"></td>
		</tr>
	<tr>
		<td>Tanggal Mulai</td>
		<td>:</td>
		<td><input type="text" id="tgl1" name="tgl1" value="'.$tgl1.'"class="form-control"  required></td>
		</tr>
	<tr>
		<td>Tanggal Akhir</td>
		<td>:</td>
		<td><input type="text" id="tgl2" name="tgl2" value="'.$tgl2.'"class="form-control" required></td>
		</tr>	
<tr>
		<td></td>
		<td></td>
		<td>
		<input type="submit" value="Cetak" name="cetak"class="btn btn-success">&nbsp;
		<a href="?pilih=siswapelanggaran&amp;mod=yes"><span class="btn btn-danger">Kembali</span></a>
		</td>
	</tr>		
		</table></form></div>';
}


}

echo $admin;

?>