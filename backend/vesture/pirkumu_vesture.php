<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  require_once("../db/db_connection.php");

  // Iegūstam filtrēšanas parametrus no GET pieprasījuma
  $userID = isset($_GET["userID"]) ? $_GET["userID"] : null;

  // Izveidojam SQL vaicājumu, lai iegūtu pirkumu vēsturi konkrētam lietotājam
  $sql = "SELECT ph.PurchaseID, e.EventName, ph.PurchaseDate, t.Quantity, t.Price
            FROM PurchaseHistory ph
            JOIN Tickets t ON ph.TicketID = t.TicketID
            JOIN Events e ON t.EventID = e.EventID
            WHERE ph.UserID = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $userID);
  $stmt->execute();

  $result = $stmt->get_result();

  // Pārveidojam rezultātu masīvā
  $purchaseHistory = [];
  while ($row = $result->fetch_assoc()) {
    $purchaseHistory[] = $row;
  }

  // Atgriežam rezultātu klienta pusei JSON formātā
  echo json_encode($purchaseHistory);

  // Aizveram izpildes paziņojumu un savienojumu ar datu bāzi
  $stmt->close();
  $conn->close();
}
?>