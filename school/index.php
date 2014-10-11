<?php
include "connect.php";



?>
<!DOCTYPE html>
<html>
    <head>
	<title>Brookfield Community School</title>
	<?php include "links.php"; ?>
    </head>
    <body>
    <?php include "header.php"; ?>
    
<div class="sidebar">
    <h3>Search</h3>
    <div class="pad">
	<form action="http://www.google.com/search" method="get"><input style="width:184px" type="text" placeholder="Google Search" name="q"></form>
    </div>
</div>


    
    
    <div id="content">
	Welcome please <a href="/school/login">login</a>
	</div>
    <?php include "footer.php"; ?>
    </body>
</html>