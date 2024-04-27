<?php
// Database connection details
$servername = "db4free.net";
$username = "almiralic";
$password = "almir123";
$dbname = "bookingtrips";

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL query
    $sql = "SELECT * FROM bookings";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Execute the statement
    $stmt->execute();
    
    // Fetch all rows as associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Process the rows
    foreach ($rows as $row) {
        // Access row data using column names
        $column1 = $row['name'];
        $column2 = $row['email'];
        
        // Do something with the data
        echo "Column 1: $column1, Column 2: $column2<br>";
    }
} catch(PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
