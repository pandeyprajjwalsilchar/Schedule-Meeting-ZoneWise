

<?php
// Get the raw POST data from the request body
$inputData = file_get_contents('php://input');
// error_log("Raw POST data: " . $inputData);

// Decode the JSON data to check its structure
$data = json_decode($inputData, true);
// error_log("Decoded data: " . print_r($data, true));
// if (empty($data)) {
//     http_response_code(400);
//     echo json_encode(['error' => 'No data received']);
//     exit;
// }

// Check if JSON decoding was successful
// if (json_last_error() !== JSON_ERROR_NONE) {
//     http_response_code(400);
//     echo json_encode(['error' => 'Invalid JSON']);
//     exit;
// }

// Log or output the received data (optional, for debugging)
// error_log(print_r($data, true));

// Check if data is correctly decoded
// if (empty($data)) {
//     http_response_code(400);
//     echo json_encode(['error' => 'No data received']);
//     exit;
// }

// Write the data to a file
file_put_contents('data.json', json_encode($data));

// Define the command to run the Python script
$command = "python process_timings.py";

// Execute the command and capture the output
exec($command, $output, $resultCode);

// Check if the execution was successful
if ($resultCode === 0) {
    // Join the output array into a single string (it should be JSON)
    $outputString = implode("\n", $output);

    // Set the content type to JSON
    header('Content-Type: application/json');

    // Echo the output string (which should be valid JSON)
    echo $outputString;
} else {
    // Handle error case
    http_response_code(500);
    echo json_encode(['error' => 'Error executing Python script']);
}
?>
