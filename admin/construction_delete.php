<?php
include("config.php");
$aid = $_GET['id'];

// view code//
$sql = "SELECT * FROM mahalaxmi_construction where id='$aid'";
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
	$img = $row["images"];
}
@unlink('upload/' . $img);

//end view code


$msg = "";
$sql = "DELETE FROM mahalaxmi_construction WHERE id = {$aid}";
$result = mysqli_query($con, $sql);
if ($result == true) {
	$msg = "<p class='alert alert-success msg-box'>Mahalaxmi Construction Data Deleted</p>";
	header("Location:construction_view?msg=$msg");
} else {
	$msg = "<p class='alert alert-warning msg-box'>Mahalaxmi Construction Data not Deleted</p>";
	header("Location:construction_view?msg=$msg");
}

mysqli_close($con);
?>
