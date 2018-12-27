<?php 
echo $_SERVER['REMOTE_ADDR'];
/*
ini_set('max_execution_time', 1300);
$chars = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
$randoms=array();
for ($i=0; $i <1000 ; $i++) { 
$res = "";
    for ($j=0;$j<6; $j++) {
    $res .= $chars[mt_rand(0, strlen($chars)-1)];
}
array_push($randoms,$res);
}
sort($randoms);
for ($i=0; $i <count($randoms) ; $i++) { 
    echo $randoms[$i]."<br>";
}



require 'connectsql.php';

$sql="CREATE TABLE IF NOT EXISTS `couponcodes`(
    	`id` int(10) NOT NULL AUTO_INCREMENT,
    	`code` varchar(6) NOT NULL,
    	`email` varchar(254),
    	`used` tinyint(1) NOT NULL,
    	`date` varchar(25),
    	PRIMARY KEY (`id`)
    	)
    	ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
    	mysqli_query($DBcon,$sql);

for ($i=0; $i <count($coupons) ; $i++) { 
	$code=$coupons[$i];
	$sql="INSERT INTO `couponcodes` (`code`,`used`)
			VALUES('$code','0')";
			mysqli_query($DBcon,$sql);
}*/

?>