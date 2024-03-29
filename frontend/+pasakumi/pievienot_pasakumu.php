<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pievienot Pasākumu</title>
    <link rel="stylesheet" href="pievienot_pasakumu.css">
    <link rel="stylesheet" type="text/css"
        href="http://localhost/bilesu_pardosana/bilesu_pardosana/frontend/header/header.css">
</head>

<body>
    <div id="header-container"></div>
    <div class="container">
        <div id="eventFormContainer">
            <h2>Pievienot Pasākumu</h2>
            <!-- Wrap your input fields in a form element and give it an ID -->
            <form id="eventForm">
                <div id="addEventForm" class="form-group">
                    <label for="eventName">Pasākuma nosaukums:</label>
                    <input type="text" id="eventName" name="eventName" required>

                    <label for="eventDate">Pasākuma datums:</label>
                    <input type="date" id="eventDate" name="eventDate" required>

                    <label for="eventTime">Pasākuma laiks:</label>
                    <input type="time" id="eventTime" name="eventTime" required>

                    <label for="ticketType">Žanrs:</label>
                    <input type="text" id="ticketType" name="ticketType" required>

                    <label for="Venue">Pasākuma vieta:</label>
                    <input type="text" id="Venue" name="Venue" />

                    <label for="ticketPrice">Biļetes cena:</label>
                    <input type="number" step="0.01" id="ticketPrice" name="ticketPrice" required>

                    <label for="ticketQuantity">Biļešu skaits:</label>
                    <input type="number" id="ticketQuantity" name="ticketQuantity" required>
                </div>
                <button type="button" id="addEventButton" onclick="addEvent()">Pievienot Pasākumu</button>
            </form>
            <div id="addEventError" class="error"></div>
        </div>
    </div>

    <script>
        // Fetch the header HTML and insert it into the 'header-container'
        fetch('http://localhost/bilesu_pardosana/bilesu_pardosana/frontend/header/header.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('header-container').innerHTML = data;
            })
            .catch(error => console.error('Error fetching header:', error));
    </script>

    <script src="pievienot_pasakumu.js"></script>
</body>

</html>