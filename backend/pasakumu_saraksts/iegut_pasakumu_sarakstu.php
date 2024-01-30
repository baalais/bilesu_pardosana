<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  require_once("../db/db_connection.php");

  // Iegūstam filtrēšanas parametrus no GET pieprasījuma
  $genre = isset($_GET["genre"]) ? $_GET["genre"] : null;
  $startDate = isset($_GET["startDate"]) ? $_GET["startDate"] : null;
  $endDate = isset($_GET["endDate"]) ? $_GET["endDate"] : null;

  // Veicam validāciju, piemēram, vai datumiem ir pareizs formāts

  // Izveidojam SQL vaicājumu, lai iegūtu pasākumu sarakstu ar filtrēšanu
  $sql = "SELECT * FROM Events WHERE 1";

  if ($genre) {
    $sql .= " AND Genre = '$genre'";
  }

  if ($startDate) {
    $sql .= " AND EventDate >= '$startDate'";
  }

  if ($endDate) {
    $sql .= " AND EventDate <= '$endDate'";
  }

  $result = $conn->query($sql);

  // Pārveidojam rezultātu masīvā
  $events = [];
  while ($row = $result->fetch_assoc()) {
    $events[] = $row;
  }

  // Atgriežam rezultātu klienta pusei JSON formātā
  echo json_encode($events);

  // Aizveram savienojumu ar datu bāzi
  $conn->close();
}
?>