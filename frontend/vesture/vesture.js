function getReviews() {
  const eventID = document.getElementById("eventID").value;

  // Izveidojiet XMLHttpRequest vai izmantojiet fetch, lai sazinātos ar serveri
  // un iegūtu atsauksmes par norādīto pasākumu

  // Piemērs ar fetch:
  fetch(`../backend/vesture/atsauksmes.php?eventID=${eventID}`)
      .then(response => response.json())
      .then(data => {
          displayReviews(data);
      })
      .catch((error) => {
          console.error('Kļūda:', error);
      });
}

function displayReviews(reviews) {
  const reviewsListDiv = document.getElementById("reviewsList");
  reviewsListDiv.innerHTML = "";

  reviews.forEach(review => {
      const reviewDiv = document.createElement("div");
      reviewDiv.className = "review";
      reviewDiv.innerHTML = `
          <h3>Lietotājs ID: ${review.UserID}</h3>
          <p>Vērtējums: ${review.Rating}</p>
          <p>Komentārs: ${review.Comment}</p>
      `;
      reviewsListDiv.appendChild(reviewDiv);
  });
}

function getPurchaseHistory() {
  const userID = document.getElementById("userID").value;

  // Izveidojiet XMLHttpRequest vai izmantojiet fetch, lai sazinātos ar serveri
  // un iegūtu pirkumu vēsturi par norādīto lietotāju

  // Piemērs ar fetch:
  fetch(`../backend/vesture/pirkumu_vesture.php?userID=${userID}`)
      .then(response => response.json())
      .then(data => {
          displayPurchaseHistory(data);
      })
      .catch((error) => {
          console.error('Kļūda:', error);
      });
}

function displayPurchaseHistory(purchaseHistory) {
  const purchaseHistoryListDiv = document.getElementById("purchaseHistoryList");
  purchaseHistoryListDiv.innerHTML = "";

  purchaseHistory.forEach(history => {
      const historyDiv = document.createElement("div");
      historyDiv.className = "purchase-history";
      historyDiv.innerHTML = `
          <h3>Pirkuma ID: ${history.PurchaseID}</h3>
          <p>Pasākuma nosaukums: ${history.EventName}</p>
          <p>Pirkuma datums: ${history.PurchaseDate}</p>
          <p>Biļešu skaits: ${history.Quantity}</p>
          <p>Kopējā cena: ${history.Price}</p>
      `;
      purchaseHistoryListDiv.appendChild(historyDiv);
  });
}
