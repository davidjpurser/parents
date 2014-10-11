<?php
include "../connect.php";

$mustbestaff = true;
require "../check.php";

function arrivestudent($id)
{
  $alreadypresent = mysql_num_rows(mysql_query("SELECT * FROM bcs_present WHERE DATE_FORMAT(intime,'%d %m %Y') = DATE_FORMAT(UTC_TIMESTAMP,'%d %m %Y') AND studentid = '$id'"));
  if ($alreadypresent == 0) {
    mysql_query("INSERT INTO bcs_present (`studentid`,`intime`) VALUES ('$id', UTC_TIMESTAMP)");
  }

  return true;
}

if ($_POST['action'] == 'arive') {
  $id = $_POST['id'];
  $pointless = arrivestudent($id);
  $respond = true;
}

if ($_POST['action'] == 'leave') {
  $id = $_POST['id'];
  $date = $_POST['date'];
  mysql_query("DELETE FROM bcs_present WHERE studentid = '$id' AND DATE_FORMAT(intime, '%d/%m/%Y') = '$date' LIMIT 1");
  $respond = true;
}

if ($_POST['action'] == 'bookstudent') {
  $id = $_POST['id'];
  $username = $userarray['username'];
  $time = $_POST['time'];
  $date = $_POST['date'];
  $date = preg_replace("/((\d{2})\/(\d{2})\/(\d{4}))/", "$4-$3-$2", $date);
  if (!empty($id) && !empty($time)) {
    mysql_query("INSERT INTO bcs_bookings (`staff`,`studentid`,`expectedtimestamp`) VALUES ('$username','$id',CONCAT( '$date',' ', '$time',':00'))") or die(mysql_error());
  }

  $teacher = true;
}

if ($_POST['action'] == 'seestudent') {
  $id = $_POST['bookingid'];
  $studentid = $_POST['studentid'];
  arrivestudent($studentid);
  $present = $_POST['present'];
  mysql_query("UPDATE bcs_bookings SET seen = '$present', actualtimestamp = UTC_TIMESTAMP WHERE id = '$id'") or die(mysql_error());
  $teacher = true;
}

if ($_POST['action'] == 'deletebooking') {
  $id = $_POST['bookingid'];
  mysql_query("DELETE FROM bcs_bookings WHERE id = '$id'") or die(mysql_error());
  $teacher = true;
}

if ($_POST['action'] == 'get' || $respond) {
  $search = trim($_POST['search']);
  $year = $_POST['year'];
  $date = $_POST['date'];
  $activities = mysql_query("SELECT *,
       CONCAT(firstname, ' ', lastname) AS name,
       students.id                      AS outputid,
       Ifnull(present, 3)               AS ordercolumn
FROM   bcs_students AS students
       LEFT JOIN (SELECT *,
                         bcs_present.id            AS presentid,
                         Date_format(intime, '%T') AS timein
                  FROM   bcs_present
                  WHERE  Date_format(intime, '%d/%m/%Y') = '$date') AS present
         ON present.studentid = students.id
WHERE  CONCAT(firstname, ' ', lastname, ' ', firstname, ' ', form) LIKE
       '%$search%'
       AND form LIKE '$year%'
ORDER  BY ordercolumn DESC,
          lastname ASC  ");
?>
<table class="left">
<td colspan=3><h3>Yet to Arrive</h3></td>
 <?php
  $present = null;
  while ($item = mysql_fetch_array($activities)) {
    if ($item['present'] != $present) {
?>
   </table>
   <table class="right" style="clear:right">
<tr><td colspan="3"><h3><?php
      if ($item['present'] == '1') { ?>Arrived <?php
      }
      else { ?>Signed Out<?php
      } ?></h3></td></tr>   
   <?php
    }

    $present = $item['present'];
?>
<tr class="item " data-id="<?php
    echo $item['outputid']; ?>" >
<td >
<h3 data-cat="title" ><?php
    echo $item['name']; ?></h3>


<div class="small">
<?php
    if (!is_null($item['present'])) {
?>
In: <?php
      echo $item['timein']; ?>

    <?php
    }

?>    
    
</div>
<div class="review"></div>

</td>

<td><?php
    echo $item['form'] ?></td>
<td class="epc"><button title="Show more details" data-action="expanduser" class="pictogram2"  >/</button></td>
<td class="swap" style="width:82px;">

<?php
    if (is_null($item['present'])) {
      if ($date == date('d/m/Y', date('U') - date('Z'))) {
?>
<button data-action="arrive" class="green">Arrive</button>
<?php
      }
    }
    elseif ($item['present'] == '1') {
?>
<button data-action="leave" class="red">Not Here</button>

<?php
    }
    elseif ($item['present'] == '0') {
?>
<button data-action="leave" class="red">Not Been</button>
<?php
    }

?>

</td>




</tr>
<?php
  }

?>
</table>
<div> &nbsp; </div>
<?php
}

if ($_POST['action'] == 'expanduser') {
  $studentid = $_POST['studentid'];
  $date = $_POST['date'];
  $items = mysql_query("SELECT *, DATE_FORMAT(expectedtimestamp,'%T') as expected, DATE_FORMAT(actualtimestamp,'%T') as actual FROM bcs_bookings LEFT JOIN bcs_login ON bcs_login.username = bcs_bookings.staff  WHERE studentid = '$studentid' AND DATE_FORMAT(expectedtimestamp,'%d/%m/%Y') = '$date' ") or die(mysql_error());
?>
  <table>
    <tr><td colspan=2>Department</td></tr>

    <?php
  while ($item = mysql_fetch_array($items)) {
?>
    
    <tr>
      <td><?php
    echo $item['department']; ?> <abbr title="<?php
    echo $item['staffname']; ?>">(<?php
    echo strtoupper($item['username']); ?>)</abbr></td>
      <td><?php
    if ($item['seen'] == '1') {
      echo "Seen: " . $item['actual'];
    }
    else {
      echo "Expected: " . $item['expected'];
    }

?></td>
    </tr>
    
    <?php
  }

  if (mysql_num_rows($items) == 0) {
?>
      <tr>
          <td colspan=2>No Bookings Made</td>
      </tr><?php
  }

?>
  
  </table>
    
    <?php
}

if ($_POST['action'] == 'Teacher' || $teacher) {
  $date = $_POST['date'];
  $year = $_POST['year'];
  $username = $userarray['username'];
  $items = mysql_query("SELECT *, CONCAT(firstname, ' ', lastname) as name, DATE_FORMAT(expectedtimestamp ,'%T') as expected, DATE_FORMAT(bookings.actualtimestamp ,'%T') as actualtime, students.id as tblstudentsid, bookings.id as bookingid FROM bcs_students as students RIGHT JOIN bcs_bookings as bookings ON students.id = bookings.studentid  LEFT JOIN (SELECT *, bcs_present.id as presentid, DATE_FORMAT(intime, '%T') as timein FROM bcs_present WHERE DATE_FORMAT(intime, '%d/%m/%Y') = '$date') as present ON present.studentid = students.id  WHERE students.form LIKE '$year%' AND DATE_FORMAT(bookings.expectedtimestamp,'%d/%m/%Y') = '$date' AND bookings.staff = '$username' ORDER BY bookings.seen, lastname, firstname") or die(mysql_error());
?>
    <table class="left">
    <tr><td>Not-Seen</td></tr>
  <?php
  $seen = 0;
  while ($item = mysql_fetch_array($items)) {
    if ($seen != $item['seen']) {
?>

    </table>
    
    
    <table class="right">
      <tr>
    <td>Students Seen</td>
      </tr>
      <?php
    }

    $seen = $item['seen']
?>
      <tr data-id="<?php
    echo $item['tblstudentsid']; ?>" data-bookingid="<?php
    echo $item['bookingid']; ?>" class="item">
    <td><?php
    echo $item['name'];
    if (!is_null($item['timein'])) {
?>
     <div class="small">In: <?php
      echo $item['timein']; ?>
     <?php
      if ($item['seen'] == '1') { ?>
     Appointment: <?php
        echo $item['expected']; ?>
     <?php
      } ?>
    
     </div>
     <?php
    }

?>
    <div class="review"></div>
    </td>
    <td>
    
    <?php
    if ($item['seen'] == '1') {
      echo $item['actualtime'];
    }
    else {
      echo $item['expected'];
    }

?>
    
    </td>
    <td class="epc"><button title="Show more details" data-action="expanduser" class="pictogram2"  >/</button></td>
    
    <td style="width: 80px;">
    <?php
    if (is_null($item['timein']) || $item['seen'] == '0') {
?><button data-action="deletebooking" class="red">Delete</button><?php
      if ($date == date('d/m/Y', date('U') - date('Z'))) {
?>
       <button data-action="seestudent" data-present="1" class="green"><?php
        if (is_null($item['timein'])) {
          echo "Arrive & ";
        } ?>See</button>
        <?php
      }
    }
    elseif ($item['seen'] == '1') {
?>
        <button data-action="seestudent" data-present="0" class="blue">Not Seen</button>
        <?php
    }

?>
    </td>
      </tr>
      <?php
  }

?>
    </table>
    <br clear=both>
    <table style=";width:100%;margin-top: 10px;">
  <tr class="item">
<td>
<em>Use this feature only in Chrome, Firefox or Safari</em><br />
    Add: <input type="text" data-prop="timepicker" placeholder="time" style="width: 50px;" /> <input type="text" placeholder="student" data-action="addbooking" /> <button data-action="studentbooking">Book</button>
    
    
</td>    
    
</tr>

    </table>
    
    <div style="height:250px;">
  
  
    </div>
    <?php
}

if ($_GET['action'] == 'autocomplete') {
  $term = $_POST['term'];
  $year = $_GET['year'];
  $students = mysql_query("SELECT *, CONCAT(firstname, ' ', lastname) as name FROM bcs_students WHERE CONCAT(firstname, ' ', lastname,' ', firstname) LIKE '%$term%' AND form LIKE '$year%'");
  $i = 0;
  while ($student = mysql_fetch_array($students)) {
    $output[$i]['label'] = $student['name'];
    $output[$i]['value'] = $student['id'];
    $output[$i]['desc'] = $student['form'];
    $i++;
  }

  echo json_encode($output);
}

if ($_POST['action'] == 'summary') {
  $date = $_POST['date'];
  $year = $_POST['year'];
  $activities = mysql_query("SELECT *,GROUP_CONCAT(staff) AS peopleseen
FROM   (SELECT Concat(firstname, ' ', lastname) AS name,form,present,intime, firstname, lastname,
                      students.id AS outputid
        FROM   bcs_students AS students
               LEFT JOIN (SELECT present,studentid,Date_format(intime, '%T') AS
                                                   intime
                          FROM   bcs_present
                          WHERE  Date_format(intime, '%d/%m/%Y') = '$date')
                         AS
                         present
                 ON present.studentid = students.id
        WHERE  form LIKE '$year%'
        ORDER  BY form,lastname,firstname) AS students
       LEFT JOIN (SELECT staff,studentid
                  FROM   bcs_bookings
                  WHERE  Date_format(expectedtimestamp, '%d/%m/%Y') =
                         '$date') AS
                                                                 bookings
         ON students.outputid = bookings.studentid
GROUP  BY outputid
ORDER BY form, lastname, firstname
") or die(mysql_error());
?>
<table style="width:100%" >

 <?php
  $form = null;
  while ($item = mysql_fetch_array($activities)) {
    if ($item['form'] != $form) {
?>
    <tr class="<?php
      if (!is_null($form)) {
        echo "break";
      } ?>"><td colspan=5></td></tr>
<tr><td colspan=5 ><h3><?php
      echo $item['form']; ?></h3></td></tr>    
    <?php
    }

    $form = $item['form'];
?>
<tr class="item" data-id="<?php
    echo $item['outputid']; ?>" >
<td >
<?php
    echo $item['name']; ?>

</td>

<td><?php
    echo $item['intime']; ?></td>
<td><?php
    echo $item['peopleseen']; ?></td>
<td style="width:50px;">
<?php
    if (is_null($item['present'])) {
?>
<img src="http://app.davidpurser.net/icon/delete_16.png" >

<?php
    }
    else {
?>
<img src="http://app.davidpurser.net/icon/tick16.png" >
<?php
    }

?>
</td>




</tr>
<?php
  }

?>
    <tr class="<?php
  if (!is_null($form)) {
    echo "break";
  } ?>"><td colspan=5></td></tr>
<tr><td colspan=5 >No Shows</td></tr>    
<?php
  $noshow = mysql_query("SELECT *,
       CONCAT(firstname, ' ', lastname) AS name,
       students.id                      AS outputid
FROM   bcs_students AS students
       LEFT JOIN (SELECT *
                  FROM   bcs_present
                  WHERE  Date_format(intime, '%d/%m/%Y') = '$date') AS
                 present
         ON present.studentid = students.id
WHERE  form LIKE '$year%'
       AND Ifnull(present.intime, 'no') = 'no'
ORDER  BY form,
          lastname,
          firstname");
  while ($item = mysql_fetch_array($noshow)) {
?>
    <tr class="item"><td><?php
    echo $item['name'] ?></td><td><?php
    echo $item['form'] ?></td><td colspan=3></td></tr>    
    <?php
  }

?>




</table>
<div> &nbsp; </div>
<?php
}

?>