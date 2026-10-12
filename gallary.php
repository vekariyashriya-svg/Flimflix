<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FILMFLIX - MOVIE GALLERY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-image: url('back.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            padding-top: 100px; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .search-wrapper-main { margin-bottom: 40px; }
        .search-input {
            border-radius: 50px 0 0 50px !important;
            padding: 12px 25px !important;
            border: 2px solid #e50914 !important;
            background: rgba(0, 0, 0, 0.8) !important; 
            color: white !important;
        }
        .search-btn {
            border-radius: 0 50px 50px 0 !important;
            background-color: #e50914 !important;
            border: 2px solid #e50914 !important;
            color: white !important;
            padding: 0 30px !important;
            font-weight: bold;
        }
        .cat-img {
            height: 250px;
            object-fit: cover;
            width: 100%;
            transition: 0.5s;
        }
        .card {
            background: #000 !important;
            border: 1px solid #222 !important;
            transition: 0.4s;
            overflow: hidden;
            height: 100%;
        }
        .card:hover {
            transform: scale(1.05);
            border-color: #e50914 !important;
        }
        .card-title { color: white; font-weight: 700; }
        .hr-style {
            width: 80px;
            height: 3px;
            background-color: #e50914;
            opacity: 1;
            margin: 20px auto;
            border: none;
        }
        .movie-item {
            transition: all 0.4s ease;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<?php include 'hhh.php'; ?>

<div class="container">

    <div class="text-center mb-5">
        <h2 class="fw-bold text-light">MOVIE GALLERY</h2>
        <p class="text-light">Explore categories and register for updates</p>
        <hr class="hr-style">
    </div>
    
    <div class="row justify-content-center search-wrapper-main">
        <div class="col-md-6">
            <div class="input-group shadow-lg">
                <input type="text" class="form-control search-input shadow-none" placeholder="Type to filter movies..." id="movieSearch">
                <button class="btn search-btn" type="button"><i class="bi bi-search"></i></button>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5" id="movieGrid">

        <?php
        // Fetch all gallery items from database
        $sql = "SELECT * FROM gallery ORDER BY id ASC";
        $result = mysqli_query($con, $sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $title = htmlspecialchars($row['title']);
                $desc = htmlspecialchars($row['description']);
                $img = htmlspecialchars($row['image_path']);
                $link = htmlspecialchars($row['link']);
                $tags = htmlspecialchars($row['search_tags']);
        ?>
            <div class="col-md-4 movie-item" data-title="<?php echo $tags; ?>">
                <div class="card shadow rounded-4">
                    <img src="<?php echo $img; ?>" class="card-img-top cat-img" alt="<?php echo $title; ?>">
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <h5 class="card-title text-light"><?php echo $title; ?></h5>
                        <p class="text-light small"><?php echo $desc; ?></p>
                        <a href="<?php echo $link; ?>" class="btn btn-danger w-100 py-2 mt-auto rounded-pill">Discover Now</a>
                    </div>
                </div>
            </div>
        <?php
            }
        } else {
            echo '<p class="text-center text-white">No movies found in the gallery.</p>';
        }
        ?>

    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    // Search/filter functionality
    document.getElementById('movieSearch').addEventListener('keyup', function(){
        let filter = this.value.toLowerCase();
        let items = document.querySelectorAll('.movie-item');

        items.forEach(function(item){
            let text = item.getAttribute('data-title').toLowerCase();
            item.style.display = text.includes(filter) ? "block" : "none";
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
</html>