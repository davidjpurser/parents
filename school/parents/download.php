<?php
$today = date('d-m-y');
header("Content-disposition: attachment; filename=students$today.txt");
header('Content-type: text/plain');



$mustbeadmin =true ;
include "../connect.php";
include "../check.php";
$result = mysql_query('SELECT * FROM parentsdb_students');
$num_fields = mysql_num_fields($result);



for ($i = 0; $i < $num_fields; $i++) 
{
  while($row = mysql_fetch_row($result))
  {
    $return.= 'INSERT INTO `parentsdb_students` (`id`,`firstname`,`lastname`,`form`) VALUES(';
    for($j=0; $j<$num_fields; $j++) 
    {
      $row[$j] = addslashes($row[$j]);
      $row[$j] = ereg_replace("\n","\\n",$row[$j]);
      if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
      if ($j<($num_fields-1)) { $return.= ','; }
    }
    $return.= ");\n";
  }
}
$return.="\n\n\n";
    
$result = mysql_query('SELECT * FROM parentsdb_present');
$num_fields = mysql_num_fields($result);
    
    

for ($i = 0; $i < $num_fields; $i++) 
{
  while($row = mysql_fetch_row($result))
  {
    $return.= 'INSERT INTO `parentsdb_present` (`id`,`studentid`,`intime`,`present`) VALUES(';
    for($j=0; $j<$num_fields; $j++) 
    {
      $row[$j] = addslashes($row[$j]);
      $row[$j] = ereg_replace("\n","\\n",$row[$j]);
      if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
      if ($j<($num_fields-1)) { $return.= ','; }
    }
    $return.= ");\n";
  }
}
$return.="\n\n\n";


echo $return;