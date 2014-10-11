<div id="page">
<header>
    <h1><?php echo Settings::school_name ?></h1>
</header>

<nav>
    
    <ul id="coolMenu">
    <li><a href="/school/">Home</a></li>
  
    <li><a href="<?php echo $prefix; ?>/parents/" >Parents</a></li>
    <?php if(!isset($_COOKIE['bcs_username'])){ ?>
    <li style="float:right"><a href="/school/login">Login</a></li>
	<?php 

	}
	else{
	?>
	<li style="float:right"><a href="/school/logout">Logout</a></li>
	
	<li style="float:right"><a href="<?php echo $prefix; ?>/me.php">Me</a></li>
	<?php
	}
        ?>
</ul>
</nav>




