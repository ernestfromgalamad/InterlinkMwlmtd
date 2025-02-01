




<section id="featured-projects" class="blank-section" style="background-color: rgba(211, 211, 211, 0.05);">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>My Previos Projects</h2>
        <p>Discover projects posted by talented artists from various genres.</p>
    </div><!-- End Section Title -->

    <!-- Projects -->
    <div class="container py-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            // Check if artist ID is provided in the URL
            if (isset($_GET['id'])) {
                $artist_id = $_GET['id']; // Ensure this value is sanitized in a production environment

                // Fetch projects for the specific artist
                $stmt = $pdo->prepare("
                    SELECT 
                        p.id AS project_id, p.project_name, p.project_description, p.project_media, p.created_at,
                        CONCAT(a.first_name, ' ', a.last_name) AS fullname, a.profile_picture, a.id AS user_id
                    FROM `projects` p 
                    LEFT JOIN `artists` a ON p.user_id = a.id 
                    WHERE a.id = :artist_id
                    ORDER BY p.created_at DESC
                ");
                $stmt->execute(['artist_id' => $artist_id]);

                // Check if any projects are available
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // Sanitize and assign variables
                        $project_id = htmlspecialchars($row['project_id']);
                        $project_name = htmlspecialchars($row['project_name']);
                        $project_description = htmlspecialchars($row['project_description']);
                        $project_media = htmlspecialchars($row['project_media']);
                        $created_at = htmlspecialchars($row['created_at']);
                        $fullname = htmlspecialchars($row['fullname']);
                        $artist_profile_picture = htmlspecialchars($row['profile_picture']);
                        $user_id = htmlspecialchars($row['user_id']);

                        // Default profile picture handling
                        if (empty($artist_profile_picture)) {
                            $artist_profile_picture = 'html/uploads/artists/default_picture_old.jpg';
                        } else {
                            $artist_profile_picture = 'html/uploads/artists/' . $artist_profile_picture;
                        }

                        // Media path validation
                        $project_media_path = "html/" . $project_media;
                        if (!file_exists($project_media_path) || empty($project_media)) {
                            $project_media_path = "html/uploads/default_project_image.jpg"; // Fallback image
                        }
            ?>
            <div class="col mb-4">
                <div class="card h-100" style="font-size: 1rem; border: none;">
                    <div class="position-relative">
                        <img src="<?php echo $project_media_path; ?>" 
                             class="card-img-top img-thumbnail" 
                             alt="Project Image" 
                             style="width: 100%; height: 200px; object-fit: cover;" 
                             data-bs-toggle="modal" 
                             data-bs-target="#projectModal<?php echo $project_id; ?>">

                        <!-- Love Icon -->
                        <a href="your_backend_php_script.php?project_id=<?php echo $project_id; ?>" 
                           class="position-absolute top-0 end-0 p-2 love-icon" 
                           style="font-size: 1.5rem;" 
                           onclick="this.classList.toggle('liked')">
                            <i class="fas fa-heart"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Wrap the project name in a link to the artist's profile -->
                        <h6 class="card-title mb-2"><?php echo $project_name; ?></h6>
                        <!-- <div class="d-flex justify-content-between align-items-center">
                            <div>
                                
                                <a href="profile_view.php?id=<?php echo $user_id; ?>">
                                    <img src="<?php echo $artist_profile_picture; ?>" 
                                         alt="Artist Picture" 
                                         class="rounded-circle" 
                                         style="width: 30px; height: 30px;">
                                </a>
                                <a href="profile_view.php?id=<?php echo $user_id; ?>" 
                                   class="text-muted"><?php echo $fullname; ?></a>
                            </div>
                            <small class="text-muted"><?php echo date('F j, Y', strtotime($created_at)); ?></small>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- Modal for Image Full View -->
            <div class="modal fade" id="projectModal<?php echo $project_id; ?>" tabindex="-1" aria-labelledby="projectModalLabel<?php echo $project_id; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="projectModalLabel<?php echo $project_id; ?>"><?php echo $project_name; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="<?php echo $project_media_path; ?>" class="img-fluid" alt="Full Project Image">
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo "<p class='text-center'>No projects found for this artist.</p>";
                }
            } else {
                echo "<p class='text-center'>No artist ID provided in the URL.</p>";
            }
            ?>
        </div>
    </div>
</section>
