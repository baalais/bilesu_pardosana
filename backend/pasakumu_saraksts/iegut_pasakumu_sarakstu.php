<?php
//iegut_pasakumu_sarakstu.php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  require_once(__DIR__ . "/../db/db_connection.php");

  // Get filtering parameters from GET request
  $ticketType = isset($_GET["ticketType"]) ? $_GET["ticketType"] : null;
  $startDate = isset($_GET["startDate"]) ? $_GET["startDate"] : null;
  $endDate = isset($_GET["endDate"]) ? $_GET["endDate"] : null;

  // Perform validation, e.g., check if dates have the correct format

  // Create SQL query to retrieve the event list with filtering
  $sql = "SELECT * FROM Events WHERE 1";

  if ($ticketType) {
    $sql .= " AND TicketType = '$ticketType'";
  }

  if ($startDate) {
    $sql .= " AND EventDate >= '$startDate'";
  }

  if ($endDate) {
    $sql .= " AND EventDate <= '$endDate'";
  }

  $result = $conn->query($sql);

  // Check if the query was successful
  if (!$result) {
    die(json_encode(["error" => "Query error: " . $conn->error]));
  }

  // Transform the result into an array
  $events = [];
  while ($row = $result->fetch_assoc()) {
    $events[] = $row;
  }

  // Return the result to the client in JSON format
  echo json_encode($events);

  // Close the database connection
  $conn->close();
}

?>