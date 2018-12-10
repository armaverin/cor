<?php
// Database configuration
$dbHost     = "";
$dbUsername = "";
$dbPassword = "";
$dbName     = "";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    $db->query( "SET CHARSET utf8" );
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>