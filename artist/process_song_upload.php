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
$user_id = $_SESSION['user_id'];  // Assuming `user_id` corresponds to `id` in the artists table

// Retrieve the fullname from the artists table
try {
    $stmt = $pdo->prepare("SELECT CONCAT(first_name, ' ', last_name) AS fullname FROM artists WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $artist = $stmt->fetch(PDO::FETCH_ASSOC);
    $fullname = $artist['fullname'];
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get POST values
    $song_title = $_POST['song_title'];
    $song_description = $_POST['song_description'];
    $genre = $_POST['genre'];
    $release_date = $_POST['release_date'];
    $tags = $_POST['tags'];
    $song_cover = null;
    $song_file = null;

    // Handle song cover upload
    if (isset($_FILES['song_cover']) && $_FILES['song_cover']['error'] == 0) {
        $cover_name = $_FILES['song_cover']['name'];  // Get the original file name
        $cover_tmp_name = $_FILES['song_cover']['tmp_name'];

        // Define the upload path
        $cover_path = 'uploads/songs/covers/' . basename($cover_name);  // Use the original file name

        // Move the uploaded cover file to the desired location
        if (move_uploaded_file($cover_tmp_name, $cover_path)) {
            // Store the original file name in the database
            $song_cover = $cover_name;  // Store the original file name
        } else {
            die("Error uploading the cover image.");
        }
    }

    // Handle song file upload
    if (isset($_FILES['song_file']) && $_FILES['song_file']['error'] == 0) {
        $file_name = $_FILES['song_file']['name'];
        $file_tmp_name = $_FILES['song_file']['tmp_name'];
        $file_path = 'uploads/songs/' . basename($file_name);  // Full path for song file

        // Move the uploaded song file to the desired location
        if (move_uploaded_file($file_tmp_name, $file_path)) {
            $song_file = $file_path;
        } else {
            die("Error uploading the song file.");
        }
    }

    // Insert the song into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO songs (artist_id, song_title, song_description, genre, release_date, song_cover, song_file, tags) 
                               VALUES (:user_id, :song_title, :song_description, :genre, :release_date, :song_cover, :song_file, :tags)");

        // Bind parameters
        $stmt->bindParam(':user_id', $user_id); // This corresponds to artist_id in the songs table
        $stmt->bindParam(':song_title', $song_title);
        $stmt->bindParam(':song_description', $song_description);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':release_date', $release_date);
        $stmt->bindParam(':song_cover', $song_cover);  // Store original file name here
        $stmt->bindParam(':song_file', $song_file);
        $stmt->bindParam(':tags', $tags);

        // Execute the query
        $stmt->execute();

        // Redirect to upload_song.php with a success message
        header("Location: upload_song.php?message=success");
        exit;

    } catch (PDOException $e) {
        // Handle any errors
        die("Error: " . $e->getMessage());
    }
}
?>
