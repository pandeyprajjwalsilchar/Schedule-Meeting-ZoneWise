<?php
// Function to format date to ICS format
function formatDateToICS($dateStr) {
    // Convert 12-hour format to 24-hour format and then format to ICS format
    return date('Ymd\THis\Z', strtotime($dateStr));
}

// Retrieve the time intervals from your analysis (assuming this data is passed to PHP)
$jsonData = file_get_contents('data.json');
// Decode the JSON data into an associative array
$data = json_decode($jsonData, true);
// Initialize an empty array to hold the intervals
$intervals = [];

if (isset($data['optimal_times'])) {
    foreach ($data['optimal_times'] as $timePair) {
        $today = date('Y-m-d'); // Current date
        $intervals[] = [
            'start' => $today . ' ' . $timePair[0],  // Use current date
            'end' => $today . ' ' . $timePair[1]     // Use current date
        ];
    }
}

// Initialize ICS content
$icsContent = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//YourApp//Meeting Planner//EN\r\n";

// Loop through the intervals and create an event for each
foreach ($intervals as $interval) {
    $icsContent .= "BEGIN:VEVENT\r\n";
    $icsContent .= "UID:" . uniqid() . "@yourapp.com\r\n";  // Unique identifier for event
    $icsContent .= "DTSTAMP:" . formatDateToICS(date('Y-m-d H:i:s')) . "\r\n";  // Timestamp of generation
    $icsContent .= "DTSTART:" . formatDateToICS($interval['start']) . "\r\n";  // Event start time
    $icsContent .= "DTEND:" . formatDateToICS($interval['end']) . "\r\n";  // Event end time
    $icsContent .= "SUMMARY:Meeting with Maximum Participants\r\n";  // Event title
    $icsContent .= "DESCRIPTION:Suggested meeting time based on participant availability.\r\n";
    $icsContent .= "END:VEVENT\r\n";
}

$icsContent .= "END:VCALENDAR\r\n";

// Set headers to force download of the ICS file
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="Meeting_scheduled.ics"');

// Output the ICS content
echo $icsContent;
?>
