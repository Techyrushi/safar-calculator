<?php
require("config.php");
////code

if (!isset($_SESSION['auser'])) {
	header("location:index");
}
?>
<div class="header">

	<!-- Logo -->
	<div class="header-left">
		<a href="dashboard" class="logo">
			<img src="assets/img/logo.png" alt="Logo">
		</a>
		<a href="dashboard" class="logo logo-small">
			<img src="assets/img/logo.png" alt="Logo" width="30" height="30">
		</a>
	</div>
	<!-- /Logo -->

	<a href="javascript:void(0);" id="toggle_btn">
		<i class="fe fe-text-align-left"></i>
	</a>



	<!-- Mobile Menu Toggle -->
	<a class="mobile_btn" id="mobile_btn">
		<i class="fa fa-bars"></i>
	</a>
	<!-- /Mobile Menu Toggle -->

	<!-- Header Right Menu -->
	<ul class="nav user-menu">


		<!-- User Menu -->
		<!-- <h4 style="color:white;margin-top:13px;text-transform:capitalize;"><?php echo $_SESSION['auser']; ?></h4> -->
		<li class="nav-item dropdown app-dropdown">
			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
				<span class="user-img"><img class="rounded-circle" src="assets/img/profiles/avatar-01.png" width="31" alt="Ryan Taylor"></span>
			</a>

			<div class="dropdown-menu">
				<div class="user-header">
					<div class="avatar avatar-sm">
						<img src="assets/img/profiles/avatar-01.png" alt="User Image" class="avatar-img rounded-circle">
					</div>
					<div class="user-text">
						<h5><?php echo $_SESSION['auser']; ?></h5>
						<p class="text-muted mb-0">Administrator</p>
					</div>
				</div>
				<a class="dropdown-item" href="profile" style="font-size: 16px;">Profile</a>
				<a class="dropdown-item" href="logout" style="font-size: 16px;">Logout</a>
			</div>
		</li>

		<!-- /User Menu -->

	</ul>
	<!-- /Header Right Menu -->

</div>

<!-- header --->



<!-- Sidebar -->
<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				<li class="menu-title">
					<span>Main</span>
				</li>
				<li>
					<a href="dashboard" style="font-size: 18px;"><i class="fe fe-home"></i> <span>Dashboard</span></a>
				</li>

				<!-- <li class="menu-title">
								<span>Authentication</span>
							</li>

							<li class="submenu">
								<a href="#"><i class="fe fe-user"></i> <span> Authentication </span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="index"> Login </a></li>
									<li><a href="register"> Register </a></li>

								</ul>
							</li> -->

				<li class="menu-title">
					<span>Home</span>
				</li>
				<li class="submenu">
					<a href="#" style="font-size: 18px;"><i class="fe fe-browser"></i> <span> Home Page </span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="homeadd" style="font-size: 16px;"> Add Home Content</a></li>
						<li><a href="industry_view" style="font-size: 16px;"> View Industries Served</a></li>
						<li><a href="construction_view" style="font-size: 16px;">View Mahalaxmi Work</a></li>
						<li><a href="projects_view" style="font-size: 16px;"> View Featured Projects</a></li>
					</ul>
				</li>

				<li class="menu-title">
					<span>About</span>
				</li>
				<li class="submenu">
					<a href="#" style="font-size: 18px;"><i class="fe fe-activity"></i> <span> About Page </span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="aboutadd" style="font-size: 16px;"> Add About Content </a></li>
						<li><a href="aboutview" style="font-size: 16px;"> View About </a></li>
					</ul>
				</li>

				<!-- <li class="menu-title">
					<span>State & City</span>
				</li> -->

				<!-- <li class="submenu">
					<a href="#"><i class="fe fe-location"></i> <span>State & City</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="stateadd"> State </a></li>
						<li><a href="cityadd"> City </a></li>
					</ul>
				</li> -->

				<li class="menu-title">
					<span>Projects Manage</span>
				</li>
				<li class="submenu">
					<a href="#" style="font-size: 18px;"><i class="fe fe-map"></i> <span> Featured Projects</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="propertyadd" style="font-size: 16px;"> Add Projects</a></li>
						<li><a href="propertyview" style="font-size: 16px;"> View Projects </a></li>
					</ul>
				</li>

				<li class="menu-title">
					<span>Sectors</span>
				</li>
				<li class="submenu">
					<a href="#" style="font-size: 18px;"><i class="fe fe-bookmark"></i> <span> Sectors Page </span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="aboutadd" style="font-size: 16px;"> Add Sectors Content </a></li>
						<li><a href="aboutview" style="font-size: 16px;"> View Sectors </a></li>
					</ul>
				</li>

				<li class="menu-title">
					<span>Careers</span>
				</li>
				<li class="submenu">
					<a href="#" style="font-size: 18px;"><i class="fe fe-folder"></i> <span> Careers Page </span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="careerview" style="font-size: 16px;"> View Career Details </a></li>
						<li><a href="applicants" style="font-size: 16px;"> View Applications </a></li>
					</ul>
				</li>

				<li class="menu-title">
					<span>Query</span>
				</li>
				<li class="submenu">
					<a href="#" style="font-size: 18px;"><i class="fe fe-comment"></i> <span> Contact  Manage</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="contactview" style="font-size: 16px;"> Contact</a></li>
						<!-- <li><a href="feedbackview" style="font-size: 16px;"> Feedback </a></li> -->
					</ul>
				</li>

				<li class="menu-title">
					<span>SEO Settings</span>
				</li>
				<li class="submenu">
					<a href="#" style="font-size: 18px;"><i class="fe fe-globe"></i> <span> SEO Settings </span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="seo" style="font-size: 16px;"> Add SEO Data</a></li>
					</ul>
				</li>

				<li class="menu-title">
					<span>Admin Settings</span>
				</li>

				<li class="submenu">
					<a href="#" style="font-size: 18px;"><i class="fe fe-user"></i> <span>Admin Settings</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="adminlist" style="font-size: 16px;"> Admin </a></li>
						<!-- <li><a href="userlist"> Users </a></li>
									<li><a href="useragent"> Agent </a></li>
									<li><a href="userbuilder"> Builder </a></li> -->
					</ul>
				</li>

			</ul>
		</div>
	</div>
</div>
<!-- /Sidebar -->