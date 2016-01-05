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
$script_include[] = $JS_SCRIPT;	
//$index_hal=1;	
$admin .= '<script type="text/javascript" language="javascript">
   function GP_popupConfirmMsg(msg) { //v1.0
  document.MM_returnValue = confirm(msg);
}
</script>';
$admin  .='<legend>MANAGE USER</legend>';
if ($_GET['aksi'] == 'hapus' && is_numeric($_GET['id'])){
	$id = int_filter ($_GET['id']);
$s = mysql_query ("SELECT * FROM `akad_useraura` WHERE `UserId`='$id'");	
$data = mysql_fetch_array($s);
$user = $data['user'];	
$hapus = mysql_query ("DELETE FROM `akad_useraura` WHERE `UserId`='$id' AND `user`!='admin'");	
if ($hapus){
$admin.='<div class="sukses">Data Berhasil Dihapus Dengan ID = '.$id.'</div>';	
}else {
$admin.='<div class="error">Data Gagal dihapus Dengan ID = '.$id.'</div>';	
}	
}

######################################
# Tambah User
######################################
if ($_GET['aksi'] == ''){
	
if (isset($_POST['add_users'])){
	
$user = cleantext($_POST['user']);	
$level = cleantext($_POST['level']);	
$tipe = cleantext($_POST['tipe']);
$password = cleantext($_POST['password']);
$email = cleantext($_POST['email']);

if (empty($_POST['user']))  $error .= "Error: Formulir user belum diisi , silahkan ulangi.<br />";
if (empty($_POST['email']))  $error .= "Error: Formulir email belum diisi , silahkan ulangi.<br />";
if (empty($_POST['password']))  $error .= "Error: Formulir Password belum diisi , silahkan ulangi.<br />";
if (!$user || preg_match("/[^a-zA-Z0-9_-]/", $user)) $error .= "Error: Karakter Username tidak diizinkan kecuali a-z,A-Z,0-9,-, dan _<br />";
if (strlen($user) > 20) $error .= "Username Terlalu Panjang Maksimal 20 Karakter<br />";
if (strrpos($user, " ") > 0) $error .= "Username Tidak Boleh Menggunakan Spasi";
if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT user FROM akad_useraura WHERE user='$user'")) > 0) $error .= "Error: Username ".$user." sudah terdaftar , silahkan ulangi.<br />";
if ($koneksi_db->sql_numrows($koneksi_db->sql_query("SELECT email FROM akad_useraura WHERE email='$email'")) > 0) $error .= "Error: Email ".$email." sudah terdaftar , silahkan ulangi.<br />";
if (!is_valid_email($email)) $error .= "Error: E-Mail address invalid!<br />";
if ($error){
        $admin.='<div class="error">'.$error.'</div>';
}else{
$query = mysql_query ("INSERT INTO `akad_useraura` (`user`,`password`,`level`,`tipe`,`email`) VALUES ('$user',md5('$password'),'$level','$tipe','$email')");	
$admin .= '<div class="sukses">Data : '.$user.',Berhasil Di add</div>';
}
}	

$ss = mysql_query ("SHOW FIELDS FROM akad_useraura");
while ($as = mysql_fetch_array ($ss)){
$arrs = $as['Type'];
if (substr($arrs,0,4) == 'enum' && $as['Field'] == 'level') break;
}

$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Tambah User</h3></div>';
$admin.='<form method="post" action="#">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="width:75px; padding:5px;">Username</td>
    <td style="width:10px; padding:5px;">:</td>
    <td style="padding:5px;"><input type="text" name="user" size="20" class="form-control"></td>
  </tr> 
  <tr>
    <td style="padding:5px;">Password</td>
    <td style="padding:5px;">:</td>
    <td style="padding:5px;"><input type="text" name="password" size="20" class="form-control"></td>
  </tr>
  <tr>
    <td style="padding:5px;">Email</td>
    <td style="padding:5px;">:</td>
    <td style="padding:5px;"><input type="text" name="email" size="20" class="form-control"></td>
  </tr>';
  
  
$sel = '<select name="level" class="form-control">';
$arrs = ''.substr ($arrs,4);
$arr = eval( '$arr5 = array'.$arrs.';' );
foreach ($arr5 as $k=>$v){
	$sel .= '<option value="'.$v.'">'.$v.'</option>';	
	
}

$sel .= '</select>';  
  
$sel2 = '<select name="tipe" class="form-control">';
$arr2 = array ('aktif','pasif');
foreach ($arr2 as $kk=>$vv){
	$sel2 .= '<option value="'.$vv.'">'.$vv.'</option>';	

}

$sel2 .= '</select>';    
  
  
$admin .='<tr>
    <td style="padding:5px;">Level</td>
    <td style="padding:5px;">:</td>
    <td style="padding:5px;">'.$sel.'</td>
  </tr>';

$admin .='<tr>
    <td style="padding:5px;">Status</td>
    <td style="padding:5px;">:</td>
    <td style="padding:5px;">'.$sel2.'</td>
  </tr>';  

$admin .='<tr>
	<td style="padding:5px;">&nbsp;</td>
    <td style="padding:5px;">&nbsp;</td>
    <td style="padding:5px;"><input type="submit" value="Tambah" name="add_users" class="btn btn-success"></td>
  </tr>
</table></form>';
$admin .='</div>';	
}

######################################
# Edit User
######################################
if ($_GET['aksi'] == 'edit_user'){
if ($_POST['edit_users']){
	$id = int_filter ($_GET['id']);
	$level = $_POST['level'];
	$tipe = $_POST['tipe'];
	$email	      = text_filter($_POST['email']);
	$password = md5($_POST['password']);
if (!is_valid_email($email)) $error .= "Error, E-Mail address invalid!<br />";
if ($error) {
$admin.='<div class="error">'.$error.'</div>';
} else {
	if($password<>''){
$up = mysql_query ("UPDATE `akad_useraura` SET `level`='$level',`tipe`='$tipe',`email`='$email',`password`='$password' WHERE `UserId`='$id'");	
	}else{
$up = mysql_query ("UPDATE `akad_useraura` SET `level`='$level',`tipe`='$tipe',`email`='$email' WHERE `UserId`='$id'");			
	}
$admin.='<div class="sukses">Data Berhasil Diupdate Dengan ID = '.$id.'</div>';	
$admin .='<meta http-equiv="refresh" content="1; url=admin.php?pilih=user&amp;mod=yes" />';	
}
}
	
$id = int_filter($_GET['id']);
$s = mysql_query ("SELECT * FROM `akad_useraura` WHERE `UserId`='$id'");	
$data = mysql_fetch_array($s);
$user = $data['user'];	
$level = $data['level'];	
$tipe = $data['tipe'];
$email = $data['email'];
$ss = mysql_query ("SHOW FIELDS FROM akad_useraura");
while ($as = mysql_fetch_array ($ss)){
	 $arrs = $as['Type'];
if (substr($arrs,0,4) == 'enum' && $as['Field'] == 'level') break;
}
	
$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">Edit User</h3></div>';

$admin .= '<form method="post" action="">
<table class="table table-striped">
  <tr>
    <td>Username</td>
    <td><input type="text" name="user" value="'.$user.'" class="form-control" disabled="disabled"></td>
  </tr>';
$admin .= '<tr>
    <td>Email</td>
    <td><input type="text" name="email" value="'.$email.'" class="form-control"></td>
  </tr>';  
  
$sel = '<select name="level" class="form-control">';
$arrs = ''.substr ($arrs,4);
$arr = eval( '$arr5 = array'.$arrs.';' );
foreach ($arr5 as $k=>$v){
	if ($level == $v){
	$sel .= '<option value="'.$v.'" selected="selected">'.$v.'</option>';
	}else {
	$sel .= '<option value="'.$v.'">'.$v.'</option>';	
	}
}

$sel .= '</select>';  
  
$sel2 = '<select name="tipe" class="form-control">';
$arr2 = array ('aktif','pasif');
foreach ($arr2 as $kk=>$vv){
	if ($tipe == $vv){
	$sel2 .= '<option value="'.$vv.'" selected="selected">'.$vv.'</option>';
	}else {
	$sel2 .= '<option value="'.$vv.'">'.$vv.'</option>';	
	}
}

$sel2 .= '</select>';    
  
  
$admin .= '<tr>
    <td>Level</td>
    <td>'.$sel.'</td>
</tr>
<tr>
    <td>Status</td>
    <td>'.$sel2.'</td>
</tr>
  <tr>
    <td>Password</td>
    <td><input type="text" name="password" size="20" class="form-control"></td>
  </tr>
<tr>
	<td>&nbsp;</td>
    <td><input type="submit" value="Simpan" name="edit_users" class="btn btn-success"></td>
  </tr>
</table></form>';
$admin .= '</div>';
}



$admin .= '<div class="panel panel-info">
<div class="panel-heading"><h3 class="panel-title">List User</h3></div>';

$admin.='<table class="table table-striped" id="example">
<thead>
<tr>
<th>Users</th>
<th>Email</th>
<th>Level</th>
<th>Status</th>
<th>Aksi</th>
</tr>
    </thead>
';
$admin.='<tbody>';
$q = mysql_query ("SELECT * FROM `akad_useraura` where user<>'superadmin'");
while ($data = mysql_fetch_array($q)){
$admin.='<tr>
<td>'.$data['user'].'</td>
<td>'.$data['email'].'</td>
<td>'.$data['level'].'</td>
<td>'.$data['tipe'].'</td>
<td>
<a  class="btn btn-info" href="?pilih=user&amp;mod=yes&amp;aksi=edit_user&amp;id='.$data['UserId'].'">Edit</a> 
<a  class="btn btn-danger" href="?pilih=user&amp;mod=yes&amp;aksi=hapus&amp;id='.$data['UserId'].'" onClick="GP_popupConfirmMsg(\'Apakah anda Ingin menghapus Users \n['.$data['user'].']\');return document.MM_returnValue;">Hapus</a></td>
</tr>';  
}
$admin.='</tbody>
</table>';
$admin.='</div>';
}

echo $admin;

?>