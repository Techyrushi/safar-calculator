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

// Check if we have a success message in session to display
if (isset($_SESSION['success_message'])) {
    $msg = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// Fetch Existing Statistics
$sqlStats = "SELECT * FROM statistics LIMIT 1";
$resultStats = mysqli_query($con, $sqlStats);
$statsData = mysqli_fetch_assoc($resultStats);

$title = $statsData['title'] ?? '';
$description = $statsData['description'] ?? '';
$action_title = $statsData['action_title'] ?? '';
$action_description = $statsData['action_description'] ?? '';
$video = $statsData['video_url'] ?? '';
$road_built = $statsData['rides_count'] ?? '';
$ongoing_projects = $statsData['city_covered_count'] ?? '';
$excellence_year = $statsData['support_count'] ?? '';
$machinery_units = $statsData['services_count'] ?? '';
$road_built_title = $statsData['rides_title'] ?? '';
$ongoing_projects_title = $statsData['city_covered_title'] ?? '';
$excellence_year_title = $statsData['support_title'] ?? '';
$machinery_units_title = $statsData['services_title'] ?? '';

if (isset($_POST['updateStatistics'])) {
    $title = ($_POST['title'] ?? '');
    $description = ($_POST['description'] ?? '');
    $action_title = ($_POST['action_title'] ?? '');
    $action_description = ($_POST['action_description'] ?? '');
    $video = ($_POST['video_url'] ?? '');
    $road_built = ($_POST['rides_count'] ?? '');
    $ongoing_projects = ($_POST['city_covered_count'] ?? '');
    $excellence_year = ($_POST['support_count'] ?? '');
    $machinery_units = ($_POST['services_count'] ?? '');
    $road_built_title = ($_POST['rides_title'] ?? '');
    $ongoing_projects_title = ($_POST['city_covered_title'] ?? '');
    $excellence_year_title = ($_POST['support_title'] ?? '');
    $machinery_units_title = ($_POST['services_title'] ?? '');

    $newImage = null;

    // Handle image upload if a new file is provided
    if (!empty($_FILES['stat_image']['name'])) {
        $filename = $_FILES['stat_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            $unique_name = uniqid() . '.' . $ext;
            $upload_path = "upload/" . $unique_name;

            if (move_uploaded_file($_FILES['stat_image']['tmp_name'], $upload_path)) {
                $newImage = $unique_name;

                // Delete old image if exists
                $oldImageQuery = mysqli_query($con, "SELECT image_path FROM statistics WHERE id = 1");
                if ($oldImageRow = mysqli_fetch_assoc($oldImageQuery)) {
                    if (!empty($oldImageRow['image_path']) && file_exists("upload/" . $oldImageRow['image_path'])) {
                        unlink("upload/" . $oldImageRow['image_path']);
                    }
                }
            }
        }
    }

    // Update Query
    if ($newImage) {
        // With image
        $stmt = $con->prepare("UPDATE statistics 
            SET title=?, description=?, action_title=?, action_description=?, video_url=?, rides_count=?, city_covered_count=?, 
                support_count=?, services_count=?, rides_title=?, city_covered_title=?, 
                support_title=?, services_title=?, image_path=? 
            WHERE id=1");
        $stmt->bind_param(
            "ssssssssssssss",
            $title,
            $description,
            $action_title,
            $action_description,
            $video,
            $road_built,
            $ongoing_projects,
            $excellence_year,
            $machinery_units,
            $road_built_title,
            $ongoing_projects_title,
            $excellence_year_title,
            $machinery_units_title,
            $newImage
        );
    } else {
        // Without image
        $stmt = $con->prepare("UPDATE statistics 
            SET title=?, description=?, action_title=?, action_description=?,video_url=?, rides_count=?, city_covered_count=?, 
                support_count=?, services_count=?, rides_title=?, city_covered_title=?, 
                support_title=?, services_title=?
            WHERE id=1");
        $stmt->bind_param(
            "sssssssssssss",
            $title,
            $description,
            $action_title,
            $action_description,
            $video,
            $road_built,
            $ongoing_projects,
            $excellence_year,
            $machinery_units,
            $road_built_title,
            $ongoing_projects_title,
            $excellence_year_title,
            $machinery_units_title
        );
    }

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Statistics Data Updated Successfully";
        $_SESSION['active_tab'] = 'statistics';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error1 = "<p class='alert alert-warning msg-box'>* Error updating data: " . $con->error . "</p>";
    }

    $stmt->close();
}


// Handle Service Submission
if (isset($_POST['addService'])) {
    $service_title = ($_POST['service_title'] ?? '');
    $service_description = ($_POST['service_desc'] ?? '');
    $title = ($_POST['title'] ?? '');
    $description = ($_POST['description'] ?? '');
    $icon_class = ($_POST['icon'] ?? '');

    $image = '';

    // Single image upload
    if (!empty($_FILES['service_image']['name'])) {
        $filename = $_FILES['service_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            $unique_name = uniqid() . '.' . $ext;
            $upload_path = "upload/" . $unique_name;

            if (move_uploaded_file($_FILES['service_image']['tmp_name'], $upload_path)) {
                $image = $unique_name;
            }
        }
    }

    // Prepared statement for services
    $stmt = $con->prepare("INSERT INTO services (service_title, service_desc, title, description, icon, image_path) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $service_title, $service_description, $title, $description, $icon_class, $image);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Service Added Successfully";
        $_SESSION['active_tab'] = 'services';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error2 = "<p class='alert alert-warning msg-box'>* Error adding service: " . $con->error . "</p>";
    }
    $stmt->close();
}

// Fetch all services
$services = [];
$sqlServices = "SELECT * FROM services ORDER BY id DESC";
$resultServices = mysqli_query($con, $sqlServices);
if ($resultServices) {
    while ($row = mysqli_fetch_assoc($resultServices)) {
        $services[] = $row;
    }
}

// Handle Testimonial Submission
if (isset($_POST['addTestimonial'])) {
    $testi_title = ($_POST['testi_title'] ?? '');
    $testi_desc = ($_POST['testi_desc'] ?? '');
    $client_name = ($_POST['name'] ?? '');
    $testi_content = ($_POST['testi_content'] ?? '');
    $profile = ($_POST['profile'] ?? '');
    $rating = ($_POST['rating'] ?? 5);

    // Prepared statement for testimonials
    $stmt = $con->prepare("INSERT INTO testimonials (testi_title, testi_desc, name, testi_content, rating, profiles) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $testi_title, $testi_desc, $client_name, $testi_content, $rating, $profile);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Testimonials Added Successfully";
        $_SESSION['active_tab'] = 'testimonials';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error3 = "<p class='alert alert-warning msg-box'>* Error adding testimonial: " . $con->error . "</p>";
    }
    $stmt->close();
}

// Fetch all testimonials
$testimonials = [];
$sqlTestimonials = "SELECT * FROM testimonials ORDER BY id DESC";
$resultTestimonials = mysqli_query($con, $sqlTestimonials);
if ($resultTestimonials) {
    while ($row = mysqli_fetch_assoc($resultTestimonials)) {
        $testimonials[] = $row;
    }
}

// Handle Banner Submission
if (isset($_POST['addBanner'])) {
    $banner_title = ($_POST['banner_title'] ?? '');
    $banner_subtitle = ($_POST['banner_subtitle'] ?? '');

    $banner_image = '';

    // Image upload handling
    if (!empty($_FILES['banner_image']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['banner_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $unique_name = uniqid() . '.' . $ext;
            $upload_path = "upload/" . $unique_name;
            move_uploaded_file($_FILES['banner_image']['tmp_name'], $upload_path);
            $banner_image = $unique_name;
        } else {
            $error4 = "<p class='alert alert-warning msg-box'>* Invalid file type for banner image</p>";
        }
    }

    // Prepared statement for banners
    $stmt = $con->prepare("INSERT INTO banners (banner_title, banner_subtitle, image_path, is_active) VALUES (?, ?, ?, 1)");
    $stmt->bind_param("sss", $banner_title, $banner_subtitle, $banner_image);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Banner Added Successfully";
        $_SESSION['active_tab'] = 'banners';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error4 = "<p class='alert alert-warning msg-box'>* Error adding banner: " . $con->error . "</p>";
    }
    $stmt->close();
}

// Fetch all banners
$banners = [];
$sqlBanners = "SELECT * FROM banners ORDER BY id DESC";
$resultBanners = mysqli_query($con, $sqlBanners);
if ($resultBanners) {
    while ($row = mysqli_fetch_assoc($resultBanners)) {
        $banners[] = $row;
    }
}

// Handle Banner Activation
if (isset($_GET['activate_banner'])) {
    $banner_id = intval($_GET['activate_banner']);

    // First deactivate all banners
    $deactivateAll = $con->prepare("UPDATE banners SET is_active = 0");
    $deactivateAll->execute();
    $deactivateAll->close();

    // Activate the selected banner
    $activateStmt = $con->prepare("UPDATE banners SET is_active = 0 WHERE id = ?");
    $activateStmt->bind_param("i", $banner_id);

    if ($activateStmt->execute()) {
        $_SESSION['success_message'] = "Banner Deactivate Successfully";
        $_SESSION['active_tab'] = 'banners';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error5 = "<p class='alert alert-warning msg-box'>* Error deactivating banner: " . $con->error . "</p>";
    }
    $activateStmt->close();
}

// Handle Banner Activation
if (isset($_GET['deactivate_banner'])) {
    $banner_id = intval($_GET['deactivate_banner']);

    // First deactivate all banners
    $deactivateAll = $con->prepare("UPDATE banners SET is_active = 1");
    $deactivateAll->execute();
    $deactivateAll->close();

    // Activate the selected banner
    $activateStmt = $con->prepare("UPDATE banners SET is_active = 1 WHERE id = ?");
    $activateStmt->bind_param("i", $banner_id);

    if ($activateStmt->execute()) {
        $_SESSION['success_message'] = "Banner Activate Successfully";
        $_SESSION['active_tab'] = 'banners';
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        $error5 = "<p class='alert alert-warning msg-box'>* Error activating banner: " . $con->error . "</p>";
    }
    $activateStmt->close();
}

// Handle Banner Deletion
if (isset($_GET['delete_banner'])) {
    $banner_id = intval($_GET['delete_banner']);

    $deleteStmt = $con->prepare("DELETE FROM banners WHERE id = ?");
    $deleteStmt->bind_param("i", $banner_id);

    if ($deleteStmt->execute()) {
        $_SESSION['success_message'] = "Banner Deleted Successfully";
        $_SESSION['active_tab'] = 'banners';
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        $error6 = "<p class='alert alert-warning msg-box'>* Error deleting banner: " . $con->error . "</p>";
    }
    $deleteStmt->close();
}
if (isset($_GET['delete_service'])) {
    $service_id = intval($_GET['delete_service']);

    $deleteStmt = $con->prepare("DELETE FROM services WHERE id = ?");
    $deleteStmt->bind_param("i", $service_id);

    if ($deleteStmt->execute()) {
        $_SESSION['success_message'] = "Service Deleted Successfully";
        $_SESSION['active_tab'] = 'services';
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        $error6 = "<p class='alert alert-warning msg-box'>* Error deleting service: " . $con->error . "</p>";
    }
    $deleteStmt->close();
}
if (isset($_GET['delete_testimonial'])) {
    $testimonial_id = intval($_GET['delete_testimonial']);

    $deleteStmt = $con->prepare("DELETE FROM testimonials WHERE id = ?");
    $deleteStmt->bind_param("i", $testimonial_id);

    if ($deleteStmt->execute()) {
        $_SESSION['success_message'] = "Testimonials Deleted Successfully";
        $_SESSION['active_tab'] = 'testimonials';
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        $error6 = "<p class='alert alert-warning msg-box'>* Error deleting testimonial: " . $con->error . "</p>";
    }
    $deleteStmt->close();
}

// Handle Service Edit
if (isset($_POST['editService'])) {
    $service_id = intval($_POST['service_id']);
    $service_title = ($_POST['service_title'] ?? '');
    $service_description = ($_POST['service_desc'] ?? '');
    $title = ($_POST['title'] ?? '');
    $description = ($_POST['description'] ?? '');
    $icon_class = ($_POST['icon'] ?? '');

    // Handle image upload if a new file is provided
    $image_update = '';
    if (!empty($_FILES['service_image']['name'])) {
        $filename = $_FILES['service_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            $unique_name = uniqid() . '.' . $ext;
            $upload_path = "upload/" . $unique_name;

            if (move_uploaded_file($_FILES['service_image']['tmp_name'], $upload_path)) {
                $image_update = ", image_path = '$unique_name'";

                // Delete old image if exists
                $oldImageQuery = mysqli_query($con, "SELECT image_path FROM services WHERE id = $service_id");
                if ($oldImageRow = mysqli_fetch_assoc($oldImageQuery)) {
                    if (!empty($oldImageRow['image_path']) && file_exists("upload/" . $oldImageRow['image_path'])) {
                        unlink("upload/" . $oldImageRow['image_path']);
                    }
                }
            }
        }
    }

    // Update Query
    $sql = "UPDATE services SET service_title = '$service_title', service_desc = '$service_description', 
            title = '$title', description = '$description', icon = '$icon_class' $image_update WHERE id = $service_id";

    if (mysqli_query($con, $sql)) {
        $_SESSION['success_message'] = "Service Updated Successfully";
        $_SESSION['active_tab'] = 'services';
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        $error2 = "<p class='alert alert-warning msg-box'>* Error updating service: " . mysqli_error($con) . "</p>";
    }
}

// Handle Testimonial Edit
if (isset($_POST['editTestimonial'])) {
    $testimonial_id = intval($_POST['testimonial_id']);
    $testi_title = ($_POST['testi_title'] ?? '');
    $testi_desc = ($_POST['testi_desc'] ?? '');
    $client_name = ($_POST['name'] ?? '');
    $testi_content = ($_POST['testi_content'] ?? '');
    $profile = ($_POST['profile'] ?? '');
    $rating = intval($_POST['rating'] ?? 5);

    // Update Query
    $stmt = $con->prepare("UPDATE testimonials SET testi_title = ?, testi_desc = ?, name = ?, testi_content = ?, rating = ? , profiles = ? WHERE id = ?");
    $stmt->bind_param("ssssisi", $testi_title, $testi_desc, $client_name, $testi_content, $rating, $profile, $testimonial_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Testimonials Updated Successfully";
        $_SESSION['active_tab'] = 'testimonials';
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        $error3 = "<p class='alert alert-warning msg-box'>* Error updating testimonial: " . $con->error . "</p>";
    }
    $stmt->close();
}

// Store active tab from form submissions
if (isset($_POST['active_tab'])) {
    $_SESSION['active_tab'] = $_POST['active_tab'];
} elseif (isset($_GET['active_tab'])) {
    $_SESSION['active_tab'] = $_GET['active_tab'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Safar | Home Page Management</title>

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

    <style>
        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 5px 5px 0 0;
        }

        .nav-tabs .nav-link.active {
            background-color: #f8f9fa;
            border-bottom-color: #f8f9fa;
            color: #007bff;
        }

        .tab-content {
            background: #fff;
            padding: 25px;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }

        .section-header {
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 15px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .preview-image {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
            margin-top: 10px;
        }

        .image-preview-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .stats-counter {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .card-tab {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 30px;
        }

        .card-tab .card-header {
            background: #fff;
            border-bottom: 1px solid #eee;
        }

        .btn-section {
            padding: 10px 25px;
            font-weight: 500;
        }

        .alert-auto-dismiss {
            animation: fadeOut 1s ease-in 5s forwards;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
                display: none;
            }
        }

        .service-icon-preview {
            font-size: 24px;
            margin-top: 10px;
            color: #007bff;
        }

        .current-image-preview {
            max-width: 100px;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 3px;
            border-radius: 4px;
        }

        .alert-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .alert-content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
        }

        .alert-icon {
            margin-bottom: 15px;
        }

        .alert-buttons {
            margin-top: 20px;
        }

        .alert-ok-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .alert-ok-btn:hover {
            background-color: #0069d9;
        }

        .logo-preview {
            max-width: 300px;
            height: auto;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
        }
    </style>
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
                            <h3 class="page-title">Home Page Management</h3>
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
                        <div class="card card-tab">
                            <div class="card-header">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo (isset($_SESSION['active_tab']) && $_SESSION['active_tab'] == 'banners') || !isset($_SESSION['active_tab']) ? 'active' : ''; ?>" data-toggle="tab" href="#banners">Banners</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo (isset($_SESSION['active_tab']) && $_SESSION['active_tab'] == 'services') ? 'active' : ''; ?>" data-toggle="tab" href="#services">Services</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo (isset($_SESSION['active_tab']) && $_SESSION['active_tab'] == 'statistics') ? 'active' : ''; ?>" data-toggle="tab" href="#statistics">Statistics</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo (isset($_SESSION['active_tab']) && $_SESSION['active_tab'] == 'testimonials') ? 'active' : ''; ?>" data-toggle="tab" href="#testimonials">Testimonials</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">

                                    <!-- Banners Tab -->
                                    <div id="banners" class="tab-pane <?php echo (isset($_SESSION['active_tab']) && $_SESSION['active_tab'] == 'banners') || !isset($_SESSION['active_tab']) ? 'active' : ''; ?>">
                                        <div class="section-header">
                                            <h4>Manage Home Page Banners</h4>
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#addBannerModal">
                                                <i class="fa fa-plus"></i> Add New Banner
                                            </button>
                                        </div>

                                        <?php echo $error4; ?>
                                        <?php echo $msg4; ?>
                                        <?php echo $error5 ?? ''; ?>
                                        <?php echo $msg5 ?? ''; ?>
                                        <?php echo $error6 ?? ''; ?>
                                        <?php echo $msg6 ?? ''; ?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>All Banners</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover">
                                                                <thead class="text-center">
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Preview</th>
                                                                        <th>Title</th>
                                                                        <th>Subtitle</th>
                                                                        <th>Status</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="text-center">
                                                                    <?php if (!empty($banners)): ?>
                                                                        <?php foreach ($banners as $index => $banner): ?>
                                                                            <tr>
                                                                                <td><?php echo $index + 1; ?></td>
                                                                                <td><img src="upload/<?php echo $banner['image_path']; ?>" height="40"></td>
                                                                                <td><?php echo strlen($banner['banner_title']) > 20 ? substr($banner['banner_title'], 0, 20) . '...' : $banner['banner_title']; ?></td>
                                                                                <td><?php echo strlen($banner['banner_subtitle']) > 30 ? substr($banner['banner_subtitle'], 0, 30) . '...' : $banner['banner_subtitle']; ?></td>
                                                                                <td>
                                                                                    <?php if ($banner['is_active'] == 1): ?>
                                                                                        <span class="badge badge-success">Active</span>
                                                                                    <?php else: ?>
                                                                                        <span class="badge badge-secondary">Inactive</span>
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php if ($banner['is_active'] == 1): ?>
                                                                                        <a href="?activate_banner=<?php echo $banner['id']; ?>" class="btn btn-sm btn-danger" title="Deactivate Banner">
                                                                                            <i class="fa fa-times"></i>
                                                                                        </a>
                                                                                    <?php endif; ?>
                                                                                    <?php if ($banner['is_active'] == 0): ?>
                                                                                        <a href="?deactivate_banner=<?php echo $banner['id']; ?>" class="btn btn-sm btn-success" title="Activate Banner">
                                                                                            <i class="fa fa-check"></i>
                                                                                        </a>
                                                                                    <?php endif; ?>
                                                                                    <a href="?delete_banner=<?php echo $banner['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this banner?')" title="Delete Banner">
                                                                                        <i class="fa fa-trash"></i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <tr>
                                                                            <td colspan="6" class="text-center">Record Not Found</td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Services Tab -->
                                    <div id="services" class="tab-pane fade <?php echo (isset($_SESSION['active_tab']) && $_SESSION['active_tab'] == 'services') ? 'active show' : ''; ?>">
                                        <div class="section-header">
                                            <h4>Manage Services</h4>
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#addServiceModal">
                                                <i class="fa fa-plus"></i> Add New Service
                                            </button>
                                        </div>

                                        <?php echo $error2; ?>
                                        <?php echo $msg2; ?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover">
                                                                <thead class="text-center">
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Icon</th>
                                                                        <th>Service Title</th>
                                                                        <th>Service Description</th>
                                                                        <th>Image</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="text-center">
                                                                    <?php if (!empty($services)): ?>
                                                                        <?php foreach ($services as $index => $service): ?>
                                                                            <tr>
                                                                                <td><?php echo $index + 1; ?></td>
                                                                                <td><i class="fa <?php echo $service['icon']; ?> fa-2x"></i></td>
                                                                                <td><?php echo $service['title']; ?></td>
                                                                                <td><?php echo strlen($service['description']) > 50 ? substr($service['description'], 0, 50) . '...' : $service['description']; ?></td>
                                                                                <td>
                                                                                    <?php if (!empty($service['image_path'])): ?>
                                                                                        <img src="upload/<?php echo $service['image_path']; ?>" height="40">
                                                                                    <?php else: ?>
                                                                                        No Image
                                                                                    <?php endif; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editServiceModal"
                                                                                        data-id="<?php echo $service['id']; ?>"
                                                                                        data-service_title="<?php echo htmlspecialchars($service['service_title']); ?>"
                                                                                        data-service_desc="<?php echo htmlspecialchars($service['service_desc']); ?>"
                                                                                        data-title="<?php echo htmlspecialchars($service['title']); ?>"
                                                                                        data-description="<?php echo htmlspecialchars($service['description']); ?>"
                                                                                        data-icon="<?php echo $service['icon']; ?>"
                                                                                        data-image_path="<?php echo $service['image_path']; ?>">
                                                                                        <i class="fa fa-edit"></i>
                                                                                    </button>
                                                                                    <a href="?delete_service=<?php echo $service['id']; ?>&active_tab=services" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this service?')" title="Delete Service">
                                                                                        <i class="fa fa-trash"></i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <tr>
                                                                            <td colspan="6" class="text-center">Record Not Found</td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Statistics Tab -->
                                    <div id="statistics" class="tab-pane fade <?php echo (isset($_SESSION['active_tab']) && $_SESSION['active_tab'] == 'statistics') ? 'active show' : ''; ?>">
                                        <div class="section-header">
                                            <h4>Manage Statistics</h4>
                                        </div>

                                        <?php echo $error1; ?>
                                        <?php echo $msg1; ?>

                                        <form method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="active_tab" value="statistics">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="stats-counter">
                                                        <div class="form-group">
                                                            <label for="rides_count">Rides Count</label>
                                                            <input type="text" class="form-control" name="rides_count" value="<?php echo $road_built; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="rides_title">Rides Title</label>
                                                            <input type="text" class="form-control" name="rides_title" value="<?php echo $road_built_title; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="stats-counter">
                                                        <div class="form-group">
                                                            <label for="city_covered_count">Cities Covered Count</label>
                                                            <input type="text" class="form-control" name="city_covered_count" value="<?php echo $ongoing_projects; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="city_covered_title">Cities Covered Title</label>
                                                            <input type="text" class="form-control" name="city_covered_title" value="<?php echo $ongoing_projects_title; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="stats-counter">
                                                        <div class="form-group">
                                                            <label for="support_count">Support Count</label>
                                                            <input type="text" class="form-control" name="support_count" value="<?php echo $excellence_year; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="support_title">Support Title</label>
                                                            <input type="text" class="form-control" name="support_title" value="<?php echo $excellence_year_title; ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="stats-counter">
                                                        <div class="form-group">
                                                            <label for="services_count">Services Count</label>
                                                            <input type="text" class="form-control" name="services_count" value="<?php echo $machinery_units; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="services_title">Services Title</label>
                                                            <input type="text" class="form-control" name="services_title" value="<?php echo $machinery_units_title; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">Statistics Section Title</label>
                                                        <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="description">Statistics Section Description</label>
                                                        <textarea class="form-control" name="description" rows="3"><?php echo $description; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="action_title">Call to Action Section Title</label>
                                                        <input type="text" class="form-control" name="action_title" value="<?php echo $action_title; ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="action_description">Call to Action Section Description</label>
                                                        <textarea class="form-control" name="action_description" rows="3"><?php echo $action_description; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="video_url">Video URL</label>
                                                <input type="text" class="form-control" name="video_url" value="<?php echo $video; ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="stat_image">Statistics Image</label>
                                                <input type="file" class="form-control" name="stat_image" accept="image/*">
                                                <small class="form-text text-muted">Statistics image 1500x1000 Pixels(JPG, PNG, WebP)</small>
                                                <?php if (!empty($statsData['image_path'])): ?>
                                                    <div class="logo-preview-container mt-2">
                                                        <p>Current Statistics Image:</p>
                                                        <img src="upload/<?php echo $statsData['image_path']; ?>" class="logo-preview">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-center mt-4">
                                                <button type="submit" class="btn btn-primary btn-section" name="updateStatistics">Update Statistics</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Testimonials Tab -->
                                    <div id="testimonials" class="tab-pane fade <?php echo (isset($_SESSION['active_tab']) && $_SESSION['active_tab'] == 'testimonials') ? 'active show' : ''; ?>">
                                        <div class="section-header">
                                            <h4>Manage Testimonials</h4>
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#addTestimonialModal">
                                                <i class="fa fa-plus"></i> Add New Testimonial
                                            </button>
                                        </div>

                                        <?php echo $error3; ?>
                                        <?php echo $msg3; ?>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-hover">
                                                                <thead class="text-center">
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Client Name</th>
                                                                        <th>Client Profile</th>
                                                                        <th>Reviews</th>
                                                                        <th>Rating</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="text-center">
                                                                    <?php if (!empty($testimonials)): ?>
                                                                        <?php foreach ($testimonials as $index => $testimonial): ?>
                                                                            <tr>
                                                                                <td><?php echo $index + 1; ?></td>
                                                                                <td><?php echo $testimonial['name']; ?></td>
                                                                                <td><?php echo $testimonial['profiles']; ?></td>
                                                                                <td>
                                                                                    <?php echo strlen($testimonial['testi_content']) > 50
                                                                                        ? substr($testimonial['testi_content'], 0, 50) . '...'
                                                                                        : $testimonial['testi_content']; ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                    $rating = $testimonial['rating'];
                                                                                    for ($i = 1; $i <= 5; $i++) {
                                                                                        echo $i <= $rating ? '★' : '☆';
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editTestimonialModal"
                                                                                        data-id="<?php echo $testimonial['id']; ?>"
                                                                                        data-testi_title="<?php echo htmlspecialchars($testimonial['testi_title']); ?>"
                                                                                        data-testi_desc="<?php echo htmlspecialchars($testimonial['testi_desc']); ?>"
                                                                                        data-name="<?php echo htmlspecialchars($testimonial['name']); ?>"
                                                                                        data-profile="<?php echo htmlspecialchars($testimonial['profiles']); ?>"
                                                                                        data-testi_content="<?php echo htmlspecialchars($testimonial['testi_content']); ?>"
                                                                                        data-rating="<?php echo $testimonial['rating']; ?>">
                                                                                        <i class="fa fa-edit"></i>
                                                                                    </button>
                                                                                    <a href="?delete_testimonial=<?php echo $testimonial['id']; ?>&active_tab=testimonials"
                                                                                        class="btn btn-sm btn-danger"
                                                                                        onclick="return confirm('Are you sure you want to delete this testimonial?')"
                                                                                        title="Delete Testimonial">
                                                                                        <i class="fa fa-trash"></i>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    <?php else: ?>
                                                                        <tr>
                                                                            <td colspan="6" class="text-center">Record Not Found</td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                </tbody>

                                                            </table>
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
                </div>
            </div>
        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!-- Add Banner Modal -->
    <div class="modal fade" id="addBannerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="active_tab" value="banners">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Banner Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="banner_image" name="banner_image" required>
                                <label class="custom-file-label" for="banner_image">Choose image</label>
                            </div>
                            <small class="form-text text-muted">Recommended size: 9238x3950 pixels</small>
                        </div>
                        <div class="form-group">
                            <label for="banner_title">Banner Title</label>
                            <input type="text" class="form-control" id="banner_title" name="banner_title">
                        </div>
                        <div class="form-group">
                            <label for="banner_subtitle">Banner Subtitle</label>
                            <textarea class="form-control" id="banner_subtitle" name="banner_subtitle" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="addBanner">Save Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Service Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="active_tab" value="services">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="serviceIcon">Service Icon</label>
                            <select class="form-control" id="serviceIcon" name="icon" onchange="updateIconPreview(this.value)">
                                <option value="fa-road">Road icon</option>
                                <option value="fa-building">Building icon</option>
                                <option value="fa-bridge">Bridge icon</option>
                                <option value="fa-tools">Tools icon</option>
                                <option value="fa-truck">Truck icon</option>
                                <option value="fa-home">Home icon</option>
                                <option value="fa-industry">Industry icon</option>
                                <option value="fa-hotel">Hotel icon</option>
                                <option value="fa-bus">Bus icon</option>
                                <option value="fa-store">Store icon</option>
                                <option value="fa-file-alt">File icon</option>
                                <option value="fa-plane-departure">Plane Depart icon</option>
                                <option value="fa-headset">Headset icon</option>
                                <option value="fa-umbrella-beach">Umbrella Beach icon</option>
                                <option value="fa-user-tag">User Tag icon</option>
                                <option value="fa-car">Car icon</option>
                                <option value="fa-users">User icon</option>
                                <option value="fa-cogs">Cogs icon</option>
                            </select>
                            <div class="service-icon-preview">
                                <i id="iconPreview" class="fa fa-road"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="serviceTitle">Service Section Title</label>
                            <input type="text" class="form-control" id="serviceTitle" name="service_title">
                        </div>
                        <div class="form-group">
                            <label for="serviceDescription">Service Section Description</label>
                            <textarea class="form-control" id="serviceDescription" name="service_desc" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="title">Specific Service Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Specific Service Description</label>
                            <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Service Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="service_image" name="service_image" required>
                                <label class="custom-file-label" for="service_image">Choose image</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="addService">Add Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Service Modal -->
    <div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="active_tab" value="services">
                    <input type="hidden" name="service_id" id="edit_service_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_service_icon">Service Icon</label>
                            <select class="form-control" id="edit_service_icon" name="icon" onchange="updateEditIconPreview(this.value)">
                                <option value="fa-road">Road icon</option>
                                <option value="fa-building">Building icon</option>
                                <option value="fa-bridge">Bridge icon</option>
                                <option value="fa-tools">Tools icon</option>
                                <option value="fa-truck">Truck icon</option>
                                <option value="fa-home">Home icon</option>
                                <option value="fa-industry">Industry icon</option>
                                <option value="fa-hotel">Hotel icon</option>
                                <option value="fa-bus">Bus icon</option>
                                <option value="fa-store">Store icon</option>
                                <option value="fa-file-alt">File icon</option>
                                <option value="fa-plane-departure">Plane Depart icon</option>
                                <option value="fa-headset">Headset icon</option>
                                <option value="fa-umbrella-beach">Umbrella Beach icon</option>
                                <option value="fa-user-tag">User Tag icon</option>
                                <option value="fa-car">Car icon</option>
                                <option value="fa-users">User icon</option>
                                <option value="fa-cogs">Cogs icon</option>
                            </select>
                            <div class="service-icon-preview">
                                <i id="edit_icon_preview" class="fa fa-road"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_service_title">Service Section Title</label>
                            <input type="text" class="form-control" id="edit_service_title" name="service_title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_service_description">Service Section Description</label>
                            <textarea class="form-control" id="edit_service_description" name="service_desc" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_title">Specific Service Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Specific Service Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Service Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="edit_service_image" name="service_image">
                                <label class="custom-file-label" for="edit_service_image">Choose new image (leave blank to keep current)</label>
                            </div>
                            <div id="current_image_preview" class="mt-2"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="editService">Update Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Testimonial Modal -->
    <div class="modal fade" id="addTestimonialModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Testimonial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post">
                    <input type="hidden" name="active_tab" value="testimonials">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="testi_title">Testimonial Section Title</label>
                            <input type="text" class="form-control" id="testi_title" name="testi_title">
                        </div>
                        <div class="form-group">
                            <label for="testi_desc">Testimonial Section Description</label>
                            <textarea class="form-control" id="testi_desc" name="testi_desc" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="clientName">Client Name</label>
                            <input type="text" class="form-control" id="clientName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="profile">Client Profile</label>
                            <input type="text" class="form-control" id="profile" name="profile" required>
                        </div>
                        <div class="form-group">
                            <label for="testimonialText">Client Reviews</label>
                            <textarea class="form-control" id="testimonialText" name="testi_content" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="testimonialRating">Rating</label>
                            <select class="form-control" id="testimonialRating" name="rating" required>
                                <option value="5">★★★★★ (5 Stars)</option>
                                <option value="4">★★★★☆ (4 Stars)</option>
                                <option value="3">★★★☆☆ (3 Stars)</option>
                                <option value="2">★★☆☆☆ (2 Stars)</option>
                                <option value="1">★☆☆☆☆ (1 Star)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="addTestimonial">Add Testimonial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Alert Modal -->
    <div id="alertModal" class="alert-modal">
        <div class="alert-content">
            <div class="alert-icon">
                <i class="fa fa-check-circle" style="font-size: 48px; color: #28a745;"></i>
            </div>
            <h4>Success</h4>
            <p id="alertMessage"></p>
            <div class="alert-buttons">
                <button class="alert-ok-btn" onclick="closeAlertAndRefresh()">OK</button>
            </div>
        </div>
    </div>

    <!-- Edit Testimonial Modal -->
    <div class="modal fade" id="editTestimonialModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Testimonial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post">
                    <input type="hidden" name="active_tab" value="testimonials">
                    <input type="hidden" name="testimonial_id" id="edit_testimonial_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_testi_title">Testimonial Section Title</label>
                            <input type="text" class="form-control" id="edit_testi_title" name="testi_title">
                        </div>
                        <div class="form-group">
                            <label for="edit_testi_desc">Testimonial Section Description</label>
                            <textarea class="form-control" id="edit_testi_desc" name="testi_desc" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_client_name">Client Name</label>
                            <input type="text" class="form-control" id="edit_client_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_client_profile">Client Profile</label>
                            <input type="text" class="form-control" id="edit_client_profile" name="profile" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_testimonial_content">Reviews</label>
                            <textarea class="form-control" id="edit_testimonial_content" name="testi_content" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_testimonial_rating">Rating</label>
                            <select class="form-control" id="edit_testimonial_rating" name="rating" required>
                                <option value="5">★★★★★ (5 Stars)</option>
                                <option value="4">★★★★☆ (4 Stars)</option>
                                <option value="3">★★★☆☆ (3 Stars)</option>
                                <option value="2">★★☆☆☆ (2 Stars)</option>
                                <option value="1">★☆☆☆☆ (1 Star)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="editTestimonial">Update Testimonial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
        // Image preview function
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);

                // Update file label
                var fileName = input.files[0].name;
                input.nextElementSibling.innerHTML = fileName;
            }
        }

        // Update icon preview
        function updateIconPreview(iconClass) {
            document.getElementById('iconPreview').className = 'fa ' + iconClass;
        }

        // Update edit icon preview
        function updateEditIconPreview(iconClass) {
            document.getElementById('edit_icon_preview').className = 'fa ' + iconClass;
        }

        // Auto-dismiss alerts
        setTimeout(function() {
            $('.alert-auto-dismiss').fadeOut('slow');
        }, 5000);

        // Initialize tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });

        // Update custom file input label
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Handle edit service modal
        $('#editServiceModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var service_title = button.data('service_title');
            var service_desc = button.data('service_desc');
            var title = button.data('title');
            var description = button.data('description');
            var icon = button.data('icon');
            var image_path = button.data('image_path');

            var modal = $(this);
            modal.find('#edit_service_id').val(id);
            modal.find('#edit_service_title').val(service_title);
            modal.find('#edit_service_description').val(service_desc);
            modal.find('#edit_title').val(title);
            modal.find('#edit_description').val(description);
            modal.find('#edit_service_icon').val(icon);
            modal.find('#edit_icon_preview').attr('class', 'fa ' + icon);

            // Show current image if exists
            if (image_path) {
                modal.find('#current_image_preview').html(
                    '<p>Current Image:</p>' +
                    '<img src="upload/' + image_path + '" class="current-image-preview">'
                );
            } else {
                modal.find('#current_image_preview').html('<p>No image uploaded</p>');
            }
        });

        // Handle edit testimonial modal
        $('#editTestimonialModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var testi_title = button.data('testi_title');
            var testi_desc = button.data('testi_desc');
            var name = button.data('name');
            var profile = button.data('profile');
            var testi_content = button.data('testi_content');
            var rating = button.data('rating');

            var modal = $(this);
            modal.find('#edit_testimonial_id').val(id);
            modal.find('#edit_testi_title').val(testi_title);
            modal.find('#edit_testi_desc').val(testi_desc);
            modal.find('#edit_client_name').val(name);
            modal.find('#edit_client_profile').val(profile);
            modal.find('#edit_testimonial_content').val(testi_content);
            rating = Math.round(parseFloat(rating));
            modal.find('#edit_testimonial_rating').val(rating.toString());
        });

        // Store active tab in session when a tab is shown
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr("href");
            var tabName = target.substring(1); // Remove the # from the href

            // Store the active tab in a hidden field for form submissions
            $('input[name="active_tab"]').val(tabName);

            // Also store in session via AJAX
            $.ajax({
                url: 'set_active_tab.php',
                method: 'POST',
                data: {
                    active_tab: tabName
                },
                success: function(response) {
                    console.log('Active tab saved:', tabName);
                }
            });
        });

        // Check if there's a stored active tab and activate it
        $(document).ready(function() {
            <?php if (isset($_SESSION['active_tab'])): ?>
                var activeTab = '<?php echo $_SESSION['active_tab']; ?>';
                $('.nav-tabs a[href="#' + activeTab + '"]').tab('show');
            <?php endif; ?>

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
    <script>
        $(document).ready(function() {
            <?php if (isset($_SESSION['active_tab'])): ?>
                var activeTab = '<?php echo $_SESSION['active_tab']; ?>';
                $('.nav-tabs a[href="#' + activeTab + '"]').tab('show');
            <?php endif; ?>

            // Check if we have a success message to show in alert
            <?php if (!empty($msg)): ?>
                showAlert('<?php echo addslashes($msg); ?>');
            <?php endif; ?>
        });

        function showAlert(message) {
            document.getElementById('alertMessage').textContent = message;
            document.getElementById('alertModal').style.display = 'flex';
        }

        function closeAlertAndRefresh() {
            document.getElementById('alertModal').style.display = 'none';
            // Refresh the page to avoid form resubmission
            window.location.href = window.location.pathname + '?tab=<?php echo isset($_SESSION['active_tab']) ? $_SESSION['active_tab'] : 'banners'; ?>';
        }

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>