<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  require_once(__DIR__ . "/../db/db_connection.php");

  // Iegūstam filtrēšanas parametrus no GET pieprasījuma
  $eventID = isset($_GET["eventID"]) ? $_GET["eventID"] : null;

  // Izveidojam SQL vaicājumu, lai iegūtu atsauksmes par konkrētu pasākumu
  $sql = "SELECT * FROM Reviews WHERE EventID = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $eventID);
  $stmt->execute();

  $result = $stmt->get_result();

  // Pārveidojam rezultātu masīvā
  $reviews = [];
  while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
  }

  // Atgriežam rezultātu klienta pusei JSON formātā
  echo json_encode($reviews);

  // Aizveram izpildes paziņojumu un savienojumu ar datu bāzi
  $stmt->close();
  $conn->close();
}
?>