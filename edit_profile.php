<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userId = $_POST["userId"];
    $dietaryPreferences = $_POST["dietaryPreferences"];
    $allergies = $_POST["allergies"];
    $cookingSkill = $_POST["cookingSkill"];
    
    // Validate form data (you can add more validation as needed)
    if (empty($userId) || empty($dietaryPreferences) || empty($cookingSkill)) {
        echo "All fields are required.";
    } else {
        // Connect to your database
        $conn = new mysqli("localhost", "root", "", "cookies");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Prepare and execute SQL statement to update profile data in database
        $stmt = $conn->prepare("UPDATE profiles SET dietary_preferences=?, allergies=?, cooking_skill=? WHERE user_id=?");
        $stmt->bind_param("sssi", $dietaryPreferences, $allergies, $cookingSkill, $userId);
        
        if ($stmt->execute()) {
            echo "Profile updated successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
        
        // Close database connection
        $stmt->close();
        $conn->close();
    }
}
?>
