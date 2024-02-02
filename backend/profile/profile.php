<?php
//profile.php
session_start();

if (!isset($_SESSION["userID"]) || !isset($_SESSION["token"])) {
  header("Location: http://localhost/bilesu_pardosana/bilesu_pardosana/backend/login/pierakstisanas.php"); // Redirect to login if not logged in
  exit();
}

require_once(__DIR__ . "/../db/db_connection.php");

$userID = $_SESSION["userID"];
$token = $_SESSION["token"];

$stmt = $conn->prepare("SELECT Username FROM Users WHERE UserID = ? AND AuthToken = ?");
$stmt->bind_param("is", $userID, $token);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();

// Fetch user's ticket history (replace this with your actual logic)
$ticketHistory = [
  ["event" => "Concert A", "date" => "2024-02-01"],
  ["event" => "Movie Night", "date" => "2024-02-15"]
];

$userData = ["username" => $username, "ticketHistory" => $ticketHistory];

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['success' => true, 'userData' => $userData]);
exit(); // Make sure to exit after sending the JSON response
?>