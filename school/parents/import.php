<?php

$mustbeadmin =true ;
include "../connect.php";
include "../check.php";
if( isset($_FILES['uploadedfile']['tmp_name']) && file_exists($_FILES['uploadedfile']['tmp_name'])  ){
    
    
    
    
$table    = "bcs_students";
$fileName = $_FILES['uploadedfile']['tmp_name'];
ini_set('auto_detect_line_endings',TRUE);
$output =  Array();
$ignoreFirstRow = 2;
if (($handle = fopen($fileName, "r")) !== FALSE) {
    $opening = "INSERT INTO `".$table."` (`lastname`,`firstname`,`form`) VALUES ";
            
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	
        if($ignoreFirstRow != 1){
            $sql .= '("'.implode('","',$data).'"';
            $output[] .= "".$sql.')';
            $sql = "";
     }
        $ignoreFirstRow++;
    }
    fclose($handle);
}

if( count($output) > 0){
$toecho = $opening . implode(',', $output);

mysql_query($toecho) or die(mysql_error());
echo "this has been added";
header("Location: import.php?success=true");
}
else{
    echo "no records";
}
}
else{
    
if(isset($_GET['success'])){
?>
FILE ADDED DO NOT ADD AGAIN! <br>
<a href="index.php">Go To Site</a>
<?php    
    
    }    
    
    ?>
   <a href="app.php">Back to app</a><br>
How to use:
<ul>
<li>
Create a spread sheet using SIMS from student list</li>
<li>Include ONLY Preferred surname, Preferred firstname and form - in that order (change in excel if necessary)</li>
<li>Open the spreadsheet in excel</li>
<li>IMPORTANT - remove all header rows - including the date it is correct and the column headers</li>
<li>SAVE AS and choose the file type as CSV - call it what you like!</li>
<li>Use the following system</li>
</ul>
Problems: davidjpurser@gmail.com
    
<form enctype="multipart/form-data" action="import.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
Choose a file to upload: <input name="uploadedfile" type="file" /><br />
<input type="submit" value="Upload File" />
</form>
    
    
    <?php
}



?>