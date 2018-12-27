<?php session_start();
require 'connectsql.php';

    if(isset($_POST['page'])) 
	$curpg=$_POST['page'];
elseif(isset($_GET['pgno']))
	$curpg=$_GET['pgno'];
else $curpg=1;
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow">
	<title>Talerang Express | Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/adminstyle.css">
	<?php include 'jqueryload.php' ?>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<?php include 'noscript.php' ?>
</head>

<body>
<div id="wrapper">
<div id="header">
	<img src="img/logoexpress.jpg" alt="Talerang">
	<?php if(isset($_SESSION['adminuser'])) { ?>
		<a href='adminlogout.php' id="logout">Logout</a>
		<a href='adminlanding.php' id="back">Back</a>
	<?php } ?>
</div> <!-- end header -->

<div id="content">

<?php if(isset($_SESSION['adminuser'])){ 
		if(isset($_GET['search'])) $search=$_GET['search'];
		else
		isset($_POST['search'])? $search=$_POST['search']: $search="";

		$query="SELECT * FROM `placement` WHERE `firstname` LIKE '%$search%' OR `lastname` LIKE '%$search%' OR `email` LIKE '%$search%'";
		$result=mysqli_query($DBcon,$query);
		$row_cnt=mysqli_num_rows($result);
		$nopgs=10; // no of entries you want per page
		$pgs=ceil($row_cnt/$nopgs); ?>

		<div id="search">
			<p>You may search either by name or email</p> 
		    <form method="post" action="adminplacement.php"  id="searchform"> 
		      <input type="text" name="search" value="<?php echo $search ?>"> 
		      <input type="submit" name="search-submit" value="Search">
		    </form> 
		    <a href="adminplacement.php" target="_self" id="showall">Show all entries</a>
	    </div>

		<?php echo "<div id=\"num\">Total number of entries: ".$row_cnt."</div>"; ?>

		<form method="post" action="adminplacement.php" id="pages">
			<label for="page">Page No:</label>
			<select name="page" id="page">
				<?php 
					for($i=1; $i <=$pgs ; $i++) 
					{
						if($i!=$curpg)
						echo "<option value=\"".$i."\">".$i."</option>";
						else
						echo "<option value=\"".$i."\" selected>".$i."</option>";
					}
				?>
			</select>
			<input type="submit" name="submit" id="submit" style="display: none">
		</form>
<?php	require 'connectsql.php';
		$pgstart=($curpg-1)*$nopgs;
		?>

<div class="rTable">
<div class="rTableRow">
	<div class="rTableHead center" style="border-left: 0">No</div>
	<div class="rTableHead center">Full Name</div>
	<div class="rTableHead center">Email</div>
	<div class="rTableHead center">Mobile</div>
	<div class="rTableHead center">College</div>
	<div class="rTableHead center">Current City</div>
	<div class="rTableHead center">Preferred City</div>
	<div class="rTableHead center">Register Date</div>
	<div class="rTableHead center">Paid?</div>
</div>
<?php 
$vals=array();
for ($i=0; $i<$nopgs ; $i++) array_push($vals,$pgstart++);
$i=0;
while($row=mysqli_fetch_assoc($result)) 
{	
	if(!in_array($i,$vals))
	{
		$i++; 
		continue;
	}
	$rowemail=$row['email'];
	$accountno=$row['accountno'];
	$fees=mysqli_query($DBcon,"SELECT * FROM `feespaid` WHERE `type`='Placement Express' AND `status`='SUCCESS' AND `accountno`='$accountno' LIMIT 1;");
	$feespaid=mysqli_num_rows($fees);
	$fees=mysqli_fetch_assoc($fees);
	$fees=$fees['amount'];
	$row['date']=date('jS M, Y - h:i A',strtotime($row['date']));
?>
<div class="rTableRow <?php if($i%2==0) echo "evenRow" ?>">
	<div class="rTableCell center"><?php echo ($i+1); ?></div>
	<div class="rTableCell center"><?php echo $row['firstname'].' '.$row['lastname'] ?></div>
	<div class="rTableCell center"><?php echo $row['email'] ?></div>
	<div class="rTableCell center"><?php echo $row['mobileno'] ?></div>
	<div class="rTableCell center"><?php echo $row['college'] ?></div>
	<div class="rTableCell center"><?php echo $row['city'] ?></div>
	<div class="rTableCell center"><?php echo $row['citypref'] ?></div>
	<div class="rTableCell center"><?php echo $row['date'] ?></div>
	<div class="rTableCell center"><?php if($feespaid) echo 'Rs. '.$fees; else echo '<img src="img/redcross.png"/>'; ?></div>
</div>


<?php $i++;} //end while loop ?>
</table>

<?php } else { ?> <!-- end if session isset? -->
	<div class="container" id="notsignedin">
		<div class="alert alert-warning">
			You are not signed in! Please <a href="adminlogin.php" class="alert-link">log in</a> first.
		</div>
	</div>

<?php } ?> <!-- end else session isset? -->
</div> <!-- close content -->

<?php include 'footer.php' ?>
</div><!--  close wrapper -->
<script type="text/javascript">
	$( "#page" ).change(function() {
 		$("#submit").trigger('click');
	});
</script>
</body>
</html>