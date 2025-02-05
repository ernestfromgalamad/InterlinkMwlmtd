


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
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>InterLink Malawi</title>
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

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

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
    <li><a href="#hero" class="active">Home</a></li>
    <!-- <li><a href="#about">About</a></li> -->
    <li><a href="#featured-talents">Featured Talents</a></li>
    <li><a href="#featured-services">Featured Services</a></li>
    <li><a href="#featured-projects">Explore Projects</a></li>
    <!-- <li class="dropdown"><a href="#"><span>Resources</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
      <ul>
        <li><a href="#">Blog</a></li>
        <li><a href="#">Help Center</a></li>
        <li><a href="#">FAQs</a></li>
        <li><a href="#">Tutorials</a></li>
      </ul>
    </li> -->
    <li><a href="#about">About</a></li>
  </ul>
  <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>

<a class="btn-getstarted" href="index.html#about">
    <i class="fas fa-sign-in-alt"></i> Sign in
</a>

    </div>
  </header>

  <main class="main">

   
    <section id="featured-services" class="hero section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Featured Jobs</h2>
        <p>Explore a wide array of job opportunities posted by talented artists across various industries. Whether you're looking for freelance gigs, part-time, or full-time positions, you'll find a range of exciting opportunities to elevate your career.</p>
    </div>
    <!-- End Section Title -->

    <!-- Jobs -->
    <div class="container py-5">
        <div class="row g-4">
        <?php
        // Fetch all jobs and the corresponding artist details from the database
        $stmt = $pdo->prepare("SELECT j.*, CONCAT(a.first_name, ' ', a.last_name) AS fullname, a.profile_picture 
                               FROM `jobs` j 
                               LEFT JOIN `artists` a ON j.user_id = a.id 
                               ORDER BY j.created_at DESC");
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $job_title = htmlspecialchars($row['job_title']);
            $job_description = htmlspecialchars($row['job_description']);
            $job_media = htmlspecialchars($row['job_media']);
            $created_at = htmlspecialchars($row['created_at']);
            $job_location = htmlspecialchars($row['job_location']);
            $job_requirements = htmlspecialchars($row['job_requirements']);
            $fullname = htmlspecialchars($row['fullname']);
            $artist_profile_picture = htmlspecialchars($row['profile_picture']);
            if (empty($artist_profile_picture)) {
                $artist_profile_picture = 'html/uploads/artists/default_picture.jpg';
            } else {
                $artist_profile_picture = 'html/uploads/artists/' . $artist_profile_picture;
            }
        ?>
            <div class="col-12">
            <div class="card h-100 border-0 rounded-3" style="font-size: 1rem; background-color:rgb(220, 244, 255);">
                    <div class="position-relative">
                        <!-- Apply Button with Icon -->
                        <a href="apply_job.php?job_id=<?php echo $row['job_id']; ?>" class="position-absolute top-0 end-0 p-2 apply-button" style="font-size: 1rem; background-color: #007bff; color: #fff; border-radius: 50px;">
                            <i class="fas fa-paper-plane me-2"></i> Apply Now
                        </a>
                    </div>
                    <div class="card-body px-4 py-4">
                        <!-- Title -->
                        <h5 class="card-title text-dark mb-3" style="font-size: 1.5rem; font-weight: 700;"><?php echo $job_title; ?></h5>
                        
                        <!-- Job Description (Clamped to 2 lines) -->
                        <p class="card-text text-muted mb-3" style="overflow: hidden; text-overflow: ellipsis; -webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical;"><?php echo $job_description; ?></p>
                        
                        <!-- Requirements (Clamped to 2 lines) -->
                        <div class="mb-3" style="overflow: hidden; text-overflow: ellipsis; -webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical;">
                            <span class="text-success"><i class="fas fa-check-circle"></i> <strong>Requirements:</strong> <?php echo $job_requirements; ?></span>
                        </div>

                        <!-- Location -->
                        <div>
                            <span class="text-primary"><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> <?php echo $job_location; ?></span>
                        </div>

                        <hr class="my-3">

                        <!-- Artist Info & Date -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <!-- Artist Profile Link -->
                                <a href="profile_view.php?id=<?php echo $row['user_id']; ?>" class="d-flex align-items-center">
                                    <img src="<?php echo $artist_profile_picture; ?>" alt="Artist Picture" class="rounded-circle" style="width: 40px; height: 40px; border: 3px solid #fff;">
                                    <span class="ms-3 text-muted"><?php echo $fullname; ?></span>
                                </a>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i><?php echo date('F j, Y', strtotime($created_at)); ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</section>


<!-- CSS for line-clamping the description -->
<style>
.card-text {
    display: -webkit-box;
    -webkit-line-clamp: 2;  /* Set this to 2 for limiting the description to 2 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-title {
    color: black;  /* Title color set to black */
}
</style>

<!-- Features Cards Section -->
<section id="features-cards" class="features-cards section">

  <div class="container">

    <div class="row gy-4">

      <!-- Feature 1: Find Talents -->
      <div class="col-xl-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
        <div class="feature-box orange">
          <i class="bi bi-person-check"></i>
          <h4>Find Talents</h4>
          <p>Access a wide pool of talented professionals, including freelancers and remote workers, ready to bring your projects to life.</p>
        </div>
      </div><!-- End Feature Box -->

      <!-- Feature 2: Secure Transactions -->
      <div class="col-xl-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
        <div class="feature-box blue">
          <i class="bi bi-lock"></i>
          <h4>Secure Transactions</h4>
          <p>Enjoy secure payment options with escrow to ensure fair compensation and quality work for both clients and freelancers.</p>
        </div>
      </div><!-- End Feature Box -->

      <!-- Feature 3: Remote Work Opportunities -->
      <div class="col-xl-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
        <div class="feature-box green">
          <i class="bi bi-briefcase"></i>
          <h4>Remote Work Opportunities</h4>
          <p>Explore remote job listings from companies worldwide, offering flexibility and the chance to work from anywhere.</p>
        </div>
      </div><!-- End Feature Box -->

      <!-- Feature 4: Verified Profiles -->
      <div class="col-xl-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
        <div class="feature-box red">
          <i class="bi bi-check-circle"></i>
          <h4>Verified Profiles</h4>
          <p>All professionals and companies are verified, ensuring trust and reliability for a seamless experience.</p>
        </div>
      </div><!-- End Feature Box -->

    </div>

  </div>

</section><!-- /Features Cards Section -->



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