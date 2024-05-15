



<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "cookies");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$dietaryPreferences = $_POST["dietaryPreferences"];
$allergies = $_POST["allergies"];
$cookingSkill = $_POST["cookingSkill"];
$ingredientPreferences = $_POST["ingredientPreferences"];
$ingredientAvoidance = $_POST["ingredientAvoidance"];

// Hash the password (you should use a stronger hashing algorithm)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user data into the database
$sql = "INSERT INTO users (username, email, password, dietary_preferences, allergies, cooking_skill, ingredient_preferences, ingredient_avoidance) VALUES ('$username', '$email', '$hashedPassword', '$dietaryPreferences', '$allergies', '$cookingSkill', '$ingredientPreferences', '$ingredientAvoidance')";
if ($conn->query($sql) === TRUE) {
    // Redirect to the login page
    header("Location: login.html");
    exit(); // Make sure to exit after redirecting
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>

