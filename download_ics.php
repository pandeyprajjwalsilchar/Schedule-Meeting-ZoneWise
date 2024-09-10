<?php
// Function to format date to ICS format
function formatDateToICS($dateStr) {
    return date('Ymd\THis\Z', strtotime($dateStr));
}

// Retrieve the time intervals from your analysis (assuming this data is passed to PHP)
$intervals = [
    ['start' => '2024-09-10 09:00:00', 'end' => '2024-09-10 10:00:00'],
    ['start' => '2024-09-11 11:00:00', 'end' => '2024-09-11 12:00:00']
];

// Initialize ICS content
$icsContent = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//YourApp//Meeting Planner//EN\r\n";

// Loop through the intervals and create an event for each
foreach ($intervals as $interval) {
    $icsContent .= "BEGIN:VEVENT\r\n";
    $icsContent .= "UID:" . uniqid() . "@yourapp.com\r\n";  // Unique identifier for event
    $icsContent .= "DTSTAMP:" . formatDateToICS('now') . "\r\n";  // Timestamp of generation
    $icsContent .= "DTSTART:" . formatDateToICS($interval['start']) . "\r\n";  // Event start time
    $icsContent .= "DTEND:" . formatDateToICS($interval['end']) . "\r\n";  // Event end time
    $icsContent .= "SUMMARY:Meeting with Maximum Participants\r\n";  // Event title
    $icsContent .= "DESCRIPTION:Suggested meeting time based on participant availability.\r\n";
    $icsContent .= "END:VEVENT\r\n";
}

$icsContent .= "END:VCALENDAR\r\n";

// Set headers to force download of the ICS file
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="meeting_schedule.ics"');

// Output the ICS content
echo $icsContent;
?>
