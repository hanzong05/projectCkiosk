<?php
// submit_feedback.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all required fields are received
    if (isset($_POST['rating'], $_POST['feedback'], $_POST['email'], $_POST['college'], $_POST['year'])) {
        
        // Sanitize input
        $rating = htmlspecialchars($_POST['rating']);
        $feedback = htmlspecialchars($_POST['feedback']);
        $email = htmlspecialchars($_POST['email']);
        $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
        $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
        $college = htmlspecialchars($_POST['college']);
        $year = htmlspecialchars($_POST['year']);
        
        // Handle file upload (optional)
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = basename($_FILES['image']['name']);
            $uploadDir = 'uploads/'; // Folder to store images
            $imagePath = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $image = $imagePath; // Set image path
            } else {
                // Handle image upload error
                $image = null;
            }
        }

        // Insert the data into the database (adjust according to your database structure)
        try {
            // Database connection
            $pdo = new PDO('mysql:host=localhost;dbname=ckiosk', 'root', ''); 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Prepare the SQL query
            $sql = "INSERT INTO feedback (rating, feedback_text, email, name, address, college, year, image) 
                    VALUES (:rating, :feedback, :email, :name, :address, :college, :year, :image)";
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':feedback', $feedback);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':college', $college);
            $stmt->bindParam(':year', $year);
            $stmt->bindParam(':image', $image);
            
            // Execute the statement
            $stmt->execute();
            
            // Return success response
            echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully!']);
        } catch (PDOException $e) {
            // Handle any errors
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        // Missing required fields
        echo json_encode(['success' => false, 'message' => 'Required fields are missing.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
