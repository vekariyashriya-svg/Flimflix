<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php'; 
include 'mailer.php'; 

if(isset($_POST['save_user'])) {
    
    if (!$con) { die("Database connection failed: " . mysqli_connect_error()); }

    $fullname  = mysqli_real_escape_string($con, $_POST['FullName']);
    $email     = mysqli_real_escape_string($con, $_POST['email']);
    $number    = mysqli_real_escape_string($con, $_POST['number']);
    $password  = mysqli_real_escape_string($con, $_POST['password']); 
    $birthdate = mysqli_real_escape_string($con, $_POST['Birthdate']);
    $city      = mysqli_real_escape_string($con, $_POST['City']);
    $genres    = isset($_POST['hobbies']) ? implode(", ", $_POST['hobbies']) : "";

    $image_name = "default.png"; 
    if(isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
        $image_name = time() . "_" . basename($_FILES["profile_photo"]["name"]);
        move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_dir . $image_name);
    }

    $query = "INSERT INTO user (image, fullname, email, number, birthdate, password, genres, city, role, status) 
              VALUES ('$image_name', '$fullname', '$email', '$number', '$birthdate', '$password', '$genres', '$city', 'user', 'active')";
    
    if(mysqli_query($con, $query)) {
        
        $subject = "Welcome to FilmFlix!";
        
        // ========== CORRECT BASE URL FOR YOUR PROJECT ==========
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        
        // Get the current directory path (where this script is running)
        $script_dir = dirname($_SERVER['SCRIPT_NAME']);
        
        // Remove trailing slash if present and not root
        if ($script_dir == '/') {
            $base_url = $protocol . "://" . $host;
        } else {
            $base_url = $protocol . "://" . $host . $script_dir;
        }
        
        // Home page link - c.php is in the same directory
        $home_link = $base_url . "/c2.php";
        
        $body = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
                .email-header { background: linear-gradient(135deg, #e50914, #b20710); padding: 30px; text-align: center; }
                .email-header h1 { color: white; margin: 0; font-size: 28px; }
                .email-body { padding: 30px; }
                .email-body h2 { color: #333; margin-top: 0; }
                .email-body p { color: #666; line-height: 1.6; font-size: 16px; }
                .btn-home { display: inline-block; background: linear-gradient(135deg, #e50914, #b20710); color: white; text-decoration: none; padding: 12px 30px; border-radius: 50px; font-weight: bold; margin: 20px 0; transition: 0.3s; }
                .btn-home:hover { background: #b20710; transform: scale(1.05); }
                .email-footer { background-color: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #999; }
                .highlight { color: #e50914; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='email-header'>
                    <h1>🎬 FILMFLIX</h1>
                </div>
                <div class='email-body'>
                    <h2>Welcome to FilmFlix, <span class='highlight'>$fullname</span>! 🎉</h2>
                    <p>Thank you for registering with FilmFlix. Your account has been successfully created.</p>
                    <p>You can now enjoy unlimited access to thousands of movies, TV shows, and exclusive content. Stream anywhere, anytime!</p>
                    <p><strong>Your Account Details:</strong><br>
                    📧 Email: $email<br>
                    🎭 Favorite Genres: $genres<br>
                    📍 City: $city</p>
                    <div style='text-align: center;'>
                        <a href='$home_link' class='btn-home'>🏠 GO TO HOME PAGE</a>
                    </div>
                    <p>Start exploring and discover amazing content tailored just for you!</p>
                    <p>Happy Watching! 🍿<br>
                    <strong>Team FilmFlix</strong></p>
                </div>
                <div class='email-footer'>
                    <p>&copy; 2025 FilmFlix. All rights reserved. | This is an automated email, please do not reply.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        sendEmail($email, $subject, $body);

        echo "<script>
                alert('Registration Successful! A welcome email has been sent to your inbox.');
                window.location.href='login22.php';
              </script>";
        exit();
    } else {
        echo "<h4>Error: " . mysqli_error($con) . "</h4>";
    }
}
?>