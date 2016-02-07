<?php
include "connect.php";
session_unset(); 
header("Location: $prefix/login.php");

?>