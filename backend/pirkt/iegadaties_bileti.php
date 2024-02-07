<?php
//iegadaties_bileti.php
session_start();
// Include the database connection
require_once(__DIR__ . "/../db/db_connection.php");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to fetch and display comments
function fetchComments($eventID, $conn)
{
  // Create SQL query to retrieve comments for a specific event
  $sql = "SELECT * FROM Reviews WHERE EventID = $eventID";
  $result = $conn->query($sql);

  // Check if the query was successful
  if (!$result) {
    die("Query error: " . $conn->error);
  }

  // Fetch all comments
  $comments = [];
  while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
  }

  // Return comments as JSON
  return $comments;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // Get event ID from the GET request
  $eventID = isset($_GET["eventID"]) ? $_GET["eventID"] : null;

  // Perform validation, e.g., check if eventID is valid

  // Fetch event details
  $sql = "SELECT * FROM Events WHERE EventID = $eventID";
  $result = $conn->query($sql);

  // Check if the query was successful
  if (!$result) {
    die("Query error: " . $conn->error);
  }

  // Get the event details
  $eventDetails = $result->fetch_assoc();

  // Fetch comments
  $comments = fetchComments($eventID, $conn);

  // Set content type as JSON
  header('Content-Type: application/json');

  // Combine event details and comments in a single JSON response
  echo json_encode(['eventDetails' => $eventDetails, 'comments' => $comments]);

  // Close the database connection
  $conn->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Assuming you have session information available
  session_start();

  // Check if the user is logged in (you might need to adjust this based on your authentication logic)
  if (isset($_SESSION["userID"])) {
    // Get data from the POST request
    $eventID = $_POST["eventID"];
    $userID = $_SESSION["userID"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];

    // Validate data (you may add more validation based on your requirements)

    // Insert the review into the Reviews table
    $insertReview = $conn->prepare("INSERT INTO Reviews (EventID, UserID, Rating, Comment) VALUES (?, ?, ?, ?)");
    $insertReview->bind_param("iiis", $eventID, $userID, $rating, $comment);

    if ($insertReview->execute()) {
      // If the insertion is successful, return a success response
      echo json_encode(["success" => true, "message" => "Review added successfully"]);
    } else {
      // If the insertion fails, return an error response
      echo json_encode(["success" => false, "message" => "Error adding review"]);
    }

    $insertReview->close();
  } else {
    // If the user is not logged in, return an error response
    echo json_encode(["success" => false, "message" => "User not logged in"]);
  }
} else {
  // If the request is not a GET or POST request, return an error response
  echo json_encode(["success" => false, "message" => "Invalid request method"]);
}

// Close the database connection
$conn->close();
?>