function login() {
  const username = document.getElementById("loginUsername").value;
  const password = document.getElementById("loginPassword").value;
  const loginError = document.getElementById("loginError");

  // Veiciet papildu validācijas, ja nepieciešams

  // Izveidojiet XMLHttpRequest vai izmantojiet fetch, lai sazinātos ar serveri
  // un veiktu pierakstīšanās pārbaudi

  // Piemērs ar fetch:
  fetch('../backend/login/pierakstisanas.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({ username, password }),
  })
  .then(response => response.text())
  .then(data => {
      loginError.innerHTML = data;
  })
  .catch((error) => {
      console.error('Kļūda:', error);
  });
}

function register() {
  const username = document.getElementById("registerUsername").value;
  const password = document.getElementById("registerPassword").value;
  const confirmPassword = document.getElementById("confirmPassword").value;
  const registerError = document.getElementById("registerError");

  // Veiciet papildu validācijas, ja nepieciešams

  // Pārbaudiet, vai parole un apstiprinājuma parole ir vienādas
  if (password !== confirmPassword) {
      registerError.innerHTML = "Parole un apstiprinājuma parole nesakrīt.";
      return;
  }

  // Izveidojiet XMLHttpRequest vai izmantojiet fetch, lai sazinātos ar serveri
  // un veiktu reģistrācijas pārbaudi

  // Piemērs ar fetch:
  fetch('../backend/login/registresanas.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({ username, password }),
  })
  .then(response => response.text())
  .then(data => {
      registerError.innerHTML = data;
  })
  .catch((error) => {
      console.error('Kļūda:', error);
  });
}
