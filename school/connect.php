<?php
require "Settings.php";
mysql_connect(Settings::$db_host, Settings::$db_username, Settings::$db_password) or die(mysql_error());
mysql_select_db(Settings::$db_name) or die(mysql_error());
$prefix  = Settings::$prefix;
$appsalt = Settings::$appsalt;
session_start();
?>