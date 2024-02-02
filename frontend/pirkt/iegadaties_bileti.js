document.addEventListener("DOMContentLoaded", () => {
  // Get event ID from the query string
  const urlParams = new URLSearchParams(window.location.search);
  const eventID = urlParams.get('eventID');

  // Fetch event details based on the eventID
  fetch(`http://localhost/bilesu_pardosana/bilesu_pardosana/backend/pasakumu_saraksts/iegut_pasakumu_sarakstu.php?eventID=${eventID}`)
      .then(response => response.json())
      .then(data => {
          // Assuming data is an array, access the first element (you may adjust this based on your response structure)
          const eventData = data[0];

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
      // Implement the logic to initiate the payment process (e.g., redirect to a payment gateway)
      // You may need to pass additional information to the server for processing the payment
      initiatePayment(eventID);
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
});

// Function to initiate the payment process (replace with your actual implementation)
function initiatePayment(eventID) {
  // Implement logic to redirect to the payment gateway or show a payment form
  // This could involve server-side processing and interaction with a payment API
  // For example, you can use a service like Stripe, PayPal, etc. for handling payments
  console.log(`Initiating payment for Event ID: ${eventID}`);
  // Redirect to the payment gateway or show a payment form
}
