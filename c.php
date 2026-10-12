<?php
// 1. Database connection check karein (config.php mein $con hona chahiye)
include 'config.php'; 

// Agar config.php mein variable ka naam $conn hai, toh yahan $con = $conn; likh dein
if (!isset($con)) {
    die("Database connection variable not found. Check your config.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FILMFLIX - Experience</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body, html { margin: 0; padding: 0; background-color: #000 !important; color: white; scroll-behavior: smooth; }
        .carousel-item div { height: 100vh; min-height: 500px; background-size: cover !important; background-position: center !important; }
        .hero-overlay { background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,1)); width: 100%; height: 100%; }
        .carousel-control-prev-icon, .carousel-control-next-icon { background-color: rgba(229, 9, 20, 0.6); border-radius: 50%; padding: 25px; background-size: 50%; }
        @media (min-width: 992px) { .five-cols .col-lg-custom { flex: 0 0 20%; max-width: 20%; } }
        .release-section { background-color: #000 !important; padding: 80px 0; }
        .section-title { font-size: 1.8rem; font-weight: 700; margin-bottom: 35px; border-left: 5px solid #e50914; padding-left: 15px; letter-spacing: 1px; }
        .poster-container { position: relative; transition: all 0.4s ease-in-out; cursor: pointer; border-radius: 10px; overflow: hidden; background-color: #111; border: 1px solid #1a1a1a; }
        .poster-container img { width: 100%; aspect-ratio: 2/3; object-fit: cover; display: block; }
        .poster-container:hover { transform: scale(1.08); z-index: 5; box-shadow: 0 10px 30px rgba(229, 9, 20, 0.5); border-color: #e50914; }
        .poster-overlay { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(229, 9, 20, 0.9)); padding: 20px; opacity: 0; transition: opacity 0.3s; }
        .poster-container:hover .poster-overlay { opacity: 1; }
        .badge-new { position: absolute; top: 12px; right: 12px; background: #e50914; font-size: 11px; padding: 4px 10px; font-weight: bold; border-radius: 4px; }
        .movie-name { margin-top: 15px; font-size: 14px; font-weight: 600; color: #ccc; transition: 0.3s; }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div id="homeCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $hero_sql = "SELECT * FROM banner";
            $hero_res = mysqli_query($con, $hero_sql);
            $count = 0;
            if ($hero_res && mysqli_num_rows($hero_res) > 0) {
                while ($row = mysqli_fetch_assoc($hero_res)) {
                    $active = ($count == 0) ? "active" : "";
                    $btn_text = ($count == 0) ? "Watch Trailer" : "Get Tickets";
                    $btn_class = ($count == 0) ? "btn-danger shadow-lg" : "btn-outline-light";
                    ?>
                    <div class="carousel-item <?php echo $active; ?>" data-bs-interval="4000">
                        <div class="d-flex flex-column justify-content-center align-items-center text-white text-center"
                             style="background: url('<?php echo $row['imagurl']; ?>');">
                            <div class="hero-overlay d-flex flex-column justify-content-center align-items-center p-3">
                                <h1 class="display-1 fw-bold"><?php echo $row['title']; ?></h1>
                                <p class="lead fs-3"><?php echo $row['subtitle']; ?></p>
                                <button class="btn <?php echo $btn_class; ?> btn-lg rounded-pill px-5 mt-3 fw-bold"><?php echo $btn_text; ?></button>
                            </div>
                        </div>
                    </div>
                    <?php
                    $count++;
                }
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <section class="release-section">
        <div class="container">
            <h2 class="section-title text-uppercase text-light">New Releases</h2>
            <div class="row g-4 five-cols">
                <?php
                $movie_sql = "SELECT * FROM movies ORDER BY id DESC";
                $movie_res = mysqli_query($con, $movie_sql);
                if ($movie_res && mysqli_num_rows($movie_res) > 0) {
                    while ($movie = mysqli_fetch_assoc($movie_res)) {
                        // Check logic for 'name' or 'title'
                        $display_name = isset($movie['name']) ? $movie['name'] : (isset($movie['title']) ? $movie['title'] : 'Unknown Title');
                        $poster = isset($movie['poster img']) ? $movie['poster img'] : (isset($movie['poster_img']) ? $movie['poster_img'] : 'default.jpg');
                ?>
                        <div class="col-6 col-md-4 col-lg-custom text-center mb-4">
                            <div class="poster-container">
                                <?php if (isset($movie['is_new']) && $movie['is_new'] == 1): ?>
                                    <span class="badge-new">NEW</span>
                                <?php endif; ?>

                                <img src="<?php echo $poster; ?>" alt="Movie">

                                <div class="poster-overlay">
                                    <a href="theater.php?id=<?php echo $movie['id']; ?>" class="btn btn-sm btn-light w-100 rounded-pill fw-bold">
                                        Watch Now
                                    </a>
                                </div>
                            </div>
                            <div class="movie-name"><?php echo $display_name; ?></div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p class='text-center'>No movies found.</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>