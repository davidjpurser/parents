<?php
$username= $_COOKIE['bcs_username'];
$password = $_COOKIE['bcs_password'];
$user = mysql_query("SELECT * FROM bcs_login WHERE username= '$username' AND password = '$password'")or die(mysql_error());
$loggedin =  mysql_num_rows($user);
$userarray = mysql_fetch_array($user);
?>