<?phpif (!defined('AURACMS_admin')) {	Header("Location: ../../../index.php");	exit;}if (!cek_login ()){   $admin .='<p class="judul">Access Denied !!!!!!</p>';   exit;}$admin  .='<legend>MASTER</legend>';if($_GET['aksi']==""){$admin .= '<div align="center"><table width="70%" class="border3"><tr align="center"><td><a href="admin.php?pilih=matpel&mod=yes"><img src="images/matpel.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=jam&mod=yes"><img src="images/jam.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=ulangan&mod=yes"><img src="images/ulangan.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=guru&mod=yes"><img src="images/guru.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=kegiatan&mod=yes"><img src="images/kegiatan.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=kegiatannon&mod=yes"><img src="images/kegiatan.jpg" width="50px"><br></a></td></tr><tr align="center"><td><a href="admin.php?pilih=matpel&mod=yes"><br>MATA <br>PELAJARAN</a></td><td><a href="admin.php?pilih=jam&mod=yes"><br>JAM</a></td><td><a href="admin.php?pilih=ulangan&mod=yes"><br>ULANGAN</a></td><td><a href="admin.php?pilih=guru&mod=yes"><br>GURU</a></td><td><a href="admin.php?pilih=kegiatan&mod=yes"><br>KEGIATAN<br>AKADEMIK</a></td><td><a href="admin.php?pilih=kegiatannon&mod=yes"><br>KEGIATAN<br>NON AKADEMIK</a></td></tr></table></div><br><br></div><br><br>';}echo $admin;?>