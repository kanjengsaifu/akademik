<?php

include 'includes/config.php';
include 'includes/mysql.php';
include 'includes/configsitus.php';
global $koneksi_db,$url_situs;
$idsiswa 		= $_GET['idsiswa'];

echo "<html><head><title>Cetak Absensi Siswa</title>";
echo '<style type="text/css">
   table { page-break-inside:auto; 
    font-size: 0.8em; /* 14px/16=0.875em */
font-family: "Times New Roman", Times, serif;
   }
   tr    { page-break-inside:avoid; page-break-after:auto }
	table {
    border-collapse: collapse;}
	th,td {
    padding: 5px;
}
.border{
	border: 1px solid black;
}
.border td{
	border: 1px solid black;
}
body {
	margin		: 0;
	padding		: 0;
    font-size: 1em; /* 14px/16=0.875em */
font-family: "Times New Roman", Times, serif;
    margin			: 2px 0 5px 0;
}
</style>';
echo "</head><body>";
echo'<table border="0" cellpadding="0" cellspacing="0" width="100%">	<tr>		<td width="20%" align="center"><img src="images/logotutwuri.png" height="70" /></td><td valign="top" align="left"><font size="5"><strong>SMA Sekolah</strong></font><br />				<strong>Jl. Pendidikan No.1				<br>Telp. (031)1234567				, (031)1234567				&nbsp;&nbsp;Fax. (022)1234567&nbsp;&nbsp;				<br>				Website: www.sekolah.com&nbsp;&nbsp;				Email: info@sekolah.com			</strong>			</td>		</tr>		<tr>			<td colspan="2"><hr width="100%" /></td>		</tr>		</table>	<br />	
<center>
  <font size="4"><strong>LAPORAN ABSENSI SISWA</strong></font><br />
 </center><br /><br />
<table>
';
$query 		= mysql_query ("SELECT * FROM `aka_siswa` WHERE `replid`='$idsiswa'");
$data 		= mysql_fetch_array($query);

$replid     		= $data['replid'];
$nis     		= $data['nis'];
$nama     		= $data['nama'];	
/****************************/
echo '
<table>
<tr>
	<td width="25%"><strong>Siswa</strong></td>
    <td><strong>: '.$nis.' - '.$nama.'</strong></td>
</tr>

<tr>
	<td><strong>Periode Absensi</strong></td>
    <td><strong>: Semester 1</strong></td>
</tr>
</table>
<br />

	<table class="tab" id="table" border="1" style="border-collapse:collapse" width="100%" align="left" bordercolor="#000000">
   	<tr height="30" align="center">
    	<td width="5%" class="header">No</td>
		<td width="20%" class="header">Periode</td>
        <td width="15%" class="header">Semester</td>
        <td width="15%" class="header">Kelas</td>
   		<td width="5%" class="header">Hadir</td>
		<td width="5%" class="header">Sakit</td>            
		<td width="5%" class="header">Ijin</td>
        <td width="5%" class="header">Alpa</td>
        <td width="5%" class="header">Cuti</td>      
        <td width="*" class="header">Keterangan</td>  	
    </tr>';
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_siswaabsen where siswa='$idsiswa' order by tahun,bulan,semester asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
	$id=$data['id'];
	$semester=$data['semester'];
	$kelas=$data['kelas'];
$tahun=$data['tahun'];
$bulan=$data['bulan'];
$siswa=$data['siswa'];
$hadir=$data['hadir'];
$sakit=$data['sakit'];
$ijin=$data['ijin'];
$alpa=$data['alpa'];
$cuti=$data['cuti'];	
	
echo '<tr height="25">    	
    	<td align="center">1</td>
		<td align="center">'.getbulan($bulan).'/'.$tahun.'</td>
        <td align="center">'.getsemester($semester).'</td>
        <td align="center">'.getkelas($kelas).'</td>
        <td align="center">'.$hadir.'</td>
		<td align="center">'.$sakit.'</td>
       	<td align="center">'.$ijin.'</td>       
        <td align="center">'.$alpa.'</td>
        <td align="center">'.$cuti.'</td>
        <td></td>
    </tr>';
	$hadirtot += $hadir;
	$sakittot += $sakit;
	$ijintot += $ijin;
	$alpatot += $alpa;
	$cutitot += $cuti;
}
echo '<tr>	
		<td width="5%" colspan="4" align="right" bgcolor="#CCCCCC"><strong>Jumlah&nbsp;&nbsp;</strong></td>
   		<td width="5%" height="25" align="center">'.$hadirtot.'</td>
		<td width="5%" height="25" align="center">'.$sakittot.'</td>            
		<td width="5%" height="25" align="center">'.$ijintot.'</td>
        <td width="5%" height="25" align="center">'.$alpatot.'</td>
        <td width="5%" height="25" align="center">'.$cutitot.'</td>      
        <td width="*" bgcolor="#CCCCCC"></td>
    </tr>
	<!-- END TABLE CONTENT -->
    </table>	';

echo "</body></html>";
/*
if (isset($_GET['tglmulai'])){
echo "<script language=javascript>
window.print();
</script>";
}
*/
?>
