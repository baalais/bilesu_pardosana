document.addEventListener("DOMContentLoaded", () => {
  let eventData; // Declare eventData in a higher scope

  // Get event ID from the query string
  const urlParams = new URLSearchParams(window.location.search);
  const eventID = urlParams.get('eventID');

  // Fetch event details based on the eventID
  fetch(`http://localhost/bilesu_pardosana/bilesu_pardosana/backend/pasakumu_saraksts/iegut_pasakumu_sarakstu.php?eventID=${eventID}`)
    .then(response => response.json())
    .then(data => {
      // Assuming data is an array, access the first element (you may adjust this based on your response structure)
      eventData = data[0]; // Assign the value to the outer eventData variable

      // Populate the page with event details
      document.getElementById('eventName').textContent = `Pasākums: ${eventData.EventName}`;
      document.getElementById('eventDate').textContent = `Datums: ${eventData.EventDate}`;
      document.getElementById('eventTime').textContent = `Laiks: ${eventData.EventTime}`;
      document.getElementById('ticketType').textContent = `Žanrs: ${eventData.TicketType}`;
      document.getElementById('venue').textContent = `Vieta: ${eventData.Venue}`;
      document.getElementById('ticketPrice').textContent = `Cena: ${eventData.TicketPrice}`;

      // Initialize total cost with default quantity (1)
      updateTotalCost();
    })
    .catch(error => console.error('Error fetching event details:', error));

  // Add click event listener to the "Buy Ticket" button
  document.getElementById('buyButton').addEventListener('click', () => {
    initiatePayment(eventID, eventData);
  });

  // Add input event listener to the quantity field for dynamic total cost calculation
  const quantityInput = document.getElementById('quantity');
  quantityInput.addEventListener('input', updateTotalCost);

  // Function to update the total cost dynamically based on quantity
  function updateTotalCost() {
    const ticketPrice = parseFloat(document.getElementById('ticketPrice').textContent.replace(/[^0-9.]/g, ''));
    const quantity = parseInt(quantityInput.value, 10);
    const totalCost = ticketPrice * quantity;

    // Display the updated total cost
    document.getElementById('totalCost').textContent = `Total Cost: $${totalCost.toFixed(2)}`;
  }

  // Function to initiate the payment process and save bought history
  function initiatePayment(eventID, eventData) {
    if (!eventData) {
      console.error('Event data is not available.');
      return;
    }

    // Retrieve the existing bought history from sessionStorage
    const boughtHistory = JSON.parse(sessionStorage.getItem('boughtHistory')) || [];

    // Add the current event data to the bought history
    boughtHistory.push({
      eventID: eventID,
      eventName: eventData.EventName,
      ticketPrice: eventData.TicketPrice,
      quantity: parseInt(document.getElementById('quantity').value, 10),
      totalCost: parseFloat(document.getElementById('totalCost').textContent.replace(/[^0-9.]/g, ''))
    });

    // Save the updated bought history back to sessionStorage
    sessionStorage.setItem('boughtHistory', JSON.stringify(boughtHistory));

    // Log the bought history to the console (for demonstration purposes)
    console.log('Bought History:', boughtHistory);

    // Implement the logic to redirect to the payment gateway or show a payment form
    // You may need to pass additional information to the server for processing the payment
    console.log(`Initiating payment for Event ID: ${eventID}`);
    // Redirect to the payment gateway or show a payment form
  }
});
