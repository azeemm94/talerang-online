<?php session_start();
require 'connectsql.php';

if(isset($_POST['page']))
	$curpg=$_POST['page'];
elseif(isset($_GET['pgno']))
	$curpg=$_GET['pgno'];
else $curpg=1;

if(isset($_POST['delete']))
{
	$email=$_POST['email'];
	$sql="DELETE FROM `teststart` WHERE `email`='$email'";
	mysqli_query($DBcon,$sql);
	$sql="DELETE FROM `results` WHERE `email`='$email'";
	mysqli_query($DBcon,$sql);

    $search=$_POST['search'];
	header("location:adminreset.php?pgno=".$curpg."&search=".$search);
}// end if isset confirm
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
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
		$sql="SELECT `email` FROM ( SELECT `email` FROM `teststart` WHERE `email` LIKE '%$search%' UNION ALL SELECT `email` FROM `results` WHERE `email` LIKE '%$search%' ) N GROUP BY `email`;";
		
		$result=mysqli_query($DBcon,$sql);
		$row_cnt=mysqli_num_rows($result);
		$nopgs=20; // no of entries you want per page
		$pgs=ceil($row_cnt/$nopgs); ?>

		<div id="search">
			<p><span style="color:red">Deleting will completely reset WRAP for the student (except coupon codes and payments)</span><br>You may search by email address</p> 
		    <form method="post" action="adminreset.php"  id="searchform"> 
				<input type="text" name="search" value="<?php echo $search ?>"> 
				<input type="submit" name="search-submit" value="Search">
				<a href="adminreset.php" target="_self" id="showall">Show all entries</a>
		    </form> 
	    </div>

		<?php echo "<div id=\"num\">Total number of entries: ".$row_cnt."</div>"; ?>
		<?php if(!$row_cnt==0 && $pgs>1){ ?>
		<form method="post" action="adminreset.php" id="pages">
			<?php if($curpg!=1){ ?><a href="adminreset.php?pgno=<?php echo ($curpg-1) ?>&search=<?php echo $search ?>" class="prevnext" target="_self">&lt;&lt; Previous</a><?php } ?>
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
			<?php if($curpg!=$pgs){ ?><a href="adminreset.php?pgno=<?php echo ($curpg+1) ?>&search=<?php echo $search ?>" class="prevnext" target="_self">Next &gt;&gt;</a><?php } ?>
		</form>
		<?php } //end if row_cnt!=0 ?>
<?php	require 'connectsql.php';
		$pgstart=($curpg-1)*$nopgs; 
if(!$row_cnt==0){ ?>
<div class="rTable">
<div class="rTableRow">
	<div class="rTableHead center" style="border-left: none">No</div>
	<div class="rTableHead center">Full Name</div>
	<div class="rTableHead center">Email</div>
	<div class="rTableHead center">Test Completed</div>
	<div class="rTableHead center">Test Score</div>
	<div class="rTableHead center">View</div>
	<div class="rTableHead center">Delete entry</div>
</div>
<?php 
$vals=array();
for ($i=0; $i<$nopgs ; $i++) array_push($vals,$pgstart++);
$i=0;
while($row=mysqli_fetch_row($result)) 
{	
	if(!in_array($i,$vals))
	{ $i++; continue; }

	$rowemail=$row[0];
	$name=mysqli_fetch_row(mysqli_query($DBcon,"SELECT `firstname`,`lastname` FROM `register` WHERE `email`='$rowemail'"));
	$fullname=$name[0]." ".$name[1];
	$rows=mysqli_num_rows(mysqli_query($DBcon,"SELECT * FROM `results` WHERE `email`='$rowemail'"));
	if(!$rows==0) $completed=true;
	else $completed=false;
?>

<form method="post" onSubmit="return confirm('Are you sure you want to delete <?php echo $rowemail ?>')" class="rTableRow <?php if($i%2==0)echo 'evenRow' ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="page" value="<?php echo $curpg ?>" style="display:none">
	<input type="text" name="search" value="<?php echo $search ?>" style="display:none">
	<div class="rTableCell center" style="border-left: none"><?php echo ($i+1);//$row[8]; ?></div>
	<div class="rTableCell center"><?php echo $fullname ?></div>
	<div class="rTableCell center"><?php echo $rowemail ?><input style="display:none" name="email" type="text" value="<?php echo $rowemail ?>"/></div>
	<div class="rTableCell center">
		<?php if($completed): ?>
			<img src="img/greentick.png"/>
		<?php else: ?>
			<img src="img/redcross.png"/>
		<?php endif ?>
	</div>
	<div class="rTableCell center">
		<?php if($completed): 
			$sql="SELECT `avg` FROM `results` WHERE `email`='$rowemail';";
			$score=mysqli_fetch_row(mysqli_query($DBcon,$sql));
			$score=$score[0];
			echo $score."%";
			 endif ?>
	</div>
	<div class="rTableCell center">
		<?php if($completed): ?>
			<a href="admindashboard.php?user=<?php echo $rowemail ?>" class="dashboard-link">View Dashboard</a>
		 <?php endif; ?>
	</div>
	<div class="rTableCell center">
		<input type="submit" name="delete" value="Delete" method="post"/>
	</div>
</form>

<?php $i++;} //end while loop ?>
</div> <!-- close table -->
<?php } // end if !row_cnt==0 ?>

<?php } else { //end if session isset??>
	<div class="container" id="notsignedin">
		<div class="alert alert-warning">
			You are not signed in! Please <a href="adminlogin.php" class="alert-link">log in</a> first.
		</div>
	</div>

<?php }//end else session isset? ?> 
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