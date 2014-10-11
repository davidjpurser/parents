<?php
$mustbeadmin = true;
include "connect.php";

include "check.php";

?>

<!DOCTYPE html>
<html>
    <head>
	<?php include "links.php"; ?>
    </head>
    <body>
    <?php include "header.php"; ?>
    
	Are you <strong>SURE</strong> you want to delete


    <form method="post" action="process.php">
	<input type="hidden" value="deleteAllData" name="action" />
	<input type="submit" value="YES" />
	
	
    </form>
     <form method="get" action="/school/me.php">
	
	<input type="submit" value="NO" />
	
	
    </form>
   
    <?php include "footer.php"; ?>
    </body>
</html>