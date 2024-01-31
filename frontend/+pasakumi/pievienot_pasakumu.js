function addEvent() {
    const eventName = document.getElementById("eventName").value;
    const eventDate = document.getElementById("eventDate").value;
    const eventTime = document.getElementById("eventTime").value;
    const ticketType = document.getElementById("ticketType").value;
    const venue = document.getElementById("venue").value;
    const ticketPrice = document.getElementById("ticketPrice").value;
    const addEventError = document.getElementById("addEventError");
    const addEventButton = document.getElementById("addEventButton");

    // Client-side validation
    if (!eventName || !eventDate || !eventTime || !ticketType || !venue || !ticketPrice) {
        addEventError.innerHTML = "Visi lauki ir obligāti aizpildāmi!";
        return;
    }

    // Date and time format validation
    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
    const timeRegex = /^([01]\d|2[0-3]):[0-5]\d$/;

    if (!dateRegex.test(eventDate) || !timeRegex.test(eventTime)) {
        addEventError.innerHTML = "Nepareizs datuma vai laika formāts!";
        return;
    }

    // Prevent button spamming
    addEventButton.disabled = true;

    // Fetch request to server
    fetch('http://localhost/bilesu_pardosana/bilesu_pardosana/backend/+pasakumi/pievienot_pasakumu.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `eventName=${encodeURIComponent(eventName)}&eventDate=${encodeURIComponent(eventDate)}&eventTime=${encodeURIComponent(eventTime)}&ticketType=${encodeURIComponent(ticketType)}&venue=${encodeURIComponent(venue)}&ticketPrice=${encodeURIComponent(ticketPrice)}`,
    })
    .then(response => response.text())
    .then(data => {
        addEventError.innerHTML = data;
    })
    .catch((error) => {
        console.error('Kļūda:', error);
    })
    .finally(() => {
        // Re-enable the button after the request is complete
        addEventButton.disabled = false;
    });
}
