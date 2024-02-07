<?php
// registracija.php
session_start();

function generateAuthToken()
{
    return bin2hex(random_bytes(32)); // Generate a 64-character hexadecimal token
}

function updateAuthToken($conn, $userID, $authToken)
{
    $stmt = $conn->prepare("UPDATE Users SET AuthToken = ? WHERE UserID = ?");
    $stmt->bind_param("si", $authToken, $userID);
    $stmt->execute();
    $stmt->close();
}

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

        // Check if the username already exists
        $checkUsernameStmt = $conn->prepare("SELECT UserID FROM Users WHERE Username = ?");
        $checkUsernameStmt->bind_param("s", $username);
        $checkUsernameStmt->execute();
        $checkUsernameStmt->store_result();

        if ($checkUsernameStmt->num_rows > 0) {
            echo json_encode(["success" => false, "message" => "Lietotājvārds jau eksistē. Lūdzu, izvēlieties citu lietotājvārdu."]);
            exit();
        }

        $checkUsernameStmt->close();

        // If the username is unique, proceed with registration
        $insertStmt = $conn->prepare("INSERT INTO Users (Username, PasswordHash) VALUES (?, ?)");

        if ($insertStmt) {
            $insertStmt->bind_param("ss", $username, $password);

            if ($insertStmt->execute()) {
                $userID = $insertStmt->insert_id; // Retrieve the user ID after successful registration
                $authToken = generateAuthToken(); // Generate authentication token
                updateAuthToken($conn, $userID, $authToken); // Update user's auth token in the database

                // Return the generated token along with other data in the JSON response
                echo json_encode([
                    "success" => true,
                    "message" => "Reģistrācija veiksmīga!",
                    "userID" => $userID,
                    "authToken" => $authToken
                ]);
            } else {
                echo json_encode(["success" => false, "message" => "Reģistrācijas kļūda: " . $insertStmt->error]);
            }

            $insertStmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Statement preparation failed."]);
        }

        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "Username and password are required."]);
    }
}
?>
