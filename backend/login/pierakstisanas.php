<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Read the raw JSON data from the request body
    $json = file_get_contents('php://input');

    // Decode the JSON data into an associative array
    $data = json_decode($json, true);

    // Check if the necessary keys are set in the decoded data
    if ($data && isset($data["loginUsername"]) && isset($data["loginPassword"])) {
        require_once(__DIR__ . "/../db/db_connection.php");

        $username = $data["loginUsername"];
        $password = $data["loginPassword"];

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT UserID, PasswordHash, Role FROM Users WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($userID, $storedPassword, $role);

        if ($stmt->fetch() && password_verify($password, $storedPassword)) {
            // Login successful, you can handle other login-related tasks here
            echo json_encode([
                "success" => true,
                "message" => "Pierakstīšanās veiksmīga!",
                "userID" => $userID,
                "role" => $role
            ]);
        } else {
            // Login unsuccessful, display an error message
            echo json_encode(["success" => false, "message" => "Nepareizs lietotājvārds vai parole."]);
        }

        $stmt->close();
        $conn->close();
    } else {
        // Invalid or missing JSON data
        echo json_encode(["success" => false, "message" => "Invalid or missing JSON data."]);
    }
}
?>