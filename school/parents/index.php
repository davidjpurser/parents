<?php
include "../connect.php";
include "../getuserarray.php";
if($loggedin > 0){
    header("Location: app.php");
    die();
}
else{
    header("Location: $prefix/login");
    die();
}
?>