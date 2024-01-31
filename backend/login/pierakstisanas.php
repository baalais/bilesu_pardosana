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

        $stmt = $conn->prepare("SELECT UserID, PasswordHash FROM Users WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($userID, $storedPassword);

        if ($stmt->fetch() && password_verify($password, $storedPassword)) {
            echo "Pierakstīšanās veiksmīga! UserID: $userID";
        } else {
            echo "Nepareizs lietotājvārds vai parole.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid or missing JSON data.";
    }
}
?>
