<?php
include("config.php");
$aid = $_GET['id'];

// view code//
$sql = "SELECT * FROM industries where id='$aid'";
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
	$img1 = $row["image1"];
	$img1 = $row["image1"];
}
@unlink('upload/' . $img1);
@unlink('upload/' . $img2);

//end view code


$msg = "";
$sql = "DELETE FROM industries WHERE id = {$aid}";
$result = mysqli_query($con, $sql);
if ($result == true) {
	$msg = "<p class='alert alert-success msg-box'>Industries Serve Data Deleted</p>";
	header("Location:industry_view?msg=$msg");
} else {
	$msg = "<p class='alert alert-warning msg-box'>Industries Serve Data not Deleted</p>";
	header("Location:industry_view?msg=$msg");
}

mysqli_close($con);
?>
