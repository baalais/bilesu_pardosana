<?php

session_start();

// Check if the token exists
if (isset($_SESSION['token'])) {
  // Token exists, continue with your session logic
  // Add more session-related code here
} else {
  // Token doesn't exist, handle accordingly (e.g., redirect to a login page)
  echo "No Token.";
  // Add redirection or other handling logic here
}
;
?>