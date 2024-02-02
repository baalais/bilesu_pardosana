<?php
// Include the database connection
require_once(__DIR__ . "/../db/db_connection.php");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // Get event ID from the GET request
  $eventID = isset($_GET["eventID"]) ? $_GET["eventID"] : null;

  // Perform validation, e.g., check if eventID is valid

  // Create SQL query to retrieve the details of a specific event
  $sql = "SELECT * FROM Events WHERE EventID = $eventID";
  $result = $conn->query($sql);

  // Check if the query was successful
  if (!$result) {
    die("Query error: " . $conn->error);
  }

  // Get the event details
  $eventDetails = $result->fetch_assoc();

  // Set content type as JSON
  header('Content-Type: application/json');

  // Return the result to the client in JSON format
  echo json_encode($eventDetails);

  // Close the database connection
  $conn->close();
}
?>