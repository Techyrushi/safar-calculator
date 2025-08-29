<?php
session_start();
require("config.php");

if (!isset($_SESSION['auser'])) {
	header("location:index");
}

// Get counts for dashboard metrics
$enquiries_count = $con->query("SELECT * FROM contacts")->num_rows;
$packages_count = $con->query("SELECT * FROM packages")->num_rows;
$testimonials_count = $con->query("SELECT * FROM testimonials")->num_rows;
$services_count = $con->query("SELECT * FROM services")->num_rows;
$vehicles_count = $con->query("SELECT * FROM vehicles")->num_rows;
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>Safar - Dashboard</title>

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
		:root {
			--primary: #4361ee;
			--secondary: #3f37c9;
			--success: #4cc9f0;
			--info: #4895ef;
			--warning: #f72585;
			--danger: #e63946;
			--light: #f8f9fa;
			--dark: #212529;
			--gradient-primary: linear-gradient(135deg, #4361ee, #3a0ca3);
			--gradient-success: linear-gradient(135deg, #4cc9f0, #4895ef);
			--gradient-warning: linear-gradient(135deg, #f72585, #b5179e);
			--gradient-info: linear-gradient(135deg, #4895ef, #4361ee);
			--gradient-danger: linear-gradient(135deg, #e63946, #f72585);
		}

		body {
			background-color: #f5f7fb;
			color: #495057;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		}

		.page-header {
			background: var(--gradient-primary);
			color: white;
			padding: 25px;
			border-radius: 10px;
			margin-bottom: 25px;
			box-shadow: 0 4px 20px rgba(67, 97, 238, 0.15);
		}

		.page-header .breadcrumb {
			background: transparent;
			margin-bottom: 0;
			padding: 0;
		}

		.page-header .breadcrumb-item a {
			color: rgba(255, 255, 255, 0.8);
		}

		.page-header .breadcrumb-item.active {
			color: white;
		}

		.breadcrumb-item+.breadcrumb-item::before {
			color: rgba(255, 255, 255, 0.5);
		}

		.card {
			border: none;
			border-radius: 12px;
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
			transition: transform 0.3s ease, box-shadow 0.3s ease;
			margin-bottom: 24px;
			overflow: hidden;
		}

		.card:hover {
			transform: translateY(-5px);
			box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
		}

		.stat-card {
			position: relative;
			color: white;
			padding: 20px;
			border-radius: 12px;
			overflow: hidden;
		}

		.stat-card::before {
			content: '';
			position: absolute;
			top: -20px;
			right: -20px;
			width: 100px;
			height: 100px;
			border-radius: 50%;
			background: rgba(255, 255, 255, 0.1);
		}

		.stat-card::after {
			content: '';
			position: absolute;
			bottom: -30px;
			right: -30px;
			width: 120px;
			height: 120px;
			border-radius: 50%;
			background: rgba(255, 255, 255, 0.1);
		}

		.stat-card .card-icon {
			font-size: 28px;
			margin-bottom: 15px;
			opacity: 0.8;
			z-index: 1;
			position: relative;
		}

		.stat-card .card-value {
			font-size: 28px;
			font-weight: 700;
			margin-bottom: 5px;
			z-index: 1;
			position: relative;
		}

		.stat-card .card-label {
			font-size: 14px;
			opacity: 0.9;
			z-index: 1;
			position: relative;
		}

		.bg-gradient-primary {
			background: var(--gradient-primary);
		}

		.bg-gradient-success {
			background: var(--gradient-success);
		}

		.bg-gradient-warning {
			background: var(--gradient-warning);
		}

		.bg-gradient-info {
			background: var(--gradient-info);
		}

		.bg-gradient-danger {
			background: var(--gradient-danger);
		}

		.welcome-text {
			font-size: 1.5rem;
			font-weight: 300;
			margin-bottom: 0.5rem;
		}

		.welcome-subtext {
			font-size: 0.9rem;
			opacity: 0.8;
		}

		.dashboard-section {
			margin-top: 10px;
		}

		.section-title {
			font-size: 1.25rem;
			font-weight: 600;
			margin-bottom: 20px;
			color: var(--dark);
			position: relative;
			padding-bottom: 10px;
		}

		.section-title::after {
			content: '';
			position: absolute;
			bottom: 0;
			left: 0;
			width: 50px;
			height: 3px;
			background: var(--primary);
			border-radius: 3px;
		}

		.quick-actions {
			background: white;
			padding: 25px;
			border-radius: 12px;
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
		}

		.action-item {
			display: flex;
			align-items: center;
			padding: 15px;
			border-radius: 8px;
			margin-bottom: 15px;
			background: #f8f9fa;
			transition: all 0.3s ease;
		}

		.action-item:hover {
			background: var(--primary);
			color: white;
			transform: translateX(5px);
		}

		.action-item:hover .action-icon {
			background: rgba(255, 255, 255, 0.2);
			color: white;
		}

		.action-icon {
			width: 50px;
			height: 50px;
			border-radius: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
			margin-right: 15px;
			font-size: 20px;
			background: white;
			color: var(--primary);
			box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
			transition: all 0.3s ease;
		}

		.action-text h5 {
			margin-bottom: 0;
			font-size: 16px;
			font-weight: 600;
		}

		.action-text p {
			margin-bottom: 0;
			font-size: 13px;
			opacity: 0.8;
		}

		@media (max-width: 767.98px) {
			.page-header {
				padding: 15px;
			}

			.welcome-text {
				font-size: 1.25rem;
			}

			.stat-card .card-value {
				font-size: 24px;
			}
		}
	</style>
</head>

<body>

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<?php include("header.php"); ?>
		<!-- /Header -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content container-fluid">

				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<h3 class="welcome-text">Welcome Admin!</h3>
							<p class="welcome-subtext">Here's what's happening with your business today.</p>
							<ul class="breadcrumb">
								<li class="breadcrumb-item active">Dashboard</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<!-- Stats Cards -->
				<div class="row">
					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card stat-card bg-gradient-primary">
							<div class="card-body">
								<div class="card-icon">
									<i class="fe fe-users"></i>
								</div>
								<div class="card-value"><?php echo $enquiries_count; ?></div>
								<div class="card-label">Total Enquiries</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card stat-card bg-gradient-success">
							<div class="card-body">
								<div class="card-icon">
									<i class="fe fe-table"></i>
								</div>
								<div class="card-value"><?php echo $packages_count; ?></div>
								<div class="card-label">Total Packages</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card stat-card bg-gradient-warning">
							<div class="card-body">
								<div class="card-icon">
									<i class="fe fe-user"></i>
								</div>
								<div class="card-value"><?php echo $testimonials_count; ?></div>
								<div class="card-label">Total Testimonials</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card stat-card bg-gradient-info">
							<div class="card-body">
								<div class="card-icon">
									<i class="fe fe-home"></i>
								</div>
								<div class="card-value"><?php echo $services_count; ?></div>
								<div class="card-label">Total Services</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xl-3 col-sm-6 col-12">
						<div class="card stat-card bg-gradient-danger">
							<div class="card-body">
								<div class="card-icon">
									<i class="fe fe-car"></i>
								</div>
								<div class="card-value"><?php echo $vehicles_count; ?></div>
								<div class="card-label">Total Vehicles</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Stats Cards -->

				<!-- Quick Actions Section -->
				<div class="row dashboard-section">
					<div class="col-md-12">
						<div class="quick-actions">
							<h4 class="section-title">Quick Actions</h4>
							<div class="row">
								<div class="col-md-6 col-lg-3">
									<a href="add-package" class="action-item">
										<div class="action-icon">
											<i class="fe fe-table"></i>
										</div>
										<div class="action-text">
											<h5>Manage Packages</h5>
											<p>Add or edit tour packages</p>
										</div>
									</a>
								</div>
								<div class="col-md-6 col-lg-3">
									<a href="vehicle_manage" class="action-item">
										<div class="action-icon">
											<i class="fe fe-car"></i>
										</div>
										<div class="action-text">
											<h5>Manage Vehicles</h5>
											<p>Update vehicle details</p>
										</div>
									</a>
								</div>
								<div class="col-md-6 col-lg-3">
									<a href="homeadd#services" class="action-item">
										<div class="action-icon">
											<i class="fe fe-home"></i>
										</div>
										<div class="action-text">
											<h5>Manage Services</h5>
											<p>Edit available services</p>
										</div>
									</a>
								</div>
								<div class="col-md-6 col-lg-3">
									<a href="homeadd#testimonials" class="action-item">
										<div class="action-icon">
											<i class="fe fe-user"></i>
										</div>
										<div class="action-text">
											<h5>Manage Testimonials</h5>
											<p>View customer feedback</p>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Quick Actions Section -->

			</div>
		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="assets/js/jquery-3.2.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- Slimscroll JS -->
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js"></script>

</body>

</html>