
function getEvents() {
  const ticketType = document.getElementById("ticketType").value;
  const startDate = document.getElementById("startDate").value;
  const endDate = document.getElementById("endDate").value;

  console.log("Ticket Type:", ticketType);
  console.log("Start Date:", startDate);
  console.log("End Date:", endDate);

  // Fetch request to the server
  fetch(`http://localhost/bilesu_pardosana/bilesu_pardosana/backend/pasakumu_saraksts/iegut_pasakumu_sarakstu.php?ticketType=${ticketType}&startDate=${startDate}&endDate=${endDate}`)
    .then(response => response.json())
    .then(data => {
      displayEvents(data);
    })
    .catch((error) => {
      console.error('Kļūda:', error);
    });
}




// ... (Remaining code)



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
      <p>Žanrs: ${event.TicketType}</p>
      <p>Vieta: ${event.Venue}</p>
      <p>Cena: ${event.TicketPrice}</p>
      <button onclick="buyTicket(${event.EventID})" class="buy-button">Nopirkt</button>
    `;
    eventListDiv.appendChild(eventDiv);
  });
}



function buyTicket(eventID) {
  // Redirect to the purchase page with the event ID
  window.location.href = `http://localhost/bilesu_pardosana/bilesu_pardosana/frontend/pirkt/iegadaties_bileti.html?eventID=${eventID}`;
}