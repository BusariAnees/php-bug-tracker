<?php
$servername = "127.0.0.1";
$username = "root";
$password = "your_mysql_password";  // <-- put your actual password
$dbname = "bugtracker";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h3 style='color:green;'>✅ Database connection successful!</h3>";
} catch(PDOException $e) {
    echo "<h3 style='color:red;'>❌ Connection failed:</h3> " . $e->getMessage();
}
?>