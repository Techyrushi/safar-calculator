<?php
session_start();
require("config.php");

// Ensure user is authenticated
if (!isset($_SESSION['auser'])) {
    header("Location: index");
    exit();
}

$error = "";
$msg = "";
$error1 = "";
$msg1 = "";
$error2 = "";
$msg2 = "";
$error3 = "";
$msg3 = "";
$error4 = "";
$msg4 = "";

// Fetch Existing Home Section Data
$sqlHome = "SELECT * FROM homesection LIMIT 1";
$resultHome = mysqli_query($con, $sqlHome);
$homeData = mysqli_fetch_assoc($resultHome);

$title = $homeData['title1'] ?? '';
$content = $homeData['content1'] ?? '';
$existingImage = $homeData['image1'] ?? '';
$existingImage1 = $homeData['image2'] ?? '';
$existingBanner = $homeData['banner'] ?? '';

if (isset($_POST['updateHome'])) {
    $title = ($_POST['title1'] ?? '');
    $content = ($_POST['content1'] ?? '');

    if (!empty($_FILES['aimage']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['aimage']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $unique_name = uniqid() . '.' . $ext;
            $upload_path = "upload/" . $unique_name;
            move_uploaded_file($_FILES['aimage']['tmp_name'], $upload_path);
            $existingImage = $unique_name;
        } else {
            $error = "<p class='alert alert-warning msg-box'>* Invalid file type</p>";
        }
    }
    if (!empty($_FILES['cimage']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['cimage']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $unique_name = uniqid() . '.' . $ext;
            $upload_path = "upload/" . $unique_name;
            move_uploaded_file($_FILES['cimage']['tmp_name'], $upload_path);
            $existingImage1 = $unique_name;
        } else {
            $error = "<p class='alert alert-warning msg-box'>* Invalid file type</p>";
        }
    }

    // File Upload Logic
    if (!empty($_FILES['bimage']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['bimage']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $unique_name = uniqid() . '.' . $ext;
            $upload_path = "upload/" . $unique_name;
            move_uploaded_file($_FILES['bimage']['tmp_name'], $upload_path);
            $existingBanner = $unique_name;
        } else {
            $error = "<p class='alert alert-warning msg-box'>* Invalid file type</p>";
        }
    }

    // Update Query
    $stmt = $con->prepare("UPDATE homesection SET title1=?, content1=?, image1=?, image2=?, banner=? WHERE id=1");
    $stmt->bind_param("sssss", $title, $content, $existingImage, $existingImage1, $existingBanner);
    if ($stmt->execute()) {
        $msg = "<p class='alert alert-success msg-box'>Home About Us Updated Successfully</p>";
    } else {
        $error = "<p class='alert alert-warning msg-box'>* Error updating data: " . $con->error . "</p>";
    }
    $stmt->close();
}

// Fetch Existing Statistics
$sqlStats = "SELECT * FROM statistics LIMIT 1";
$resultStats = mysqli_query($con, $sqlStats);
$statsData = mysqli_fetch_assoc($resultStats);

$road_built = $statsData['road_built_count'] ?? '';
$ongoing_projects = $statsData['ongoing_projects_count'] ?? '';
$excellence_year = $statsData['excellence_year_count'] ?? '';
$machinery_units = $statsData['machinery_units_count'] ?? '';
$road_built_title = $statsData['road_built_title'] ?? '';
$ongoing_projects_title = $statsData['ongoing_projects_title'] ?? '';
$excellence_year_title = $statsData['excellence_year_title'] ?? '';
$machinery_units_title = $statsData['machinery_units_title'] ?? '';

if (isset($_POST['updateStatistics'])) {
    $road_built = ($_POST['road_built_count'] ?? '');
    $ongoing_projects = ($_POST['ongoing_projects_count'] ?? '');
    $excellence_year = ($_POST['excellence_year_count'] ?? '');
    $machinery_units = ($_POST['machinery_units_count'] ?? '');
    $road_built_title = ($_POST['road_built_title'] ?? '');
    $ongoing_projects_title = ($_POST['ongoing_projects_title'] ?? '');
    $excellence_year_title = ($_POST['excellence_year_title'] ?? '');
    $machinery_units_title = ($_POST['machinery_units_title'] ?? '');

    // Update Query
    $stmt = $con->prepare("UPDATE statistics SET road_built_count=?, ongoing_projects_count=?, excellence_year_count=?, machinery_units_count=? ,
    road_built_title=?, ongoing_projects_title=?, excellence_year_title=?, machinery_units_title=? WHERE id=1");
    $stmt->bind_param("iiiissss", $road_built, $ongoing_projects, $excellence_year, $machinery_units, $road_built_title, $ongoing_projects_title, $excellence_year_title, $machinery_units_title);
    if ($stmt->execute()) {
        $msg1 = "<p class='alert alert-success msg-box'>Statistics Data Updated Successfully</p>";
    } else {
        $error1 = "<p class='alert alert-warning msg-box'>* Error updating data: " . $con->error . "</p>";
    }
    $stmt->close();
}


// Handle Industry Submission
if (isset($_POST['addindustry'])) {
    $title = ($_POST['industries_title'] ?? '');
    $subtitle = ($_POST['industries_subtitle'] ?? '');
    $description = ($_POST['industries_description'] ?? '');

    // Image upload handling
    $image1 = $image2 = '';
    $image_fields = [
        'industries_image1' => &$image1,
        'industries_image2' => &$image2
    ];

    foreach ($image_fields as $field => &$image_var) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES[$field]['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                $unique_name = uniqid() . '.' . $ext;
                $upload_path = "upload/" . $unique_name;

                if (move_uploaded_file($_FILES[$field]['tmp_name'], $upload_path)) {
                    $image_var = $unique_name;
                }
            }
        }
    }

    // Prepared statement for industries
    $stmt = $con->prepare("INSERT INTO industries (title, image1, image2, subtitle, descriptions) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $image1, $image2, $subtitle, $description);

    if ($stmt->execute()) {
        $msg2 = "<p class='alert alert-success msg-box'>Industry Details Added Successfully</p>";
    } else {
        $error2 = "<p class='alert alert-warning msg-box'>* Error adding industry: " . $con->error . "</p>";
    }
    $stmt->close();
}

// Handle Mahalaxmi Construction Submission
if (isset($_POST['addmahalaxmi'])) {
    $title = ($_POST['mahalaxmi_title'] ?? '');
    $heading = ($_POST['mahalaxmi_heading'] ?? '');
    $paragraph = ($_POST['mahalaxmi_paragraph'] ?? '');
    $count = ($_POST['mahalaxmi_count'] ?? '');

    $image = '';

    // Single image upload
    if (!empty($_FILES['mahalaxmi_image']['name'])) {
        $filename = $_FILES['mahalaxmi_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            $unique_name = uniqid() . '.' . $ext;
            $upload_path = "upload/" . $unique_name;

            if (move_uploaded_file($_FILES['mahalaxmi_image']['tmp_name'], $upload_path)) {
                $image = $unique_name;
            }
        }
    }

    // Prepared statement for inserting single image
    $stmt = $con->prepare("INSERT INTO mahalaxmi_construction (title, images, heading, paragraph, count) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $title, $image, $heading, $paragraph, $count);

    if ($stmt->execute()) {
        $msg3 = "<p class='alert alert-success msg-box'>Mahalaxmi Construction Details Added Successfully</p>";
    } else {
        $error3 = "<p class='alert alert-warning msg-box'>* Error adding Mahalaxmi Construction: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Handle Featured Projects Submission
if (isset($_POST['addprojects'])) {
    $title = ($_POST['projects_title'] ?? '');
    $heading = ($_POST['projects_heading'] ?? '');
    $paragraph = ($_POST['projects_paragraph'] ?? '');
    $location = ($_POST['projects_location'] ?? '');
    $image = '';

    // Single image upload
    if (!empty($_FILES['projects_image']['name'])) {
        $filename = $_FILES['projects_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            $unique_name = uniqid() . '.' . $ext;
            $upload_path = "upload/" . $unique_name;

            if (move_uploaded_file($_FILES['projects_image']['tmp_name'], $upload_path)) {
                $image = $unique_name;
            }
        }
    }


    // Prepared statement for Mahalaxmi Construction
    $stmt = $con->prepare("INSERT INTO featured_projects (title, images, heading, paragraph, locations) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $image, $heading, $paragraph, $location);

    if ($stmt->execute()) {
        $msg4 = "<p class='alert alert-success msg-box'>Featured Projects Details Added Successfully</p>";
    } else {
        $error4 = "<p class='alert alert-warning msg-box'>* Error adding Featured Projects: " . $con->error . "</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Mahalaxmi Construction | Home</title>

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
                            <h3 class="page-title">Home</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Home</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title text-center">About Us Of Home</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <form method="post" enctype="multipart/form-data">
                                            <?php echo $error; ?>
                                            <?php echo $msg; ?>
                                            <?php echo $error1; ?>
                                            <?php echo $msg1; ?>
                                            <?php echo $error2; ?>
                                            <?php echo $msg2; ?>
                                            <?php echo $error3; ?>
                                            <?php echo $msg3; ?>
                                            <?php echo $error4; ?>
                                            <?php echo $msg4; ?>
                                            <!-- General Information -->

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Home Page Banner<span style="color: red;">*</span></label>
                                                <div class="col-lg-9">
                                                    <img src="upload/<?php echo $existingBanner; ?>" height="100" width="200"><br>
                                                    <input class="form-control" name="bimage" type="file">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Title<span style="color: red;">*</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" name="title1" value="<?php echo $title; ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">About Us Image 1<span style="color: red;">*</span></label>
                                                <div class="col-lg-9">
                                                    <img src="upload/<?php echo $existingImage; ?>" height="100" width="100"><br>
                                                    <input class="form-control" name="aimage" type="file">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">About Us Image 2<span style="color: red;">*</span></label>
                                                <div class="col-lg-9">
                                                    <img src="upload/<?php echo $existingImage1; ?>" height="100" width="100"><br>
                                                    <input class="form-control" name="cimage" type="file">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Content<span style="color: red;">*</span></label>
                                                <div class="col-lg-9">
                                                    <textarea class="tinymce form-control" name="content1" rows="10" cols="30"><?php echo $content; ?></textarea>
                                                </div>
                                            </div>

                                            <center>
                                                <button type="submit" class="btn btn-primary" style="width: 250px;" name="updateHome">Update</button>
                                            </center>
                                        </form>

                                        <hr>

                                        <!-- Statistics -->
                                        <div class="card-header">
                                            <h4 class="card-title text-center">Statistics</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <form method="post" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row mt-4">
                                                                <label class="col-lg-3 col-form-label">Road Built Count<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="number" class="form-control" name="road_built_count" value="<?php echo $road_built; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Ongoing Projects Count<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="number" class="form-control" name="ongoing_projects_count" value="<?php echo $ongoing_projects; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mt-4">
                                                                <label class="col-lg-3 col-form-label">Years of Excellence<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="number" class="form-control" name="excellence_year_count" value="<?php echo $excellence_year; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Machinery Units<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="number" class="form-control" name="machinery_units_count" value="<?php echo $machinery_units; ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group row mt-4">
                                                                <label class="col-lg-3 col-form-label">Road Built Title<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="road_built_title" value="<?php echo $road_built_title; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Ongoing Projects Title<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="ongoing_projects_title" value="<?php echo $ongoing_projects_title; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mt-4">
                                                                <label class="col-lg-3 col-form-label">Years of Excellence Title<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="excellence_year_title" value="<?php echo $excellence_year_title; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-3 col-form-label">Machinery Units Title<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="machinery_units_title" value="<?php echo $machinery_units_title; ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <center>
                                                        <button type="submit" class="btn btn-primary mt-3" style="width: 250px;" name="updateStatistics">Update</button>
                                                    </center>
                                                </form>

                                                <hr>
                                                <!-- Industries We Serve -->
                                                <div class="card-header">
                                                    <h4 class="card-title text-center">Industries We Serve</h4>
                                                </div>
                                                <form method="post" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row mt-4">
                                                                <label class="col-lg-2 col-form-label">Title<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="industries_title" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-2 col-form-label">Image 1<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input class="form-control" name="industries_image1" type="file" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row mt-4">
                                                                <label class="col-lg-2 col-form-label">Subtitle<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="industries_subtitle" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-2 col-form-label">Image 2<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input class="form-control" name="industries_image2" type="file" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Description<span style="color: red;">*</span></label>
                                                        <div class="col-lg-9">
                                                            <textarea class="tinymce form-control" name="industries_description" rows="10" cols="30"></textarea>
                                                        </div>
                                                    </div>
                                                    <center>
                                                        <button type="submit" class="btn btn-primary" style="width: 250px;" name="addindustry">Submit</button>
                                                    </center>
                                                </form>
                                                <hr>
                                                <!-- Mahalaxmi Construction -->
                                                <div class="card-header">
                                                    <h4 class="card-title text-center">Mahalaxmi Construction</h4>
                                                </div>
                                                <form method="post" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row mt-4">
                                                                <label class="col-lg-2 col-form-label">Title<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="mahalaxmi_title" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-2 col-form-label">Images<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input class="form-control" name="mahalaxmi_image" type="file" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group row mt-4">
                                                                <label class="col-lg-2 col-form-label">Heading<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="mahalaxmi_heading" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-2 col-form-label">Count<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="number" class="form-control" name="mahalaxmi_count" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Content<span style="color: red;">*</span></label>
                                                        <div class="col-lg-9">
                                                            <textarea class="tinymce form-control" name="mahalaxmi_paragraph" rows="10" cols="30"></textarea>
                                                        </div>
                                                    </div>
                                                    <center>
                                                        <button type="submit" class="btn btn-primary" style="width: 250px;" name="addmahalaxmi">Submit</button>
                                                    </center>
                                                </form>
                                                <hr>
                                                <!-- Mahalaxmi Construction -->
                                                <div class="card-header">
                                                    <h4 class="card-title text-center">Featured Projects</h4>
                                                </div>
                                                <form method="post" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row mt-4">
                                                                <label class="col-lg-2 col-form-label">Title<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="projects_title" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-2 col-form-label">Images<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input class="form-control" name="projects_image" type="file" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group row mt-4">
                                                                <label class="col-lg-2 col-form-label">Location<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="projects_location" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-2 col-form-label">Heading<span style="color: red;">*</span></label>
                                                                <div class="col-lg-9">
                                                                    <input type="text" class="form-control" name="projects_heading" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Content<span style="color: red;">*</span></label>
                                                        <div class="col-lg-9">
                                                            <textarea class="tinymce form-control" name="projects_paragraph" rows="10" cols="30"></textarea>
                                                        </div>
                                                    </div>
                                                    <center>
                                                        <button type="submit" class="btn btn-primary" style="width: 250px;" name="addprojects">Submit</button>
                                                    </center>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Page Wrapper -->

    </div>
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

</html>