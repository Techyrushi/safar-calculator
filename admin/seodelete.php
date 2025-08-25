<?php
include("config.php");
$aid = $_GET['id'];
$sql = "DELETE FROM seo_settings WHERE id = {$aid}";
$result = mysqli_query($con, $sql);
if ($result == true) {
    $msg = "<p class='alert alert-success msg-box'>SEO settings deleted successfully!</p>";
    header("Location:seo?msg=$msg");
} else {
    $msg = "<p class='alert alert-warning msg-box'>SEO settings Data Not Deleted</p>";
    header("Location:seo?msg=$msg");
}
mysqli_close($con);
