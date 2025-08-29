<?php
session_start();
require("config.php");

if (!isset($_SESSION['auser'])) {
	header("location:index");
	exit();
}

// Handle form submission for updating admin data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_admin'])) {
	$id = intval($_POST['admin_id']);
	$name = mysqli_real_escape_string($con, $_POST['name']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$dob = mysqli_real_escape_string($con, $_POST['dob']);
	$contact = mysqli_real_escape_string($con, $_POST['contact']);

	// Update password only if provided
	$password_update = "";
	if (!empty($_POST['password'])) {
		$password = sha1($_POST['password']);
		$password_update = ", apass='$password'";
	}

	$query = "UPDATE admin SET auser='$name', aemail='$email', adob='$dob', aphone='$contact' $password_update WHERE aid=$id";

	if (mysqli_query($con, $query)) {
		$msg = "<div class='alert alert-success msg-box'>Admin Details updated successfully</div>";
		header("Location: adminlist?msg=$msg");
		exit();
	} else {
		$error = "<div class='alert alert-danger msg-box'>Error updating admin: " . mysqli_error($con) . "</div>";
		header("Location: adminlist?msg=$error");
		exit();
	}
}

// Fetch admin data for editing
$admin_data = [];
if (isset($_GET['edit_id'])) {
	$edit_id = intval($_GET['edit_id']);
	$result = mysqli_query($con, "SELECT * FROM admin WHERE aid=$edit_id");
	if ($result && mysqli_num_rows($result) > 0) {
		$admin_data = mysqli_fetch_assoc($result);
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Safar | Admin</title>
		
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
							<h3 class="page-title">Admin</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
								<li class="breadcrumb-item active">Admin</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title mb-3">Admin List</h4>
								<?php
								if (isset($_GET['msg']))
									echo $_GET['msg'];
								?>
							</div>
							<div class="card-body">

								<div class="table-responsive">
									<table class="table table-bordered table-hover dt-responsive nowrap">
										<thead class="text-center">
											<tr style="white-space: nowrap;">
												<th>#</th>
												<th>Username</th>
												<th>Email</th>
												<th>Date Of Birth</th>
												<th>Contact Number</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody class="text-center">
											<?php
											$query = mysqli_query($con, "SELECT * FROM admin");
											$cnt = 1;
											while ($row = mysqli_fetch_assoc($query)) {
											?>
												<tr>
													<td><?php echo $cnt; ?></td>
													<td><?php echo htmlspecialchars($row['auser']); ?></td>
													<td><?php echo htmlspecialchars($row['aemail']); ?></td>
													<td><?php echo htmlspecialchars($row['adob']); ?></td>
													<td><?php echo htmlspecialchars($row['aphone']); ?></td>
													<td style="white-space: nowrap;">
														<button class="btn btn-info edit-btn" data-id="<?php echo $row['aid']; ?>"
															data-name="<?php echo htmlspecialchars($row['auser']); ?>"
															data-email="<?php echo htmlspecialchars($row['aemail']); ?>"
															data-dob="<?php echo htmlspecialchars($row['adob']); ?>"
															data-contact="<?php echo htmlspecialchars($row['aphone']); ?>">
															<i class="fa fa-edit"></i>Edit
														</button>
														<!-- <a href="admindelete?id=<?php echo $row['aid']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this admin?')"><i class="fa fa-trash"></i>&nbsp;Delete</a> -->
													</td>
												</tr>
											<?php
												$cnt++;
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

	<!-- Edit Admin Modal -->
	<div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="editAdminModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editAdminModalLabel">Edit Admin</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method="POST" action="">
					<div class="modal-body">
						<input type="hidden" name="admin_id" id="admin_id">
						<div class="form-group">
							<label for="name">Username<span style="color: red;">*</span></label>
							<input type="text" class="form-control" id="name" name="name" required>
						</div>
						<div class="form-group">
							<label for="email">Email<span style="color: red;">*</span></label>
							<input type="email" class="form-control" id="email" name="email" required>
						</div>
						<div class="form-group">
							<label for="dob">Date of Birth<span style="color: red;">*</span></label>
							<input type="date" class="form-control" id="dob" name="dob" required>
						</div>
						<div class="form-group">
							<label for="contact">Contact Number<span style="color: red;">*</span></label>
							<input type="text" class="form-control" id="contact" name="contact" required>
						</div>
						<div class="form-group password-toggle">
							<label for="password">New Password (Leave blank to keep current)</label>
							<input type="password" class="form-control" id="password" name="password">
							<span class="toggle-password" onclick="togglePassword('password')">
								<i class="fa fa-eye"></i>
							</span>
						</div>
						<div class="form-group password-toggle">
							<label for="confirm_password">Confirm New Password</label>
							<input type="password" class="form-control" id="confirm_password" name="confirm_password">
							<span class="toggle-password" onclick="togglePassword('confirm_password')">
								<i class="fa fa-eye"></i>
							</span>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" name="update_admin" class="btn btn-primary">Save changes</button>
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
			// Initialize DataTable
			$('#adminTable').DataTable({
				responsive: true
			});

			// Handle edit button click
			$('.edit-btn').click(function() {
				var id = $(this).data('id');
				var name = $(this).data('name');
				var email = $(this).data('email');
				var dob = $(this).data('dob');
				var contact = $(this).data('contact');

				$('#admin_id').val(id);
				$('#name').val(name);
				$('#email').val(email);
				$('#dob').val(dob);
				$('#contact').val(contact);

				$('#editAdminModal').modal('show');
			});

			// Form validation
			$('form').submit(function(e) {
				var password = $('#password').val();
				var confirm_password = $('#confirm_password').val();

				if (password !== confirm_password) {
					alert('Passwords do not match!');
					e.preventDefault();
				}
			});
		});

		// Toggle password visibility
		function togglePassword(fieldId) {
			var field = document.getElementById(fieldId);
			var icon = field.nextElementSibling.querySelector('i');

			if (field.type === "password") {
				field.type = "text";
				icon.classList.remove('fa-eye');
				icon.classList.add('fa-eye-slash');
			} else {
				field.type = "password";
				icon.classList.remove('fa-eye-slash');
				icon.classList.add('fa-eye');
			}
		}
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