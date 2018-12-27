<?php session_start();
date_default_timezone_set('Asia/Kolkata');
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
	<meta name="robots" content="index, follow">  
	<title>Talerang Express | WRAP Certificate</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css">
	<link rel="stylesheet" type="text/css" href="css/certificate.css">
	<?php include 'noscript.php' ?>
	<?php include 'jqueryload.php' ?>
    <script type="text/javascript" src="js/html2canvas.min.js"></script>
</head>

<body>
<?php include 'google-analytics.php'; ?>
<div id="wrapper">
	<nav class="navbar navbar-default" id="nav-header">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	    <?php if(isset($_SESSION['useremail'])): ?>
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	    <?php endif; ?>
	      <img alt="Talerang" src="img/logoexpress.jpg">
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	   <?php if(isset($_SESSION['useremail'])): ?>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
		    <li class="nav-link welcome"><a><span class="text">Signed in as <?php echo $_SESSION['firstname'] ?></span></a></li>
		    <li class="nav-link"><a href="dashboard.php"><span class="text">Back</span></a></li>
		    <li class="nav-link"><a href="logout.php"><span class="text">Logout</span></a></li>
	      
	      </ul>
	    </div><!-- /.navbar-collapse -->
	   <?php endif; ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<div id="content">
	<div class="container-fluid">
	<?php if(isset($_SESSION['useremail'])): 
		$email=$_SESSION['useremail'];
		require 'connectsql.php';

		$sql="SELECT * FROM `results` WHERE `email`='$email' LIMIT 1;";

		$result=mysqli_query($DBcon,$sql);
		$completed=mysqli_num_rows($result);
		$result=mysqli_fetch_assoc($result);

		$fullname=$result['firstname']." ".$result['lastname'];
		$percentile=round($result['percentile'],0);
		$percentage=round($result['avg'],0)."%";
		$certificate=$result['certificate'];

		if($completed):
	?>

		<div class="container certificate-con">
			<div id="download-button" style="margin-bottom: 20px">
				<a type="button" id="btn-convert-html2image" href="#">Download this Certificate</a>
			</div>
			<div id="html-content-holder" style="position: relative; background: url(img/certificate.png); background-size: contain; background-position: center center; background-repeat: no-repeat; width: 800px; height: 600px; color: black; display: inline-block; text-align: left;">
			<!-- 	<img src="img/certificate.png" width="800px" height="600px" style="position: absolute;"> -->
			    <div style="position:absolute; padding: 0 55px; padding-top: 130px;">
					<h3 style="font-family: 'Cookie-Regular'; text-align: center; font-size: 72px;">Certificate</h3>
					<p style="text-align: center; margin-top: 20px">
					    This is to certify that <span style="font-size: 24px;text-align: center; font-weight: bolder;"><?php echo $fullname ?></span> has completed the Work-Readiness Aptitude Predictor (WRAP) with a percentile of <b><?php echo $percentile ?></b> and a work-ready score of <b><?php echo $percentage ?></b>
					</p>
			    </div>
		       	<div id="signature" style="position: absolute;top: 451px;right: 123px;font-family: Arty Signature;font-weight: 900;font-size: 40px;">S.R.
		       	</div>
		       	<div style="color: #666666; position: absolute; bottom: 3px; width: 100%; text-align: center; font-size: 18px; line-height: 18px;">
		       		Certificate ID: <?php echo $certificate ?><br>
		       		Verify at: <a href="http://www.talerang.com/express/certificate-verify.php">www.talerang.com/express/certificate-verify.php</a>
		       	</div>
			</div>
		</div>

    	<div id="previewImage" style="display: none;"></div>
	<?php  else: //WRAP not finished ?>
		<div class="container">
			<div class="alert alert-warning" style="margin-top: 20px;">
				You must complete <a href="index.php" class="alert-link">WRAP</a> for this certificate
			</div>
		</div>
	<?php  endif;
		   else: //not signed in ?>
		<div id="notsignedin" class="container">
				You are not signed in!<br/>
				Please <a href="index.php">Sign in</a> to view your certificate
		</div>
	<?php endif ?>
	
	</div> <!-- close container-fluid -->
	</div> <!-- close content -->

	<?php include 'footer.php' ?>

</div><!--  close wrapper -->
<script type="text/javascript" src="js/jspdf.min.js"></script>
<script type="text/javascript">
    var element = $("#html-content-holder"); // global variable
    var getCanvas; // global variable

     html2canvas(element, {
     onrendered: function (canvas) {
            $("#previewImage").append(canvas);
            getCanvas = canvas;
         }
     });

    $("#btn-convert-html2image").on('click', function () {

    	//for jpg
        var imageData = getCanvas.toDataURL("image/jpg");
        var newData = imageData.replace(/^data:image\/jpg/, "data:application/octet-stream");
        $("#btn-convert-html2image").attr("download", "WRAP_Certificate.jpg").attr("href", newData);

        //for pdf
      /*  var doc = new jsPDF("l", "pt", "a4");
        doc.addImage(newData, 'JPG', 0, 0, 800, 600);
        doc.save('sample-file.pdf');*/
    });
    <?php //echo "_".$_SESSION['firstname']."_".$_SESSION['lastname']; ?>
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>