<?php

if (!defined('AURACMS_admin')) {
	Header("Location: ../index.php");
	exit;
}

if (!cek_login ()){
   $admin .='<h5 class="bg text-success">Access Denied !!!!!!</h5>';
}else{

global $koneksi_db,$PHP_SELF,$theme,$error,$url_situs;

$username = $_SESSION['UserName'];

$admin  ='<h4 class="page-header">Pengaturan</h4>';

######################################
# Edit Password Admin
######################################
if($_GET['aksi']==""){

$admin .='<ol class="breadcrumb">
  <li><a href="?pilih=settingwebsite&mod=yes">Pengaturan</a></li>
  <li class="active">Password</li>
</ol>';

if (isset($_POST["submit"])) {

$user		   = text_filter($_POST['user']);
$email	      = text_filter($_POST['email']);
$password0 = md5($_POST["password0"]);
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];

$hasil = $koneksi_db->sql_query( "SELECT password,email FROM akad_useraura WHERE user='$user'" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
	$password=$data['password'];
	$email0=$data['email'];
	}
$error = '';
if (!$password0)  $error .= "Error: Please enter your Old Password!<br />";
if (!$password1)  $error .= "Error: Please enter new password!<br />";
if (!$password2)  $error .= "Error: Please retype your your new password!<br />";
checkemail($email);
if ($password0 != $password)  $error .= "Invalid old pasword, silahkan ulangi lagi.<br />";
if ($password1 != $password2)   $error .= "New password dan retype berbeda, silahkan ulangi.<br />";
if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT email FROM akad_useraura WHERE email='$email' and user!='$user'")) > 0) $error .= "Error: Email ".$email." sudah terdaftar , silahkan ulangi.<br />";

if ($error) {

$admin .='<div class="alert alert-danger">'.$error.'</div>';

} else {

$password3=md5($password1);
$hasil = $koneksi_db->sql_query( "UPDATE akad_useraura SET user='$user', email='$email', password='$password3' WHERE user='$user'" );

$admin.='<div class="alert alert-success">Informasi Admin telah di updated</div>';
}

}

$user =  $_SESSION['UserName'];
$hasil =  $koneksi_db->sql_query( "SELECT * FROM akad_useraura WHERE user='$user'" );
while ($data = $koneksi_db->sql_fetchrow($hasil)) {
$id		= $data[0];
$user	= $data[1];
$email	= $data[3];
}

$admin .='<form class="form-horizontal" method="post" action=""><table class="table table-striped">
<tr>
	<td>Username</td>
	<td><input type="text" value="'.$user.'" size="80" class="form-control" disabled></td>
</tr>
<tr>
    <td>Password Lama</td>
	<td><input type="password" name="password0" size="80" class="form-control"></td>
</tr>
<tr>
    <td>Password Baru</td>
	<td><input type="password" name="password1" size="80" class="form-control"></td>
</tr>
<tr>
    <td>Ulangi Password Baru</td>
	<td><input type="password" name="password2" size="80" class="form-control"></td>
</tr>
<tr>
    <td></td>
	<td><input type="hidden" name="email" value="'.$email.'"><input type="hidden" name="user" value="'.$user.'"><input type="submit" name="submit" value="Simpan" class="btn btn-success"></td>
</tr>
</table></form>';
}

}
echo $admin;
?>