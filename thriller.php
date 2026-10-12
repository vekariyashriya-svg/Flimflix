<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    setcookie("error", "Please login to discover movies!", time() + 5, "/");
    header("Location: login22.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thriller Collection - FILMFLIX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #050505; color: white; padding-top: 80px; }
        .section-title { border-left: 4px solid #e50914; padding-left: 15px; margin-bottom: 30px; color: white; }
        @media (min-width: 992px) { .five-cols .col-lg-custom { flex: 0 0 20%; max-width: 20%; } }
        .poster-container { position: relative; transition: transform 0.2s ease; cursor: pointer; background-color: #1a1a1a; border-radius: 8px; overflow: hidden; }
        .poster-container img { width: 100%; aspect-ratio: 2/3; object-fit: cover; display: block; }
        .poster-container:hover { transform: scale(1.05); z-index: 5; box-shadow: 0 10px 25px rgba(229, 9, 20, 0.4); }
        .poster-overlay { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.9)); padding: 15px; }
        .badge-new { position: absolute; top: 10px; right: 10px; background: #e50914; font-size: 10px; padding: 3px 8px; font-weight: bold; border-radius: 2px; z-index: 2; color: white; }
        .movie-title { color: #ffffff !important; font-size: 1.1rem; margin-top: 10px; font-weight: 600; }
        .movie-item { transition: opacity 0.3s ease; }
    </style>
</head>
<body style="background:black;">
    <?php include 'header.php'; ?>
    <div class="container py-5">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-6">
                <div class="input-group search-wrapper">
                    <span class="input-group-text bg-dark border-secondary text-white"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control bg-dark text-white border-secondary shadow-none" placeholder="Search Thriller movies..." id="movieSearch">
                    <button class="btn btn-danger px-4" type="button">Search</button>
                </div>
            </div>
        </div>
        <h2 class="section-title text-uppercase">🔪 Edge of Seat Thrillers</h2>
        <div class="row g-4 five-cols" id="movieGrid">
            <div class="col-6 col-md-4 col-lg-custom text-center movie-item" data-title="drishyam thriller suspense">
                <div class="poster-container shadow"><span class="badge-new">MASTERPIECE</span><img src="drishyam.jpg" alt="Drishyam"><div class="poster-overlay"><a href="theater.php?movie=Drishyam" class="btn btn-sm btn-danger w-100 rounded-pill">Select Session</a></div></div>
                <div class="movie-title">Drishyam</div>
            </div>
            <div class="col-6 col-md-4 col-lg-custom text-center movie-item" data-title="kahaani thriller suspense">
                <div class="poster-container shadow"><img src="kahaani.jpg" alt="Kahaani"><div class="poster-overlay"><a href="theater.php?movie=Kahaani" class="btn btn-sm btn-danger w-100 rounded-pill">Select Session</a></div></div>
                <div class="movie-title">Kahaani</div>
            </div>
            <div class="col-6 col-md-4 col-lg-custom text-center movie-item" data-title="andhadhun thriller comedy">
                <div class="poster-container shadow"><span class="badge-new">UNIQUE</span><img src="andhadhun.jpg" alt="Andhadhun"><div class="poster-overlay"><a href="theater.php?movie=Andhadhun" class="btn btn-sm btn-danger w-100 rounded-pill">Select Session</a></div></div>
                <div class="movie-title">Andhadhun</div>
            </div>
            <div class="col-6 col-md-4 col-lg-custom text-center movie-item" data-title="talaash thriller suspense">
                <div class="poster-container shadow"><img src="talaash.jpg" alt="Talaash"><div class="poster-overlay"><a href="theater.php?movie=Talaash" class="btn btn-sm btn-danger w-100 rounded-pill">Select Session</a></div></div>
                <div class="movie-title">Talaash</div>
            </div>
            <div class="col-6 col-md-4 col-lg-custom text-center movie-item" data-title="it chapter 2 horror thriller">
                <div class="poster-container shadow"><span class="badge-new">HIT</span><img src="it_chapter2.jpg" alt="It Chapter 2"><div class="poster-overlay"><a href="theater.php?movie=It%20Chapter%202" class="btn btn-sm btn-danger w-100 rounded-pill">Select Session</a></div></div>
                <div class="movie-title">It Chapter 2</div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </div>
    <script>
        document.getElementById('movieSearch').addEventListener('keyup', function(){
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll('.movie-item');
            items.forEach(function(item){
                let title = item.getAttribute('data-title').toLowerCase();
                title.includes(filter) ? item.style.display = "block" : item.style.display = "none";
            });
        });
    </script>
</body>
</html>