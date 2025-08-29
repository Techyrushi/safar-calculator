<?php
session_start();
require("config.php");

// Ensure user is authenticated
if (!isset($_SESSION['auser'])) {
	header("Location: index");
	exit();
}

// Initialize messages and package data
$error = $msg = "";
$package = null;

// Check if we have a package ID to edit
if (!isset($_GET['id']) || empty($_GET['id'])) {
	header("Location: packages"); // Redirect to packages list if no ID provided
	exit();
}

$package_id = mysqli_real_escape_string($con, $_GET['id']);

// Fetch the specific package data
$sqlPackage = "SELECT * FROM packages WHERE id = '$package_id'";
$resultPackage = mysqli_query($con, $sqlPackage);

if (!$resultPackage || mysqli_num_rows($resultPackage) === 0) {
	header("Location: packages"); // Redirect if package not found
	exit();
}

$package = mysqli_fetch_assoc($resultPackage);

// Check if we have a success message in session to display
if (isset($_SESSION['success_message'])) {
	$msg = $_SESSION['success_message'];
	unset($_SESSION['success_message']);
}

// Handle form submission for updating package
if (isset($_POST['update'])) {
	// Sanitize and validate input data
	$pkg_title = mysqli_real_escape_string($con, $_POST['pkg_title']);
	$pkg_desc = mysqli_real_escape_string($con, $_POST['pkg_desc']);
	$title = mysqli_real_escape_string($con, $_POST['title']);
	$description = mysqli_real_escape_string($con, $_POST['description']);
	$duration = mysqli_real_escape_string($con, $_POST['duration']);
	$group_size = mysqli_real_escape_string($con, $_POST['group_size']);
	$price = mysqli_real_escape_string($con, $_POST['price']);
	$price_unit = mysqli_real_escape_string($con, $_POST['price_unit']);
	$is_active = mysqli_real_escape_string($con, $_POST['is_active']);
	$mrpPrice = mysqli_real_escape_string($con, $_POST['mrpPrice']);
	$location = mysqli_real_escape_string($con, $_POST['location']);
	$discount = mysqli_real_escape_string($con, $_POST['discount']);
	$rating = mysqli_real_escape_string($con, $_POST['rating']);
	$display_order = mysqli_real_escape_string($con, $_POST['display_order']);
	$modal_content = mysqli_real_escape_string($con, $_POST['modal_content']);

	// Handle image upload if a new image is provided
	$image_path = $package['image_path']; // Keep existing image by default

	if (!empty($_FILES['image_path']['name'])) {
		$target_dir = "assets/img/packages/";
		$imageFileType = strtolower(pathinfo($_FILES["image_path"]["name"], PATHINFO_EXTENSION));
		$new_filename = "package_" . $package_id . "_" . time() . "." . $imageFileType;
		$target_file = $target_dir . $new_filename;

		// Check if image file is an actual image
		$check = getimagesize($_FILES["image_path"]["tmp_name"]);
		if ($check !== false) {
			if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $target_file)) {
				$image_path = $target_file;
				// Optionally delete the old image file
			} else {
				$error = "<div class='alert alert-danger'>Sorry, there was an error uploading your image.</div>";
			}
		} else {
			$error = "<div class='alert alert-danger'>File is not an image.</div>";
		}
	}

	// Handle PDF upload if a new PDF is provided
	$pdf_path = $package['pdf_path']; // Keep existing PDF by default

	if (!empty($_FILES['pdf_path']['name'])) {
		$target_dir = "assets/pdf/";
		$pdfFileType = strtolower(pathinfo($_FILES["pdf_path"]["name"], PATHINFO_EXTENSION));

		if ($pdfFileType == "pdf") {
			$new_filename = "package_" . $package_id . "_" . time() . ".pdf";
			$target_file = $target_dir . $new_filename;

			if (move_uploaded_file($_FILES["pdf_path"]["tmp_name"], $target_file)) {
				$pdf_path = $target_file;
				// Optionally delete the old PDF file
			} else {
				$error = "<div class='alert alert-danger'>Sorry, there was an error uploading your PDF.</div>";
			}
		} else {
			$error = "<div class='alert alert-danger'>Only PDF files are allowed.</div>";
		}
	}

	// If no errors, update the package in database
	if (empty($error)) {
		$update_sql = "UPDATE packages SET 
                      pkg_title = '$pkg_title',
                      pkg_desc = '$pkg_desc',
                      title = '$title',
                      description = '$description',
                      duration = '$duration',
                      group_size = '$group_size',
                      price = '$price',
                      price_unit = '$price_unit',
                      is_active = '$is_active',
                      mrpPrice = '$mrpPrice',
                      location = '$location',
                      discount = '$discount',
                      rating = '$rating',
                      display_order = '$display_order',
                      modal_content = '$modal_content',
                      image_path = '$image_path',
                      pdf_path = '$pdf_path'
                      WHERE id = '$package_id'";

		if (mysqli_query($con, $update_sql)) {
			$_SESSION['success_message'] = "Package updated successfully";
			header("Location: edit-package?id=" . $package_id);
			exit();
		} else {
			$error = "<div class='alert alert-danger'>Error updating package: " . mysqli_error($con) . "</div>";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Safar | Edit Package</title>

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

		.package-image {
			width: 80px;
			height: 60px;
			object-fit: cover;
			border-radius: 5px;
		}

		.status-badge {
			padding: 5px 10px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 500;
		}

		.action-buttons .btn {
			padding: 5px 10px;
			margin-right: 5px;
		}

		.price-tag {
			font-weight: bold;
			color: #28a745;
		}

		.discount-badge {
			background: #dc3545;
			color: white;
			padding: 3px 8px;
			border-radius: 3px;
			font-size: 12px;
			margin-left: 5px;
		}

		.rating {
			color: #ffc107;
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

		.current-file {
			margin-top: 5px;
			font-size: 12px;
			color: #6c757d;
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
							<h3 class="page-title">Edit Package</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="packages">Packages</a></li>
								<li class="breadcrumb-item active">Edit Package</li>
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
										<a class="nav-link active" data-bs-toggle="tab" href="#edit-package">Edit Package</a>
									</li>

									<li class="nav-item">
										<a class="nav-link" href="add-package#view-packages">View Package</a>
									</li>

								</ul>
							</div>
							<div class="card-body">
								<div class="tab-content">
									<!-- Edit Package Tab -->
									<div id="edit-package" class="tab-pane fade show active">
										<h4 class="card-title mb-4">Edit Package: <?php echo htmlspecialchars($package['title']); ?></h4>
										<?php echo $error; ?>

										<form method="post" enctype="multipart/form-data">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group mb-3">
														<label>Package Title *</label>
														<input type="text" class="form-control" name="pkg_title" value="<?php echo htmlspecialchars($package['pkg_title']); ?>" required>
													</div>
													<div class="form-group mb-3">
														<label>Package Description *</label>
														<textarea class="form-control" name="pkg_desc" rows="3" required><?php echo htmlspecialchars($package['pkg_desc']); ?></textarea>
													</div>
													<div class="form-group mb-3">
														<label>Title *</label>
														<input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($package['title']); ?>" required>
													</div>
													<div class="form-group mb-3">
														<label>Description *</label>
														<textarea class="form-control" name="description" rows="3"><?php echo htmlspecialchars($package['description']); ?></textarea>
													</div>
													<div class="form-group mb-3">
														<label>Duration *</label>
														<input type="text" class="form-control" name="duration" value="<?php echo htmlspecialchars($package['duration']); ?>" placeholder="e.g., 5 Days / 4 Nights" required>
													</div>
													<div class="form-group mb-3">
														<label>Group Size *</label>
														<input type="text" class="form-control" name="group_size" value="<?php echo htmlspecialchars($package['group_size']); ?>" placeholder="e.g., 2-10 People" required>
													</div>

												</div>
												<div class="col-md-6">
													<div class="form-group mb-3">
														<label>Price *</label>
														<input type="number" class="form-control" name="price" value="<?php echo htmlspecialchars($package['price']); ?>" step="0.01" required>
													</div>

													<div class="form-group mb-3">
														<label>Price Unit *</label>
														<input type="text" class="form-control" name="price_unit" value="<?php echo htmlspecialchars($package['price_unit']); ?>" placeholder="e.g., per person" required>
													</div>


													<div class="form-group mb-3">
														<label>MRP Price *</label>
														<input type="number" class="form-control" name="mrpPrice" value="<?php echo htmlspecialchars($package['mrpPrice']); ?>" step="0.01">
													</div>
													<div class="form-group mb-3">
														<label>Location *</label>
														<input type="text" class="form-control" name="location" value="<?php echo htmlspecialchars($package['location']); ?>" required>
													</div>
													<div class="form-group mb-3">
														<label>Discount (%) *</label>
														<input type="number" class="form-control" name="discount" value="<?php echo htmlspecialchars($package['discount']); ?>" step="0.01" min="0" max="100">
													</div>
													<div class="form-group mb-3">
														<label>Rating (1-5) *</label>
														<select class="form-control" id="rating" name="rating">
															<option value="5" <?php echo ($package['rating'] == 5) ? 'selected' : ''; ?>>★★★★★ (5 Stars)</option>
															<option value="4" <?php echo ($package['rating'] == 4) ? 'selected' : ''; ?>>★★★★☆ (4 Stars)</option>
															<option value="3" <?php echo ($package['rating'] == 3) ? 'selected' : ''; ?>>★★★☆☆ (3 Stars)</option>
															<option value="2" <?php echo ($package['rating'] == 2) ? 'selected' : ''; ?>>★★☆☆☆ (2 Stars)</option>
															<option value="1" <?php echo ($package['rating'] == 1) ? 'selected' : ''; ?>>★☆☆☆☆ (1 Star)</option>
														</select>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group mb-3">
																<label>Display Order *</label>
																<input type="number" class="form-control" name="display_order" value="<?php echo htmlspecialchars($package['display_order']); ?>">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group mb-3">
																<label>Status *</label>
																<select class="form-control" id="is_active" name="is_active">
																	<option value="1" <?php echo ($package['is_active'] == 1) ? 'selected' : ''; ?>>Active</option>
																	<option value="0" <?php echo ($package['is_active'] == 0) ? 'selected' : ''; ?>>Inactive</option>
																</select>
															</div>
														</div>
													</div>

												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group mb-3">
														<label>Package Image</label>
														<input type="file" class="form-control" name="image_path" accept="image/*">
														<small class="form-text text-muted">Recommended size: 800x600 pixels</small>
														<?php if (!empty($package['image_path'])): ?>
															<div class="current-file">
																Current: <a href="<?php echo $package['image_path']; ?>" target="_blank">View Image</a>
															</div>
														<?php endif; ?>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group mb-3">
														<label>PDF Itinerary *</label>
														<input type="file" class="form-control" name="pdf_path" accept=".pdf">
														<?php if (!empty($package['pdf_path'])): ?>
															<div class="current-file">
																Current: <a href="<?php echo $package['pdf_path']; ?>" target="_blank">View PDF</a>
															</div>
														<?php endif; ?>
													</div>
												</div>
											</div>

											<div class="form-group mb-3">
												<label>Modal Content (Detailed Description) *</label>
												<textarea class="tinymce form-control" name="modal_content" rows="5"><?php echo htmlspecialchars($package['modal_content']); ?></textarea>
											</div>

											<div class="text-center mt-4">
												<button type="submit" class="btn btn-primary btn-lg" name="update">Update Package</button>
												<a href="packages" class="btn btn-secondary btn-lg">Cancel</a>
											</div>
										</form>
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
	<script src="assets/plugins/tinymce/tinymce.min.js"></script>
	<script src="assets/plugins/tinymce/init-tinymce.min.js"></script>
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
			window.location.href = window.location.pathname + window.location.search;
		}

		// Prevent form resubmission on page refresh
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>
</body>

</html>