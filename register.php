<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    // Validate form data (you can add more validation as needed)
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
    } else {
        // Connect to your database (replace 'dbname', 'username', 'password' with your actual database credentials)
        $conn = new mysqli("localhost", "root", "", "cookies");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Prepare and execute SQL statement to insert user data into database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            echo "User registered successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
        
        // Close database connection
        $stmt->close();
        $conn->close();
    }
}
?>
