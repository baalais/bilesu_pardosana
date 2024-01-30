function getEvents() {
  const genre = document.getElementById("genre").value;
  const startDate = document.getElementById("startDate").value;
  const endDate = document.getElementById("endDate").value;

  // Izveidojiet XMLHttpRequest vai izmantojiet fetch, lai sazinātos ar serveri
  // un iegūtu pasākumu sarakstu ar filtrēšanu

  // Piemērs ar fetch:
  fetch(`../backend/pasakumu_saraksts/iegut_pasakumu_sarakstu.php?genre=${genre}&startDate=${startDate}&endDate=${endDate}`)
      .then(response => response.json())
      .then(data => {
          displayEvents(data);
      })
      .catch((error) => {
          console.error('Kļūda:', error);
      });
}

function displayEvents(events) {
  const eventListDiv = document.getElementById("eventList");
  eventListDiv.innerHTML = "";

  events.forEach(event => {
      const eventDiv = document.createElement("div");
      eventDiv.className = "event";
      eventDiv.innerHTML = `
          <h3>${event.EventName}</h3>
          <p>Datums: ${event.EventDate}</p>
          <p>Laiks: ${event.EventTime}</p>
          <p>Biļetes veids: ${event.TicketType}</p>
          <p>Vieta: ${event.Venue}</p>
          <p>Cena: ${event.TicketPrice}</p>
      `;
      eventListDiv.appendChild(eventDiv);
  });
}

function printPage() {
  window.print();
}
