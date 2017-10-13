<?php
include('sampleCode_SHA1.php');
$MerchantKey = "HllSlGLEeK";
$MerchantCode = "M01224";

if(isset($_GET['PaymentId']))
{
	$PaymentId = $_GET['PaymentId'];
}

if(isset($_GET['RefNo']))
{
	$RefNo = $_GET['RefNo'];
}

if(isset($_GET['ProdDesc']))
{
	$ProdDesc = $_GET['ProdDesc'];
}

if(isset($_GET['Amount']))
{
	$Amount = $_GET['Amount'];
	$Amount1 = str_replace(".", "", $Amount);
}

if(isset($_GET['UserName']))
{
	$UserName = $_GET['UserName'];
}

if(isset($_GET['UserEmail']))
{
	$UserEmail = $_GET['UserEmail'];
}

if(isset($_GET['UserContact']))
{
	$UserContact = $_GET['UserContact'];
}

$Currency = "MYR";
$sc = $MerchantKey.$MerchantCode.$RefNo.$Amount1.$Currency;

?>
<FORM method="post" id="ePayment" name="ePayment" action="https://www.mobile88.com/ePayment/entry.asp">
	<INPUT type="hidden" name="MerchantCode" value="<?php echo $MerchantCode; ?>">
	<INPUT type="hidden" name="PaymentId" value="<?php echo $PaymentId; ?>">
	<INPUT type="hidden" name="RefNo" value="<?php echo $RefNo; ?>">
	<INPUT type="hidden" name="Amount" value="<?php echo $Amount; ?>">
	<INPUT type="hidden" name="Currency" value="MYR">
	<INPUT type="hidden" name="ProdDesc" value="<?php echo $ProdDesc; ?>">
	<INPUT type="hidden" name="UserName" value="<?php echo $UserName; ?>">
	<INPUT type="hidden" name="UserEmail" value="<?php echo $UserEmail; ?>">
	<INPUT type="hidden" name="UserContact" value="<?php echo $UserContact; ?>">
	<INPUT type="hidden" name="Remark" value="Testing payment gateway">
	<INPUT type="hidden" name="Lang" value="UTF-8">
	<INPUT type="hidden" name="Signature" value="<?php echo iPay88_signature($sc); ?>">
	<INPUT type="hidden" name="ResponseURL" value="http://www.pbmart.com.my/payment_respond.php">
	<INPUT type="hidden" name="BackendURL" value="http://www.YourBackendURL.com/payment/backend_response.asp">
	<script language="JavaScript">document.ePayment.submit();</script>
	<!--<INPUT type="submit" value="Proceed with Payment" name="Submit">-->
</FORM>	