<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "cookies");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$user_id = $_POST["user_id"];
$dietary_preferences = $_POST["dietary_preferences"];
$allergies = $_POST["allergies"];
$cooking_skill = $_POST["cooking_skill"];
$ingredient_preferences = $_POST["ingredient_preferences"];
$ingredient_avoidances = $_POST["ingredient_avoidances"];

// Insert profile data into the database
$sql = "INSERT INTO profiles (user_id, dietary_preferences, allergies, cooking_skill, ingredient_preferences, ingredient_avoidances) 
        VALUES ('$user_id', '$dietary_preferences', '$allergies', '$cooking_skill', '$ingredient_preferences', '$ingredient_avoidances')";
if ($conn->query($sql) === TRUE) {
    echo "Profile created successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>
