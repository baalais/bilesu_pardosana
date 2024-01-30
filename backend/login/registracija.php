<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../db/db_connection.php");

    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO Users (Username, PasswordHash) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        echo "Reģistrācija veiksmīga!";
    } else {
        echo "Reģistrācijas kļūda: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>