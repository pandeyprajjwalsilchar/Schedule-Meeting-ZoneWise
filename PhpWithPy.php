

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

// Convert the output to a single JSON string if it's an array
$pythonOutput = implode("\n", $output);

// Decode the output if it's JSON formatted
$pythonData = json_decode($pythonOutput, true);

$dataFile = 'data.json';
$existingData = [];

// Read the existing data from the file
if (file_exists($dataFile)) {
    $existingContent = file_get_contents($dataFile);
    $existingData = json_decode($existingContent, true); // Decode existing JSON content
}

if ($resultCode === 0 && $pythonData !== null) {
    // Merge optimal_times
    if (isset($pythonData['optimal_times'])) {
        if (!isset($existingData['optimal_times'])) {
            $existingData['optimal_times'] = [];
        }
        $existingData['optimal_times'] = array_merge($existingData['optimal_times'], $pythonData['optimal_times']);
    }

    // Update data.json file
    file_put_contents($dataFile, json_encode($existingData, JSON_PRETTY_PRINT));

    // Prepare response data
    $response = [
        'optimal_times' => $existingData['optimal_times'],
        'plot_data' => $pythonData['plot_data'] // Ensure this is properly formatted in the Python script
    ];

    // Set the content type to JSON
    header('Content-Type: application/json');

    // Output the response
    echo json_encode($response);
} else {
    // Handle error case
    http_response_code(500);
    echo json_encode(['error' => 'Error executing Python script']);
}
?>
