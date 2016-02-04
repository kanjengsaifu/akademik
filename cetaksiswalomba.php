<?php

include 'includes/config.php';
include 'includes/mysql.php';
include 'includes/configsitus.php';
global $koneksi_db,$url_situs;
$idsiswa 		= $_GET['idsiswa'];
$tgl1 		= $_GET['tgl1'];
$tgl2 		= $_GET['tgl2'];
echo "<html><head><title>Cetak Lomba Siswa</title>";
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
echo'<table border="0" cellpadding="0" cellspacing="0" width="99%">	<tr>		<td width="20%" align="center"><img src="images/logotutwuri.png" height="70" /></td><td valign="top" align="left"><font size="5"><strong>SMA Sekolah</strong></font><br />				<strong>Jl. Pendidikan No.1				<br>Telp. (031)1234567				, (031)1234567				&nbsp;&nbsp;Fax. (022)1234567&nbsp;&nbsp;				<br>				Website: www.sekolah.com&nbsp;&nbsp;				Email: info@sekolah.com			</strong>			</td>		</tr>		<tr>			<td colspan="2"><hr width="100%" /></td>		</tr>		</table>	<br />	
<center>
  <font size="4"><strong>LAPORAN LOMBA SISWA</strong></font><br />
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
	<td><strong>Tangal Mulai</strong></td>
    <td><strong>: '.tanggalindolong($tgl1).'</strong></td>
</tr>
<tr>
	<td><strong>Tangal Akhir</strong></td>
    <td><strong>: '.tanggalindolong($tgl2).'</strong></td>
</tr>
</table>
<br />

	<table align="center" class="tab" id="table" border="1" style="border-collapse:collapse" width="99%" align="left" bordercolor="#000000">
   	<tr height="30" align="center">
    	<td width="5%" class="header">No</td>
        <td width="10%" class="header">Tanggal</td>
        <td width="5%" class="header">Kelas</td>
   		<td width="15%" class="header">PIC</td>
   		<td width="45%" class="header">Lomba</td>
		<td width="20%" class="header">Hasil Lomba</td>             

    </tr>';
	$no = 1;
$hasil = $koneksi_db->sql_query( "SELECT * FROM akad_siswalomba where tgl between '$tgl1' and '$tgl2' and  siswa='$idsiswa' order by tgl asc" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$id=$data['id'];
$tgl=$data['tgl'];
$kelas=$data['kelas'];
$siswa=$data['siswa'];
$pic=$data['pic'];
$lomba=$data['lomba'];
$hasillomba=$data['hasillomba'];
	
echo '<tr height="25">    	
    	<td align="center">'.$no.'</td>
	       <td align="center">'.tanggalindoshort($tgl).'</td>
        <td align="center">'.getkelas($kelas).'</td>
        <td align="left">'.$pic.'</td>
		<td align="left">'.getlomba($lomba).'</td>      
        <td align="left">'.$hasillomba.'</td>
    </tr>';
	$no++;
}
echo '
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
