<?php
require 'connectsql.php';

if(isset($_POST['submit-citrus'])){
/*$formPostUrl = "https://sandbox.citruspay.com/sslperf/qpu2ot7kd9"; //sandbox	*/
$formPostUrl = "https://sandbox.citruspay.com/sslperf/xfvlfc2mck";	
/*$secret_key = "04e6433045ff1be1045abd298410b85fd5ff63eb";//sandbox*/
$secret_key = "a91aa548d10e890d2f6db3353e7f0cc2ad4b1c03";	
/*$vanityUrl = "qpu2ot7kd9"; //sandbox */
$vanityUrl = "xfvlfc2mck";
$merchantTxnId = uniqid(); 
$fname=$_SESSION['firstname'];
$lname=$_SESSION['lastname'];

$currency = "INR";
$data= $vanityUrl.$orderAmount.$merchantTxnId.$currency;
$securitySignature = hash_hmac('sha1', $data, $secret_key);
?>
<script type="text/javascript" >
	var dataObj = {
				 orderAmount : "<?php echo $orderAmount ?>",
				 currency: "INR",
				 vanityUrl: "<?php echo $vanityUrl ?>",
				 merchantTxnId: "<?php echo $merchantTxnId ?>",
				 returnUrl: "<?php echo $returnUrl ?>",
				 secSignature: "<?php echo $securitySignature ?>",
				 mode:"dropOut",
				 firstName: "<?php echo $fname ?>",
				 lastName: "<?php echo $lname ?>",
				};

	configObj = {
		icpUrl: "https://sboxcontext.citruspay.com/kiwi/kiwi-popover", 
		eventHandler: function(cbObj) {
		if (cbObj.event === 'icpLaunched') {
			//This is good place to stop loader
			console.log('Citrus ICP pop-up is launched');
		} else if (cbObj.event === 'icpClosed') {
			console.log(JSON.stringify(cbObj.message));
			console.log('Citrus ICP pop-up is closed');
		}
		}
	}; /*end configObj*/
	try {
		citrusICP.launchIcp(dataObj, configObj);
	}
	catch(error) {
		console.log(error);
	}
</script>
<?php
} /*end isset post citrus*/

set_include_path('../lib'.PATH_SEPARATOR.get_include_path());
$data = "";
$flag = "true";
if(isset($_POST['TxId']))        { $txnid       = $_POST['TxId'];        $data .= $txnid;      }
if(isset($_POST['TxStatus']))    { $txnstatus   = $_POST['TxStatus'];    $data .= $txnstatus;  }
if(isset($_POST['amount']))      { $amount      = $_POST['amount'];      $data .= $amount;     }
if(isset($_POST['pgTxnNo']))     { $pgtxnno     = $_POST['pgTxnNo'];     $data .= $pgtxnno;    }
if(isset($_POST['issuerRefNo'])) { $issuerrefno = $_POST['issuerRefNo']; $data .= $issuerrefno;}
if(isset($_POST['authIdCode']))  { $authidcode  = $_POST['authIdCode'];  $data .= $authidcode; }
if(isset($_POST['firstName']))   { $firstName   = $_POST['firstName'];   $data .= $firstName;  }
if(isset($_POST['lastName']))    { $lastName    = $_POST['lastName'];    $data .= $lastName;   }
if(isset($_POST['pgRespCode']))  { $pgrespcode  = $_POST['pgRespCode'];  $data .= $pgrespcode; }
if(isset($_POST['addressZip']))  { $pincode     = $_POST['addressZip'];  $data .= $pincode;    }
if(isset($_POST['signature'])) $signature=$_POST['signature']; else $signature="";
     
/*$secret_key = "04e6433045ff1be1045abd298410b85fd5ff63eb";//sandbox*/
$secret_key = "a91aa548d10e890d2f6db3353e7f0cc2ad4b1c03";	
$respSignature = hash_hmac('sha1', $data, $secret_key);

if($signature != "" && strcmp($signature, $respSignature) != 0) 
	$flag = "false";

if (isset($_POST['TxStatus'])) 
{	
	require 'connectsql.php';
    $fname=$_SESSION['firstname'];
    $lname=$_SESSION['lastname'];
    $email=$_SESSION['useremail'];
    $date=date("Y-m-d h:i:sa");
    $emailcitrus=$_POST['email'];
    $mobile=$_POST['mobileNo'];
    $accountno=$_SESSION['accountno'];
    $sql="INSERT INTO `feespaid` (`accountno`,`firstname`,`lastname`,`email`,`status`,`transactionid`,`amount`,`paymenttime`,`emailcitrus`,`mobilecitrus`,`type`)
    	  VALUES('$accountno','$fname','$lname','$email','$txnstatus','$txnid','$amount','$date','$emailcitrus','$mobile','$paymenttype');";
    mysqli_query($DBcon,$sql);
    $DBcon->close();
}
?>