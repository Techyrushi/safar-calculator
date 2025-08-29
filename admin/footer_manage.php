<?php
session_start();
require("config.php");

// Ensure user is authenticated
if (!isset($_SESSION['auser'])) {
    header("Location: index");
    exit();
}

// Initialize messages
$error = $msg = "";

// Check if we have a success message in session to display
if (isset($_SESSION['success_message'])) {
    $msg = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// Handle Update Footer Information
if (isset($_POST['update'])) {
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Social media links and status
    $facebook_url = mysqli_real_escape_string($con, $_POST['facebook_url']);
    $twitter_url = mysqli_real_escape_string($con, $_POST['twitter_url']);
    $instagram_url = mysqli_real_escape_string($con, $_POST['instagram_url']);
    $linkedin_url = mysqli_real_escape_string($con, $_POST['linkedin_url']);
    $youtube_url = mysqli_real_escape_string($con, $_POST['youtube_url']);

    $facebook_status = isset($_POST['facebook_status']) ? 1 : 0;
    $twitter_status = isset($_POST['twitter_status']) ? 1 : 0;
    $instagram_status = isset($_POST['instagram_status']) ? 1 : 0;
    $linkedin_status = isset($_POST['linkedin_status']) ? 1 : 0;
    $youtube_status = isset($_POST['youtube_status']) ? 1 : 0;

    // Handle logo upload
    $logo_path = '';
    if (!empty($_FILES['logo_path']['name'])) {
        $filename = $_FILES['logo_path']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        if (in_array($ext, $allowed)) {
            $unique_name = uniqid() . '.' . $ext;
            $upload_path = "packages/" . $unique_name;

            if (move_uploaded_file($_FILES['logo_path']['tmp_name'], $upload_path)) {
                $logo_path = $unique_name;

                // Update logo path in database
                $sql_logo = "UPDATE footer_cms SET logo_path = '$logo_path' WHERE id = 1";
                mysqli_query($con, $sql_logo);
            }
        }
    }

    // Update the footer information (assuming id=1)
    $sql = "UPDATE footer_cms SET 
            description = '$description', 
            facebook_url = '$facebook_url',
            twitter_url = '$twitter_url',
            instagram_url = '$instagram_url',
            linkedin_url = '$linkedin_url',
            youtube_url = '$youtube_url',
            facebook_status = '$facebook_status',
            twitter_status = '$twitter_status',
            instagram_status = '$instagram_status',
            linkedin_status = '$linkedin_status',
            youtube_status = '$youtube_status'
            WHERE id = 1";

    $result = mysqli_query($con, $sql);
    if ($result) {
        $_SESSION['success_message'] = "Footer Information Updated Successfully";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "<p class='alert alert-warning'>Something went wrong. Please try again: " . mysqli_error($con) . "</p>";
    }
}

// Fetch footer information
$footer_info = [];
$sqlFooter = "SELECT * FROM footer_cms WHERE id=1";
$resultFooter = mysqli_query($con, $sqlFooter);
if ($resultFooter && mysqli_num_rows($resultFooter) > 0) {
    $footer_info = mysqli_fetch_assoc($resultFooter);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Safar | Footer Management</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
        }

        .card-header {
            background: linear-gradient(45deg, rgb(129, 186, 243), rgb(0, 105, 218));
            color: white;
            border-radius: 10px 10px 0 0 !important;
            border: none;
        }

        .form-control,
        .form-select {
            border-radius: 5px;
            padding: 12px 15px;
            border: 1px solid #e1e5eb;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
            border-color: #007bff;
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #004494);
        }

        .nav-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #495057;
            font-weight: 500;
            padding: 12px 20px;
        }

        .nav-tabs .nav-link.active {
            border-bottom: 3px solid #007bff;
            color: rgb(0, 0, 0);
            background: transparent;
        }

        .footer-info-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .footer-detail {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .footer-detail:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #212529;
        }

        .social-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            margin-left: 10px;
        }

        .status-active {
            background-color: #28a745;
            color: white;
        }

        .status-inactive {
            background-color: #dc3545;
            color: white;
        }

        .logo-preview {
            max-width: 150px;
            max-height: 80px;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
            margin-left: 10px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
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
                            <h3 class="page-title">Footer Management</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Footer</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#edit-footer">Edit Footer Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#view-footer">View Footer Information</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- Edit Footer Tab -->
                                    <div id="edit-footer" class="tab-pane fade show active">
                                        <h4 class="card-title mb-4">Edit Footer Information</h4>
                                        <?php echo $error; ?>

                                        <form method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label>Logo Image</label>
                                                        <input type="file" class="form-control" name="logo_path" accept="image/*">
                                                        <small class="form-text text-muted">Recommended size: 375x216 pixels (JPG, PNG, SVG)</small>
                                                        <?php if (!empty($footer_info['logo_path'])): ?>
                                                            <div class="logo-preview-container">
                                                                <p>Current Logo:</p>
                                                                <img src="packages/<?php echo $footer_info['logo_path']; ?>" class="logo-preview">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label>Description *</label>
                                                        <textarea class="form-control" name="description" rows="4" required><?php echo isset($footer_info['description']) ? $footer_info['description'] : ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <h5 class="mb-3">Social Media Settings</h5>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label>Facebook URL</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fa fa-facebook"></i></span>
                                                            <input type="url" class="form-control" name="facebook_url" value="<?php echo isset($footer_info['facebook_url']) ? $footer_info['facebook_url'] : ''; ?>">
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" name="facebook_status" id="facebook_status" <?php echo (isset($footer_info['facebook_status']) && $footer_info['facebook_status'] == 1) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="facebook_status">
                                                                Show Facebook Link
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>Twitter URL</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fa fa-twitter"></i></span>
                                                            <input type="url" class="form-control" name="twitter_url" value="<?php echo isset($footer_info['twitter_url']) ? $footer_info['twitter_url'] : ''; ?>">
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" name="twitter_status" id="twitter_status" <?php echo (isset($footer_info['twitter_status']) && $footer_info['twitter_status'] == 1) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="twitter_status">
                                                                Show Twitter Link
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>Youtube URL</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fa fa-youtube"></i></span>
                                                            <input type="url" class="form-control" name="youtube_url" value="<?php echo isset($footer_info['youtube_url']) ? $footer_info['youtube_url'] : ''; ?>">
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" name="youtube_status" id="youtube_status" <?php echo (isset($footer_info['youtube_status']) && $footer_info['youtube_status'] == 1) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="youtube_status">
                                                                Show Youtube Link
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label>Instagram URL</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fa fa-instagram"></i></span>
                                                            <input type="url" class="form-control" name="instagram_url" value="<?php echo isset($footer_info['instagram_url']) ? $footer_info['instagram_url'] : ''; ?>">
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" name="instagram_status" id="instagram_status" <?php echo (isset($footer_info['instagram_status']) && $footer_info['instagram_status'] == 1) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="instagram_status">
                                                                Show Instagram Link
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>LinkedIn URL</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="fa fa-linkedin"></i></span>
                                                            <input type="url" class="form-control" name="linkedin_url" value="<?php echo isset($footer_info['linkedin_url']) ? $footer_info['linkedin_url'] : ''; ?>">
                                                        </div>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input" type="checkbox" name="linkedin_status" id="linkedin_status" <?php echo (isset($footer_info['linkedin_status']) && $footer_info['linkedin_status'] == 1) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="linkedin_status">
                                                                Show LinkedIn Link
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="text-center mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg" name="update">Update Footer Information</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- View Footer Tab -->
                                    <div id="view-footer" class="tab-pane fade">
                                        <h4 class="card-title mb-4">Footer Information</h4>

                                        <div class="footer-info-card">
                                            <?php if (!empty($footer_info)): ?>

                                                <?php if (!empty($footer_info['logo_path'])): ?>
                                                    <div class="footer-detail">
                                                        <div class="detail-label">Logo</div>
                                                        <div class="detail-value">
                                                            <img src="packages/<?php echo $footer_info['logo_path']; ?>" class="logo-preview">
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="footer-detail">
                                                    <div class="detail-label">Description</div>
                                                    <div class="detail-value"><?php echo $footer_info['description']; ?></div>
                                                </div>

                                                <div class="footer-detail">
                                                    <div class="detail-label">Social Media Links</div>
                                                    <div class="detail-value">
                                                        <?php if (!empty($footer_info['facebook_url'])): ?>
                                                            <div class="mb-2">
                                                                Facebook:
                                                                <a href="<?php echo $footer_info['facebook_url']; ?>" target="_blank">
                                                                    <?php echo $footer_info['facebook_url']; ?>
                                                                </a>
                                                                <span class="social-status <?php echo ($footer_info['facebook_status'] == 1) ? 'status-active' : 'status-inactive'; ?>">
                                                                    <?php echo ($footer_info['facebook_status'] == 1) ? 'Active' : 'Inactive'; ?>
                                                                </span>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (!empty($footer_info['twitter_url'])): ?>
                                                            <div class="mb-2">
                                                                Twitter:
                                                                <a href="<?php echo $footer_info['twitter_url']; ?>" target="_blank">
                                                                    <?php echo $footer_info['twitter_url']; ?>
                                                                </a>
                                                                <span class="social-status <?php echo ($footer_info['twitter_status'] == 1) ? 'status-active' : 'status-inactive'; ?>">
                                                                    <?php echo ($footer_info['twitter_status'] == 1) ? 'Active' : 'Inactive'; ?>
                                                                </span>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (!empty($footer_info['instagram_url'])): ?>
                                                            <div class="mb-2">
                                                                Instagram:
                                                                <a href="<?php echo $footer_info['instagram_url']; ?>" target="_blank">
                                                                    <?php echo $footer_info['instagram_url']; ?>
                                                                </a>
                                                                <span class="social-status <?php echo ($footer_info['instagram_status'] == 1) ? 'status-active' : 'status-inactive'; ?>">
                                                                    <?php echo ($footer_info['instagram_status'] == 1) ? 'Active' : 'Inactive'; ?>
                                                                </span>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (!empty($footer_info['linkedin_url'])): ?>
                                                            <div class="mb-2">
                                                                LinkedIn:
                                                                <a href="<?php echo $footer_info['linkedin_url']; ?>" target="_blank">
                                                                    <?php echo $footer_info['linkedin_url']; ?>
                                                                </a>
                                                                <span class="social-status <?php echo ($footer_info['linkedin_status'] == 1) ? 'status-active' : 'status-inactive'; ?>">
                                                                    <?php echo ($footer_info['linkedin_status'] == 1) ? 'Active' : 'Inactive'; ?>
                                                                </span>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if (!empty($footer_info['youtube_url'])): ?>
                                                            <div class="mb-2">
                                                                Youtube:
                                                                <a href="<?php echo $footer_info['youtube_url']; ?>" target="_blank">
                                                                    <?php echo $footer_info['youtube_url']; ?>
                                                                </a>
                                                                <span class="social-status <?php echo ($footer_info['youtube_status'] == 1) ? 'status-active' : 'status-inactive'; ?>">
                                                                    <?php echo ($footer_info['youtube_status'] == 1) ? 'Active' : 'Inactive'; ?>
                                                                </span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center py-4">
                                                    <p>No footer information found. Please add footer information.</p>
                                                </div>
                                            <?php endif; ?>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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

    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>

    <script>
        // Initialize Bootstrap tabs
        $(document).ready(function() {
            $('a[data-bs-toggle="tab"]').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Preview logo image before upload
            $('input[name="logo_path"]').change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        // Remove existing preview if any
                        $('.logo-preview-container').remove();

                        // Create new preview
                        $('input[name="logo_path"]').after(
                            '<div class="logo-preview-container">' +
                            '<p>New Logo Preview:</p>' +
                            '<img src="' + e.target.result + '" class="logo-preview">' +
                            '</div>'
                        );
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {

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
            window.location.href = window.location.pathname;
        }

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // get hash from URL
            let hash = window.location.hash;
            if (hash) {
                let tabTrigger = document.querySelector(`a[href="${hash}"]`);
                if (tabTrigger) {
                    let tab = new bootstrap.Tab(tabTrigger);
                    tab.show();
                }
            }
        });
    </script>

</body>

</html>