<?php // register code
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
                $userID = $stmt->insert_id; // Retrieve the user ID after successful registration
                $authToken = generateAuthToken(); // You need to implement this function
                updateAuthToken($conn, $userID, $authToken); // You need to implement this function

                echo json_encode([
                    "success" => true,
                    "message" => "Reģistrācija veiksmīga!",
                    "userID" => $userID,
                    "authToken" => $authToken
                ]);
            } else {
                echo json_encode(["success" => false, "message" => "Reģistrācijas kļūda: " . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Statement preparation failed."]);
        }

        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "Username and password are required."]);
    }
}

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
?>