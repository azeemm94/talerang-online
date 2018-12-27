<?php
require 'connectsql.php'; 

if(isset($_POST['email']))
{
	$email=mysqli_real_escape_string($DBcon,$_POST['email']);
	$sql="SELECT `email` FROM `register` WHERE `email`='$email';";
	$emails=mysqli_query($DBcon,$sql);
	$emails=mysqli_num_rows($emails);

 if($emails>0)
  echo "Email already exists! Please choose another email to register with";
 else
  echo "";
 exit();
}

?>