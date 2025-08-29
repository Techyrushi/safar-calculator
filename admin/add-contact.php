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

// Fetch contact information FIRST to get existing image filenames
$contact_info = [];
$sqlContact = "SELECT * FROM contact_cms WHERE id=1";
$resultContact = mysqli_query($con, $sqlContact);
if ($resultContact && mysqli_num_rows($resultContact) > 0) {
    $contact_info = mysqli_fetch_assoc($resultContact);
}

// Handle Update Contact Information
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $location_url = mysqli_real_escape_string($con, $_POST['location_url']);

    // Initialize variables for image paths with EXISTING values
    $contact_banner = isset($contact_info['contact_banner']) ? $contact_info['contact_banner'] : '';
    $package_banner = isset($contact_info['package_banner']) ? $contact_info['package_banner'] : '';

    // Handle contact banner upload
    if (!empty($_FILES['contact_banner']['name'])) {
        $filename = $_FILES['contact_banner']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        if (in_array($ext, $allowed)) {
            $unique_name = uniqid() . '.' . $ext;
            $upload_path = "packages/" . $unique_name;

            if (move_uploaded_file($_FILES['contact_banner']['tmp_name'], $upload_path)) {
                // Delete old contact banner if exists
                if (!empty($contact_banner) && file_exists("packages/" . $contact_banner)) {
                    unlink("packages/" . $contact_banner);
                }
                $contact_banner = $unique_name;
            }
        }
    }

    // Handle package banner upload
    if (!empty($_FILES['package_banner']['name'])) {
        $filename = $_FILES['package_banner']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        if (in_array($ext, $allowed)) {
            $unique_name = uniqid() . '.' . $ext;
            $upload_path = "packages/" . $unique_name;

            if (move_uploaded_file($_FILES['package_banner']['tmp_name'], $upload_path)) {
                // Delete old package banner if exists
                if (!empty($package_banner) && file_exists("packages/" . $package_banner)) {
                    unlink("packages/" . $package_banner);
                }
                $package_banner = $unique_name;
            }
        }
    }

    // Update all information in a single query
    $sql = "UPDATE contact_cms SET 
            title = '$title', 
            description = '$description', 
            mobile_number = '$mobile_number', 
            email = '$email', 
            address = '$address', 
            location_url = '$location_url', 
            contact_banner = '$contact_banner', 
            package_banner = '$package_banner' 
            WHERE id = 1";

    $result = mysqli_query($con, $sql);
    if ($result) {
        $_SESSION['success_message'] = "Contact Information Updated Successfully";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "<p class='alert alert-warning'>Something went wrong. Please try again: " . mysqli_error($con) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Safar | Contact Management</title>

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

        .contact-info-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .contact-detail {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .contact-detail:last-child {
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
        
        .logo-preview {
            max-width: 300px;
            height: auto;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 5px;
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
                            <h3 class="page-title">Contact Management</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Contacts</li>
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
                                        <a class="nav-link active" data-bs-toggle="tab" href="#edit-contact">Edit Contact Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#view-contact">View Contact Information</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- Edit Contact Tab -->
                                    <div id="edit-contact" class="tab-pane fade show active">
                                        <h4 class="card-title mb-4">Edit Contact Information</h4>
                                        <?php echo $error; ?>

                                        <form method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label>Contact Banner Image</label>
                                                        <input type="file" class="form-control" name="contact_banner" accept="image/*">
                                                        <small class="form-text text-muted">Recommended size: 9238x3950 pixels (JPG, PNG, SVG)</small>
                                                        <?php if (!empty($contact_info['contact_banner'])): ?>
                                                            <div class="logo-preview-container">
                                                                <p>Current Banner:</p>
                                                                <img src="packages/<?php echo $contact_info['contact_banner']; ?>" class="logo-preview">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>Title *</label>
                                                        <input type="text" class="form-control" name="title" value="<?php echo isset($contact_info['title']) ? $contact_info['title'] : ''; ?>" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>Mobile Number *</label>
                                                        <input type="text" class="form-control" name="mobile_number" value="<?php echo isset($contact_info['mobile_number']) ? $contact_info['mobile_number'] : ''; ?>" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>Description *</label>
                                                        <textarea class="form-control" name="description" rows="5" required><?php echo isset($contact_info['description']) ? $contact_info['description'] : ''; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label>Package Banner Image</label>
                                                        <input type="file" class="form-control" name="package_banner" accept="image/*">
                                                        <small class="form-text text-muted">Recommended size: 9238x3950 pixels (JPG, PNG, SVG)</small>
                                                        <?php if (!empty($contact_info['package_banner'])): ?>
                                                            <div class="logo-preview-container">
                                                                <p>Current Banner:</p>
                                                                <img src="packages/<?php echo $contact_info['package_banner']; ?>" class="logo-preview">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>Email *</label>
                                                        <input type="email" class="form-control" name="email" value="<?php echo isset($contact_info['email']) ? $contact_info['email'] : ''; ?>" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>Location URL (Google Maps) *</label>
                                                        <input type="url" class="form-control" name="location_url" value="<?php echo isset($contact_info['location_url']) ? $contact_info['location_url'] : ''; ?>" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>Address *</label>
                                                        <textarea class="form-control" name="address" rows="5" required><?php echo isset($contact_info['address']) ? $contact_info['address'] : ''; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg" name="update">Update Contact Information</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- View Contact Tab -->
                                    <div id="view-contact" class="tab-pane fade">
                                        <h4 class="card-title mb-4">Contact Information</h4>

                                        <div class="contact-info-card">
                                            <?php if (!empty($contact_info)): ?>
                                                <?php if (!empty($contact_info['contact_banner'])): ?>
                                                <div class="contact-detail">
                                                    <div class="detail-label">Contact Banner</div>
                                                    <div class="detail-value">
                                                        <img src="packages/<?php echo $contact_info['contact_banner']; ?>" class="logo-preview">
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                                <?php if (!empty($contact_info['package_banner'])): ?>
                                                <div class="contact-detail">
                                                    <div class="detail-label">Package Banner</div>
                                                    <div class="detail-value">
                                                        <img src="packages/<?php echo $contact_info['package_banner']; ?>" class="logo-preview">
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                                <div class="contact-detail">
                                                    <div class="detail-label">Title</div>
                                                    <div class="detail-value"><?php echo $contact_info['title']; ?></div>
                                                </div>
                                                <div class="contact-detail">
                                                    <div class="detail-label">Description</div>
                                                    <div class="detail-value"><?php echo $contact_info['description']; ?></div>
                                                </div>
                                                <div class="contact-detail">
                                                    <div class="detail-label">Mobile Number</div>
                                                    <div class="detail-value"><?php echo $contact_info['mobile_number']; ?></div>
                                                </div>
                                                <div class="contact-detail">
                                                    <div class="detail-label">Email</div>
                                                    <div class="detail-value"><?php echo $contact_info['email']; ?></div>
                                                </div>
                                                <div class="contact-detail">
                                                    <div class="detail-label">Address</div>
                                                    <div class="detail-value"><?php echo $contact_info['address']; ?></div>
                                                </div>
                                                <div class="contact-detail">
                                                    <div class="detail-label">Location URL</div>
                                                    <div class="detail-value">
                                                        <a href="<?php echo $contact_info['location_url']; ?>" target="_blank">
                                                            <?php echo $contact_info['location_url']; ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center py-4">
                                                    <p>No contact information found. Please add contact information.</p>
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