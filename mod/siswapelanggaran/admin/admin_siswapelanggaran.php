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
$admin  .='<legend>SETTING DEFAULT</legend>';

######################################
# Edit User
######################################
if ($_GET['aksi'] == ''){

	
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Siswa Pelanggaran</h3></div>';

$admin .= '<form method="post" action=""class="form-inline">
<table class="table table-striped">
';
$admin .= '<tr>
	<td>Nama Siswa</td>
		<td>:</td>
	<td><select name="siswa" id="siswa" class="form-control"  required >';
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
$admin .= '<option value="'.$datasj['id'].'"class="'.$datasj['siswa'].'">'.getkelas($datasj['kelas']).' ('.$aktif.')</option>';
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
    <td><input type="submit" value="Simpan" name="submit" class="btn btn-success"></td>
  </tr>
</table></form>';
$admin .= '</div>';
}


}

echo $admin;

?>