<?php
session_start();
include_once 'config.php'; 

if (isset($_POST['login_btn'])) {
    $name    = mysqli_real_escape_string($con, $_POST['fullname']);
    $em      = mysqli_real_escape_string($con, $_POST['email']);
    $pwd     = mysqli_real_escape_string($con, $_POST['password']); 
    $contact = mysqli_real_escape_string($con, $_POST['contact']);

    $q = "SELECT * FROM user WHERE email='$em' AND password='$pwd' LIMIT 1";
    $result = mysqli_query($con, $q);
    
    if ($result && mysqli_num_rows($result) == 1) {
        $user_data = mysqli_fetch_assoc($result);
        if ($user_data['fullname'] == $name && $user_data['number'] == $contact) {
            if (strtolower($user_data['status']) == 'active') {
                $_SESSION['user_id']    = $user_data['id']; 
                $_SESSION['user_email'] = $user_data['email'];
                $_SESSION['user_name']  = $user_data['fullname'];
                header("Location: " . (strtolower($user_data['role']) == 'admin' ? "admin_dashboard.php" : "dashboard.php"));
                exit(); 
            } else {
                setcookie("error", "Account is not active.", time() + 5, "/");
            }
        } else {
            setcookie("error", "Name ya Contact match nahi hua!", time() + 5, "/");
        }
    } else {
        setcookie("error", "Email ya Password galat hai!", time() + 5, "/");
    }
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FLIMFLIX - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), url('all 1.jpg') no-repeat center center fixed !important; 
            background-size: cover !important; 
            color: #fff;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        .main-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 100px 0;
        }

        /* Left Side Details */
        .brand-details {
            padding-right: 60px;
            color: #ffffff !important;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.8);
        }
        .brand-details h1 {
            font-size: 5rem;
            font-weight: 900;
            color: #e50914;
            margin-bottom: 5px;
        }
        .brand-details h2 { font-size: 2.5rem; margin-bottom: 40px; font-weight: bold; color: #fff; }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 12px;
            border-left: 6px solid #e50914;
        }
        .feature-icon { font-size: 2.2rem; color: #fff; margin-right: 25px; }
        .feature-text h5 { margin-bottom: 2px; font-weight: bold; color: #fff; }
        .feature-text p { margin-bottom: 0; color: #ffffff !important; font-size: 1rem; }

        /* Login Card */
        .login-card {
            background-color: rgba(0, 0, 0, 0.8) !important;
            border-radius: 10px;
            padding: 50px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .form-label { color: #ffffff !important; font-weight: 500; } /* Label White */
        .form-control {
            background: #333 !important;
            border: none;
            color: white !important;
            height: 55px;
        }
        .form-control:focus {
            box-shadow: none;
            border-bottom: 3px solid #e50914;
        }

        .btn-danger {
            background-color: #e50914;
            border: none;
            height: 55px;
            font-weight: bold;
            font-size: 1.2rem;
        }

        /* YAHAN CHANGES KIYE HAIN: LINKS WHITE KARNE KE LIYE */
        .help-links { display: flex; justify-content: space-between; margin-top: 15px; }
        .help-links a { 
            color: #ffffff !important; /* Pure White */
            text-decoration: none; 
            font-size: 0.9rem; 
            font-weight: 400;
        }
        .help-links a:hover { text-decoration: underline; }

        .form-check-label { 
            color: #ffffff !important; /* Remember me White */
            font-size: 0.9rem;
        }

        .signup-text { 
            color: #ffffff !important; /* Main text White */
            margin-top: 40px; 
            font-size: 1.1rem; 
        }
        .signup-text a { 
            color: #e50914 !important; /* Link Red (Netflix Style) */
            text-decoration: none; 
            font-weight: bold; 
        }
        .signup-text a:hover { text-decoration: underline; }

        .captcha-text {
            color: #cccccc !important;
            font-size: 0.75rem;
            margin-top: 15px;
        }

        /* Validation Style */
        .error { color: #ffc107 !important; font-size: 0.85rem; font-weight: bold; display: block; margin-top: 5px; }
        
        @media (max-width: 991px) {
            .brand-details { text-align: center; padding-right: 0; margin-bottom: 40px; }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container main-wrapper">
    <div class="row w-100 g-5 align-items-center">
        
        <div class="col-lg-7 brand-details">
            <h1>FLIMFLIX</h1>
            <h2>Unlimited movies, TV shows, and more.</h2>
            
            <div class="feature-item">
                <i class="fas fa-tv feature-icon"></i>
                <div class="feature-text">
                    <h5>Enjoy on your TV</h5>
                    <p>Watch on Smart TVs, Playstation, Xbox, Apple TV, and more.</p>
                </div>
            </div>

            <div class="feature-item">
                <i class="fas fa-download feature-icon"></i>
                <div class="feature-text">
                    <h5>Download & Watch</h5>
                    <p>Save your favorites easily and always have something to watch.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="login-card shadow-lg">
                <h3 class="mb-4 fw-bold">Sign In</h3>
                
                <?php if(isset($_COOKIE['error'])): ?>
                    <div class="alert alert-warning py-2 small border-0 text-dark mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i> <?php echo $_COOKIE['error']; ?>
                    </div>
                <?php endif; ?>

                <form id="loginForm" action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="fullname" class="form-control" placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="email@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact No</label>
                        <input type="text" name="contact" class="form-control" placeholder="10 Digit Number">
                    </div>

                    <button type="submit" name="login_btn" class="btn btn-danger w-100 mt-2">Sign In</button>

                    <div class="help-links">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remMe">
                            <label class="form-check-label" for="remMe">Remember me</label>
                        </div>
                        <a href="forget.php">Forgot Password?</a>
                    </div>

                    <div class="signup-text">
                        New to FlimFlix? <a href="register.php">Sign up now</a>.
                    </div>
                    
                    <p class="captcha-text">
                        This page is protected by Google reCAPTCHA to ensure you're not a bot.
                    </p>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>

<script>
$(document).ready(function() {
    $("#loginForm").validate({
        rules: {
            fullname: { required: true, minlength: 3 },
            email: { required: true, email: true },
            password: { required: true, minlength: 4 },
            contact: { required: true, digits: true, minlength: 10, maxlength: 10 }
        },
        messages: {
            fullname: "Please enter your full name.",
            email: "Enter a valid email address.",
            password: "Minimum 4 characters required.",
            contact: "Enter a 10-digit mobile number."
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('error');
            element.closest('.mb-3').append(error);
        },
        highlight: function (element) { $(element).addClass('border-warning'); },
        unhighlight: function (element) { $(element).removeClass('border-warning'); }
    });
});
</script>

</body>
</html>