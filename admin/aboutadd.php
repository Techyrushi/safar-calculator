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

// Fetch about information FIRST to get existing image filenames
$about_info = [];
$partners_info = [];
$sqlAbout = "SELECT * FROM about_cms WHERE id=1";
$resultAbout = mysqli_query($con, $sqlAbout);
if ($resultAbout && mysqli_num_rows($resultAbout) > 0) {
	$about_info = mysqli_fetch_assoc($resultAbout);

	// Fetch partners information
	$sqlPartners = "SELECT * FROM about_partners WHERE about_id=1";
	$resultPartners = mysqli_query($con, $sqlPartners);
	if ($resultPartners && mysqli_num_rows($resultPartners) > 0) {
		while ($row = mysqli_fetch_assoc($resultPartners)) {
			$partners_info[] = $row;
		}
	}
}

// Handle Update About Information
if (isset($_POST['update'])) {
	$text1 = mysqli_real_escape_string($con, $_POST['text1']);
	$text2 = mysqli_real_escape_string($con, $_POST['text2']);
	$description = mysqli_real_escape_string($con, $_POST['description']);

	// Initialize variables for image paths with EXISTING values
	$banner_image = isset($about_info['banner_image']) ? $about_info['banner_image'] : '';
	$main_image = isset($about_info['main_image']) ? $about_info['main_image'] : '';
	$story_image = isset($about_info['story_image']) ? $about_info['story_image'] : '';

	// Handle banner image upload
	if (!empty($_FILES['banner_image']['name'])) {
		$filename = $_FILES['banner_image']['name'];
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

		if (in_array($ext, $allowed)) {
			$unique_name = uniqid() . '.' . $ext;
			$upload_path = "about/" . $unique_name;

			if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $upload_path)) {
				// Delete old banner image if exists
				if (!empty($banner_image) && file_exists("about/" . $banner_image)) {
					unlink("about/" . $banner_image);
				}
				$banner_image = $unique_name;
			}
		}
	}

	// Handle main image upload
	if (!empty($_FILES['main_image']['name'])) {
		$filename = $_FILES['main_image']['name'];
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

		if (in_array($ext, $allowed)) {
			$unique_name = uniqid() . '.' . $ext;
			$upload_path = "about/" . $unique_name;

			if (move_uploaded_file($_FILES['main_image']['tmp_name'], $upload_path)) {
				// Delete old main image if exists
				if (!empty($main_image) && file_exists("about/" . $main_image)) {
					unlink("about/" . $main_image);
				}
				$main_image = $unique_name;
			}
		}
	}

	// Handle story image upload
	if (!empty($_FILES['story_image']['name'])) {
		$filename = $_FILES['story_image']['name'];
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

		if (in_array($ext, $allowed)) {
			$unique_name = uniqid() . '.' . $ext;
			$upload_path = "about/" . $unique_name;

			if (move_uploaded_file($_FILES['story_image']['tmp_name'], $upload_path)) {
				// Delete old story image if exists
				if (!empty($story_image) && file_exists("about/" . $story_image)) {
					unlink("about/" . $story_image);
				}
				$story_image = $unique_name;
			}
		}
	}

	// Check if about record exists
	if (empty($about_info)) {
		// Insert new record
		$sql = "INSERT INTO about_cms (banner_image, main_image, story_image, text1, text2, description) 
                VALUES ('$banner_image', '$main_image', '$story_image', '$text1', '$text2', '$description')";
	} else {
		// Update existing record
		$sql = "UPDATE about_cms SET 
                banner_image = '$banner_image', 
                main_image = '$main_image', 
                story_image = '$story_image', 
                text1 = '$text1', 
                text2 = '$text2', 
                description = '$description' 
                WHERE id = 1";
	}

	$result = mysqli_query($con, $sql);

	// Handle partner images upload
	if ($result && !empty($_FILES['partner_images']['name'][0])) {
		$about_id = empty($about_info) ? mysqli_insert_id($con) : 1;

		// Delete existing partners if we're updating
		if (!empty($about_info)) {
			$deleteSql = "DELETE FROM about_partners WHERE about_id = 1";
			mysqli_query($con, $deleteSql);

			// Delete old partner images
			foreach ($partners_info as $partner) {
				if (!empty($partner['partner_image']) && file_exists("about/partners/" . $partner['partner_image'])) {
					unlink("about/partners/" . $partner['partner_image']);
				}
			}
		}

		// Create partners directory if it doesn't exist
		if (!is_dir("about/partners")) {
			mkdir("about/partners", 0777, true);
		}

		// Process each uploaded partner image
		foreach ($_FILES['partner_images']['name'] as $key => $name) {
			if ($_FILES['partner_images']['error'][$key] === UPLOAD_ERR_OK) {
				$filename = $_FILES['partner_images']['name'][$key];
				$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
				$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

				if (in_array($ext, $allowed)) {
					$unique_name = uniqid() . '.' . $ext;
					$upload_path = "about/partners/" . $unique_name;

					if (move_uploaded_file($_FILES['partner_images']['tmp_name'][$key], $upload_path)) {
						$partner_name = mysqli_real_escape_string($con, $_POST['partner_names'][$key] ?? 'Partner');
						$insertSql = "INSERT INTO about_partners (about_id, partner_image, partner_name) 
                                     VALUES ('$about_id', '$unique_name', '$partner_name')";
						mysqli_query($con, $insertSql);
					}
				}
			}
		}
	}

	if ($result) {
		$_SESSION['success_message'] = "About Information Updated Successfully";
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
										<a class="nav-link active" data-bs-toggle="tab" href="#edit-contact">Edit About Information</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-bs-toggle="tab" href="#view-about">View About Information</a>
									</li>
								</ul>
							</div>
							<div class="card-body">
								<div class="tab-content">
									<!-- Edit Contact Tab -->
									<div id="edit-contact" class="tab-pane fade show active">
										<h4 class="card-title mb-4">Edit About Information</h4>
										<?php echo $error; ?>

										<form method="post" enctype="multipart/form-data">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group mb-3">
														<label>Banner Image</label>
														<input type="file" class="form-control" name="banner_image" accept="image/*">
														<small class="form-text text-muted">Recommended size: 9238x3950 pixels (JPG, PNG, WebP)</small>
														<?php if (!empty($about_info['banner_image'])): ?>
															<div class="logo-preview-container mt-2">
																<p>Current Banner:</p>
																<img src="about/<?php echo $about_info['banner_image']; ?>" class="logo-preview">
															</div>
														<?php endif; ?>
													</div>

													<div class="form-group mb-3">
														<label>Main Image</label>
														<input type="file" class="form-control" name="main_image" accept="image/*">
														<small class="form-text text-muted">Main about us image 1500x1000 Pixels(JPG, PNG, WebP)</small>
														<?php if (!empty($about_info['main_image'])): ?>
															<div class="logo-preview-container mt-2">
																<p>Current Main Image:</p>
																<img src="about/<?php echo $about_info['main_image']; ?>" class="logo-preview">
															</div>
														<?php endif; ?>
													</div>

													<div class="form-group mb-3">
														<label>Title *</label>
														<input type="text" class="form-control" name="text1" value="<?php echo isset($about_info['text1']) ? $about_info['text1'] : ''; ?>" required>
													</div>

													<div class="form-group mb-3">
														<label>Description *</label>
														<textarea class="tinymce form-control" name="description" rows="5" required><?php echo isset($about_info['description']) ? $about_info['description'] : ''; ?></textarea>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group mb-3">
														<label>Story Image</label>
														<input type="file" class="form-control" name="story_image" accept="image/*">
														<small class="form-text text-muted">Our story image 1500x1000 Pixels(JPG, PNG, WebP)</small>
														<?php if (!empty($about_info['story_image'])): ?>
															<div class="logo-preview-container mt-2">
																<p>Current Story Image:</p>
																<img src="about/<?php echo $about_info['story_image']; ?>" class="logo-preview">
															</div>
														<?php endif; ?>
													</div>

													<div class="form-group mb-3">
														<label>Partner Images</label>
														<input type="file" class="form-control" name="partner_images[]" multiple accept="image/*">
														<small class="form-text text-muted">Select multiple partner logos 150x95 Pixels(JPG, PNG, WebP)</small>

														<div id="partnerNamesContainer" class="mt-2">
															<?php if (!empty($partners_info)): ?>
																<?php foreach ($partners_info as $index => $partner): ?>
																	<div class="partner-name-input mb-2">
																		<input type="text" class="form-control" name="partner_names[]"
																			placeholder="Partner Name" value="<?php echo $partner['partner_name']; ?>">
																		<div class="mt-1">
																			<img src="about/partners/<?php echo $partner['partner_image']; ?>" class="logo-preview" style="max-width: 100px;">
																		</div>
																	</div>
																<?php endforeach; ?>
															<?php endif; ?>
														</div>
													</div>

													<div class="form-group mb-3">
														<label>Subtitle *</label>
														<input type="text" class="form-control" name="text2" value="<?php echo isset($about_info['text2']) ? $about_info['text2'] : ''; ?>" required>
													</div>
												</div>
											</div>

											<div class="text-center mt-4">
												<button type="submit" class="btn btn-primary btn-lg" name="update">Update About Information</button>
											</div>
										</form>
									</div>

									<!-- View Contact Tab -->
									<div id="view-about" class="tab-pane fade">
										<h4 class="card-title mb-4">About Information</h4>

										<div class="contact-info-card">
											<?php if (!empty($about_info)): ?>
												<?php if (!empty($about_info['banner_image'])): ?>
													<div class="contact-detail">
														<div class="detail-label">Banner Image</div>
														<div class="detail-value">
															<img src="about/<?php echo $about_info['banner_image']; ?>" class="logo-preview">
														</div>
													</div>
												<?php endif; ?>

												<?php if (!empty($about_info['main_image'])): ?>
													<div class="contact-detail">
														<div class="detail-label">Main Image</div>
														<div class="detail-value">
															<img src="about/<?php echo $about_info['main_image']; ?>" class="logo-preview">
														</div>
													</div>
												<?php endif; ?>

												<?php if (!empty($about_info['story_image'])): ?>
													<div class="contact-detail">
														<div class="detail-label">Story Image</div>
														<div class="detail-value">
															<img src="about/<?php echo $about_info['story_image']; ?>" class="logo-preview">
														</div>
													</div>
												<?php endif; ?>

												<div class="contact-detail">
													<div class="detail-label">Title</div>
													<div class="detail-value"><?php echo $about_info['text1']; ?></div>
												</div>

												<div class="contact-detail">
													<div class="detail-label">Subtitle</div>
													<div class="detail-value"><?php echo $about_info['text2']; ?></div>
												</div>

												<div class="contact-detail">
													<div class="detail-label">Description</div>
													<div class="detail-value"><?php echo $about_info['description']; ?></div>
												</div>

												<?php if (!empty($partners_info)): ?>
													<div class="contact-detail">
														<div class="detail-label">Partners</div>
														<div class="detail-value">
															<div class="row">
																<?php foreach ($partners_info as $partner): ?>
																	<div class="col-md-3 mb-3 text-center">
																		<img src="about/partners/<?php echo $partner['partner_image']; ?>" class="logo-preview" style="max-width: 120px; height: auto;">
																		<div class="mt-1"><?php echo $partner['partner_name']; ?></div>
																	</div>
																<?php endforeach; ?>
															</div>
														</div>
													</div>
												<?php endif; ?>
											<?php else: ?>
												<div class="text-center py-4">
													<p>No about information found. Please add about information.</p>
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
	<script>
		$(document).ready(function() {
			// Handle partner image selection to show name inputs
			$('input[name="partner_images[]"]').on('change', function() {
				const files = this.files;
				const container = $('#partnerNamesContainer');

				// Clear existing inputs (except those with existing images)
				container.find('.partner-name-input').each(function() {
					if ($(this).find('img').length === 0) {
						$(this).remove();
					}
				});

				// Add input for each new file
				for (let i = 0; i < files.length; i++) {
					const inputHtml = `
                <div class="partner-name-input mb-2">
                    <input type="text" class="form-control" name="partner_names[]" 
                           placeholder="Partner Name for ${files[i].name}" required>
                    <small class="text-muted">For: ${files[i].name}</small>
                </div>
            `;
					container.append(inputHtml);
				}
			});
		});
	</script>
</body>

</html>