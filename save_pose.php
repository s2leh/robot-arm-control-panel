<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "esp";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servo1 = $_POST['servo1'] ?? null;
    $servo2 = $_POST['servo2'] ?? null;
    $servo3 = $_POST['servo3'] ?? null;
    $servo4 = $_POST['servo4'] ?? null;
    $servo5 = $_POST['servo5'] ?? null;
    $servo6 = $_POST['servo6'] ?? null;

    if ($servo1 && $servo2 && $servo3 && $servo4 && $servo5 && $servo6) {
        $sql = "INSERT INTO pose (servo1, servo2, servo3, servo4, servo5, servo6)
                VALUES ('$servo1', '$servo2', '$servo3', '$servo4', '$servo5', '$servo6')";
        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Pose saved!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "DB Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing one or more servo values"]);
    }
}
?>
