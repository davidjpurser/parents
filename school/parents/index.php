<?php
include "../connect.php";
include "../getuserarray.php";
if($loggedin > 0){
    header("Location: app.php");
    die();
}
else{
    header("Location: /school/login");
    die();
}

?>
<!DOCTYPE html>
<html>
    <head>
	<title>Parent Evening Check In</title>
	<?php
	
	include "../../head.php"; ?>
	<link href="css.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
    	
	
	<div class="holder loginpage pagewidth">
	    <header>
		<h1>Parent Evening Check In</h1>
	    </header>
	    <br><Br><br>
	    <div>
		    <div class="left round half">
			    <div class="pad">
				    <h1>
					    <a href="/school/login">Login</a>
				    </h1>
				    
			    </div>
		    </div>
		    <div class="right round half">
			    <div class="pad">
				    Press Login
			    </div>
		    </div>
	    </div>
	     
	      
       </div>
	  

   </body>
</html>