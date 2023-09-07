<?php
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'guvi';

// Create a MySQLi connection
$db = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

// Check if the connection was successful
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Now $db is a valid MySQLi connection object
?>