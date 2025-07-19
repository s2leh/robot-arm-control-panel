document.addEventListener('DOMContentLoaded', function () {
    // Function to update slider display values
    function updateSliderValue(sliderId, spanId) {
        var slider = document.getElementById(sliderId);
        var output = document.getElementById(spanId);
        output.innerHTML = slider.value;

        slider.oninput = function() {
            output.innerHTML = this.value;
        };
    }

    // Initialize all sliders
    updateSliderValue("Servo1D", "demo1");
    updateSliderValue("Servo2D", "demo2");
    updateSliderValue("Servo3D", "demo3");
    updateSliderValue("Servo4D", "demo4");
    updateSliderValue("Servo5D", "demo5");
    updateSliderValue("Servo6D", "demo6");

    // Reset button - set all sliders to 90
    document.getElementById('resetButton').addEventListener('click', function() {
        const sliders = [
            { sliderId: 'Servo1D', spanId: 'demo1' },
            { sliderId: 'Servo2D', spanId: 'demo2' },
            { sliderId: 'Servo3D', spanId: 'demo3' },
            { sliderId: 'Servo4D', spanId: 'demo4' },
            { sliderId: 'Servo5D', spanId: 'demo5' },
            { sliderId: 'Servo6D', spanId: 'demo6' }
        ];

        sliders.forEach(function(slider) {
            document.getElementById(slider.sliderId).value = 90;
            document.getElementById(slider.spanId).innerHTML = 90;
        });
    });

    // Save Pose button
    document.getElementById('savePoseButton').addEventListener('click', function(e) {
        e.preventDefault();
        
        const poseData = {
            servo1: document.getElementById('Servo1D').value,
            servo2: document.getElementById('Servo2D').value,
            servo3: document.getElementById('Servo3D').value,
            servo4: document.getElementById('Servo4D').value,
            servo5: document.getElementById('Servo5D').value,
            servo6: document.getElementById('Servo6D').value
        };

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_pose.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    alert(response.message);
                    if (response.status === 'success') {
                        location.reload();
                    }
                } catch (e) {
                    alert("Error parsing response: " + e.message);
                }
            } else {
                alert("Request failed: " + xhr.status);
            }
        };
        xhr.onerror = function() {
            alert("Request failed");
        };
        xhr.send(new URLSearchParams(poseData).toString());
    });

    // Run Pose button (updated sequence)
    document.getElementById('runButton').addEventListener('click', function(e) {
        e.preventDefault();
        const runBtn = e.target;
        runBtn.disabled = true;
        runBtn.textContent = 'Running...';

        const poseData = {
            servo1: document.getElementById('Servo1D').value,
            servo2: document.getElementById('Servo2D').value,
            servo3: document.getElementById('Servo3D').value,
            servo4: document.getElementById('Servo4D').value,
            servo5: document.getElementById('Servo5D').value,
            servo6: document.getElementById('Servo6D').value
        };

        // 1. First reset all statuses to 0
        const xhrReset = new XMLHttpRequest();
        xhrReset.open('POST', 'update_status.php', true);
        xhrReset.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhrReset.onload = function() {
            if (xhrReset.status === 200) {
                try {
                    const resetResponse = JSON.parse(xhrReset.responseText);
                    if (resetResponse.status === 'success') {
                        // 2. Then insert new pose with status=1
                        const xhrRun = new XMLHttpRequest();
                        xhrRun.open('POST', 'run_pose.php', true);
                        xhrRun.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhrRun.onload = function() {
                            runBtn.disabled = false;
                            runBtn.textContent = 'Run';
                            
                            if (xhrRun.status === 200) {
                                try {
                                    const runResponse = JSON.parse(xhrRun.responseText);
                                    alert(runResponse.message);
                                    if (runResponse.status === 'success') {
                                        location.reload();
                                    }
                                } catch (e) {
                                    alert("Error parsing response: " + e.message);
                                }
                            } else {
                                alert("Request failed: " + xhrRun.status);
                            }
                        };
                        xhrRun.onerror = function() {
                            runBtn.disabled = false;
                            runBtn.textContent = 'Run';
                            alert("Request failed");
                        };
                        xhrRun.send(new URLSearchParams(poseData).toString());
                    } else {
                        runBtn.disabled = false;
                        runBtn.textContent = 'Run';
                        alert(resetResponse.message);
                    }
                } catch (e) {
                    runBtn.disabled = false;
                    runBtn.textContent = 'Run';
                    alert("Error parsing response: " + e.message);
                }
            } else {
                runBtn.disabled = false;
                runBtn.textContent = 'Run';
                alert("Request failed: " + xhrReset.status);
            }
        };
        xhrReset.onerror = function() {
            runBtn.disabled = false;
            runBtn.textContent = 'Run';
            alert("Request failed");
        };
        xhrReset.send();
    });

    // Load Pose button
    document.querySelectorAll('.loadBtn').forEach(button => {
        button.addEventListener('click', function() {
            const poseId = this.getAttribute('data-id');
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_pose.php?id=' + poseId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const pose = JSON.parse(xhr.responseText);
                        if (pose.status === 'error') {
                            throw new Error(pose.message);
                        }
                        
                        // Update sliders and displays
                        document.getElementById('Servo1D').value = pose.servo1;
                        document.getElementById('demo1').innerHTML = pose.servo1;
                        document.getElementById('Servo2D').value = pose.servo2;
                        document.getElementById('demo2').innerHTML = pose.servo2;
                        document.getElementById('Servo3D').value = pose.servo3;
                        document.getElementById('demo3').innerHTML = pose.servo3;
                        document.getElementById('Servo4D').value = pose.servo4;
                        document.getElementById('demo4').innerHTML = pose.servo4;
                        document.getElementById('Servo5D').value = pose.servo5;
                        document.getElementById('demo5').innerHTML = pose.servo5;
                        document.getElementById('Servo6D').value = pose.servo6;
                        document.getElementById('demo6').innerHTML = pose.servo6;
                    } catch (e) {
                        alert("Error loading pose: " + e.message);
                    }
                } else {
                    alert("Request failed: " + xhr.status);
                }
            };
            xhr.onerror = function() {
                alert("Request failed");
            };
            xhr.send();
        });
    });

    // Remove Pose button
    document.querySelectorAll('.removeBtn').forEach(button => {
        button.addEventListener('click', function() {
            if (!confirm('Are you sure you want to delete this pose?')) return;
            
            const poseId = this.getAttribute('data-id');
            const row = document.getElementById('poseRow_' + poseId);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'remove_pose.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            row.remove();
                        } else {
                            alert(response.message);
                        }
                    } catch (e) {
                        alert("Error parsing response: " + e.message);
                    }
                } else {
                    alert("Request failed: " + xhr.status);
                }
            };
            xhr.onerror = function() {
                alert("Request failed");
            };
            xhr.send('id=' + poseId);
        });
    });
});