<?php 
// Include the database connection
include 'db.php';

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}

// Get the logged-in user ID from the session
$user_id = $_SESSION['user_id']; 

// Retrieve the fullname from the artists table (concatenate first_name and last_name)
try {
    $stmt = $pdo->prepare("SELECT first_name, last_name FROM artists WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $artist = $stmt->fetch(PDO::FETCH_ASSOC);
    $fullname = $artist['first_name'] . ' ' . $artist['last_name'];  
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get POST values
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    $job_type = $_POST['job_type'];
    $job_category = $_POST['job_category'];
    $job_location = $_POST['job_location'];
    $job_requirements = $_POST['job_requirements'];
    $application_deadline = $_POST['application_deadline'];
    $job_tags = isset($_POST['job_tags']) ? $_POST['job_tags'] : '';  
    $job_media = null;

    // Handle file upload
    if (isset($_FILES['job_media']) && $_FILES['job_media']['error'] == 0) {
        $media_name = $_FILES['job_media']['name'];
        $media_tmp_name = $_FILES['job_media']['tmp_name'];
        $media_path = 'uploads/jobs/' . basename($media_name);

        // Move the uploaded file to the desired location
        if (move_uploaded_file($media_tmp_name, $media_path)) {
            $job_media = $media_path;
        } else {
            die("Error uploading the file.");
        }
    }

    // Insert the job posting into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO jobs (user_id, fullname, job_title, job_description, job_type, job_category, job_location, job_requirements, application_deadline, job_media, job_tags) 
                               VALUES (:user_id, :fullname, :job_title, :job_description, :job_type, :job_category, :job_location, :job_requirements, :application_deadline, :job_media, :job_tags)");

        // Bind parameters
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':job_title', $job_title);
        $stmt->bindParam(':job_description', $job_description);
        $stmt->bindParam(':job_type', $job_type);
        $stmt->bindParam(':job_category', $job_category);
        $stmt->bindParam(':job_location', $job_location);
        $stmt->bindParam(':job_requirements', $job_requirements);
        $stmt->bindParam(':application_deadline', $application_deadline);
        $stmt->bindParam(':job_media', $job_media);
        $stmt->bindParam(':job_tags', $job_tags);

        // Execute the query
        $stmt->execute();

        // Redirect to job listings page after successful insertion
        header("Location: my_jobs.php?message=success");
        exit;

    } catch (PDOException $e) {
        // Handle any errors
        die("Error: " . $e->getMessage());
    }
}
?>
