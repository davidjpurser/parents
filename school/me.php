<?php
include "connect.php";

include "check.php";

?>
<!DOCTYPE html>
<html>
    <head>
	<title>Administration</title>
	<?php include "links.php"; ?>
    </head>
    <body>
    <?php include "header.php"; ?>
    <div id="content">
	
	<a href="/school/parents">Go to Parents Evening System</a>
	
	
	<h3>Change my Password</h3>
	<form method="post" action="process.php">
	<em><?php echo $_GET['message']; ?></em><br>
	    Old Password: <input name="oldpasssword" type="password"><br>
	    New Password: <input name="n1" type="password"><br>
	    New Password: <input name="n2" type="password"><br>
	    <input name="action" value="Change Password" type="submit">
	</form>
	
	
	<br>
	<h3>Parents Evenings</h3>
<?php

$parentsevening = mysql_query("SELECT *,CONVERT(form, SIGNED) AS year FROM (SELECT *,DATE_FORMAT(intime, '%d/%m/%Y') as date FROM bcs_present GROUP BY date) as part LEFT JOIN bcs_students ON part.studentid =bcs_students.id  GROUP BY date ORDER BY intime ASC");
while($evening = mysql_fetch_array($parentsevening)){
   
    ?>
    <a href="/school/parents/app.php?date=<?php echo $evening['date']; ?>&year=<?php echo $evening['year']; ?>"> <?php echo $evening['date']; ?> Year: <?php echo $evening['year']; ?></a><br>
    <?php
}

if($userarray['type'] =='admin'){
?>
<hr>
<h2>Admin Only</h2>
<h3>Manage</h3>
<a href="http://app.davidpurser.net/parentseveninghowto.pdf">Download help sheet</a><br><br>


<a href="<?php echo $prefix?>/parents/import.php">Add Students</a><br>

<a href="<?php echo $prefix?>/parents/download.php">Download Students - Do this before delete</a><br>

<a href="<?php echo $prefix?>/delete.php">Delete this year</a>

<br>
The download can be readded to the database by your system administrator manually.


If you delete without download it is gone forever.


 <h3>Add New Staff</h3>
    <form method="post" action="process.php">
	username: <input type="text" name="username" ><br>
	department: <input type="text" name="department"><br>
	staffname: <input type="text" name="staffname"><br>
	<em>This users password will be: 'password' They should be encouraged to change this</em><br>
	<input type="submit" value="Add User" name="action" >
	
    </form>

    <table class="standardtbl">
	<tr>
	    <td>Staff</td>
	    <td>User</td>
	    <td>Department</td>
	    <td>Access</td>
	    <td>Reset Password</td>
	    <td>Delete</td>
	    <td>Password: 'password'</td>
	   <td>Change Access</td>
	</tr>
	<?php
	
	$staffs = mysql_query("SELECT * FROM `bcs_login` ORDER BY `type`,`department`");
	while($staff = mysql_fetch_array($staffs)){
	?>
	<tr>
	    <td>
		<?php echo $staff['staffname']; ?>
	    </td>
	    <td>
		<?php echo $staff['username']; ?>
	    </td>
	    <td>
		<?php echo $staff['department']; ?>
	    </td>
	    <td>
		<?php echo $staff['type']; ?>
	    </td>
	    <td>
		<a href="process.php?action=resetpassword&username=<?php echo $staff['username']; ?>">Reset</a>
	    </td>
	    <td>
		<a href="process.php?action=deleteuser&username=<?php echo $staff['username']; ?>">Delete</a>
	     </td>
	    <td>
		<?php
		if($staff['password'] =='5f4dcc3b5aa765d61d8327deb882cf99'){
		echo "yes";
		}
		
		?>
	    </td>
	    <td>
		<?php
		if($staff['type'] =='admin'){
		?>
		<a href="process.php?action=changeaccess&username=<?php echo $staff['username']; ?>&type=staff">Demote</a>
		<?php
		}
		else{
		?>
		<a href="process.php?action=changeaccess&username=<?php echo $staff['username']; ?>&type=admin">Promote</a>
		
		<?php 
		}
		
		?>
	    </td>
	</tr>
	
	<?php 
	}
	
	
	?>
    </table>
    
    
    
<?php
} //Admin only
?>	

    </div>
    <?php include "footer.php"; ?>
    </body>
</html>