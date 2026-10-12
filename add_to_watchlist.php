<?php
session_start();
include 'config.php';

if(isset($_POST['movie_title']) && isset($_SESSION['user_id'])) {
    $u_id = $_SESSION['user_id'];
    
    // User details fetch karna
    $user_res = mysqli_query($con, "SELECT fullname FROM user WHERE id = '$u_id'");
    $u_data = mysqli_fetch_assoc($user_res);
    $user_name = $u_data['fullname'];

    $title = mysqli_real_escape_string($con, $_POST['movie_title']);
    $type = mysqli_real_escape_string($con, $_POST['movie_type']);
    $avatar = mysqli_real_escape_string($con, $_POST['movie_avatar']);
    $priority = mysqli_real_escape_string($con, $_POST['movie_rating']);

    // Check karein duplicate toh nahi hai
    $check = mysqli_query($con, "SELECT id FROM watchlist WHERE user_name='$user_name' AND title='$title'");
    
    if(mysqli_num_rows($check) == 0) {
        $sql = "INSERT INTO watchlist (user_name, avatar, title, type, priority) 
                VALUES ('$user_name', '$avatar', '$title', '$type', '$priority')";
        mysqli_query($con, $sql);
    }
}
?>