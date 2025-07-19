<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "esp";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM pose WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Pose removed"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error deleting pose"]);
    }
}
?>
