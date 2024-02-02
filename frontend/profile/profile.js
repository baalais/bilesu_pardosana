// Fetch user-specific data using AJAX
fetch('http://localhost/bilesu_pardosana/bilesu_pardosana/backend/profile/profile.php', {
    method: 'GET',
    credentials: 'include'
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        // Update profile information
        document.getElementById('profileInfo').innerHTML = `<h2>Name: ${data.userData.username}</h2>`;
        
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
.catch(error => console.error('Error fetching user data:', error));
