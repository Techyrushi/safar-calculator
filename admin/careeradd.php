<?php
session_start();
require("config.php");

if (!isset($_SESSION['auser'])) {
    header("location:index");
}

$error = "";
$msg = "";
if (isset($_POST['submit'])) {
    // Sanitize input data
    $position = mysqli_real_escape_string($con, $_POST["position"]);
    $location = mysqli_real_escape_string($con, $_POST["location"]);
    $experience = mysqli_real_escape_string($con, $_POST["experience"]);
    $description = mysqli_real_escape_string($con, $_POST["description"]);
    $roles_responsibilities = ($_POST["roles_responsibilities"]);
    $key_skills = ($_POST["key_skills"]);

    if (empty($position) || empty($location) || empty($experience)) {
        echo "All fields are required.";
    } else {

        $status = 1;
        $stmt = $con->prepare("INSERT INTO tblcareers(position, location, experience, description, roles_responsibilities, key_skills, Is_Active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $position, $location, $experience, $description, $roles_responsibilities, $key_skills, $status);

        $result = $stmt->execute();

        if ($result) {
            $msg = "<p class='alert alert-success msg-box'>New career position added successfully!!</p>";
        } else {
            $error = "<p class='alert alert-danger msg-box'>Something went wrong. Please try again.</p>";
        }
        header("Location: careerview?msg=" . ($msg));
        $stmt->close();
    }
}
?>
<script>
    setTimeout(function() {
        document.querySelectorAll(".msg-box").forEach(function(msgBox) {
            msgBox.style.transition = "opacity 0.5s";
            msgBox.style.opacity = "0";
            setTimeout(() => msgBox.style.display = "none", 500);
        });
    }, 5000);
</script>