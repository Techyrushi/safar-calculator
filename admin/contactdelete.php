<?php
include("config.php");
$cid = $_GET['id'];
$sql = "DELETE FROM contact WHERE cid = {$cid}";
$result = mysqli_query($con, $sql);
if($result == true)
{
	$msg="<p class='alert alert-success msg-box'>Contact Details Deleted</p>";
	header("Location:contactview?msg=$msg");
}
else{
	$msg="<p class='alert alert-warning msg-box'>Contact Details Not Deleted</p>";
	header("Location:contactview?msg=$msg");
}
mysqli_close($con);
?>
