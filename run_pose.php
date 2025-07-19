<?php
header('Content-Type: application/json');
error_reporting(0);

$host = "localhost";
$user = "root";
$pass = "";
$db = "esp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servo1 = $_POST['servo1'];
    $servo2 = $_POST['servo2'];
    $servo3 = $_POST['servo3'];
    $servo4 = $_POST['servo4'];
    $servo5 = $_POST['servo5'];
    $servo6 = $_POST['servo6'];

    // Insert new pose with status=1
    $sql = "INSERT INTO run (servo1, servo2, servo3, servo4, servo5, servo6, status)
            VALUES ('$servo1', '$servo2', '$servo3', '$servo4', '$servo5', '$servo6', 1)";

    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            "status" => "success",
            "message" => "Pose saved and activated"
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error saving pose"]);
    }
}
$conn->close();
?>