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

// Handle Add Package
if (isset($_POST['add'])) {
	$pkg_title = mysqli_real_escape_string($con, $_POST['pkg_title']);
	$pkg_desc = mysqli_real_escape_string($con, $_POST['pkg_desc']);
	$title = mysqli_real_escape_string($con, $_POST['title']);
	$description = mysqli_real_escape_string($con, $_POST['description']);
	$duration = mysqli_real_escape_string($con, $_POST['duration']);
	$group_size = mysqli_real_escape_string($con, $_POST['group_size']);
	$location = mysqli_real_escape_string($con, $_POST['location']);
	$price = mysqli_real_escape_string($con, $_POST['price']);
	$price_unit = mysqli_real_escape_string($con, $_POST['price_unit']);
	$rating = mysqli_real_escape_string($con, $_POST['rating']);
	$modal_content = mysqli_real_escape_string($con, $_POST['modal_content']);
	$discount = mysqli_real_escape_string($con, $_POST['discount']);
	$mrpPrice = mysqli_real_escape_string($con, $_POST['mrpPrice']);
	$display_order = mysqli_real_escape_string($con, $_POST['display_order']);
	$is_active = mysqli_real_escape_string($con, $_POST['is_active']);

	// Handle image upload
	$image_path = '';
	if (!empty($_FILES['image_path']['name'])) {
		$filename = $_FILES['image_path']['name'];
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

		if (in_array($ext, $allowed)) {
			$unique_name = uniqid() . '.' . $ext;
			$upload_path = "packages/" . $unique_name;

			if (move_uploaded_file($_FILES['image_path']['tmp_name'], $upload_path)) {
				$image_path = $unique_name;
			}
		}
	}

	// Handle PDF upload
	$pdf_path = '';
	if (!empty($_FILES['pdf_path']['name'])) {
		$filename = $_FILES['pdf_path']['name'];
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		$allowed = ['pdf'];

		if (in_array($ext, $allowed)) {
			$unique_name = uniqid() . '.' . $ext;
			$upload_path = "packages/pdf/" . $unique_name;

			if (move_uploaded_file($_FILES['pdf_path']['tmp_name'], $upload_path)) {
				$pdf_path = $unique_name;
			}
		}
	}

	$sql = "INSERT INTO packages (pkg_title, pkg_desc, title, description, image_path, duration, group_size, location, price, price_unit, pdf_path, rating, modal_content, discount, mrpPrice, display_order, is_active) 
            VALUES ('$pkg_title', '$pkg_desc', '$title', '$description', '$image_path', '$duration', '$group_size', '$location', '$price', '$price_unit', '$pdf_path', '$rating', '$modal_content', '$discount', '$mrpPrice', '$display_order', '$is_active')";

	$result = mysqli_query($con, $sql);
	if ($result) {
		$_SESSION['success_message'] = "Package Added Successfully";
		header("Location: " . $_SERVER['PHP_SELF']);
		exit();
	} else {
		$error = "<p class='alert alert-warning'>Something went wrong. Please try again: " . mysqli_error($con) . "</p>";
	}
}

// Fetch all packages
$packages = [];
$sqlPackages = "SELECT * FROM packages ORDER BY display_order, created_at DESC";
$resultPackages = mysqli_query($con, $sqlPackages);
if ($resultPackages) {
	while ($row = mysqli_fetch_assoc($resultPackages)) {
		$packages[] = $row;
	}
}

if (isset($_GET['delete_packages'])) {
	$packages_id = intval($_GET['delete_packages']);

	$deleteStmt = $con->prepare("DELETE FROM packages WHERE id = ?");
	$deleteStmt->bind_param("i", $packages_id);

	if ($deleteStmt->execute()) {
		$_SESSION['success_message'] = "Package Deleted Successfully";
		header("Location: " . $_SERVER['PHP_SELF']);
	} else {
		$error6 = "<p class='alert alert-warning msg-box'>* Error deleting package: " . $con->error . "</p>";
	}
	$deleteStmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Safar | Package Management</title>

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
							<h3 class="page-title">Package Management</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
								<li class="breadcrumb-item active">Packages</li>
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
										<a class="nav-link active" data-bs-toggle="tab" href="#add-package">Add Package</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#view-packages">View Packages</a>
									</li>
								</ul>
							</div>
							<div class="card-body">
								<div class="tab-content">
									<!-- Add Package Tab -->
									<div id="add-package" class="tab-pane fade show active">
										<h4 class="card-title mb-4">Add New Package</h4>
										<?php echo $error; ?>

										<form method="post" enctype="multipart/form-data">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group mb-3">
														<label>Package Title *</label>
														<input type="text" class="form-control" name="pkg_title" required>
													</div>
													<div class="form-group mb-3">
														<label>Package Description *</label>
														<textarea class="form-control" name="pkg_desc" rows="3" required></textarea>
													</div>
													<div class="form-group mb-3">
														<label>Title *</label>
														<input type="text" class="form-control" name="title" required>
													</div>
													<div class="form-group mb-3">
														<label>Description *</label>
														<textarea class="form-control" name="description" rows="3" required></textarea>
													</div>
													<div class="form-group mb-3">
														<label>Duration *</label>
														<input type="text" class="form-control" name="duration" placeholder="e.g., 5 Days / 4 Nights" required>
													</div>
													<div class="form-group mb-3">
														<label>Group Size *</label>
														<input type="text" class="form-control" name="group_size" placeholder="e.g., 2-10 People" required>
													</div>

												</div>
												<div class="col-md-6">
													<div class="form-group mb-3">
														<label>Price *</label>
														<input type="number" class="form-control" name="price" step="0.01" required>
													</div>

													<div class="form-group mb-4">
														<label>Price Unit *</label>
														<input type="text" class="form-control" name="price_unit" placeholder="e.g., per person" required>
													</div>

													<div class="form-group mb-3">
														<label>MRP Price *</label>
														<input type="number" class="form-control" name="mrpPrice" step="0.01" required>
													</div>
													<div class="form-group mb-3">
														<label>Location *</label>
														<input type="text" class="form-control" name="location" required>
													</div>
													<div class="form-group mb-3">
														<label>Discount (%)*</label>
														<input type="number" class="form-control" name="discount" step="0.01" min="0" max="100" required>
													</div>
													<div class="form-group mb-3">
														<label>Rating (1-5) *</label>
														<select class="form-control" id="rating" name="rating" required>
															<option value="5">★★★★★ (5 Stars)</option>
															<option value="4">★★★★☆ (4 Stars)</option>
															<option value="3">★★★☆☆ (3 Stars)</option>
															<option value="2">★★☆☆☆ (2 Stars)</option>
															<option value="1">★☆☆☆☆ (1 Star)</option>
														</select>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group mb-3">
																<label>Display Order *</label>
																<input type="number" class="form-control" name="display_order" value="1" required>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group mb-3">
																<label>Status *</label>
																<select class="form-control" id="is_active" name="is_active" required>
																	<option value="1">Active</option>
																	<option value="0">Inactive</option>
																</select>
															</div>
														</div>
													</div>

												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group mb-3">
														<label>Package Image *</label>
														<input type="file" class="form-control" name="image_path" accept="image/*" required>
														<small class="form-text text-muted">Recommended size: 1080x1080 pixels</small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group mb-3">
														<label>PDF Itinerary *</label>
														<input type="file" class="form-control" name="pdf_path" accept=".pdf" required>
													</div>
												</div>
											</div>

											<div class="form-group mb-3">
												<label>Modal Content (Detailed Description)</label>
												<textarea class="tinymce form-control" name="modal_content" rows="5" required></textarea>
											</div>

											<div class="text-center mt-4">
												<button type="submit" class="btn btn-primary btn-lg" name="add">Add Package</button>
											</div>
										</form>
									</div>

									<!-- View Packages Tab -->
									<div id="view-packages" class="tab-pane fade">
										<h4 class="card-title mb-4">All Packages</h4>

										<div class="table-responsive">
											<table class="table table-hover table-bordered">
												<thead class="text-center">
													<tr>
														<th>#</th>
														<th>Image</th>
														<th>Package Title</th>
														<th>Duration</th>
														<th>Location</th>
														<th>Price</th>
														<th>Rating</th>
														<th>Status</th>
														<th>Order</th>
														<th>Actions</th>
													</tr>
												</thead>
												<tbody class="text-center">
													<?php if (count($packages) > 0): ?>
														<?php foreach ($packages as $index => $package): ?>
															<tr>
																<td><?php echo $index + 1; ?></td>
																<td>
																	<?php if (!empty($package['image_path'])): ?>
																		<img src="packages/<?php echo $package['image_path']; ?>" class="package-image">
																	<?php else: ?>
																		<span class="text-muted">No Image</span>
																	<?php endif; ?>
																</td>
																<td><?php echo $package['pkg_title']; ?></td>
																<td><?php echo $package['duration']; ?></td>
																<td><?php echo $package['location']; ?></td>
																<td>
																	<span class="price-tag"><?php echo $package['price_unit'] . ' ' . $package['price']; ?></span>
																	<?php if (!empty($package['discount']) && $package['discount'] > 0): ?>
																		<span class="discount-badge"><?php echo $package['discount']; ?>% off</span>
																	<?php endif; ?>
																</td>
																<td>
																	<?php if (!empty($package['rating'])): ?>
																		<span class="rating">
																			<?php
																			$rating = $package['rating'];
																			for ($i = 1; $i <= 5; $i++) {
																				if ($i <= $rating) {
																					echo '★';
																				} else {
																					echo '☆';
																				}
																			}
																			?>
																		</span>
																	<?php endif; ?>
																</td>
																<td>
																	<?php if ($package['is_active'] == 1): ?>
																		<span class="badge bg-success status-badge">Active</span>
																	<?php else: ?>
																		<span class="badge bg-secondary status-badge">Inactive</span>
																	<?php endif; ?>
																</td>
																<td><?php echo $package['display_order']; ?></td>
																<td class="action-buttons">
																	<a href="edit-package.php?id=<?php echo $package['id']; ?>" class="btn btn-sm btn-info">
																		<i class="fa fa-edit"></i>
																	</a>
																	<a href="?delete_packages=<?php echo $package['id']; ?>"
																		title="Delete Package" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this package?')">
																		<i class="fa fa-trash"></i>
																	</a>
																</td>
															</tr>
														<?php endforeach; ?>
													<?php else: ?>
														<tr>
															<td colspan="10" class="text-center">No packages found. Add your first package!</td>
														</tr>
													<?php endif; ?>
												</tbody>
											</table>
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