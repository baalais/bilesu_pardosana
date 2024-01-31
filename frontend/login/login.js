function login() {
    const username = document.getElementById("loginUsername").value;
    const password = document.getElementById("loginPassword").value;
    const loginError = document.getElementById("loginError");
  
    // Clear previous error messages
    loginError.innerHTML = "";
  
    // Validate username
    if (username.trim() === "") {
      loginError.innerHTML = "Lietotājvārds ir obligāts lauks.";
      return;
    }
  
    // Validate password
    if (password.trim() === "") {
      loginError.innerHTML = "Parole ir obligāts lauks.";
      return;
    }
  
    // If all validations pass, proceed with login
    fetch('http://localhost/bilesu_pardosana/bilesu_pardosana/backend/login/pierakstisanas.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ loginUsername: username, loginPassword: password }),
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
  
    // Clear previous error messages
    registerError.innerHTML = "";
  
    // Validate username
    if (username.trim() === "") {
      registerError.innerHTML = "Lietotājvārds ir obligāts lauks.";
      return;
    }
  
    // Validate password
    if (password.trim() === "") {
      registerError.innerHTML = "Parole ir obligāts lauks.";
      return;
    }
  
    // Validate password length or other criteria if needed
    if (password.length < 6) {
      registerError.innerHTML = "Parolei jābūt vismaz 6 simboliem garai.";
      return;
    }
  
    // Validate confirmPassword
    if (confirmPassword.trim() === "") {
      registerError.innerHTML = "Apstiprinājuma parole ir obligāts lauks.";
      return;
    }
  
    // Validate password and confirmPassword match
    if (password !== confirmPassword) {
      registerError.innerHTML = "Parole un apstiprinājuma parole nesakrīt.";
      return;
    }
  
    // If all validations pass, proceed with registration
    fetch('http://localhost/bilesu_pardosana/bilesu_pardosana/backend/login/registracija.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ registerUsername: username, registerPassword: password }),
    })
    .then(response => response.text())
    .then(data => {
        registerError.innerHTML = data;
    })
    .catch((error) => {
        console.error('Kļūda:', error);
    });
  }
    document.addEventListener("DOMContentLoaded", function() {
        showLogin();
    
        function showLogin() {
            const loginContainer = document.getElementById("loginContainer");
            const registerContainer = document.getElementById("registerContainer");
    
            loginContainer.style.display = "block";
            registerContainer.style.display = "none";
        }
    
        function showRegister() {
            const loginContainer = document.getElementById("loginContainer");
            const registerContainer = document.getElementById("registerContainer");
    
            loginContainer.style.display = "none";
            registerContainer.style.display = "block";
        }
    
        // Assign click event listeners
        document.getElementById("showLoginForm").addEventListener("click", showLogin);
        document.getElementById("showRegisterForm").addEventListener("click", showRegister);
    
        // Prevent default form submission behavior
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault();
            login();
        });
    
        document.getElementById("registerForm").addEventListener("submit", function(event) {
            event.preventDefault();
            register();
        });
    });
    