<?phpif (!defined('AURACMS_admin')) {	Header("Location: ../../../index.php");	exit;}if (!cek_login ()){   $admin .='<p class="judul">Access Denied !!!!!!</p>';   exit;}$admin  .='<legend>MASTER</legend>';if($_GET['aksi']==""){$admin .= '<div align="center"><table width="70%" class="border3"><tr align="center"><td><a href="admin.php?pilih=lokasi&mod=yes"><img src="images/lokasi.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=jenjang&mod=yes"><img src="images/jenjang.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=kelas&mod=yes"><img src="images/kelas.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=tahunajaran&mod=yes"><img src="images/kalender.jpg" width="50px"><br></a></td></tr><tr align="center"><td><a href="admin.php?pilih=lokasi&mod=yes">LOKASI/CABANG<br></a></td><td><a href="admin.php?pilih=jenjang&mod=yes">JENJANG/TINGKAT<br></a></td><td><a href="admin.php?pilih=kelas&mod=yes">KELAS<br></a></td><td><a href="admin.php?pilih=tahunajaran&mod=yes">TAHUN AJARAN<br></a></td></tr><tr align="center"><td><a href="admin.php?pilih=matpel&mod=yes"><img src="images/matpel.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=jam&mod=yes"><img src="images/jam.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=ulangan&mod=yes"><img src="images/ulangan.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=guru&mod=yes"><img src="images/guru.jpg" width="50px"><br></a></td></tr><tr align="center"><td><a href="admin.php?pilih=matpel&mod=yes"><br>MATA <br>PELAJARAN</a></td><td><a href="admin.php?pilih=jam&mod=yes"><br>JAM</a></td><td><a href="admin.php?pilih=ulangan&mod=yes"><br>ULANGAN</a></td><td><a href="admin.php?pilih=guru&mod=yes"><br>GURU</a></td></tr><tr align="center"><td><a href="admin.php?pilih=pelanggaran&mod=yes"><img src="images/pelanggaran.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=lessonplan&mod=yes"><img src="images/lessonplan.jpg" width="50px"><br></a></td><td><a href="#"><img src="images/rapor.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=lomba&mod=yes"><img src="images/lomba.jpg" width="50px"><br></a></td></tr><tr align="center"><td><a href="admin.php?pilih=pelanggaran&mod=yes"><br>PELANGGARAN</a></td><td><a href="admin.php?pilih=lessonplan&mod=yes"><br>LESSON PLAN</a></td><td><a href="#"><br>RAPOR</a></td><td><a href="admin.php?pilih=lomba&mod=yes"><br>LOMBA</a></td></tr><tr align="center"><td><a href="admin.php?pilih=kegiatan&mod=yes"><img src="images/kegiatan.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=kegiatannon&mod=yes"><img src="images/kegiatan.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=grade&mod=yes"><img src="images/grade.jpg" width="50px"><br></a></td><td><a href="admin.php?pilih=linkssites&mod=yes"><img src="images/linkssites.jpg" width="50px"><br></a></td></tr><tr align="center"><td><a href="admin.php?pilih=kegiatan&mod=yes"><br>KEGIATAN<br>AKADEMIK</a></td><td><a href="admin.php?pilih=kegiatannon&mod=yes"><br>KEGIATAN<br>NON AKADEMIK</a></td><td><a href="admin.php?pilih=grade&mod=yes"><br>GRADE</a></td><td><a href="admin.php?pilih=linkssites&mod=yes"><br>LINKS SITES</a></td></tr></table></div><br><br></div><br><br>';}echo $admin;?>