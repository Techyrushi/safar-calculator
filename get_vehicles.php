<?php
// get_vehicles.php
require("config.php");

header('Content-Type: application/json');

$sql = "SELECT * FROM vehicles WHERE is_active = 1 ORDER BY display_order, name";
$result = mysqli_query($con, $sql);

$vehicles = [];
if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    // Convert database format to frontend format
    $vehicles[] = [
      'id' => strtolower(str_replace(' ', '_', $row['name'])) . '_' . strtolower($row['fuel_type']),
      'name' => $row['name'],
      'fuel' => $row['fuel_type'],
      'rate' => floatval($row['rate_per_km']),
      'capacity' => $row['capacity']
    ];
  }
}

echo json_encode($vehicles);
?>