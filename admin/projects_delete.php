<?php
include("config.php");
$aid = $_GET['id'];

// view code//
$sql = "SELECT * FROM featured_projects where id='$aid'";
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
	$img = $row["images"];
}
@unlink('upload/' . $img);

//end view code


$msg = "";
$sql = "DELETE FROM featured_projects WHERE id = {$aid}";
$result = mysqli_query($con, $sql);
if ($result == true) {
	$msg = "<p class='alert alert-success msg-box'>Featured Projects Deleted</p>";
	header("Location:projects_view?msg=$msg");
} else {
	$msg = "<p class='alert alert-warning msg-box'>Featured Projects not Deleted</p>";
	header("Location:projects_view?msg=$msg");
}

mysqli_close($con);
?>
