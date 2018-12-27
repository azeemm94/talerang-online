<?php 
/*//Connection format
$DBcon=mysqli_connect(host,user,password,DBname);*/
//connects locally
if(in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','::1')))
{
	$DBcon=mysqli_connect('localhost','root','','taldata');
}
else //connects to talerang
{
	if(isset($edusynch))
	{
		$EDcon=mysqli_connect('taledusynch.db.12086615.hostedresource.com','taledusynch','Edusynch@123','taledusynch');
		unset($edusynch);
	}
	else
	{
		$DBcon=mysqli_connect('talexpress1.db.12086615.hostedresource.com','talexpress1','Neelkanth@203','talexpress1'); 
	}
}
?>