<!---session destroy !-->
<?php
session_start();
include("config.php");

// Check if the user is logged in (has an active session)
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the home page or any other suitable page after logout
    header("Location: index.php"); // Replace 'index.php' with your home page URL
    exit();
} else {
    // If the user is not logged in, you can handle this case differently (e.g., show an error message)
    echo "You are not logged in.";
}
?>