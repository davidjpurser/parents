<?php
include "connect.php";


function logout(){
    session_unset(); 
}


if($_POST['action']=='Login'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = md5($appsalt . $username . $password);
    $user = mysql_query("SELECT * FROM parentsdb_login WHERE username= '$username' AND password = '$password'")or die(mysql_error());
    if( mysql_num_rows($user) > 0){
        $_SESSION["loginuser"] = $username;
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
    $password = md5($appsalt . $username . 'password');
    $staffname = $_POST['staffname'];
    mysql_query("INSERT INTO parentsdb_login (`username`,`password`,`department`,`type`,`staffname`) VALUES ('$username', '$password', '$department','staff','$staffname')")or die(mysql_error());
    
    $returnto = $_SERVER["HTTP_REFERER"];
    header("Location: $returnto");
}

if($_GET['action']=='resetpassword'){
    $mustbeadmin=true;
    include "check.php";
    $username = $_GET['username'];
    $password = md5($appsalt . $username . 'password');
    mysql_query("UPDATE `parentsdb_login` SET `password` = '$password' WHERE `username`= '$username'")or die(mysql_error());
    
    $returnto = $_SERVER["HTTP_REFERER"];
    header("Location: $returnto");
}
if($_GET['action']=='deleteuser'){
    $mustbeadmin=true;
    include "check.php";
    $username = $_GET['username'];
    
    mysql_query("DELETE FROM `parentsdb_login` WHERE `username`= '$username'")or die(mysql_error());
    
    $returnto = $_SERVER["HTTP_REFERER"];
    header("Location: $returnto");
}
if($_GET['action']=='changeaccess'){
    $mustbeadmin=true;
    include "check.php";
    $username = $_GET['username'];
    $type= $_GET['type'];
    mysql_query("UPDATE `parentsdb_login` SET `type` = '$type' WHERE `username`= '$username'")or die(mysql_error());
    
    $returnto = $_SERVER["HTTP_REFERER"];
    header("Location: $returnto");
}

if($_POST['action']=='deleteAllData'){
    $mustbeadmin=true;
    include "check.php";
    
    mysql_query("TRUNCATE TABLE `parentsdb_bookings`");
    mysql_query("TRUNCATE TABLE `parentsdb_present`");
    mysql_query("TRUNCATE TABLE `parentsdb_students`");
  
    header("Location: $prefix/me.php");
}

if($_POST['action']=='Change Password'){
    
    include "check.php";
    $username = $userarray['username'];


    $old = md5($appsalt . $username . $_POST['oldpasssword']);
    $new1 = md5($appsalt . $username . $_POST['n1']);
    $new2 = md5($appsalt . $username . $_POST['n2']);
    
    mysql_query("UPDATE parentsdb_login SET password= '$new1' WHERE username= '$username' AND password= '$old' AND '$new1' = '$new2'")or die(mysql_error());
    $returnto = explode('?',$_SERVER["HTTP_REFERER"]);
    $return = $returnto[0] . (mysql_affected_rows() > 0 ? "" : "message=failed");
    header("Location: $return");
   
}


?>