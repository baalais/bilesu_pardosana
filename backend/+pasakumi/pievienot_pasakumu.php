<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once(__DIR__ . "/../db/db_connection.php");

    // Function for basic field validation (eliminates SQL injection)
    function validateInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    // Function for date and time validation
    function validateDateTime($date, $time) {
        $dateRegex = '/^\d{4}-\d{2}-\d{2}$/';
        $timeRegex = '/^([01]\d|2[0-3]):[0-5]\d$/';
        return (preg_match($dateRegex, $date) === 1 && preg_match($timeRegex, $time) === 1);
    }

    // Iegūstam informāciju no POST pieprasījuma
    $eventName = validateInput($_POST["eventName"] ?? '');
    $eventDate = validateInput($_POST["eventDate"] ?? '');
    $eventTime = validateInput($_POST["eventTime"] ?? '');
    $ticketType = validateInput($_POST["ticketType"] ?? '');
    $venue = validateInput($_POST["venue"] ?? '');
    $ticketPrice = validateInput($_POST["ticketPrice"] ?? '');

    // Server-side validation
    if (empty($eventName) || empty($eventDate) || empty($eventTime) || empty($ticketType) || empty($venue) || empty($ticketPrice)) {
        echo "Visi lauki ir obligāti aizpildāmi!";
        exit;
    }

    // Additional validation
    if (!validateDateTime($eventDate, $eventTime)) {
        echo "Nepareizs datuma vai laika formāts!";
        exit;
    }

    // Izveidojam SQL vaicājumu, lai pievienotu jaunu pasākumu
    $stmt = $conn->prepare("INSERT INTO Events (EventName, EventDate, EventTime, TicketType, Venue, TicketPrice) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssd", $eventName, $eventDate, $eventTime, $ticketType, $venue, $ticketPrice);

    // Izpildam vaicājumu
    if ($stmt->execute()) {
        echo "Pasākums veiksmīgi pievienots!";
    } else {
        echo "Pasākuma pievienošanas kļūda: " . $stmt->error;
    }

    // Aizveram izpildes paziņojumu un savienojumu ar datu bāzi
    $stmt->close();
    $conn->close();
}
?>
