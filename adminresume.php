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
	<link rel="stylesheet" type="text/css" href="css/adminstyle.css?version=?1.1">
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

<?php if(isset($_SESSION['adminuser']))
	  { 
		if(isset($_GET['search'])) $search=$_GET['search'];
		else
		isset($_POST['search'])? $search=$_POST['search']: $search="";

		$query="SELECT  `register`.`firstname`,`register`.`lastname` ,`register`.`email`,`register`.`accountno` 
				FROM  `register` 
				INNER JOIN  `resume` ON  `register`.`accountno` =  `resume`.`resumeid` 
				ORDER BY `lastname`;";
		$result=mysqli_query($DBcon,$query);
		$row_cnt=mysqli_num_rows($result);
		$nopgs=20; // no of entries you want per page
		$pgs=ceil($row_cnt/$nopgs); ?>

		<div id="search">
			<p>You may search either by first/last name or email</p> 
		    <form  method="post" action="adminresume.php"  id="searchform"> 
				<input type="text" name="search" value="<?php echo $search ?>"> 
				<input type="submit" name="search-submit" value="Search">
				<a href="adminresume.php" target="_self" id="showall">Show all entries</a>
		    </form> 
	    </div>

		<?php if(!$row_cnt==0) echo "<div id=\"num\">Total number of entries: ".$row_cnt."</div>"; ?>
		<?php if(!$row_cnt==0 && $pgs>1) { ?>
		<form method="post" action="adminresume.php" id="pages">
			<?php if($curpg!=1){ ?><a href="adminresume.php?pgno=<?php echo ($curpg-1) ?>&search=<?php echo $search ?>" class="prevnext" target="_self">&lt;&lt; Previous</a><?php } ?>
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
			<?php if($curpg!=$pgs){ ?><a href="adminresume.php?pgno=<?php echo ($curpg+1) ?>&search=<?php echo $search ?>" class="prevnext" target="_self">Next &gt;&gt;</a><?php } ?>
		</form>
		<?php } //end if row_cnt!=0 ?>
<?php	require 'connectsql.php';
		$pgstart=($curpg-1)*$nopgs; 
if($row_cnt==0) echo "<div style=\"margin-left:20px\"><b>$search</b> not found! Please search again</div>";
if(!$row_cnt==0){ ?>
<div class="rTable">
<div class="rTableRow">
	<div class="rTableHead center">No</div>
	<div class="rTableHead center">Full Name</div>
	<div class="rTableHead center">Email</div>
	<div class="rTableHead center">Date Modified</div>
	<div class="rTableHead center">Personal</div>
	<div class="rTableHead center">Education</div>
	<div class="rTableHead center">Work-ex</div>
	<div class="rTableHead center">Leadership</div>
	<div class="rTableHead center">Skills</div>
	<div class="rTableHead center">Download</div>
	<div class="rTableHead center">Edit</div>
</div>
<?php 
$vals=array();
for ($i=0; $i<$nopgs ; $i++) array_push($vals,$pgstart++);
$i=0;
while($row=mysqli_fetch_assoc($result)) 
{
	if($search!="")
	{	
		$flag=false;
		if(strpos(strtolower($row['firstname'].' '.$row['lastname']),strtolower($search))!==false) $flag=true;
		if(strpos(strtolower($row['email']),strtolower($search))!==false) $flag=true;
		
		if(!$flag) continue;
	}	
	
	if(!in_array($i,$vals))
	{ $i++; continue; }
	
	//Checking how much of the resume is complete
	$resumeid=$row['accountno'];
	$resumearr=mysqli_query($DBcon,"SELECT * FROM `resume` WHERE `resumeid`='$resumeid' LIMIT 1;");
	$resumearr=mysqli_fetch_assoc($resumearr);
	$resumests=array('personal'=>false,'education'=>false,'workex'=>false,'leader'=>false,'skills'=>false); //status of completion for each of the sections...updated below
	if($resumearr['firstname']!=""&&$resumearr['lastname']!=""&&$resumearr['mobileno']!=""&&$resumearr['email']!=""&&$resumearr['city']!=""&&$resumearr['country']!=""&&$resumearr['pincode']!="") 
	$resumests['personal']=true; //Personal complete
	if($resumearr['schoolname']!=""&&$resumearr['schoolcity']!=""&&$resumearr['schoolcourse']!=""&&$resumearr['schoolyear']!=""&&$resumearr['schoolmarks']!=""&&$resumearr['schoolname']!="")
	$resumests['education']=true; //Education complete
	if($resumearr['workcompany']!=""&&$resumearr['workdes']!=""&&$resumearr['workstart']!=""&&$resumearr['workend']!=""&&$resumearr['workresp']!="")
	$resumests['workex']=true; //Work ex complete
	if($resumearr['leadername']!=""&&$resumearr['leaderdesc']!="")
	$resumests['leader']=true; //leader complete
	if($resumearr['skills']!="")
	$resumests['skills']=true; // skills complete

	$edited=$resumearr['dateedited'];
	if($edited=="") $edited=$resumearr['datecreate'];
	$edited=date('jS M, y H:i a', strtotime($edited));
?>

<form method="post" class="lifevisform rTableRow <?php if($i%2==0)echo 'evenRow' ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="page" value="<?php echo $curpg ?>" style="display:none">
	<input type="text" name="search" value="<?php echo $search ?>" style="display:none">
	<div class="rTableCell center"><?php echo ($i+1);//$row[8]; ?></div>
	<div class="rTableCell center"><?php echo $row['firstname'].' '.$row['lastname']; ?></div>
	<div class="rTableCell center"><?php echo $row['email']; ?></div>
	<div class="rTableCell center"><?php echo $edited; ?></div>
	<div class="rTableCell center"><?php if($resumests['personal']): ?><img src="img/greentick.png"><?php endif ?></div>
	<div class="rTableCell center"><?php if($resumests['education']): ?><img src="img/greentick.png"><?php endif ?></div>
	<div class="rTableCell center"><?php if($resumests['workex']): ?><img src="img/greentick.png"><?php endif ?></div>
	<div class="rTableCell center"><?php if($resumests['leader']): ?><img src="img/greentick.png"><?php endif ?></div>
	<div class="rTableCell center"><?php if($resumests['skills']): ?><img src="img/greentick.png"><?php endif ?></div>
	<div class="rTableCell center"><a href="resumedownload.php?admindl&account=<?php echo $row['accountno'] ?>" class="reslink" <?php if($resumests['personal']&&$resumests['education']&&$resumests['workex']&&$resumests['leader']&&$resumests['skills']) echo 'style="background:green;"'; ?>>Download</a></div>
	<div class="rTableCell center"><a href="resumecreate.php?accountno=<?php echo $row['accountno'] ?>" class="reslink">Edit</a></div>
</form>

<?php $i++; 
	} //end while loop ?>
</div> <!-- close table -->
<?php } // end if row_cnt==0 ?>
<?php } else { //end if session isset??>
	<div class="container" id="notsignedin">
		<div class="alert alert-warning">
			You are not signed in! Please <a href='adminlogin.php' class="alert-link">log in</a> first.
		</div>
		
	</div>

<?php } ?> <!-- end else session isset? -->
</div> <!-- close content -->

<?php include 'footer.php' ?>
</div><!--  close wrapper -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/admin.js"></script>
</body>
</html>