<?php
header('Content-Type: application/json');
error_reporting(0);

$host = "localhost";
$user = "root";
$pass = "";
$db = "esp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "DB connection failed"]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Simply reset all statuses to 0
    if ($conn->query("UPDATE run SET status = 0")) {
        echo json_encode(["status" => "success", "message" => "All statuses reset to 0"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to reset statuses"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
$conn->close();
?>