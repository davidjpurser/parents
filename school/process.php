<?php
include "connect.php";


function logout(){
    setcookie(bcs_username, $username, time() - 60*60*60*60,'/');
    setcookie(bcs_password, $password, time() - 60*60*60*60,'/');
}


if($_POST['action']=='Login'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = md5($password);
    $user = mysql_query("SELECT * FROM bcs_login WHERE username= '$username' AND password = '$password'")or die(mysql_error());
    if( mysql_num_rows($user) > 0){
	setcookie(bcs_username, $username, time() + 60*60*60*60,'/');
	setcookie(bcs_password, $password, time() + 60*60*60*60,'/');
    }
    else{
	logout();
    }
    header("Location: $prefix/login");
}

if($_GET['action'] =='logout'){
    logout();
    header("Location: $prefix/login");
}








if($_POST['action']=='Add User'){
    $mustbeadmin=true;
    include "check.php";
    $username = $_POST['username'];
    $department = $_POST['department'];
    $password = md5('password');
    $staffname = $_POST['staffname'];
    mysql_query("INSERT INTO bcs_login (`username`,`password`,`department`,`type`,`staffname`) VALUES ('$username', '$password', '$department','staff','$staffname')")or die(mysql_error());
    
    $returnto = $_SERVER["HTTP_REFERER"];
    header("Location: $returnto");
}

if($_GET['action']=='resetpassword'){
    $mustbeadmin=true;
    include "check.php";
    $username = $_GET['username'];
    
    mysql_query("UPDATE `bcs_login` SET `password` = '5f4dcc3b5aa765d61d8327deb882cf99' WHERE `username`= '$username'")or die(mysql_error());
    
    $returnto = $_SERVER["HTTP_REFERER"];
    header("Location: $returnto");
}
if($_GET['action']=='deleteuser'){
    $mustbeadmin=true;
    include "check.php";
    $username = $_GET['username'];
    
    mysql_query("DELETE FROM `bcs_login` WHERE `username`= '$username'")or die(mysql_error());
    
    $returnto = $_SERVER["HTTP_REFERER"];
    header("Location: $returnto");
}
if($_GET['action']=='changeaccess'){
    $mustbeadmin=true;
    include "check.php";
    $username = $_GET['username'];
    $type= $_GET['type'];
   mysql_query("UPDATE `bcs_login` SET `type` = '$type' WHERE `username`= '$username'")or die(mysql_error());
    
    $returnto = $_SERVER["HTTP_REFERER"];
    header("Location: $returnto");
}

if($_POST['action']=='deleteAllData'){
    $mustbeadmin=true;
    include "check.php";
    
    mysql_query("TRUNCATE TABLE `bcs_bookings`");
    mysql_query("TRUNCATE TABLE `bcs_present`");
    mysql_query("TRUNCATE TABLE `bcs_students`");
    
    
  
    header("Location: /school/me");
}

if($_POST['action']=='Change Password'){
    
    include "check.php";
    $username = $userarray['username'];
    $old = md5($_POST['oldpasssword']);
    $new1 = md5($_POST['n1']);
    $new2 = md5($_POST['n2']);
    
    mysql_query("UPDATE bcs_login SET password= '$new1' WHERE username= '$username' AND password= '$old' AND '$new1' = '$new2'")or die(mysql_error());
    setcookie(bcs_password, $new1, time() - 60*60*60*60,'/');
    $returnto = explode('?',$_SERVER["HTTP_REFERER"]);
    $return = $returnto[0];
    if(mysql_affected_rows() > 0){
    header("Location: $return");
    }
    else{
    
    header("Location: $return?message=failed");
    }
}


?>