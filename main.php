<?php 
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Meetings</title>
    <link rel="icon" href="meeting.png" type="image/png">
    <link rel="stylesheet" href="main.css">
    <!-- <script src="mainApp.js"></script> -->
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- <link rel="stylesheet" href="https://pyscript.net/alpha/pyscript.css" /> -->
    <!-- <script defer src="https://pyscript.net/alpha/pyscript.js"></script> -->

    <!-- <script type="module" src="https://pyscript.net/releases/2024.1.1/core.js"></script> -->
    <!-- <style>
        #loading { 
            outline: none;
            border: none;
            background: rgba(0, 0, 0, 0.7); 
            color: white;
            font-size: 24px;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); 
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
    </style>
<script type="module">
    document.addEventListener('DOMContentLoaded', () => {
        const loading = document.getElementById('loading');
        
        if (loading) {
            loading.showModal(); // Use showModal for dialogs
            console.log('Loading dialog shown');

            document.addEventListener('py:ready', () => {
                loading.close(); // Close the loading dialog when PyScript is ready
                console.log('PyScript is ready. Loading dialog closed.');
            });
        } else {
            console.error('Loading dialog element not found');
        }
    });
</script> -->
    <style>
        #export-schedule:disabled {
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <!-- <dialog id="loading">
        <h1>Loading...</h1>
    </dialog> -->

    <div class="container">
        <div class="left-half">
            <h2>Meeting Scheduler</h2>
            <form action="" method="POST">
                <div class="input-group">
                    <label for="participant-name">Participant Name</label>
                    <textarea id="participant-name" class="input-field" placeholder="Enter participant name" name="Name" required></textarea>
                </div>
                <div class="input-group">
                    <label for="Employee-id">Employee ID</label>
                    <textarea id="Employee-id" class="input-field" placeholder="Enter ID" name="Empy" required></textarea>
                </div>

                <div class="input-group">
                    <label for="timezone-input">Your Time Zone</label>
                        <select id="timezone-input" class="input-field" name="Zone" required>
                            <option value="" select>--Choose a Location--</option>
                            <option value="America/Chicago">Chicago (CST)</option>
                            <option value="America/Denver">Denver (MST)</option>
                            <option value="Asia/Hong_Kong">Hong Kong (HKT)</option>
                            <option value="Asia/Kolkata">Kolkata (IST)</option>
                            <option value="Europe/London">London (GMT)</option>
                            <option value="America/Los_Angeles">Los Angeles (PST)</option>
                            <option value="America/New_York">New York (EST)</option>
                            <option value="Asia/Singapore">Singapore (SGT)</option>
                            <option value="Australia/Sydney">Sydney (AEDT)</option>
                            <option value="Asia/Tokyo">Tokyo (JST)</option>
                    </select>
                </div>
                
                <div class="input-group">
                    <label for="availability">Your Availability</label>
                    <input type="time" id="start-time" class="input-field" placeholder="Start Time" name="Start" required>
                    <input type="time" id="end-time" class="input-field" placeholder="End Time" name="End" required>
                </div>

                <button id="add-participant-btn" class="button" name="Add_participant">Add Participant</button>
                <button id="suggest-meeting" class="button">Suggest Meeting Times</button>
            </form>
                

                <div id="suggested-times" class="meeting-suggestions">
                    <h3>Suggested Meeting Times</h3>
                    <ul id="meeting-list">
                        <!-- Enterd timing suggestions -->
                    </ul>
                </div>
                
                <div id="analysis-results" class="analyze-results" style="font-size: 25px;">
                <!-- our analysis will reflect here -->
                </div>
                <div id="heatmap"></div>
        
                <!-- Calendar Sync/Export -->
                <div class="input-group">
                    <button id="our-analysis" class="button">Our Analysis</button>
                    <button id="sync-google" class="button">Sync with Google Calendar</button>
                    <button id="export-schedule" class="button" disabled>Export as File</button>
                </div>
        </div>

        <!-- Embedded webpage on the right -->
        <div class="embedded-content">
            <iframe src="index.php" frameborder="0"></iframe>
        </div>

    </div>
</body>

<script>
    let timePairs = [];
    document.getElementById('suggest-meeting').addEventListener('click', function(event) {
        event.preventDefault();  // Prevent the default form submission

        fetch('availabile_meeting_times.php') 
            .then(response => response.json())
            .then(data => {
                const meetingList = document.getElementById('meeting-list');
                meetingList.innerHTML = '';
                timePairs = [];

                data.forEach(meeting => {
                    const li = document.createElement('li');
                    li.textContent = `${meeting.Name}, ${meeting.emp_id} from zone ${meeting.Zone} meeting on ${meeting.Start_time} to ${meeting.End_time}`;
                    meetingList.appendChild(li);
                    timePairs.push([meeting.Start_time, meeting.End_time]);
                });

                // console.log(typeof(timePairs[0][0]));
                console.log(typeof(timePairs));
                console.log(timePairs);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });


// --------------------------our-analysis----------------------

document.getElementById('our-analysis').addEventListener('click', function(event) {
    event.preventDefault();

    fetch('PhpWithPy.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ timePairs: timePairs })
    })
    .then(response => response.json())
    .then(result => {
        const resultContainer = document.getElementById('analysis-results');
        resultContainer.innerHTML = '';
        const section = document.createElement('section');
        section.innerHTML = '<h4>Available Time Intervals</h4>';

        if (result.optimal_times && result.plot_data) {
            result.optimal_times.forEach(intervals => {
                const ul = document.createElement('ul');
                const li = document.createElement('li');
                li.textContent = `${intervals[0]} - ${intervals[1]}`;
                ul.appendChild(li);
                section.appendChild(ul);
            });
            resultContainer.appendChild(section);

            // Render the heatmap
            Plotly.newPlot('heatmap', result.plot_data.data, result.plot_data.layout);
            const exportButton = document.getElementById('export-schedule');
            exportButton.disabled = false;  // Enable the export button
        } else {
            resultContainer.innerHTML = '<p>Unexpected response format.</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error); 
    });
});

document.getElementById('export-schedule').addEventListener('click', function() {
    // Trigger the download by redirecting to the PHP endpoint
    window.location.href = 'download_ics.php';
});
</script>
</html>

<?php
include("connect.php");

    if(isset($_POST['Add_participant']))
    {
        $Name = $_POST['Name'];
        $emp_id = $_POST['Empy'];
        $Zone = $_POST['Zone'];
        $Start_time = $_POST['Start'];
        $End_time = $_POST['End'];

        if (empty($Name) || empty($Zone) || empty($Start_time) || empty($End_time) || empty($emp_id)) {
            echo "All fields are required.";
            exit();
        }
        
        $query = "INSERT INTO zoneresponsess (Name, Employee_ID, Zone, Start_time, End_time) VALUES('$Name', '$emp_id', '$Zone', '$Start_time', '$End_time')";

        $data = mysqli_query($conn, $query);
        if($data){
            // echo "Participant added successfully!";
        }
        else{
            echo "Error: " .mysqli_error($conn);
        }
    }
?>
