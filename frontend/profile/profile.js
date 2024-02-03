

fetch('http://localhost/bilesu_pardosana/bilesu_pardosana/backend/profile/profile.php', {
    method: 'GET',
    credentials: 'include'
})
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            console.log(data);
            // Update profile information
            document.getElementById('profileInfo').innerHTML = `<h2>Name: ${data.userData.Username}</h2>`;

            // Update ticket history
            const ticketHistory = document.getElementById('ticketHistory');
            data.userData.ticketHistory.forEach(ticket => {
                const listItem = document.createElement('li');
                listItem.textContent = `Event: ${ticket.event} - Date: ${ticket.date}`;
                ticketHistory.appendChild(listItem);
            });
        } else {
            console.error('Error fetching user data:', data.message);
        }
    })
    .catch(error => console.error('Fetch error:', error));

// Assume you have an event ID or retrieve it dynamically
const eventID = eventID;

// Fetch event details and comments
Promise.all([
    fetch(`http://localhost/bilesu_pardosana/bilesu_pardosana/backend/profile/profile.php`, {
        method: 'GET',
        credentials: 'include'
    }),
    fetch(`http://localhost/bilesu_pardosana/bilesu_pardosana/backend/pirkt/iegadaties_bileti.php?eventID=${eventID}`)
])
    .then(responses => Promise.all(responses.map(response => response.json())))
    .then(([profileData, commentsData]) => {
        if (profileData.success) {
            console.log(profileData);
            // Update profile information
            document.getElementById('profileInfo').innerHTML = `<h2>Name: ${profileData.userData.Username}</h2>`;

            // Update ticket history
            const ticketHistory = document.getElementById('ticketHistory');
            profileData.userData.ticketHistory.forEach(ticket => {
                const listItem = document.createElement('li');
                listItem.textContent = `Event: ${ticket.event} - Date: ${ticket.date}`;
                ticketHistory.appendChild(listItem);
            });

            // Update comment section
            const commentList = document.getElementById('commentList');
            commentsData.forEach(comment => {
                const listItem = document.createElement('li');
                listItem.textContent = `Rating: ${comment.Rating} - Comment: ${comment.Comment}`;
                commentList.appendChild(listItem);
            });
        } else {
            console.error('Error fetching user data:', profileData.message);
        }
    })
    .catch(error => console.error('Fetch error:', error));

// Fetch header
fetch('http://localhost/bilesu_pardosana/bilesu_pardosana/frontend/header/header.html')
    .then(response => response.text())
    .then(headerData => {
        document.getElementById('header-container').innerHTML = headerData;
    })
    .catch(error => console.error('Error fetching header:', error));
