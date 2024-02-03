<?php
//profile.php
session_start();
if (!isset($_SESSION["userID"]) || !isset($_SESSION["token"])) {
  header("Location: http://localhost/bilesu_pardosana/bilesu_pardosana/backend/login/pierakstisanas.php");
  exit();
}

require_once(__DIR__ . "/../db/db_connection.php");

$userID = $_SESSION["userID"];
$token = $_SESSION["token"];

// Prepare the SQL statement
$stmt = $conn->prepare("SELECT Username FROM users WHERE UserID = ?");
if (!$stmt) {
  // Handle error
  die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

// Bind parameters
$stmt->bind_param("i", $userID);

// Execute the statement
if (!$stmt->execute()) {
  // Handle error
  die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
}

// Bind result variables
$stmt->bind_result($username);

// Fetch result
$stmt->fetch();

// Close statement
$stmt->close();

// Construct user data
$userData = [];
if ($username !== null) {
  $userData['Username'] = $username;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['success' => true, 'userData' => $userData]);
exit();
?>