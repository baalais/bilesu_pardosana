document.addEventListener("DOMContentLoaded", () => {
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
                    listItem.textContent = `Event: ${ticket.EventName} - Date: ${ticket.EventDate}`;
                    ticketHistory.appendChild(listItem);
                });

                // Check and display bought history from sessionStorage
                const boughtHistory = JSON.parse(sessionStorage.getItem('boughtHistory')) || [];
                if (boughtHistory.length > 0) {
                    console.log('Bought History:', boughtHistory);
                    const boughtHistoryList = document.createElement('ul');
                    boughtHistory.forEach(item => {
                        const boughtItem = document.createElement('li');
                        boughtItem.textContent = `Event: ${item.eventName} - Quantity: ${item.quantity} - Total Cost: $${item.totalCost.toFixed(2)}`;
                        boughtHistoryList.appendChild(boughtItem);
                    });
                    document.getElementById('boughtHistory').appendChild(boughtHistoryList);
                }
            } else {
                console.error('Error fetching user data:', data.message);
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
});
