<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login_form.php");
    exit;
}
?>

<!doctype html>

<html
  lang="en"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets2/"
  data-template="vertical-menu-template-free"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Upload Song</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets2/img/favicon/favicon.png" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="../assets2/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets2/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets2/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets2/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets2/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets2/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets2/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets2/js/config.js"></script>
  </head>


  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->


        <?php include 'header.php'; ?>



        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <?php include 'navbar.php'; ?>


<!-- Portfolio page content here -->






         
      <!-- / Navbar -->

      <?php
// Include the database connection
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}
?>

<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8">
                <!-- Upload Song Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="my_songs.php">
                                    <i class="bx bx-sm bx-music me-1_5"></i> My Songs
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form id="formUploadSong" method="POST" action="process_song_upload.php" enctype="multipart/form-data">
                            <div class="row g-3">
                                <!-- Form fields for song title, description, genre, release date, cover, etc. -->

                                <div class="col-md-12">
                                    <label for="songTitle" class="form-label">Song Title</label>
                                    <input type="text" class="form-control" id="songTitle" name="song_title" placeholder="Enter the song title" required />
                                </div>
                                <div class="col-md-12">
                                    <label for="songDescription" class="form-label">Song Description</label>
                                    <textarea class="form-control" id="songDescription" name="song_description" placeholder="Describe your song..." rows="4" required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="genre" class="form-label">Genre</label>
                                    <select class="form-select" id="genre" name="genre" required>
                                        <option value="pop">Pop</option>
                                        <option value="rock">Rock</option>
                                        <option value="hip-hop">Hip Hop</option>
                                        <option value="jazz">Jazz</option>
                                        <option value="electronic">Electronic</option>
                                        <option value="folk">Folk</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="releaseDate" class="form-label">Release Date</label>
                                    <input type="date" class="form-control" id="releaseDate" name="release_date" required />
                                </div>
                                
                                <!-- Song Cover Upload with Cropper -->
                                <div class="col-md-12">
                                    <label class="form-label">Upload Song Cover</label>
                                    <input type="file" id="songCover" name="song_cover" class="form-control" accept="image/*" required />
                                    <div id="coverImagePreview" class="mt-3"></div>
                                    <button id="confirmCropCover" class="btn btn-primary mt-2" disabled>Confirm Crop</button>
                                    <input type="hidden" id="croppedCoverData" name="cropped_cover">
                                    <small class="form-text text-muted">Accepted formats: JPG, PNG, GIF.</small>
                                </div>

                                <!-- Song File Upload -->
                                <div class="col-md-12">
                                    <label class="form-label">Upload Song File</label>
                                    <input type="file" class="form-control" id="songFile" name="song_file" accept="audio/*" required />
                                    <small class="form-text text-muted">Accepted formats: MP3, WAV, FLAC.</small>
                                </div>
                                
                                <div class="col-md-12">
                                    <label for="tags" class="form-label">Tags (Optional)</label>
                                    <input type="text" class="form-control" id="tags" name="tags" placeholder="Enter tags separated by commas (e.g., upbeat, acoustic, love song)" />
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-3">Upload Song</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Success Message -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel"><i class="bi bi-check-circle-fill"></i> Success!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="successMessage">Song uploaded successfully!</p>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>

<!-- JS for Modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Check for success message in the URL query string and trigger modal
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('message') && urlParams.get('message') === 'success') {
            const modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
        }
    };
</script>

<!-- CSS for Modal (Enhanced Styling) -->
<style>
    /* Modal Header with gradient */
    .modal-header {
        background: linear-gradient(90deg, rgba(0, 204, 255, 1) 0%, rgba(0, 255, 85, 1) 100%);
        color: white;
        border-bottom: none;
    }

    .modal-title i {
        margin-right: 10px;
    }

    /* Modal Body */
    .modal-body {
        font-size: 1.2rem;
        color: #333;
        text-align: center;
    }

  
    .btn-success {
        background-color: #28a745;
        color: white;
        border-radius: 25px;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
        cursor: pointer;
    }

    /* Smooth animation when the modal appears */
    .modal.fade .modal-dialog {
        transform: translate(0, -50px);
        transition: transform 0.3s ease-out;
    }

    .modal.show .modal-dialog {
        transform: translate(0, 0);
    }

    /* Icon styling */
    .modal-title i {
        font-size: 1.5rem;
        color: #f9f9f9;
    }
</style>

<!-- Cropper.js CSS & JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
    let coverCropper;
    document.getElementById('songCover').addEventListener('change', function(event) {
        const fileInput = event.target;
        const coverPreview = document.getElementById('coverImagePreview');
        const confirmCropButton = document.getElementById('confirmCropCover');
        coverPreview.innerHTML = '';
        if (coverCropper) coverCropper.destroy();

        if (fileInput.files && fileInput.files[0]) {
            const file = fileInput.files[0];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100%';
                    img.style.maxHeight = '400px';
                    img.id = 'coverToCrop';
                    coverPreview.appendChild(img);
                    coverCropper = new Cropper(img, { aspectRatio: 1, viewMode: 2 });
                    confirmCropButton.disabled = false;
                };
                reader.readAsDataURL(file);
            }
        }
    });

    document.getElementById('confirmCropCover').addEventListener('click', function() {
        const canvas = coverCropper.getCroppedCanvas();
        const croppedImage = canvas.toDataURL('image/png');
        document.getElementById('coverImagePreview').innerHTML = `<img src="${croppedImage}" style="max-width: 150px;" />`;
        document.getElementById('croppedCoverData').value = croppedImage;
        this.disabled = true;
    });
</script>

<script>
// Show/hide "Specific Users" field based on visibility selection
document.getElementById('visibility').addEventListener('change', function() {
    if (this.value === 'specific-users') {
        document.getElementById('specificUsersSection').style.display = 'block';
    } else {
        document.getElementById('specificUsersSection').style.display = 'none';
    }
});
</script>


<!-- Bootstrap JavaScript (for Modal functionality) -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- Optional: Add any additional JavaScript -->

<style>


/* Success Message in Black */
.custom-modal .alert-success {
    color: #000; /* Black text */
    background-color: #e7f4e7; /* Light green background */
    border-color: #c3e6cb; /* Light green border */
}

/* Smaller and Stylish Modal */
.custom-modal {
    width: 400px;
    border-radius: 8px;
    background-color: #f9f9f9;
    color: #333;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border: none;
}

.custom-modal .modal-header {
    background-color: #007bff; /* Soft blue header */
    color: #fff;
    border-radius: 8px 8px 0 0;
    padding: 1rem;
}

.custom-modal .modal-body {
    padding: 1rem;
    font-size: 1rem;
    line-height: 1.5;
}

.custom-modal .modal-footer {
    padding: 1rem;
    background-color: #f5f5f5;
    border-radius: 0 0 8px 8px;
}

.custom-modal .modal-title {
    font-size: 1.2rem;
    font-weight: 600;
}

.custom-modal .btn-close {
    background-color: transparent;
    border: none;
    color: #fff;
    font-size: 1.25rem;
    opacity: 0.8;
}

.custom-modal .btn-close:hover {
    opacity: 1;
}

.custom-modal .btn-outline-secondary {
    background-color: #e0e0e0;
    color: #333;
    border: 1px solid #ccc;
    font-weight: 500;
    transition: all 0.3s ease;
}

.custom-modal .btn-outline-secondary:hover {
    background-color: #d0d0d0;
    border-color: #bbb;
}

.custom-btn {
    background-color: #007bff; /* Soft blue for the button */
    color: #fff;
    border-radius: 6px;
    padding: 8px 18px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.custom-btn:hover {
    background-color: #0056b3; /* Darker blue on hover */
    border-color: #0056b3;
}

.custom-btn:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
}

</style>



            <?php include 'footer.php'; ?>

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

 

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="../assets2/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets2/vendor/libs/popper/popper.js"></script>
    <script src="../assets2/vendor/js/bootstrap.js"></script>
    <script src="../assets2/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets2/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets2/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets2/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets2/js/dashboards-analytics.js"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
