# robot-arm-control-panel


## Introduction
This project provides a simple interface to control the movements of a robot arm equipped with six servos. Using sliders, users can adjust the position of each motor. Additionally, users can save specific positions (poses) to a database, load them later, or even remove them as needed. The control panel uses PHP for server-side logic (e.g., saving/loading poses) and JavaScript for client-side interactions.

## Features
Motor Sliders: Control the position of each of the 6 motors (servo motors) with sliders, each ranging from 0° to 180°.

Save Pose: Save the current servo positions to a database for later use.

Load Pose: Load a previously saved pose from the database and apply it to the robot arm.

Reset: Reset the robot arm to its default position.

Real-time Control: Adjust the sliders and instantly send commands to the ESP controller to move the robot arm.

Saved Poses Table: A table displays saved poses with options to load or remove them.

## Technologies Used
HTML: For structuring the web interface.

CSS: For styling the control panel and making it responsive.

JavaScript: For interacting with the sliders, buttons, and dynamically updating the UI.

PHP: To handle server-side logic, including saving/loading poses from the database.

MySQL: Used for storing the saved poses in a database.
--
and here is index screenshot

<img width="969" height="866" alt="image" src="https://github.com/user-attachments/assets/dac029c6-6366-4ad3-829a-b9abd8742874" />
