


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


<?php

// Check if the job_id is passed in the URL
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];

    // Fetch the job details based on the job_id
    $stmt = $pdo->prepare("SELECT j.*, CONCAT(a.first_name, ' ', a.last_name) AS fullname, a.profile_picture 
                           FROM `jobs` j 
                           LEFT JOIN `artists` a ON j.user_id = a.id 
                           WHERE j.job_id = :job_id");
    $stmt->execute(['job_id' => $job_id]);

    $job = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$job) {
        echo "Job not found.";
        exit;
    }

    // Retrieve job details
    $job_title = htmlspecialchars($job['job_title']);
    $job_description = htmlspecialchars($job['job_description']);
    $job_requirements = htmlspecialchars($job['job_requirements']);
    $job_location = htmlspecialchars($job['job_location']);
    $created_at = htmlspecialchars($job['created_at']);
    $artist_name = htmlspecialchars($job['fullname']);
    $artist_profile_picture = htmlspecialchars($job['profile_picture']);
    if (empty($artist_profile_picture)) {
        $artist_profile_picture = 'html/uploads/artists/default_picture.jpg';
    } else {
        $artist_profile_picture = 'html/uploads/artists/' . $artist_profile_picture;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $applicant_name = $_POST['applicant_name'];
        $applicant_email = $_POST['applicant_email'];
        $applicant_message = $_POST['applicant_message'];

        // Insert the application into the database
        $stmt = $pdo->prepare("INSERT INTO job_applications (job_id, applicant_name, applicant_email, applicant_message, applied_at) 
                               VALUES (:job_id, :applicant_name, :applicant_email, :applicant_message, NOW())");
        $stmt->execute([
            'job_id' => $job_id,
            'applicant_name' => $applicant_name,
            'applicant_email' => $applicant_email,
            'applicant_message' => $applicant_message
        ]);

        $success_message = "Your application has been submitted successfully!";
    }
}
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

    
    

    <section id="apply-now" class="hero section">
    <!-- Section Title -->
    <!-- <div class="container section-title" data-aos="fade-up">
        <h2>Apply for the Job</h2>
        <p>Fill out the application form below to apply for this exciting job opportunity.</p>
    </div> -->
    <!-- End Section Title -->

    <!-- Centered Application Form Panel -->
    <div class="container py-5">
        <?php
        // Check if the job_id is passed in the URL
        if (isset($_GET['job_id'])) {
            $job_id = $_GET['job_id'];

            // Fetch the job details based on the job_id
            $stmt = $pdo->prepare("SELECT j.*, CONCAT(a.first_name, ' ', a.last_name) AS fullname, a.profile_picture 
                                   FROM `jobs` j 
                                   LEFT JOIN `artists` a ON j.user_id = a.id 
                                   WHERE j.job_id = :job_id");
            $stmt->execute(['job_id' => $job_id]);

            $job = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$job) {
                echo "Job not found.";
                exit;
            }

            // Retrieve job details
            $job_title = htmlspecialchars($job['job_title']);
            $job_description = htmlspecialchars($job['job_description']);
            $job_requirements = htmlspecialchars($job['job_requirements']);
            $job_location = htmlspecialchars($job['job_location']);
            $created_at = htmlspecialchars($job['created_at']);
            $artist_name = htmlspecialchars($job['fullname']);
            $artist_profile_picture = htmlspecialchars($job['profile_picture']);
            if (empty($artist_profile_picture)) {
                $artist_profile_picture = 'html/uploads/artists/default_picture.jpg';
            } else {
                $artist_profile_picture = 'html/uploads/artists/' . $artist_profile_picture;
            }

            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Collect form data
                $full_name = $_POST['full_name'];
                $dob = $_POST['dob'];
                $sex = $_POST['sex'];
                $nationality = $_POST['nationality'];
                $education_qualification = $_POST['education_qualification'];
                $institution_name = $_POST['institution_name'];
                $major_field_of_study = $_POST['major_field_of_study'];
                $graduation_date = $_POST['graduation_date'];
                $job_title_exp = $_POST['job_title_exp'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $roles = $_POST['roles'];
                $soft_skills = $_POST['soft_skills'];
                $tech_skills = $_POST['tech_skills'];
                $email = $_POST['email'];
                $linkedin_or_website = $_POST['linkedin_or_website'];
                $contact_number = $_POST['contact_number'];
                $expression_of_interest = $_POST['expression_of_interest'];

                // Handle file uploads
                $resume = $_FILES['resume']['name'];
                $highest_qualification = $_FILES['highest_qualification']['name'];

                // Insert the application into the database
                $stmt = $pdo->prepare("INSERT INTO job_applications (job_id, full_name, dob, sex, nationality, education_qualification, institution_name, major_field_of_study, graduation_date, job_title_exp, start_date, end_date, roles, soft_skills, tech_skills, email, linkedin_or_website, contact_number, expression_of_interest, resume, highest_qualification, applied_at) 
                                       VALUES (:job_id, :full_name, :dob, :sex, :nationality, :education_qualification, :institution_name, :major_field_of_study, :graduation_date, :job_title_exp, :start_date, :end_date, :roles, :soft_skills, :tech_skills, :email, :linkedin_or_website, :contact_number, :expression_of_interest, :resume, :highest_qualification, NOW())");
                $stmt->execute([
                    'job_id' => $job_id,
                    'full_name' => $full_name,
                    'dob' => $dob,
                    'sex' => $sex,
                    'nationality' => $nationality,
                    'education_qualification' => $education_qualification,
                    'institution_name' => $institution_name,
                    'major_field_of_study' => $major_field_of_study,
                    'graduation_date' => $graduation_date,
                    'job_title_exp' => $job_title_exp,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'roles' => $roles,
                    'soft_skills' => $soft_skills,
                    'tech_skills' => $tech_skills,
                    'email' => $email,
                    'linkedin_or_website' => $linkedin_or_website,
                    'contact_number' => $contact_number,
                    'expression_of_interest' => $expression_of_interest,
                    'resume' => $resume,
                    'highest_qualification' => $highest_qualification,
                ]);

                $success_message = "Your application has been submitted successfully!";
            }
        }
        ?>

        <!-- Display success message if application is successful -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <!-- Centered Panel -->
        <div class="d-flex justify-content-center">
            <div class="" style="width: 90%; max-width: 1200px;">
                <div class="card-body">
                    <!-- <h3 class="card-title text-center mb-4">Submit Your Application</h3> -->

                    <div class="container section-title" data-aos="fade-up">
        <h2>JOB APPLICATION SECTION</h2>
        <p>Fill out the application form below to apply for this exciting job opportunity.</p>
    </div>
    
    <hr>

                    <div class="row">
                        <!-- Left side: Job Details -->
                        <div class="col-md-6">
                            <!-- <h3 class="mb-4">Job Details</h3> -->
                            <div class="d-flex align-items-center">
                                <img src="<?php echo $artist_profile_picture; ?>" alt="Artist Picture" class="img-fluid rounded-circle" width="100">
                                <div class="ms-3">
                                    <h5><?php echo $artist_name; ?></h5>
                                    <p><strong>Posted the job</strong></p>
                                </div>
                            </div>
                            <br>

                            <h5><?php echo $job_title; ?></h5>
                            <p><?php echo $job_description; ?></p>

                            <h5>Requirements</h5>
                            <p><?php echo $job_requirements; ?></p>

                            <h5>Location</h5>
                            <p><?php echo $job_location; ?></p>

                            <h5>Posted On</h5>
                            <p><?php echo $created_at; ?></p>
                        </div>

                        <!-- Right side: Application Form -->
                        <div class="col-md-6">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                </div>

                                <div class="mb-3">
                                    <label for="sex" class="form-label">Sex</label>
                                    <select class="form-control" id="sex" name="sex" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="nationality" class="form-label">Nationality</label>
                                    <input type="text" class="form-control" id="nationality" name="nationality" required value="Malawi">
                                </div>

                                <h5 class="mt-4">Education Background</h5>
                                <div class="mb-3">
                                    <label for="education_qualification" class="form-label">Qualification</label>
                                    <input type="text" class="form-control" id="education_qualification" name="education_qualification" required>
                                </div>

                                <div class="mb-3">
                                    <label for="institution_name" class="form-label">Name of Institution</label>
                                    <input type="text" class="form-control" id="institution_name" name="institution_name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="major_field_of_study" class="form-label">Major Field of Study</label>
                                    <input type="text" class="form-control" id="major_field_of_study" name="major_field_of_study" required>
                                </div>

                                <div class="mb-3">
                                    <label for="graduation_date" class="form-label">Date of Graduation</label>
                                    <input type="date" class="form-control" id="graduation_date" name="graduation_date" required>
                                </div>

                                
                                <h5 class="mt-4">Skills and Expertise</h5>
                                <div class="mb-3">
                                    <label for="soft_skills" class="form-label">Soft Skills</label>
                                    <textarea class="form-control" id="soft_skills" name="soft_skills" rows="3" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="tech_skills" class="form-label">Tech Skills</label>
                                    <textarea class="form-control" id="tech_skills" name="tech_skills" rows="3" required></textarea>
                                </div>

                                <h5 class="mt-4">Attachments</h5>
                                <div class="mb-3">
                                    <label for="resume" class="form-label">Resume</label>
                                    <input type="file" class="form-control" id="resume" name="resume" required>
                                </div>

                                <div class="mb-3">
                                    <label for="highest_qualification" class="form-label">Highest Qualification</label>
                                    <input type="file" class="form-control" id="highest_qualification" name="highest_qualification" required>
                                </div>

                                <h5 class="mt-4">Additional Information</h5>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Your Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="linkedin_or_website" class="form-label">LinkedIn or Website URL</label>
                                    <input type="url" class="form-control" id="linkedin_or_website" name="linkedin_or_website">
                                </div>

                                <div class="mb-3">
                                    <label for="contact_number" class="form-label">Contact Number</label>
                                    <input type="tel" class="form-control" id="contact_number" name="contact_number" required>
                                </div>

                                <div class="mb-3">
                                    <label for="expression_of_interest" class="form-label">Expression of Interest</label>
                                    <textarea class="form-control" id="expression_of_interest" name="expression_of_interest" rows="3" required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary mt-4">Submit Application</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Centered Panel -->
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


<!-- About Section -->
<section id="about" class="about section">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4 align-items-center justify-content-between">

      <div class="col-xl-5" data-aos="fade-up" data-aos-delay="200">
        <span class="about-meta">ABOUT US</span>
        <h2 class="about-title">Connecting Professionals, Empowering Work</h2>
        <p class="about-description">We are a new platform designed to bring together top-tier freelancers and remote job seekers with clients looking for expert services. From tech to design, writing to marketing, we offer a wide range of opportunities for professionals to grow their careers from anywhere in the world.</p>

        <div class="row feature-list-wrapper">
          <div class="col-md-6">
            <ul class="feature-list">
              <li><i class="bi bi-check-circle-fill"></i> Access global job opportunities</li>
              <li><i class="bi bi-check-circle-fill"></i> Secure payment options</li>
              <li><i class="bi bi-check-circle-fill"></i> Tailored job recommendations</li>
            </ul>
          </div>
          <div class="col-md-6">
            <ul class="feature-list">
              <li><i class="bi bi-check-circle-fill"></i> Easy project management tools</li>
              <li><i class="bi bi-check-circle-fill"></i> A community of professionals</li>
              <li><i class="bi bi-check-circle-fill"></i> Flexible working hours</li>
            </ul>
          </div>
        </div>

        
      </div>

      <div class="col-xl-6" data-aos="fade-up" data-aos-delay="300">
        <div class="image-wrapper">
          <div class="images position-relative" data-aos="zoom-out" data-aos-delay="400">
            <img src="assets/img/about-5.jpg" alt="Freelancer Workspace" class="img-fluid main-image rounded-4">
            <img src="assets/img/about-2.jpg" alt="Team Collaboration" class="img-fluid small-image rounded-4">
          </div>
          <div class="experience-badge floating">
            <h3>10+ <span>Countries</span></h3>
            <p>Where professionals are growing their careers</p>
          </div>
        </div>
      </div>
    </div>

  </div>

</section><!-- /About Section -->




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