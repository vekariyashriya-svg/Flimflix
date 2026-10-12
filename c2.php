<?php
include 'config.php';
session_start();
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
        body, html {
            margin: 0;
            padding: 0;
            background-color: #000000 !important;
            color: white;
            scroll-behavior: smooth;
        }

        .carousel-item div {
            height: 100vh;
            min-height: 500px;
            background-size: cover !important;
            background-position: center !important;
        }

        .hero-overlay {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 1));
            width: 100%;
            height: 100%;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(229, 9, 20, 0.6);
            border-radius: 50%;
            padding: 25px;
            background-size: 50%;
        }

        @media (min-width: 992px) {
            .five-cols .col-lg-custom {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }

        .release-section {
            background-color: #000000 !important;
            padding: 80px 0;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 35px;
            border-left: 5px solid #e50914;
            padding-left: 15px;
            letter-spacing: 1px;
        }

        .poster-container {
            position: relative;
            transition: all 0.4s ease-in-out;
            cursor: pointer;
            border-radius: 10px;
            overflow: hidden;
            background-color: #111;
            border: 1px solid #1a1a1a;
        }

        .poster-container img {
            width: 100%;
            aspect-ratio: 2/3;
            object-fit: cover;
            display: block;
        }

        .poster-container:hover {
            transform: scale(1.08);
            z-index: 5;
            box-shadow: 0 10px 30px rgba(229, 9, 20, 0.5);
            border-color: #e50914;
        }

        .poster-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(229, 9, 20, 0.9));
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .poster-container:hover .poster-overlay {
            opacity: 1;
        }

        .badge-new {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #e50914;
            font-size: 11px;
            padding: 4px 10px;
            font-weight: bold;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        .movie-name {
            margin-top: 15px;
            font-size: 14px;
            font-weight: 600;
            color: #ccc;
            transition: 0.3s;
        }
        
        /* Login Required Modal */
        .login-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }
        .login-modal-content {
            background: #1a1a1a;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            border: 1px solid #e50914;
            max-width: 400px;
            margin: 20px;
        }
        .login-modal-content .btn {
            margin: 10px;
            padding: 10px 30px;
        }
    </style>
</head>

<body>

    <?php include 'hhh.php'; ?>

    <div id="homeCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $hero_sql = "SELECT * FROM banner";
            $hero_res = mysqli_query($con, $hero_sql);
            $count = 0;
            if ($hero_res && mysqli_num_rows($hero_res) > 0) {
                while ($row = mysqli_fetch_assoc($hero_res)) {
                    $active = ($count == 0) ? "active" : "";
                    if ($count == 0) {
                        $btn_text = "Watch Trailer";
                        $btn_class = "btn-danger shadow-lg";
                    } else {
                        $btn_text = "Get Tickets";
                        $btn_class = "btn-outline-light";
                    }
                    ?>
                    <div class="carousel-item <?php echo $active; ?>" data-bs-interval="4000">
                        <div class="d-flex flex-column justify-content-center align-items-center text-white text-center"
                             style="background: url('<?php echo $row['imagurl']; ?>'); background-size: cover; background-position: center;">
                            <div class="hero-overlay d-flex flex-column justify-content-center align-items-center p-3">
                                <h1 class="display-1 fw-bold"><?php echo htmlspecialchars($row['title']); ?></h1>
                                <p class="lead fs-3"><?php echo htmlspecialchars($row['subtitle']); ?></p>
                                <button class="btn <?php echo $btn_class; ?> btn-lg rounded-pill px-5 mt-3 fw-bold watch-trailer-btn"><?php echo $btn_text; ?></button>
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
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <section class="release-section">
        <div class="container">
            <h2 class="section-title text-uppercase text-light">New Releases</h2>
            <div class="row g-4 five-cols">
                <?php
                $movie_res = mysqli_query($con, "SELECT * FROM movies ORDER BY id DESC LIMIT 5");
                
                if ($movie_res && mysqli_num_rows($movie_res) > 0) {
                    while ($movie = mysqli_fetch_assoc($movie_res)) {
                        $poster = isset($movie['poster_img']) ? $movie['poster_img'] : 'default.jpg';
                        $movie_name = isset($movie['name']) ? $movie['name'] : 'Unknown';
                        $is_new = isset($movie['is_new']) ? $movie['is_new'] : 0;
                        $movie_id = $movie['id'];
                ?>
                        <div class="col-6 col-md-4 col-lg-custom text-center mb-4">
                            <div class="poster-container" data-movie-name="<?php echo htmlspecialchars($movie_name); ?>" data-movie-id="<?php echo $movie_id; ?>">
                                <?php if ($is_new == 1): ?>
                                    <span class="badge-new">NEW</span>
                                <?php endif; ?>
                                <img src="<?php echo htmlspecialchars($poster); ?>" alt="<?php echo htmlspecialchars($movie_name); ?>" onerror="this.src='https://via.placeholder.com/300x450?text=No+Image'">
                                <div class="poster-overlay">
                                    <button class="btn btn-sm btn-light w-100 rounded-pill fw-bold watch-now-btn" 
                                            data-movie-name="<?php echo htmlspecialchars($movie_name); ?>"
                                            data-movie-id="<?php echo $movie_id; ?>">
                                        Watch Now
                                    </button>
                                </div>
                            </div>
                            <div class="movie-name"><?php echo htmlspecialchars($movie_name); ?></div>
                        </div>
                <?php
                    }
                } else {
                    echo '<div class="col-12 text-center">
                            <p class="text-muted">No movies found. Please add movies to database.</p>
                          </div>';
                }
                ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Login Required Modal -->
    <div id="loginModal" class="login-modal">
        <div class="login-modal-content">
            <i class="fas fa-lock" style="font-size: 48px; color: #e50914;"></i>
            <h3 class="mt-3">Login Required</h3>
            <p class="text-muted">Please login to watch movies and add to your watchlist.</p>
            <div>
                <a href="login22.php" class="btn btn-danger">Login</a>
                <a href="flimflix.html" class="btn btn-outline-light">Sign Up</a>
            </div>
            <button class="btn btn-link text-muted mt-3" onclick="closeLoginModal()">Cancel</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Check if user is logged in (you can set this via PHP)
        <?php 
        $is_logged_in = isset($_SESSION['user_id']) || isset($_SESSION['email']);
        ?>
        var isLoggedIn = <?php echo $is_logged_in ? 'true' : 'false'; ?>;
        
        function showLoginModal() {
            document.getElementById('loginModal').style.display = 'flex';
        }
        
        function closeLoginModal() {
            document.getElementById('loginModal').style.display = 'none';
        }
        
        // Watch Now button functionality
        document.querySelectorAll('.watch-now-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const movieName = this.getAttribute('data-movie-name');
                const movieId = this.getAttribute('data-movie-id');
                
                if (isLoggedIn) {
                    // User is logged in - redirect to watchlist or movie page
                    window.location.href = 'theater.php?movie=' + encodeURIComponent(movieName);
                } else {
                    // User not logged in - show login modal
                    showLoginModal();
                }
            });
        });
        
        // Poster container click
        document.querySelectorAll('.poster-container').forEach(container => {
            container.addEventListener('click', function(e) {
                if (!e.target.classList.contains('watch-now-btn')) {
                    const movieName = this.getAttribute('data-movie-name');
                    const movieId = this.getAttribute('data-movie-id');
                    
                    if (isLoggedIn) {
                        window.location.href = 'theater.php?movie=' + encodeURIComponent(movieName);
                    } else {
                        showLoginModal();
                    }
                }
            });
        });
        
        // Watch trailer buttons
        document.querySelectorAll('.watch-trailer-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                alert('🎬 Trailer coming soon!');
            });
        });
        
        // Close modal when clicking outside
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLoginModal();
            }
        });
    </script>
</body>
</html>