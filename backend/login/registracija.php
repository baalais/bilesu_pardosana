<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Read the raw JSON data from the request body
    $json = file_get_contents('php://input');

    // Decode the JSON data into an associative array
    $data = json_decode($json, true);

    // Check if the necessary keys are set in the decoded data
    if ($data && isset($data["username"]) && isset($data["password"])) {
        require_once(__DIR__ . "/../db/db_connection.php");

        $username = $data["username"];
        $password = password_hash($data["password"], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO Users (Username, PasswordHash) VALUES (?, ?)");

        if ($stmt) {
            $stmt->bind_param("ss", $username, $password);

            if ($stmt->execute()) {
                echo "Reģistrācija veiksmīga!";
            } else {
                echo "Reģistrācijas kļūda: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Statement preparation failed.";
        }

        $conn->close();
    } else {
        echo "Username and password are required.";
    }
}
?>
