<?php
session_start();
require("config.php");
////code

if (!isset($_SESSION['auser'])) {
    header("location:index");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Mahalaxmi Construction | Industries Serve</title>

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
                            <h3 class="page-title">View Industries Serve</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">View Industries Serve</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-3">Industries We Serve</h4>
                                <?php
                                if (isset($_GET['msg']))
                                    echo $_GET['msg'];
                                ?>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="homeTable" class="table table-bordered table-hover dt-responsive nowrap">
                                        <thead class="text-center">
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Image 1</th>
                                                <th>Image 2</th>
                                                <th>Subtitle</th>
                                                <th>Content</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php
                                            $query = mysqli_query($con, "SELECT * FROM industries");
                                            $cnt = 1;
                                            if (mysqli_num_rows($query) > 0) {
                                                while ($row = mysqli_fetch_assoc($query)) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $cnt; ?></td>
                                                        <td><?php echo $row['title']; ?></td>
                                                        <td><img src="upload/<?php echo $row['image1']; ?>" height="200px" width="200px"></td>
                                                        <td><img src="upload/<?php echo $row['image2']; ?>" height="200px" width="200px"></td>
                                                        <td><?php echo $row['subtitle']; ?></td>
                                                        <td><?php echo strip_tags(htmlspecialchars_decode($row['descriptions'])); ?></td>
                                                        <td>
                                                            <a href="industry_edit?id=<?php echo $row['id']; ?>">
                                                                <button class="btn btn-info"><i class="fa fa-edit"></i>&nbsp;Edit</button>
                                                            </a>
                                                            <a href="industry_delete?id=<?php echo $row['id']; ?>">
                                                                <button class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Delete</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $cnt++;
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="7" class="text-center" style="color: red; font-weight: bold;">No Data Available</td>
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
    <!-- /Main Wrapper -->


    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

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


    <!-- Slimscroll JS -->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script>
          $(document).ready(function() {
            $('#homeTable').DataTable({
                responsive: true,
                dom: '<"top"Bf>rt<"bottom"lip><"clear">',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });

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