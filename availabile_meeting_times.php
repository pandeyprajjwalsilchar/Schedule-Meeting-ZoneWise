<?php
include("connect.php");

$sql = "SELECT * FROM zoneresponsess";  
$result = $conn->query($sql);

$meetings = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $meetings[] = [
            'Name' => $row['Name'], 
            'emp_id' => $row['Employee_ID'],
            'Zone' => $row['Zone'], 
            'Start_time' => $row['Start_time'], 
            'End_time' => $row['End_time']
        ];
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($meetings);
?>
