<?php
session_start();
require("config.php");

if (!isset($_SESSION['auser'])) {
    header("location:index");
    exit();
}

// Handle form submission for updating career data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_careers'])) {
    $id = intval($_POST['position_id']);
    $position = mysqli_real_escape_string($con, $_POST["position"]);
    $location = mysqli_real_escape_string($con, $_POST["location"]);
    $experience = mysqli_real_escape_string($con, $_POST["experience"]);
    $description = mysqli_real_escape_string($con, $_POST["description"]);
    $roles_responsibilities = mysqli_real_escape_string($con, $_POST["roles_responsibilities"]);
    $key_skills = mysqli_real_escape_string($con, $_POST["key_skills"]);
    $status = mysqli_real_escape_string($con, $_POST["status"]);

    $query = "UPDATE tblcareers SET
              position='$position',
              location='$location',
              experience='$experience',
              description='$description',
              roles_responsibilities='$roles_responsibilities',
              key_skills='$key_skills',
              Is_Active='$status'
              WHERE id=$id";

    if (mysqli_query($con, $query)) {
        $msg = "<div class='alert alert-success msg-box'>Career position updated successfully</div>";
        header("Location: careerview?msg=" . urlencode($msg));
        exit();
    } else {
        $error = "<div class='alert alert-danger msg-box'>Error updating career: " . mysqli_error($con) . "</div>";
        header("Location: careerview?msg=" . urlencode($error));
        exit();
    }
}

// Fetch career data for editing
$careers_data = [];
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $result = mysqli_query($con, "SELECT * FROM tblcareers WHERE id=$edit_id");
    if ($result && mysqli_num_rows($result) > 0) {
        $careers_data = mysqli_fetch_assoc($result);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Mahalaxmi Construction | Careers</title>

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
                            <h3 class="page-title">Career Applications</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Applications</li>
                            </ul>
                        </div>
                        <!-- <div class="col-auto">
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addCareerModal">
                                <i class="fe fe-plus"></i> Add Position
                            </a>
                        </div> -->
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-3">Applications List</h4>
                                <?php
                                if (isset($_GET['msg']))
                                    echo $_GET['msg'];
                                ?>
                            </div>
                            <div class="card-body">
                                <table id="careersTable" class="table table-bordered table-hover">
                                    <thead class="text-center">
                                        <tr>
                                            <th>#</th>
                                            <th class="text-center">Full Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Contact Number</th>
                                            <th class="text-center">Skills</th>
                                            <th class="text-center">Experience</th>
                                            <th class="text-center">Job Position</th>
                                            <th class="text-center">Resume</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php
                                        $query = mysqli_query($con, "SELECT * FROM tblposition");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_assoc($query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td class="text-center"><b><?php echo htmlentities($row['name']); ?></b>
                                                </td>
                                                <td class="text-center"><?php echo htmlentities($row['email']); ?></td>
                                                <td class="text-center"><?php echo htmlentities($row['number']); ?></td>
                                                <td class="text-center"><?php echo htmlentities($row['skill']); ?></td>
                                                <td class="text-center"><?php echo htmlentities($row['experience']); ?>
                                                </td>
                                                <td class="text-center"><?php echo htmlentities($row['job']); ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    $attachment = $row['attachment'];
                                                    if (!empty($attachment)) {
                                                        // Display the download icon with a clickable link
                                                        echo '<a href="http://localhost/mcl_website/' . $attachment . '" target="_blank"><i class="fa fa-download" style="font-size:20px; color: #007bff;"></i></a>';
                                                    } else {
                                                        echo 'No attachment';
                                                    }
                                                    ?>
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

    <!-- Add Career Modal -->
    <div class="modal fade" id="addCareerModal" tabindex="-1" role="dialog" aria-labelledby="addCareerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCareerModalLabel">Add New Career Position</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="careeradd">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="position">Position Title<span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="position" name="position" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Qualification<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="location" name="location" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="experience">Experience Required<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="experience" name="experience" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Job Description<span style="color: red;">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="roles_responsibilities">Roles & Responsibilities<span style="color: red;">*</span></label>
                            <textarea class="form-control" id="roles_responsibilities" name="roles_responsibilities" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="key_skills">Key Skills Required<span style="color: red;">*</span></label>
                            <textarea class="form-control" id="key_skills" name="key_skills" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Add Position</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Career Modal -->
    <div class="modal fade" id="editCareerModal" tabindex="-1" role="dialog" aria-labelledby="editCareerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCareerModalLabel">Edit Career Position</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" name="position_id" id="position_id">
                        <div class="form-group">
                            <label for="edit_position">Position Title<span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="edit_position" name="position" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_location">Qualification<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="edit_location" name="location" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_experience">Experience Required<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="edit_experience" name="experience" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Job Description<span style="color: red;">*</span></label>
                            <textarea class="form-control" id="edit_description" name="description" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_roles">Roles & Responsibilities<span style="color: red;">*</span></label>
                            <textarea class="form-control" id="edit_roles" name="roles_responsibilities" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_skills">Key Skills Required<span style="color: red;">*</span></label>
                            <textarea class="form-control" id="edit_skills" name="key_skills" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="update_careers" class="btn btn-primary">Save Changes</button>
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
            $('#careersTable').DataTable({
                responsive: true,
                dom: '<"top"Bf>rt<"bottom"lip><"clear">',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            // Edit button click handler
            $(document).on('click', '.edit-btn', function() {
                // Get data from button attributes
                var id = $(this).data('id');
                var position = $(this).data('position');
                var location = $(this).data('location');
                var experience = $(this).data('experience');
                var description = $(this).data('description');
                var roles = $(this).data('roles');
                var skills = $(this).data('skills');
                var status = $(this).data('status');

                // Set modal field values
                $('#position_id').val(id);
                $('#edit_position').val(position);
                $('#edit_location').val(location);
                $('#edit_experience').val(experience);
                $('#edit_description').val(description);
                $('#edit_roles').val(roles);
                $('#edit_skills').val(skills);
                $('#edit_status').val(status);

                // Show the modal
                $('#editCareerModal').modal('show');
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