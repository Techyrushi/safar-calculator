<?php
include("config.php");
$aid = $_GET['id'];

$sql = "SELECT * FROM tblcareers where id='$aid'";
$result = mysqli_query($con, $sql);

$msg = "";
$sql = "DELETE FROM tblcareers WHERE id = {$aid}";
$result = mysqli_query($con, $sql);
if ($result == true) {
	$msg = "<p class='alert alert-success msg-box'>Career Position Data Deleted</p>";
	header("Location:careerview?msg=$msg");
} else {
	$msg = "<p class='alert alert-warning msg-box'>Career Position Data not Deleted</p>";
	header("Location:careerview?msg=$msg");
}

mysqli_close($con);
?>
