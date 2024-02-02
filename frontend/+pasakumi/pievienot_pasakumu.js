function addEvent() {
    const addEventError = document.getElementById("addEventError");
    const addEventButton = document.getElementById("addEventButton");
    const formData = new FormData(document.getElementById("eventForm"));

    // Prevent button spamming
    addEventButton.disabled = true;

    // Display FormData values in console for debugging
    for (const [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }

    // Fetch request to server
    fetch('http://localhost/bilesu_pardosana/bilesu_pardosana/backend/+pasakumi/pievienot_pasakumu.php', {
        method: 'POST',
        body: formData,
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
