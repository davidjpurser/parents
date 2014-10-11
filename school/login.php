<?php
 include "connect.php";
 include "getuserarray.php";
 
 if($loggedin == 1){
	    header("Location: $prefix/me.php");  
    die();
 }

?>
<!DOCTYPE html>
<html>
    <head>
	<?php include "links.php"; ?>
    </head>
    <body>
    <?php include "header.php"; ?>
    <div id="content">
	Login:
	<form action="process.php" method="post">
	    Username: <input type="text" name="username" /><br>
	    Password: <input type="password" name="password" />
	    <input type="submit" value="Login" name="action" />
	    
	</form>
	
	</div>
    <?php include "footer.php"; ?>
    </body>
</html>