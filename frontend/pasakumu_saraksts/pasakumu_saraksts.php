<?php
import:
'../sesijas.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasākumu Saraksts</title>
    <link rel="stylesheet" type="text/css" href="pasakumu_saraksts.css">
    <link rel="stylesheet" type="text/css"
        href="http://localhost/bilesu_pardosana/bilesu_pardosana/frontend/header/header.css">
</head>

<body>

    <div id="header-container"></div>
    <div class="container">
        <h2>Pasākumu Saraksts</h2>

        <div class="search-container">
            <label for="ticketType" class="label">Žanrs:</label>
            <input type="text" id="ticketType" class="input-field">


            <label for="startDate" class="label">Sākuma datums:</label>
            <input type="date" id="startDate" class="input-field">

            <label for="endDate" class="label">Beigu datums:</label>
            <input type="date" id="endDate" class="input-field">

            <button onclick="getEvents()" class="search-button">Meklēt</button>
        </div>

        <div id="eventList" class="event-list"></div>

        <!-- <button id="printPageButton" onclick="printPage()" class="print-button">Izdrukāt lapu</button> -->
    </div>

    <script>
        fetch('http://localhost/bilesu_pardosana/bilesu_pardosana/frontend/header/header.html')
            .then(response => response.text())
            .then(data => {
                document.body.insertAdjacentHTML('afterbegin', data);
            })
            .catch(error => console.error('Error fetching header:', error));
    </script>

    <!-- <footer>
        <div class="footer-logo">
            <img src="http://localhost/bilesu_pardosana/bilesu_pardosana/ticket.png" alt="Footer Logo">
        </div>
        <div class="profile">
            <img src="path-to-profile-image.jpg" alt="Profile Image">
            <a href="profile.html">Profile</a>
        </div>
        <div class="shopping-cart">
            <button onclick="viewShoppingCart()">Shopping Cart</button>
        </div>
    </footer> -->

    <script src="pasakumu_saraksts.js"></script>
</body>

</html>