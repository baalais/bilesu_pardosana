<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once("../db/db_connection.php");

  // Iegūstam informāciju no POST pieprasījuma
  $eventName = $_POST["eventName"];
  $eventDate = $_POST["eventDate"];
  $eventTime = $_POST["eventTime"];
  $ticketType = $_POST["ticketType"];
  $venue = $_POST["venue"];
  $ticketPrice = $_POST["ticketPrice"];

  // Veicam validāciju, piemēram, vai datumam un laikam ir pareizs formāts

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