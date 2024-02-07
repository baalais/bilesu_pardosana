<?php
include '../sesijas.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" type="text/css"
        href="http://localhost/bilesu_pardosana/bilesu_pardosana/frontend/header/header.css">
    <script src="http://localhost/bilesu_pardosana/bilesu_pardosana/frontend/profile/profile.js">
    </script>
</head>

<body>
    <div id="header-container"></div>
    <div class="profile-container">
        <h1>User Profile</h1>
        <div class="profile-info" id="profileInfo">
            <!-- User profile information will be inserted here dynamically -->
        </div>
        <div class="boughtHistory">
            <h2>Bought Ticket History:</h2>
            <ul id="boughtHistory">
                <!-- Ticket history will be inserted here dynamically -->
            </ul>
        </div>
    </div>

</body>

</html>