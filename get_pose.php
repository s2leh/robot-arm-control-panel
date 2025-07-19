<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "esp";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM pose WHERE id = $id");
    if ($result->num_rows > 0) {
        $pose = $result->fetch_assoc();
        echo json_encode($pose); // Return pose as JSON
    } else {
        echo json_encode(["status" => "error", "message" => "Pose not found"]);
    }
}
?>
