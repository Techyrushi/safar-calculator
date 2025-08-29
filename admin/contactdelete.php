<?php
include("config.php");
$cid = $_GET['id'];
$sql = "DELETE FROM contacts WHERE cid = {$cid}";
$result = mysqli_query($con, $sql);
if($result == true)
{
	$msg="<p class='alert alert-success msg-box'>Enquiry Details Deleted</p>";
	header("Location:contactview?msg=$msg");
}
else{
	$msg="<p class='alert alert-warning msg-box'>Enquiry Details Not Deleted</p>";
	header("Location:contactview?msg=$msg");
}
mysqli_close($con);
?>
