<?php
session_start();
include("config.php");
if (!isset($_SESSION['auser'])) {
    header("location:index");
}
if (isset($_POST['update'])) {
    $aid = $_GET['id'];
    $title = $_POST['utitle'];
    $subtitle = $_POST['usubtitle'];
    $content = $_POST['ucontent'];

    // Fetch existing images if no new upload
    $query = "SELECT image1, image2 FROM industries WHERE id = {$aid}";
    $res = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($res);

    $aimage = $row['image1']; // Default to existing image
    $bimage = $row['image2']; // Default to existing image

    // Check if new images are uploaded
    if (!empty($_FILES['aimage']['name'])) {
        $aimage = uniqid() . '_' . $_FILES['aimage']['name'];
        move_uploaded_file($_FILES['aimage']['tmp_name'], "upload/$aimage");
    }

    if (!empty($_FILES['bimage']['name'])) {
        $bimage = uniqid() . '_' . $_FILES['bimage']['name'];
        move_uploaded_file($_FILES['bimage']['tmp_name'], "upload/$bimage");
    }

    // Update Query
    $sql = "UPDATE industries
            SET title = '{$title}', subtitle = '{$subtitle}', descriptions = '{$content}',
                image1 ='{$aimage}', image2 ='{$bimage}'
            WHERE id = {$aid}";

    $result = mysqli_query($con, $sql);

    if ($result) {
        $msg = "<p class='alert alert-success msg-box'>Industries Serve Data Updated</p>";
    } else {
        $msg = "<p class='alert alert-warning msg-box'>Industries Serve Data Not Updated</p>";
    }

    header("Location: industry_view?msg=" . urlencode($msg));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Mahalaxmi Construction - Industries Serve</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/css/select2.min.css">

    <link rel="stylesheet" href="assets\plugins\summernote\dist\summernote-bs4.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
</head>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        <?php include("header.php"); ?>
        <!-- /Sidebar -->

        <!-- Page Wrapper -->
        <div class="page-wrapper">

            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="page-title">Industries Serve</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Industries Serve</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Industries Serve</h2>
                            </div>
                            <?php
                            $aid = $_GET['id'];
                            $sql = "SELECT * FROM industries where id = {$aid}";
                            $result = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_row($result)) {
                            ?>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <h5 class="card-title">Industries Serve</h5>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Title<span style="color: red;">*</span></label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" name="utitle" value="<?php echo $row['1']; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Image 1<span style="color: red;">*</span></label>
                                                    <div class="col-lg-9">
                                                        <img src="upload/<?php echo $row['2']; ?>" height="200px" width="200px"><br><br>
                                                        <input class="form-control" name="aimage" type="file">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Image 2<span style="color: red;">*</span></label>
                                                    <div class="col-lg-9">
                                                        <img src="upload/<?php echo $row['3']; ?>" height="200px" width="200px"><br><br>
                                                        <input class="form-control" name="bimage" type="file">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Subtitle<span style="color: red;">*</span></label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" name="usubtitle" value="<?php echo $row['4']; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Content<span style="color: red;">*</span></label>
                                                    <div class="col-lg-9">
                                                        <textarea class="tinymce form-control" name="ucontent" rows="10" cols="30"><?php echo $row['5']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <input type="submit" class="btn btn-primary" style="width: 250px;" value="Update" name="update" style="margin-left:200px;">
                                        </div>
                                </form>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <!-- /Page Wrapper -->
    <!-- /Main Wrapper -->
    <script src="assets/plugins/tinymce/tinymce.min.js"></script>
    <script src="assets/plugins/tinymce/init-tinymce.min.js"></script>
    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Select2 JS -->
    <script src="assets/js/select2.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script>
        setTimeout(function() {
            document.querySelectorAll(".msg-box").forEach(function(msgBox) {
                msgBox.style.transition = "opacity 0.5s";
                msgBox.style.opacity = "0";
                setTimeout(() => msgBox.style.display = "none", 500);
            });
        }, 5000);
    </script>
</body>

<!-- Mirrored from dreamguys.co.in/demo/ventura/form-vertical.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 25 Aug 2019 04:41:05 GMT -->

</html>