


<?php
session_start();


// if (!isset($_SESSION['user_id'])) {
  
//     header("Location: login_form.php");
//     exit;
// }
?>



<?php
// Include your database connection
include 'db.php';

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(strip_tags($data));
}

// Check if the user is logged in and retrieve their ID from session
if (isset($_SESSION['user_id'])) {
    $artist_id = $_SESSION['user_id'];

    // Query to fetch artist details from the database
    try {
        $sql = "SELECT * FROM artists WHERE id = :artist_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':artist_id', $artist_id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if data was fetched
        if ($stmt->rowCount() > 0) {
            $artist = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Assign fetched values to variables for form pre-filling
            $first_name = sanitize($artist['first_name']);
            $last_name = sanitize($artist['last_name']);
            $email = sanitize($artist['email']);
            $phone_number = sanitize($artist['phone_number']);
            $biography = sanitize($artist['biography']);
            $genre = sanitize($artist['genre']);
            $portfolio = sanitize($artist['portfolio']);
            $social_media = sanitize($artist['social_media']);
            $achievements = sanitize($artist['achievements']);
            $address = sanitize($artist['address']);
            $country = sanitize($artist['country']);
            $currency = sanitize($artist['currency']);
            $profile_picture = sanitize($artist['profile_picture']);
        } else {
            // Handle case where artist data is not found
            echo "Artist data not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // echo "Session user_id not set.";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Index - iLanding Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


  <!-- Main CSS File -->
  <link href="assets/css/music.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: iLanding
  * Template URL: https://bootstrapmade.com/ilanding-bootstrap-landing-page-template/
  * Updated: Nov 12 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo_main_01.png" alt="">
        <!-- <h1 class="sitename">iLanding</h1> -->
      </a>
      <nav id="navmenu" class="navmenu">
  <ul>
    <li><a href="index.php#hero" class="active">Home</a></li>
    <!-- <li><a href="#about">About</a></li> -->
    <li><a href="index.php#featured-talents">Featured Talents</a></li>
    <li><a href="index.php#featured-services">Featured Services</a></li>
    <li><a href="index.php#featured-projects">Explore Projects</a></li>
    <!-- <li class="dropdown"><a href="#"><span>Resources</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
      <ul>
        <li><a href="#">Blog</a></li>
        <li><a href="#">Help Center</a></li>
        <li><a href="#">FAQs</a></li>
        <li><a href="#">Tutorials</a></li>
      </ul>
    </li> -->
    <li><a href="index.php#about">About</a></li>
  </ul>
  <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
      <a class="btn-getstarted" href="html/create_account_form.php">Join Now!</a>

    </div>
  </header>

  <main class="main">

    


<?php
// Include your database connection
include 'db.php';



// Get the artist ID from the URL (e.g., shared_profile_2.php?id=1)
if (isset($_GET['id'])) {
    $artist_id = $_GET['id'];

    // Query to fetch artist details from the database for the given artist_id
    try {
        $sql = "SELECT * FROM artists WHERE id = :artist_id"; // Using artist_id in the WHERE clause
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['artist_id' => $artist_id]);

        // Check if data was fetched
        if ($stmt->rowCount() > 0) {
            $artist = $stmt->fetch(PDO::FETCH_ASSOC);

            // Assign fetched values to variables for display
            $first_name = sanitize($artist['first_name']);
            $last_name = sanitize($artist['last_name']);
            $email = sanitize($artist['email']);
            $phone_number = sanitize($artist['phone_number']);
            $biography = sanitize($artist['biography']);
            $genre = sanitize($artist['genre']);
            $portfolio = sanitize($artist['portfolio']);
            $social_media = sanitize($artist['social_media']);
            $achievements = sanitize($artist['achievements']);
            $address = sanitize($artist['address']);
            $country = sanitize($artist['country']);
            $currency = sanitize($artist['currency']);
            $profile_picture = sanitize($artist['profile_picture']);
            $education = sanitize($artist['education']);
            $expertise = sanitize($artist['expertise']);
            $awards = sanitize($artist['awards']);
            $skills = sanitize($artist['skills']);
            $projects = sanitize($artist['projects']);
        } else {
            echo "Artist not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Artist ID not provided.";
}
?>

<!-- Hero Section -->
<section id="hero" class="hero section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
            <!-- Artist Details and Profile Picture -->
            <div class="col-12 col-md-6 mb-4">
                <div class="profile-details d-flex flex-column align-items-center">
                    <!-- Profile Picture -->
                    <div class="profile-picture mb-3">
                        <?php if (!empty($profile_picture)): ?>
                            <img src="html/uploads/artists/<?php echo $profile_picture; ?>" alt="Profile Picture" class="img-thumbnail rounded-circle" width="150">
                        <?php else: ?>
                            <img src="path_to_default_image.jpg" alt="Default Profile Picture" class="img-thumbnail rounded-circle" width="150">
                        <?php endif; ?>
                    </div>

                    <!-- Personal Details -->
                    <div class="personal-details text-center">
                        <h3 class="artist-name">
                            <?php 
                            echo $first_name . ' ' . $last_name; 
                            
                            // Generate flag emoji using country code
                            $country_code = strtoupper(substr($country, 0, 2)); // Assuming country name is provided
                            $flag_emoji = mb_convert_encoding('&#' . (127397 + ord($country_code[0])) . '&#' . (127397 + ord($country_code[1])) . ';', 'UTF-8', 'HTML-ENTITIES');
                            
                            echo ' ' . $flag_emoji; 
                            ?>
                        </h3>
                        <p><i class="fas fa-envelope"></i> <?php echo $email; ?></p>
                        <p><i class="fas fa-phone"></i> <?php echo $phone_number; ?></p>
                        <p><i class="fas fa-map-marker-alt"></i> <?php echo $country; ?></p>

                        <!-- Social Media Icons -->
                        <div class="social-media mt-3">
                            <a href="https://facebook.com/<?php echo $facebook_username; ?>" class="me-2 text-primary" target="_blank">
                                <i class="fab fa-facebook fa-lg"></i>
                            </a>
                            <a href="https://twitter.com/<?php echo $twitter_username; ?>" class="me-2 text-info" target="_blank">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                            <a href="https://instagram.com/<?php echo $instagram_username; ?>" class="me-2 text-danger" target="_blank">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                            <a href="https://linkedin.com/in/<?php echo $linkedin_username; ?>" class="me-2 text-primary" target="_blank">
                                <i class="fab fa-linkedin fa-lg"></i>
                            </a>
                            <a href="https://wa.me/<?php echo $whatsapp_number; ?>" class="me-2 text-success" target="_blank">
                                <i class="fab fa-whatsapp fa-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcoming Banner with Message Me Button -->
            <div class="col-12 col-md-6 mb-4">
                <div class="welcome-banner d-flex align-items-center justify-content-center text-white p-4" 
                     style="background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%); 
                            border-radius: 12px;">
                    <div class="banner-text text-center">
                    <h1 style="color: white;">Welcome to My Page</h1>
                    <p class="lead mb-3" style="color: #f0f0f0;">
                        Explore the range of specialized services I provide, designed to meet your unique needs. 
                    </p>
                    </div>
                </div>
            </div>
        </div>
</section>



<style>
  /* General section styling */
  #featured-songs {
    background-color: rgba(211, 211, 211, 0.05);
    padding: 40px 0;
  }

  /* Center align the section title */
  .section-title {
    text-align: center;
  }

  /* Song list container */
  .songs-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
  }

  /* Song item card */
  .song-item {
    display: flex;
    align-items: center;
    padding: 10px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    max-width: 750px;
    width: 100%;
  }

  /* Song cover image */
  .song-image {
    flex-shrink: 0;
    width: 120px;
    height: 120px;
    background-size: cover;
    background-position: center;
    border-radius: 10px;
    margin-right: 15px;
  }

  /* Song information container */
  .song-info {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  /* Song title styling with truncation on mobile */
  .song-title {
    font-size: 1.3rem;
    font-weight: bold;
    color: #333;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* Artist and album info */
  .song-meta {
    color: #555;
    font-size: 0.9rem;
    margin: 2px 0;
  }

  /* Play button styling */
  .play-icon {
    font-size: 2rem;
    color: #007bff; /* Ensures blue color */
    background: none;
    background-color: transparent; /* Removes any unwanted background */
    border: none;
    box-shadow: none;
    padding: 0;
    cursor: pointer;
  }

  /* Ensures the play icon is blue */
  .play-icon i {
    color: #007bff;
    transition: color 0.2s ease-in-out;
  }

  /* Hover effect for play button */
  .play-icon:hover i {
    color: #0056b3; /* Darker blue on hover */
  }

  /* Responsive design adjustments for mobile */
  @media screen and (max-width: 600px) {
    .song-item {
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 15px;
    }

    .song-image {
      width: 100px;
      height: 100px;
      margin-bottom: 10px;
    }

    .song-title {
      font-size: 1.1rem;
    }

    .song-meta {
      font-size: 0.85rem;
    }

    .play-icon {
      font-size: 1.8rem;
    }
  }
</style>

<section id="featured-songs" class="blank-section" style="background-color: rgba(211, 211, 211, 0.05); padding: 40px 0;">
    <div class="container section-title" data-aos="fade-up" style="text-align: center;">
        <h2 style="font-size: 2.5rem; font-weight: bold; color: #333; margin-bottom: 15px;">My Previous Songs</h2>
        <p style="color: #555; font-size: 1.1rem;">Explore the rich sounds and creativity from my previous work across various genres.</p>
    </div>
    <div class="container py-4">
        <div class="songs-list" style="display: flex; flex-direction: column; gap: 20px; align-items: center;">
            <?php
            // Include and initialize getID3 library
            require_once('getid3/getid3.php');
            $getID3 = new getID3;

            if (isset($_GET['id'])) {
                $artist_id = $_GET['id'];
                $stmt = $pdo->prepare("SELECT * FROM songs WHERE artist_id = :artist_id ORDER BY release_date DESC");
                $stmt->execute(['artist_id' => $artist_id]);

                if ($stmt->rowCount() > 0) {
                    $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($songs as $index => $row) {
                        // Determine song cover and file path
                        $song_cover = !empty($row['song_cover'])
                            ? 'html/uploads/songs/covers/' . htmlspecialchars($row['song_cover'])
                            : 'html/uploads/songs/default_song_cover.jpg';

                        $song_file_path = (!empty($row['song_file']) && file_exists("html/" . $row['song_file']))
                            ? "html/" . $row['song_file']
                            : "html/uploads/default_song_file.mp3";

                        // Initialize metadata variables
                        $duration    = '';
                        $file_title  = '';
                        $file_artist = '';
                        $file_album  = '';

                        // Analyze the song file to get metadata
                        if (file_exists($song_file_path)) {
                            $ThisFileInfo = $getID3->analyze($song_file_path);

                            // Get the duration (playtime_string)
                            if (isset($ThisFileInfo['playtime_string'])) {
                                $duration = $ThisFileInfo['playtime_string'];
                            }

                            // Check for tags in common formats (ID3v2, ID3v1, APE, etc.)
                            if (isset($ThisFileInfo['tags'])) {
                                if (isset($ThisFileInfo['tags']['id3v2'])) {
                                    $tags = $ThisFileInfo['tags']['id3v2'];
                                } elseif (isset($ThisFileInfo['tags']['id3v1'])) {
                                    $tags = $ThisFileInfo['tags']['id3v1'];
                                } elseif (isset($ThisFileInfo['tags']['ape'])) {
                                    $tags = $ThisFileInfo['tags']['ape'];
                                } else {
                                    $tags = [];
                                }

                                // Extract metadata from file if available
                                $file_title  = (isset($tags['title'][0])  && !empty($tags['title'][0]))  ? $tags['title'][0]  : '';
                                $file_artist = (isset($tags['artist'][0]) && !empty($tags['artist'][0])) ? $tags['artist'][0] : '';
                                $file_album  = (isset($tags['album'][0])  && !empty($tags['album'][0]))  ? $tags['album'][0]  : '';
                            }
                        }

                        // Fallback to database values if file metadata is missing
                        $song_title  = !empty($file_title)  ? $file_title  : (!empty($row['song_title']) ? $row['song_title'] : 'Unknown Title');
                        $song_artist = !empty($file_artist) ? $file_artist : (!empty($row['song_artist']) ? $row['song_artist'] : 'Unknown Artist');
                        $song_album  = !empty($file_album)  ? $file_album  : (!empty($row['song_album']) ? $row['song_album'] : 'Unknown Album');
            ?>
            <div class="song-item" style="display: flex; align-items: center; padding: 10px; background-color: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); max-width: 750px; width: 100%;">
                <!-- Song image -->
                <div class="song-image" style="flex-shrink: 0; width: 120px; height: 120px; background-image: url('<?php echo $song_cover; ?>'); background-size: cover; border-radius: 10px; margin-right: 15px;"></div>
                <div class="song-info" style="flex-grow: 1; display: flex; flex-direction: column;">
                    <!-- Title, Artist, Album with Duration on the edge -->
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="flex-grow: 1; margin-right: 10px;">
                            <!-- Allow the title to wrap instead of truncating -->
                            <h5 style="font-size: 1.3rem; font-weight: bold; color: #333; margin: 0;">
                                <?php echo htmlspecialchars($song_title); ?>
                            </h5>
                            <p style="color: #555; font-size: 0.9rem; margin: 2px 0;">
                                <?php echo htmlspecialchars($song_artist); ?> &mdash; <?php echo htmlspecialchars($song_album); ?>
                            </p>
                        </div>
                        <span style="font-size: 0.9rem; color: #555;">
                            <?php echo $duration; ?>
                        </span>
                    </div>
                    <!-- Optional description from the database (remove if not needed) -->
                    <?php if (!empty($row['song_description'])): ?>
                    <!-- <p style="color: #555; font-size: 0.9rem; margin: 5px 0;">
                        <?php echo htmlspecialchars($row['song_description']); ?>
                    </p> -->
                    <?php endif; ?>
                    <div style="display: flex; justify-content: flex-end; align-items: center;">
    <a href="javascript:void(0);" class="play-icon" 
       data-song-file="<?php echo $song_file_path; ?>" 
       data-song-title="<?php echo htmlspecialchars($song_title); ?>" 
       data-song-cover="<?php echo $song_cover; ?>" 
       data-song-index="<?php echo $index; ?>" 
       style="font-size: 1.8rem; color: #007bff; background: none; border: none; padding: 0; cursor: pointer;">
        <i class="fas fa-play-circle"></i>
    </a>
    <a href="<?php echo $song_file_path; ?>" download="<?php echo htmlspecialchars($song_title); ?>.mp3" 
       style="font-size: 1.2rem; color: #28a745; margin-left: 10px; cursor: pointer;">
        <i class="fas fa-download"></i>
    </a>
</div>

                </div>
            </div>
            <?php
                    }
                } else {
                    echo "<p class='text-center' style='color: #555;'>No songs found.</p>";
                }
            }
            ?>
        </div>
    </div>
</section>


<!-- Music Player Modal -->
<!-- Music Player Modal -->
<div id="music-player-modal" style="position: fixed; bottom: 20px; left: 0; width: 100%; background-color: white; padding: 10px 15px; box-shadow: 0 -2px 10px rgba(0,0,0,0.1); display: none; z-index: 1000; max-height: 180px;">
    <!-- Close Button -->
    <span id="close-modal" style="position: absolute; top: 5px; right: 10px; font-size: 1.8rem; cursor: pointer; color: #007bff;">&times;</span>

    <div style="display: flex; align-items: center; margin-top: 5px;">
        <!-- Song Cover -->
        <img id="song-cover" src="" alt="Song Cover" style="width: 60px; height: 60px; border-radius: 10px; object-fit: cover; margin-right: 15px;">
        
        <!-- Song Title and Progress -->
        <div style="flex-grow: 1;">
            <h2 id="song-title" style="font-size: 1rem; color: #333; margin-bottom: 5px;">Song Title</h2>
            <audio id="audio-player" style="width: 100%;" ontimeupdate="updateProgressBar()" onended="onSongEnded()"></audio>
            <div id="progress-container" style="width: 100%; background-color: #eee; height: 5px; border-radius: 5px; margin-top: 5px; position: relative; overflow: hidden;">
                <div id="progress-bar" style="height: 100%; background-color: #007bff; width: 0%; border-radius: 5px; position: absolute;"></div>
                <div id="wave" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0;">
                    <div id="wave-animation" style="height: 100%; background-color: rgba(0, 123, 255, 0.5); animation: wave-animation 3s infinite linear;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Controls Container -->
    <div style="display: flex; justify-content: center; align-items: center; margin-top: 10px;">
        <!-- Prev Button -->
        <button id="prev-button" style="font-size: 1.5rem; cursor: pointer; color: #007bff; background: none; border: none; padding: 0;">
            <i class="bi bi-skip-backward-fill"></i>
        </button>

        <!-- Play/Pause Button -->
        <button id="play-pause-button" style="font-size: 1.5rem; cursor: pointer; color: #007bff; margin-left: 10px; background: none; border: none; padding: 0;">
            <i class="bi bi-play-fill"></i> <!-- Default play icon -->
        </button>

        <!-- Next Button -->
        <button id="next-button" style="font-size: 1.5rem; cursor: pointer; color: #007bff; margin-left: 10px; background: none; border: none; padding: 0;">
            <i class="bi bi-skip-forward-fill"></i>
        </button>

        <!-- Repeat Button (Moved to the right end) -->
        <button id="repeat-button" style="font-size: 1.5rem; cursor: pointer; color: #007bff; margin-left: 10px; background: none; border: none; padding: 0;">
            <i class="bi bi-arrow-repeat"></i>
        </button>

        <!-- Volume Controls -->
        <div id="volume-control" style="display: flex; align-items: center; margin-left: 15px;">
        <button id="mute-volume" style="font-size: 1.5rem; cursor: pointer; color: #007bff; background: none; border: none; padding: 0;">
                <i class="bi bi-volume-mute-fill"></i>
            </button>
            <button id="decrease-volume" style="font-size: 1.5rem; cursor: pointer; color: #007bff; background: none; border: none; padding: 0;">
                <!-- <i class="bi bi-volume-down-fill"></i> -->
            </button>
            <input type="range" id="volume-slider" min="0" max="100" value="100" style="width: 100px; margin: 0 10px;">
            <button id="increase-volume" style="font-size: 1.5rem; cursor: pointer; color: #007bff; background: none; border: none; padding: 0;">
                <!-- <i class="bi bi-volume-up-fill"></i> -->
            </button>
          
        </div>
    </div>
</div>

<script>
    let songs = [];
    let currentSongIndex = -1;
    let repeatMode = 'off'; // Can be 'off', 'repeat-one', 'repeat-all'
    let audioPlayer = document.getElementById('audio-player');
    let volumeSlider = document.getElementById('volume-slider');
    let isMuted = false;

    document.querySelectorAll('.play-icon').forEach(icon => {
        icon.addEventListener('click', function() {
            const songIndex = parseInt(this.getAttribute('data-song-index'));
            songs = <?php echo json_encode($songs); ?>; // Store all songs in JS variable
            currentSongIndex = songIndex;

            document.getElementById('song-title').textContent = this.getAttribute('data-song-title');
            document.getElementById('song-cover').src = this.getAttribute('data-song-cover');
            audioPlayer.src = this.getAttribute('data-song-file');
            
            document.getElementById('music-player-modal').style.display = 'block';
            audioPlayer.play();

            let playPauseIcon = document.getElementById('play-pause-button').querySelector('i');
            playPauseIcon.classList.remove('bi-play-fill');
            playPauseIcon.classList.add('bi-pause-fill');
        });
    });

    document.getElementById('close-modal').addEventListener('click', function() {
        document.getElementById('music-player-modal').style.display = 'none';
        audioPlayer.pause();
    });

    document.getElementById('play-pause-button').addEventListener('click', function() {
        var icon = this.querySelector('i');
        if (audioPlayer.paused) {
            audioPlayer.play();
            icon.classList.remove('bi-play-fill');
            icon.classList.add('bi-pause-fill');
        } else {
            audioPlayer.pause();
            icon.classList.remove('bi-pause-fill');
            icon.classList.add('bi-play-fill');
        }
    });

    document.getElementById('prev-button').addEventListener('click', function() {
        if (currentSongIndex > 0) {
            currentSongIndex--;
            loadSong(currentSongIndex);
        }
    });

    document.getElementById('next-button').addEventListener('click', function() {
        if (currentSongIndex < songs.length - 1) {
            currentSongIndex++;
            loadSong(currentSongIndex);
        }
    });

    // Repeat button logic
    document.getElementById('repeat-button').addEventListener('click', function() {
        if (repeatMode === 'off') {
            repeatMode = 'repeat-all';
            this.querySelector('i').classList.add('bi-arrow-repeat-active');
            this.querySelector('i').classList.remove('bi-arrow-repeat-1');
        } else if (repeatMode === 'repeat-all') {
            repeatMode = 'repeat-one';
            this.querySelector('i').classList.add('bi-arrow-repeat-1');
            this.querySelector('i').classList.remove('bi-arrow-repeat-active');
        } else {
            repeatMode = 'off';
            this.querySelector('i').classList.remove('bi-arrow-repeat-active');
            this.querySelector('i').classList.remove('bi-arrow-repeat-1');
        }
    });

    function loadSong(index) {
        const song = songs[index];
        document.getElementById('song-title').textContent = song.song_title;
        document.getElementById('song-cover').src = 'html/uploads/songs/covers/' + (song.song_cover || 'default_song_cover.jpg');
        audioPlayer.src = 'html/' + (song.song_file || 'uploads/default_song_file.mp3');
        audioPlayer.play();
        
        let playPauseIcon = document.getElementById('play-pause-button').querySelector('i');
        playPauseIcon.classList.remove('bi-play-fill');
        playPauseIcon.classList.add('bi-pause-fill');
    }

    function updateProgressBar() {
        var progressBar = document.getElementById('progress-bar');
        if (audioPlayer.duration > 0) {
            var progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
            progressBar.style.width = progress + '%';
        }
    }

    document.getElementById('progress-container').addEventListener('click', function(event) {
        var progressContainer = document.getElementById('progress-container');
        var progress = (event.offsetX / progressContainer.offsetWidth) * audioPlayer.duration;
        audioPlayer.currentTime = progress;
    });

    function onSongEnded() {
        if (repeatMode === 'repeat-all') {
            if (currentSongIndex < songs.length - 1) {
                currentSongIndex++;
                loadSong(currentSongIndex);
            } else {
                currentSongIndex = 0;
                loadSong(currentSongIndex);
            }
        } else if (repeatMode === 'repeat-one') {
            audioPlayer.currentTime = 0;
            audioPlayer.play();
        } else {
            if (currentSongIndex < songs.length - 1) {
                currentSongIndex++;
                loadSong(currentSongIndex);
            } else {
                document.getElementById('music-player-modal').style.display = 'none';
                audioPlayer.pause();
            }
        }
    }


        // Adjust the volume based on the slider
        volumeSlider.addEventListener('input', function() {
        audioPlayer.volume = volumeSlider.value / 100;
    });

    // Increase the volume by 10%
    document.getElementById('increase-volume').addEventListener('click', function() {
        if (audioPlayer.volume < 1) {
            audioPlayer.volume = Math.min(1, audioPlayer.volume + 0.1);
            volumeSlider.value = audioPlayer.volume * 100;
        }
    });

    // Decrease the volume by 10%
    document.getElementById('decrease-volume').addEventListener('click', function() {
        if (audioPlayer.volume > 0) {
            audioPlayer.volume = Math.max(0, audioPlayer.volume - 0.1);
            volumeSlider.value = audioPlayer.volume * 100;
        }
    });

    // Mute or unmute the audio
    document.getElementById('mute-volume').addEventListener('click', function() {
        isMuted = !isMuted;
        audioPlayer.muted = isMuted;
        if (isMuted) {
            this.querySelector('i').classList.add('bi-volume-mute-fill');
            this.querySelector('i').classList.remove('bi-volume-up-fill');
            this.querySelector('i').classList.remove('bi-volume-down-fill');
        } else {
            this.querySelector('i').classList.remove('bi-volume-mute-fill');
            this.querySelector('i').classList.add('bi-volume-up-fill');
        }
    });




</script>


<!-- External Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<!-- External or Internal Style for UI Enhancements -->
<style>
    .play-icon {
        color: white;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        transition: background-color 0.3s;
    }

    .play-icon:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease-in-out;
    }

    .badge {
        margin-top: 5px;
    }

    #progress-container {
        background-color: #eee;
        height: 5px;
        border-radius: 5px;
        margin-top: 10px;
        position: relative;
        overflow: hidden;
    }

    #progress-bar {
        background-color: #007bff;
        height: 100%;
        width: 0%;
        border-radius: 5px;
        position: absolute;
    }

    /* Wave Animation */
    @keyframes wave-animation {
        0% {
            left: -100%;
        }
        100% {
            left: 100%;
        }
    }

    #wave-animation {
        width: 100%;
        height: 100%;
        background-color: rgba(0, 123, 255, 0.5);
        animation: wave-animation 3s infinite linear;
    }

    /* Repeat Button Styles */
    .bi-arrow-repeat-active {
        color: green; /* Active state color */
    }

    .bi-arrow-repeat-1 {
        color: orange; /* Repeat one state color */
    }

    /* Volume Control Styles */
    #volume-slider {
        -webkit-appearance: none;
        appearance: none;
        height: 8px;
        background: #ddd;
        border-radius: 5px;
        outline: none;
    }

    #volume-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        background: #007bff;
        border-radius: 50%;
        cursor: pointer;
    }

    #volume-slider::-moz-range-thumb {
        width: 20px;
        height: 20px;
        background: #007bff;
        border-radius: 50%;
        cursor: pointer;
    }
</style>


<!-- External or Internal Style and JavaScript for UI Enhancements -->
<style>
    
    .play-icon {
        color: white;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        transition: background-color 0.3s;
    }

    .play-icon:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    .modal-content {
        background-color: #222;
        color: white;
    }

    .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease-in-out;
    }

    .badge {
        margin-top: 5px;
    }

    #progress-container {
        background-color: #eee;
        height: 5px;
        border-radius: 5px;
        margin-top: 10px;
    }

    #progress-bar {
        background-color: #007bff;
        height: 100%;
        width: 0%;
        border-radius: 5px;
    }
</style>

<script>
    // Optional: Initialize AOS (Animate On Scroll) for additional effects
    AOS.init({
        duration: 1200,
        once: true,
    });
</script>




<!-- External or Internal Style and JavaScript for UI Enhancements -->
<style>
    /* Styling play icon */
    /* .play-icon {
        color: white;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        transition: background-color 0.3s;
    }

    .play-icon:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

  
    .modal-content {
        background-color: #222;
        color: white;
    }


    .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease-in-out;
    }

    .badge {
        margin-top: 5px;
    } */
</style>

<script>
    // Optional: Initialize AOS (Animate On Scroll) for additional effects
    AOS.init({
        duration: 1200,
        once: true,
    });
</script>















<style>
    /* Add this to your CSS */
.welcome-banner {
    border-radius: 15px; /* Adjust the value for more or less rounding */
    overflow: hidden; /* Ensures content doesn't overflow the rounded corners */
}


</style>





<style>
    /* Profile section layout */
.profile-details {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
}

.profile-picture {
    flex-shrink: 0;
    margin-right: 20px;
}

.personal-details {
    max-width: 500px;
}

.artist-name {
    font-size: 24px;
    font-weight: bold;
    color: #333;
}

/* Service cards layout */
.service-card {
    border: none;
    border-radius: 8px;
    overflow: hidden;
}

.service-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.service-card-body {
    padding: 15px;
}

</style>




<!-- Add the CSS for the love icon -->
<style>
/* Initially faint love icon color */
.love-icon {
    color: #ddd; /* Faint gray */
    transition: color 0.3s ease;
}

/* Change to red when clicked */
.love-icon.liked {
    color: red; /* Red when clicked */
}
</style>







</main>


<style>
    /* Make the love icon faint by default */
.love-icon {
    opacity: 0.5;
    transition: opacity 0.3s ease-in-out;
}

/* Make the love icon full when clicked or active */
.love-icon.liked {
    opacity: 1;
}

</style>
  

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>