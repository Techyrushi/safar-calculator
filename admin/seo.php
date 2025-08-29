<?php
session_start();
require("config.php");

if (!isset($_SESSION['auser'])) {
	header("location:index");
}

// Handle form submissions
if (isset($_POST['add_seo'])) {
	$page_type = mysqli_real_escape_string($con, $_POST['page_type']);
	$title = mysqli_real_escape_string($con, $_POST['title']);
	$keywords = mysqli_real_escape_string($con, $_POST['keywords']);
	$description = mysqli_real_escape_string($con, $_POST['description']);

	// Check if page_type already exists
	$check_query = "SELECT * FROM seo_settings WHERE page_type='$page_type'";
	$check_result = mysqli_query($con, $check_query);

	if (mysqli_num_rows($check_result) > 0) {
		$msg = "<div class='alert alert-danger msg-box'>SEO settings for this page type already exist. Please edit the existing entry instead.</div>";
	} else {
		$query = "INSERT INTO seo_settings (page_type, title, keywords, description) VALUES ('$page_type', '$title', '$keywords', '$description')";
		if (mysqli_query($con, $query)) {
			$msg = "<div class='alert alert-success msg-box'>SEO settings added successfully!</div>";
		} else {
			$msg = "<div class='alert alert-danger msg-box'>Error: " . mysqli_error($con) . "</div>";
		}
	}
}


if (isset($_POST['update_seo'])) {
	$id = $_POST['id'];
	$page_type = mysqli_real_escape_string($con, $_POST['page_type']);
	$title = mysqli_real_escape_string($con, $_POST['title']);
	$keywords = mysqli_real_escape_string($con, $_POST['keywords']);
	$description = mysqli_real_escape_string($con, $_POST['description']);

	$query = "UPDATE seo_settings SET page_type='$page_type', title='$title', keywords='$keywords', description='$description' WHERE id='$id'";
	if (mysqli_query($con, $query)) {
		$msg = "<div class='alert alert-success msg-box'>SEO settings updated successfully!</div>";
	} else {
		$msg = "<div class='alert alert-danger msg-box'>Error: " . mysqli_error($con) . "</div>";
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Safar | SEO Settings</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="assets/css/feathericon.min.css">

	<!-- Datatables CSS -->
	<link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="assets/plugins/datatables/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="assets/plugins/datatables/select.bootstrap4.min.css">
	<link rel="stylesheet" href="assets/plugins/datatables/buttons.bootstrap4.min.css">

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
							<h3 class="page-title">SEO Settings</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
								<li class="breadcrumb-item active">SEO Settings</li>
							</ul>
						</div>
						<div class="col-auto">
							<button class="btn btn-primary" data-toggle="modal" data-target="#addSeoModal">
								<i class="fa fa-plus"></i> Add SEO
							</button>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title mb-3">SEO Settings List</h4>
								<?php
								if (isset($msg)) echo $msg;
								?>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="datatable-buttons" class="table table-bordered table-hover dt-responsive nowrap">
										<thead class="text-center">
											<tr style="white-space: nowrap;">
												<th>#</th>
												<th>Page Type</th>
												<th>Title</th>
												<th>Keywords</th>
												<th>Description</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody class="text-center">
											<?php
											$query = mysqli_query($con, "SELECT * FROM seo_settings ORDER BY id");
											$row_count = mysqli_num_rows($query);

											if ($row_count > 0) {
												$cnt = 1;
												while ($row = mysqli_fetch_assoc($query)) {
											?>
													<tr>
														<td><?php echo $cnt; ?></td>
														<td><?php echo ucfirst($row['page_type']); ?></td>
														<td><?php echo $row['title']; ?></td>
														<td><?php echo $row['keywords']; ?></td>
														<td><?php echo substr($row['description'], 0, 50) . '...'; ?></td>
														<td style="white-space: nowrap;">
															<button class="btn btn-sm btn-primary edit-btn"
																data-id="<?php echo $row['id']; ?>"
																data-page_type="<?php echo $row['page_type']; ?>"
																data-title="<?php echo $row['title']; ?>"
																data-keywords="<?php echo $row['keywords']; ?>"
																data-description="<?php echo $row['description']; ?>"
																data-toggle="modal" data-target="#editSeoModal">
																<i class="fa fa-edit"></i> Edit
															</button>
															<a href="seodelete?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this SEO setting?');">
																<i class="fa fa-trash"></i> Delete
															</a>
														</td>
													</tr>
												<?php
													$cnt++;
												}
											} else {
												?>
												<tr>
													<td colspan="6" class="text-center">
														<div class="alert alert-info">No SEO settings found. Click the "Add SEO" button to create new settings.</div>
													</td>
												</tr>
											<?php
											}
											?>
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

	<!-- Add SEO Modal -->
	<div class="modal fade" id="addSeoModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add SEO Settings</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" action="">
					<div class="modal-body">
						<div class="form-group">
							<label>Page Type</label>
							<select class="form-control" name="page_type" required>
								<option value="">Select Page Type</option>
								<option value="home">Home</option>
								<option value="about">About Us</option>
								<option value="packages">Packages</option>
								<option value="contact">Contact Us</option>
							</select>
						</div>
						<div class="form-group">
							<label>Title</label>
							<input type="text" class="form-control" name="title" required>
						</div>
						<div class="form-group">
							<label>Keywords (comma separated)</label>
							<textarea class="form-control" name="keywords" rows="3" required></textarea>
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea class="form-control" name="description" rows="5" required></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" name="add_seo" class="btn btn-primary">Save Changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit SEO Modal -->
	<div class="modal fade" id="editSeoModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit SEO Settings</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="post" action="">
					<input type="hidden" name="id" id="edit_id">
					<div class="modal-body">
						<div class="form-group">
							<label>Page Type</label>
							<select class="form-control" name="page_type" id="edit_page_type" required>
								<option value="">Select Page Type</option>
								<option value="home">Home</option>
								<option value="about">About Us</option>
								<option value="packages">Packages</option>
								<option value="contact">Contact Us</option>
							</select>
						</div>
						<div class="form-group">
							<label>Title</label>
							<input type="text" class="form-control" name="title" id="edit_title" required>
						</div>
						<div class="form-group">
							<label>Keywords (comma separated)</label>
							<textarea class="form-control" name="keywords" id="edit_keywords" rows="3" required></textarea>
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea class="form-control" name="description" id="edit_description" rows="5" required></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" name="update_seo" class="btn btn-primary">Update Changes</button>
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

	<!-- Datatables JS -->
	<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
	<script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
	<script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
	<script src="assets/plugins/datatables/dataTables.select.min.js"></script>
	<script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
	<script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
	<script src="assets/plugins/datatables/buttons.html5.min.js"></script>
	<script src="assets/plugins/datatables/buttons.flash.min.js"></script>
	<script src="assets/plugins/datatables/buttons.print.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js"></script>

	<script>
		$(document).ready(function() {
			// Edit button click handler
			$('.edit-btn').click(function() {
				var id = $(this).data('id');
				var page_type = $(this).data('page_type');
				var title = $(this).data('title');
				var keywords = $(this).data('keywords');
				var description = $(this).data('description');

				$('#edit_id').val(id);
				$('#edit_page_type').val(page_type);
				$('#edit_title').val(title);
				$('#edit_keywords').val(keywords);
				$('#edit_description').val(description);
			});
		});
	</script>
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