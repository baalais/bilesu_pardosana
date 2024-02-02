<?php
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
    $venue = validateInput($_POST["venue"] ?? '');
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

    // Pārbaude, vai pasākums jau pastāv
    $stmt_check = $conn->prepare("SELECT EventID FROM Events WHERE EventName = ?");
    $stmt_check->bind_param("s", $eventName);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "Pasākums ar šādu nosaukumu jau pastāv!";
        exit;
    }

    $stmt_check->close();

    // Prepare the statement with the existing 'Quantity' field
    $stmt = $conn->prepare("INSERT INTO Events (EventName, EventDate, EventTime, TicketType, Venue, TicketPrice, Quantity) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Check for errors in the prepare statement
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssdss", $eventName, $eventDate, $eventTime, $ticketType, $venue, $ticketPrice, $ticketQuantity);

    // Check for errors in the bind_param
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // ... (your existing code)

    if ($stmt->execute()) {
        echo "Pasākums veiksmīgi pievienots!";
    } else {
        echo "Pasākuma pievienošanas kļūda: " . $stmt->error;
    }

    // Close the statement, but do not close the connection here
    $stmt->close();
    // Do not close the connection here
}
?>