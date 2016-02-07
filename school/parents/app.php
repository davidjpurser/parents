<?php
include "../connect.php";
$mustbestaff = true;

include "../check.php"; ?>
<!DOCTYPE html>
<html>

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Parent Evening Check In</title>




<link rel="stylesheet" href="https://www.davidpurser.net/static/formalize/css/formalize.css" type="text/css" >
<link type="text/css" href="https://www.davidpurser.net/static/jqueryui/css/smoothness/jquery-ui-1.8.21.custom.css" rel="stylesheet">

<link rel="stylesheet" href="https://www.davidpurser.net/static/tipsy/tipsy.css" type="text/css" >

<script type="text/javascript" src="https://www.davidpurser.net/static/jq.js" ></script>
<script type="text/javascript" src="https://www.davidpurser.net/static/jqueryui/js/jquery-ui-1.8.21.custom.min.js" ></script>
<script type="text/javascript" src="https://www.davidpurser.net/static/formalize/js/jquery.formalize.min.js"></script>
<script type="text/javascript" src="https://www.davidpurser.net/static/tipsy/jquery.tipsy.js"></script>



<script  src="script.js"></script>
<link href="css.css" rel="stylesheet" type="text/css" >


<script src="https://raw.github.com/perifer/timePicker/master/jquery.timePicker.min.js"></script>

<?php
if(isset($_GET['date'])){
	?>
	<script>
		$(document).ready(function(){
			
			$('input[data-prop=date]').val('<?php echo $_GET['date']; ?>');
			$('select[data-prop=year]').val(<?php echo $_GET['year']; ?>);
			doadd();
		});
		
	</script>
	<?php
}


?>
</head>


<body>
<div class="pagewidth">
	<header ><h1>Parents Evening Check In</h1></header>

<div id="add">
	<table style="width:100%; border-collapse:collapse">
		<tr class="item">
			
			<td>
				<table style="width: 100%">
					<tr >
						<td style="width: 55px">
							<h3>
								Search:
							</h3>
						</td>
						<td style="width: 40px;">
							<select data-prop="year">
								<?php
								for($i=7; $i<= 13; $i++){
								?><option><?php echo $i; ?></option><?php
								}
								?>
							</select>
						</td>
						<td style="width: 60px;">
							<input style="width:75px;" type="text" value="<?php echo date('d/m/Y'); ?>" data-prop="date" />
						</td>
						<td style="width: 75px;">
							<select data-prop="action">
								<option value="get">Checkin</option>
								<option>Teacher</option>
								<option value="summary">Summary</option>
							</select>
						</td>
						<td  id="title" >
							<input data-prop="title" />
						</td>
						
						<td style="width:50px;">
							<button data-action="add">
								Search
							</button>
						</td>
					</tr>
				</table>
			</td>
			<td style="width:54px">
				
				<button class="opacative" data-action="fullrefresh">Refresh</button>
			</td>
			<td style="width:54px">
				<form action="/school/logout.php" method="get">
					<button>Logout</button>
				</form>
				
			</td>
			<td style="width:60px">
				
				<form action="/school/me.php" method="get" stude>
					<button>Manage</button>
				</form>
			</td>

		</tr>
	</table>
</div>
<br>

<div id="timer">
	
</div>

</div>

</body>

</html>
