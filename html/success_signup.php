<?php
session_start();
include 'db.php'; // Assuming db.php contains your PDO connection

$errors = [];
$email_or_username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $email_or_username = htmlspecialchars($_POST['email-username']);
    $password = htmlspecialchars($_POST['password']);

    // Validate email or username and password
    if (empty($email_or_username)) {
        $errors[] = "Email or Username is required.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // If no errors, check credentials
    if (count($errors) == 0) {
        try {
            // Prepare SQL statement to check if the email or username exists
            $stmt = $pdo->prepare("SELECT * FROM artists WHERE email = :email_or_username OR username = :email_or_username");
            $stmt->execute(['email_or_username' => $email_or_username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Login successful, start session and store user details
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['phone_number'] = $user['phone_number'];
                    $_SESSION['biography'] = $user['biography'];
                    $_SESSION['genre'] = $user['genre'];
                    $_SESSION['portfolio'] = $user['portfolio'];
                    $_SESSION['social_media'] = $user['social_media'];
                    $_SESSION['achievements'] = $user['achievements'];
                    $_SESSION['address'] = $user['address'];
                    $_SESSION['country'] = $user['country'];
                    $_SESSION['currency'] = $user['currency'];
                    $_SESSION['profile_picture'] = $user['profile_picture'];
                    $_SESSION['created_at'] = $user['created_at'];
                    $_SESSION['username'] = $user['username'];
                    
                    header("Location: index.php"); // Redirect to dashboard
                    exit;
                } else {
                    $errors[] = "Invalid password.";
                }
            } else {
                $errors[] = "No user found with that email or username.";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!doctype html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
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

    <title>WELCOME TO INTERLINK</title>

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

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../assets2/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="../assets2/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets2/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card px-sm-6 px-0">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
  <img src="logo_main_01.png" alt="Logo" width="100">
</span>

                  <!-- <span class="app-brand-text demo text-heading fw-bold">sneat</span> -->
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1">Signup Successiful 👋</h4>
              <p class="mb-6">Please sign-in to your account and start the adventure</p>

              <form id="formAuthentication" class="mb-6"  method="POST">
        <div class="mb-6">
            <label for="email" class="form-label">Email or Username</label>
            <input
                type="text"
                class="form-control"
                id="email"
                name="email-username"
                value="<?php echo htmlspecialchars($email_or_username); ?>"
                placeholder="Enter your email or username"
                autofocus />
        </div>
        <div class="mb-6 form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge">
                <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>
        <div class="mb-8">
            <div class="d-flex justify-content-between mt-8">
                <div class="form-check mb-0 ms-2">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                </div>
                <a href="auth-forgot-password-basic.html">
                    <span>Forgot Password?</span>
                </a>
            </div>
        </div>
        <div class="mb-6">
            <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
        </div>
        <?php if (count($errors) > 0): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </form>
              <p class="text-center">
                <span>New on our platform?</span>
                <a href="create_account_form.php">
                  <span>Create an account</span>
                </a>
              </p>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

 
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="../assets2/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets2/vendor/libs/popper/popper.js"></script>
    <script src="../assets2/vendor/js/bootstrap.js"></script>
    <script src="../assets2/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets2/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets2/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
