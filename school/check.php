<?php
include "getuserarray.php";


if ($mustbeadmin == true && $userarray['type'] != 'admin') {
	header("Location: $prefix/logout.php");
	die();
}
if ($mustbestaff == true && !($userarray['type'] == 'admin' || $userarray['type'] == 'staff')) {
	header("Location: $prefix/logout.php");
	die();
} elseif ($loggedin != 1) {
	header("Location: $prefix/logout.php");
	die();
}


?>