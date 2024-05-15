<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "cookies");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$email = $_POST["email"];
$password = $_POST["password"];

// Retrieve user data from the database
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found, verify password
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["password"])) {
        echo "Login successful!";
        // Redirect to home screen or dashboard
        header("Location: home.php?user_id=".$row["id"]);
        exit();
    } else {
        echo "Invalid password!";
    }
} else {
    echo "User not found!";
}

// Close database connection
$conn->close();
?>
