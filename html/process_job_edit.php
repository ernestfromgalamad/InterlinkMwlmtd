<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login_form.php");
    exit;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the database connection
    include 'db.php';

    // Validate and sanitize form inputs
    $job_id = isset($_POST['job_id']) ? (int) $_POST['job_id'] : 0;
    $job_title = isset($_POST['job_title']) ? trim($_POST['job_title']) : '';
    $job_description = isset($_POST['job_description']) ? trim($_POST['job_description']) : '';
    $job_type = isset($_POST['job_type']) ? $_POST['job_type'] : '';
    $job_location = isset($_POST['job_location']) ? trim($_POST['job_location']) : '';
    $job_requirements = isset($_POST['job_requirements']) ? trim($_POST['job_requirements']) : '';
    
    // Handle file upload for media (if any)
    $job_media = null;
    if (isset($_FILES['job_media']) && $_FILES['job_media']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/jobs/';
        $file_name = basename($_FILES['job_media']['name']);
        $file_path = $upload_dir . $file_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['job_media']['tmp_name'], $file_path)) {
            $job_media = $file_path;
        } else {
            echo "Failed to upload media.";
            exit;
        }
    } else {
        // If no new media is uploaded, retain the existing media
        if (isset($_POST['current_media']) && !empty($_POST['current_media'])) {
            $job_media = $_POST['current_media'];
        }
    }

    // Update job in the database
    try {
        $stmt = $pdo->prepare("UPDATE jobs SET job_title = :job_title, job_description = :job_description, job_type = :job_type, job_location = :job_location, job_requirements = :job_requirements, job_media = :job_media WHERE job_id = :job_id");
        
        $stmt->bindParam(':job_title', $job_title);
        $stmt->bindParam(':job_description', $job_description);
        $stmt->bindParam(':job_type', $job_type);
        $stmt->bindParam(':job_location', $job_location);
        $stmt->bindParam(':job_requirements', $job_requirements);
        $stmt->bindParam(':job_media', $job_media);
        $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);

        $stmt->execute();

        // Redirect to the jobs list page after successful update
        header("Location: my_jobs.php");
        exit;
    } catch (PDOException $e) {
        die("Error updating job: " . $e->getMessage());
    }
} else {
    // Redirect if the form is not submitted correctly
    echo "Invalid request method.";
    exit;
}
?>
