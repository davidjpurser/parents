<div id="page">
<header>
    <h1><?php echo Settings::$school_name ?></h1>
</header>

<nav>
    
    <ul id="coolMenu">
    <li><a href="/school/">Home</a></li>
  
    <li><a href="<?php echo $prefix; ?>/parents/" >Parents</a></li>
    <?php if(!isset($_SESSION["loginuser"])){ ?>
    <li style="float:right"><a href="<?php echo $prefix; ?>/login.php">Login</a></li>
	<?php 

	}
	else{
	?>
	<li style="float:right"><a href="/school/process.php?action=logout">Logout</a></li>
	
	<li style="float:right"><a href="<?php echo $prefix; ?>/me.php">Manage</a></li>
	<?php
	}
        ?>
</ul>
</nav>




