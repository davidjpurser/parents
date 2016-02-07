<?php
$username= $_SESSION["loginuser"];
$user = mysql_query("SELECT * FROM parentsdb_login WHERE username= '$username'")or die(mysql_error());
$loggedin =  mysql_num_rows($user);
$userarray = mysql_fetch_array($user);
?>