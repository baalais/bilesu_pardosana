<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../db/db_connection.php");

    $username = $_POST["username"];
    $password = $_POST["password"];

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
}
?>