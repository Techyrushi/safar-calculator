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

// Handle Add Vehicle
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $fuel_type = mysqli_real_escape_string($con, $_POST['fuel_type']);
    $rate_per_km = mysqli_real_escape_string($con, $_POST['rate_per_km']);
    $capacity = mysqli_real_escape_string($con, $_POST['capacity']);
    $vehicle_type = mysqli_real_escape_string($con, $_POST['vehicle_type']);
    $note = mysqli_real_escape_string($con, $_POST['note']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $display_order = mysqli_real_escape_string($con, $_POST['display_order']);

    $sql = "INSERT INTO vehicles (name, fuel_type, rate_per_km, capacity, vehicle_type, note, is_active, display_order) 
            VALUES ('$name', '$fuel_type', '$rate_per_km', '$capacity', '$vehicle_type', '$note', '$is_active', '$display_order')";

    $result = mysqli_query($con, $sql);
    if ($result) {
        $_SESSION['success_message'] = "Vehicle Added Successfully";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "<p class='alert alert-warning'>Something went wrong. Please try again: " . mysqli_error($con) . "</p>";
    }
}

// Handle Update Vehicle
if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($con, $_POST['vehicle_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $fuel_type = mysqli_real_escape_string($con, $_POST['fuel_type']);
    $rate_per_km = mysqli_real_escape_string($con, $_POST['rate_per_km']);
    $capacity = mysqli_real_escape_string($con, $_POST['capacity']);
    $vehicle_type = mysqli_real_escape_string($con, $_POST['vehicle_type']);
    $note = mysqli_real_escape_string($con, $_POST['note']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $display_order = mysqli_real_escape_string($con, $_POST['display_order']);

    $sql = "UPDATE vehicles SET 
            name = '$name', 
            fuel_type = '$fuel_type', 
            rate_per_km = '$rate_per_km', 
            capacity = '$capacity', 
            vehicle_type = '$vehicle_type', 
            note = '$note', 
            is_active = '$is_active', 
            display_order = '$display_order' 
            WHERE id = '$id'";

    $result = mysqli_query($con, $sql);
    if ($result) {
        $_SESSION['success_message'] = "Vehicle Updated Successfully";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "<p class='alert alert-warning'>Something went wrong. Please try again: " . mysqli_error($con) . "</p>";
    }
}

// Handle Delete Vehicle
if (isset($_GET['delete_vehicle'])) {
    $id = mysqli_real_escape_string($con, $_GET['delete_vehicle']);

    $sql = "DELETE FROM vehicles WHERE id = '$id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $_SESSION['success_message'] = "Vehicle Deleted Successfully";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "<p class='alert alert-warning'>Something went wrong. Please try again: " . mysqli_error($con) . "</p>";
    }
}

// Fetch all vehicles
$vehicles = [];
$sqlVehicles = "SELECT * FROM vehicles ORDER BY display_order, name";
$resultVehicles = mysqli_query($con, $sqlVehicles);
if ($resultVehicles) {
    while ($row = mysqli_fetch_assoc($resultVehicles)) {
        $vehicles[] = $row;
    }
}

// Fetch vehicle for editing if ID is provided
$edit_vehicle = null;
if (isset($_GET['edit_vehicle'])) {
    $id = mysqli_real_escape_string($con, $_GET['edit_vehicle']);
    $sqlEdit = "SELECT * FROM vehicles WHERE id = '$id'";
    $resultEdit = mysqli_query($con, $sqlEdit);
    if ($resultEdit && mysqli_num_rows($resultEdit) > 0) {
        $edit_vehicle = mysqli_fetch_assoc($resultEdit);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Safar | Vehicle Management</title>

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

        .vehicle-info-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .vehicle-detail {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .vehicle-detail:last-child {
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

        .fuel-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            margin-left: 5px;
        }

        .fuel-cng {
            background-color: #28a745;
            color: white;
        }

        .fuel-petrol {
            background-color: #dc3545;
            color: white;
        }

        .fuel-diesel {
            background-color: #6c757d;
            color: white;
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
                            <h3 class="page-title">Vehicle Management</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Vehicles</li>
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
                                        <a class="nav-link <?php echo !isset($_GET['edit_vehicle']) ? 'active' : ''; ?>" data-bs-toggle="tab" href="#add-vehicle"><?php echo isset($_GET['edit_vehicle']) ? 'Edit Vehicle' : 'Add Vehicle'; ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo isset($_GET['edit_vehicle']) ? 'active' : ''; ?>" data-bs-toggle="tab" href="#view-vehicles">View Vehicles</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- Add/Edit Vehicle Tab -->
                                    <div id="add-vehicle" class="tab-pane fade <?php echo !isset($_GET['edit_vehicle']) ? 'show active' : ''; ?>">
                                        <h4 class="card-title mb-4"><?php echo isset($_GET['edit_vehicle']) ? 'Edit Vehicle' : 'Add New Vehicle'; ?></h4>
                                        <?php echo $error; ?>

                                        <form method="post">
                                            <?php if (isset($_GET['edit_vehicle'])): ?>
                                                <input type="hidden" name="vehicle_id" value="<?php echo $edit_vehicle['id']; ?>">
                                            <?php endif; ?>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label>Vehicle Name *</label>
                                                        <input type="text" class="form-control" name="name" value="<?php echo isset($edit_vehicle['name']) ? $edit_vehicle['name'] : ''; ?>" placeholder="e.g., Swift, Fortuner" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>Fuel Type *</label>
                                                        <select class="form-control" name="fuel_type" required>
                                                            <option value="CNG" <?php echo (isset($edit_vehicle['fuel_type']) && $edit_vehicle['fuel_type'] == 'CNG') ? 'selected' : ''; ?>>CNG</option>
                                                            <option value="Petrol" <?php echo (isset($edit_vehicle['fuel_type']) && $edit_vehicle['fuel_type'] == 'Petrol') ? 'selected' : ''; ?>>Petrol</option>
                                                            <option value="Diesel" <?php echo (isset($edit_vehicle['fuel_type']) && $edit_vehicle['fuel_type'] == 'Diesel') ? 'selected' : ''; ?>>Diesel</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>Rate per KM (₹) *</label>
                                                        <input type="number" class="form-control" name="rate_per_km" step="0.01" min="0" value="<?php echo isset($edit_vehicle['rate_per_km']) ? $edit_vehicle['rate_per_km'] : ''; ?>" placeholder="e.g., 12, 14" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label>Capacity *</label>
                                                        <input type="text" class="form-control" name="capacity" value="<?php echo isset($edit_vehicle['capacity']) ? $edit_vehicle['capacity'] : ''; ?>" placeholder="e.g., 4 + Driver" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label>Vehicle Type *</label>
                                                        <input type="text" class="form-control" name="vehicle_type" value="<?php echo isset($edit_vehicle['vehicle_type']) ? $edit_vehicle['vehicle_type'] : ''; ?>" placeholder="e.g., Sedan, SUV, Mini Bus" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label>Display Order *</label>
                                                                <input type="number" class="form-control" name="display_order" value="<?php echo isset($edit_vehicle['display_order']) ? $edit_vehicle['display_order'] : '1'; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group mb-3">
                                                                <label>Status</label>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                                                        value="1" <?php echo (!isset($edit_vehicle['is_active']) || $edit_vehicle['is_active'] == 1) ? 'checked' : ''; ?>>
                                                                    <label class="form-check-label" for="is_active">Active</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Note</label>
                                                <textarea class="form-control" name="note" rows="3" placeholder="Any additional information about this vehicle"><?php echo isset($edit_vehicle['note']) ? $edit_vehicle['note'] : ''; ?></textarea>
                                            </div>

                                            <div class="text-center mt-4">
                                                <?php if (isset($_GET['edit_vehicle'])): ?>
                                                    <button type="submit" class="btn btn-primary btn-lg" name="update">Update Vehicle</button>
                                                    <a href="vehicle_manage" class="btn btn-secondary btn-lg">Cancel</a>
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-primary btn-lg" name="add">Add Vehicle</button>
                                                <?php endif; ?>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- View Vehicles Tab -->
                                    <div id="view-vehicles" class="tab-pane fade <?php echo isset($_GET['edit_vehicle']) ? 'show active' : ''; ?>">
                                        <h4 class="card-title mb-4">All Vehicles</h4>

                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Vehicle Name</th>
                                                        <th>Fuel Type</th>
                                                        <th>Rate/KM</th>
                                                        <th>Capacity</th>
                                                        <th>Vehicle Type</th>
                                                        <th>Status</th>
                                                        <th>Order</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php if (count($vehicles) > 0): ?>
                                                        <?php foreach ($vehicles as $index => $vehicle): ?>
                                                            <tr>
                                                                <td><?php echo $index + 1; ?></td>
                                                                <td><?php echo $vehicle['name']; ?></td>
                                                                <td>
                                                                    <span class="fuel-badge fuel-<?php echo strtolower($vehicle['fuel_type']); ?>">
                                                                        <?php echo $vehicle['fuel_type']; ?>
                                                                    </span>
                                                                </td>
                                                                <td>₹<?php echo $vehicle['rate_per_km']; ?></td>
                                                                <td><?php echo $vehicle['capacity']; ?></td>
                                                                <td><?php echo $vehicle['vehicle_type']; ?></td>
                                                                <td>
                                                                    <?php if ($vehicle['is_active'] == 1): ?>
                                                                        <span class="badge bg-success status-badge">Active</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-danger status-badge">Inactive</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td><?php echo $vehicle['display_order']; ?></td>
                                                                <td class="action-buttons">
                                                                    <a href="?edit_vehicle=<?php echo $vehicle['id']; ?>" class="btn btn-sm btn-info">
                                                                        <i class="fa fa-edit"></i> Edit
                                                                    </a>
                                                                    <a href="?delete_vehicle=<?php echo $vehicle['id']; ?>"
                                                                        title="Delete Vehicle" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this vehicle?')">
                                                                        <i class="fa fa-trash"></i> Delete
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="9" class="text-center">No vehicles found. Add your first vehicle!</td>
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