<?php
include 'save_pose.php';

// Fetch all saved poses from DB
$result = $conn->query("SELECT * FROM pose");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Robot Arm Control Panel</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <h2>Robot Arm Control Panel</h2>

        <!-- Control buttons at the top -->
        <div class="button-group">
            <button id="savePoseButton">Save Pose</button>
            <button id="resetButton">Reset</button>
            <button id="runButton">Run</button>
        </div>

        <!-- Motor sliders -->
        <div class="control-panel">
            <div class="slidecontainer">
                <label>Motor 1:</label>
                <input type="range" min="1" max="180" value="90" class="slider" id="Servo1D">
                <span id="demo1">90</span>
            </div>

            <div class="slidecontainer">
                <label>Motor 2:</label>
                <input type="range" min="1" max="180" value="90" class="slider" id="Servo2D">
                <span id="demo2">90</span>
            </div>

            <div class="slidecontainer">
                <label>Motor 3:</label>
                <input type="range" min="1" max="180" value="90" class="slider" id="Servo3D">
                <span id="demo3">90</span>
            </div>

            <div class="slidecontainer">
                <label>Motor 4:</label>
                <input type="range" min="1" max="180" value="90" class="slider" id="Servo4D">
                <span id="demo4">90</span>
            </div>

            <div class="slidecontainer">
                <label>Motor 5:</label>
                <input type="range" min="1" max="180" value="90" class="slider" id="Servo5D">
                <span id="demo5">90</span>
            </div>

            <div class="slidecontainer">
                <label>Motor 6:</label>
                <input type="range" min="1" max="180" value="90" class="slider" id="Servo6D">
                <span id="demo6">90</span>
            </div>
        </div>

        <!-- Table for Saved Poses -->
        <div class="saved-poses">
            <h3>Saved Poses:</h3>
            <table id="poseTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Motor 1</th>
                        <th>Motor 2</th>
                        <th>Motor 3</th>
                        <th>Motor 4</th>
                        <th>Motor 5</th>
                        <th>Motor 6</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr id='poseRow_".$row["id"]."'>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["servo1"] . "</td>
                                <td>" . $row["servo2"] . "</td>
                                <td>" . $row["servo3"] . "</td>
                                <td>" . $row["servo4"] . "</td>
                                <td>" . $row["servo5"] . "</td>
                                <td>" . $row["servo6"] . "</td>
                                <td class='action-buttons'>
                                    <button class='loadBtn' data-id='".$row["id"]."'>Load</button>
                                    <button class='removeBtn' data-id='".$row["id"]."'>Remove</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No saved poses yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="j.js"></script>
</body>
</html>