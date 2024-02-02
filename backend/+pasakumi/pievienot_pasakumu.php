<?php
//pievienot_pasakumu.php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once(__DIR__ . "/../db/db_connection.php");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function validateInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    function validateDateTime($date, $time)
    {
        $dateRegex = '/^\d{4}-\d{2}-\d{2}$/';
        $timeRegex = '/^([01]\d|2[0-3]):[0-5]\d$/';
        return (preg_match($dateRegex, $date) === 1 && preg_match($timeRegex, $time) === 1);
    }

    $eventName = validateInput($_POST["eventName"] ?? '');
    $eventDate = validateInput($_POST["eventDate"] ?? '');
    $eventTime = validateInput($_POST["eventTime"] ?? '');
    $ticketType = validateInput($_POST["ticketType"] ?? '');
    $venue = validateInput($_POST["Venue"] ?? ''); // Change $Venue to $venue
    $ticketPrice = validateInput($_POST["ticketPrice"] ?? '');
    $ticketQuantity = validateInput($_POST["ticketQuantity"] ?? '');

    if (empty($eventName) || empty($eventDate) || empty($eventTime) || empty($ticketType) || empty($venue) || empty($ticketPrice) || empty($ticketQuantity)) {
        echo "Visi lauki ir obligāti aizpildāmi!";
        exit;
    }

    if (!validateDateTime($eventDate, $eventTime)) {
        echo "Nepareizs datuma vai laika formāts!";
        exit;
    }

    $stmt_check = $conn->prepare("SELECT EventID FROM Events WHERE EventName = ?");
    $stmt_check->bind_param("s", $eventName);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "Pasākums ar šādu nosaukumu jau pastāv!";
        exit;
    }

    $stmt_check->close();

    $stmt = $conn->prepare("INSERT INTO Events (EventName, EventDate, EventTime, TicketType, Venue, TicketPrice, Quantity) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo "Prepare failed: " . $conn->error;
        exit;
    }

    $stmt->bind_param("ssssdss", $eventName, $eventDate, $eventTime, $ticketType, $venue, $ticketPrice, $ticketQuantity);

    // Debugging the SQL query
    $sql = "INSERT INTO Events (EventName, EventDate, EventTime, TicketType, Venue, TicketPrice, Quantity) VALUES ('$eventName', '$eventDate', '$eventTime', '$ticketType', '$venue', $ticketPrice, $ticketQuantity)";
    echo "SQL Query: " . $sql . "<br>";

    if (!$stmt->execute()) {
        echo "Pasākuma pievienošanas kļūda: " . $stmt->error;
        exit;
    }

    echo "Pasākums veiksmīgi pievienots!";

    $stmt->close();
    $conn->close();
}
?>