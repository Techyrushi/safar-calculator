<?php
include("config.php");
$aid = $_GET['id'];
$sql = "DELETE FROM admin WHERE aid = {$aid}";
$result = mysqli_query($con, $sql);
if ($result == true) {
	$msg = "<p class='alert alert-success msg-box'>Admin Data Deleted</p>";
	header("Location:adminlist?msg=$msg");
} else {
	$msg = "<p class='alert alert-warning msg-box'>Admin Data Not Deleted</p>";
	header("Location:adminlist?msg=$msg");
}
mysqli_close($con);
?>
