function addEvent() {
  const eventName = document.getElementById("eventName").value;
  const eventDate = document.getElementById("eventDate").value;
  const eventTime = document.getElementById("eventTime").value;
  const ticketType = document.getElementById("ticketType").value;
  const venue = document.getElementById("venue").value;
  const ticketPrice = document.getElementById("ticketPrice").value;
  const addEventError = document.getElementById("addEventError");

  // Veiciet papildu validācijas, piemēram, vai datumiem ir pareizs formāts

  // Izveidojiet XMLHttpRequest vai izmantojiet fetch, lai sazinātos ar serveri
  // un veiktu pasākuma pievienošanas pārbaudi

  // Piemērs ar fetch:
  fetch('../backend/+pasakumi/pievienot_pasakumu.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({ eventName, eventDate, eventTime, ticketType, venue, ticketPrice }),
  })
  .then(response => response.text())
  .then(data => {
      addEventError.innerHTML = data;
  })
  .catch((error) => {
      console.error('Kļūda:', error);
  });
}
