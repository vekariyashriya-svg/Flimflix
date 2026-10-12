<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FILMFLIX - HOT OFFERS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-image: url('back.jpg'); /* Aapki background image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            padding-top: 100px; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
        }

        /* Search Styling */
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

        /* Card & Offer Styling */
        .card {
            background: #000000 !important;
            border: 1px solid #222 !important;
            transition: 0.4s;
            overflow: hidden;
            height: 100%;
            position: relative;
        }

        .card:hover {
            transform: scale(1.05);
            border-color: #e50914 !important;
        }

        .cat-img {
            height: 230px;
            object-fit: cover;
            width: 100%;
            transition: 0.5s;
            filter: brightness(0.7);
        }

        .card:hover .cat-img {
            filter: brightness(1);
        }

        /* Discount Badge */
        .offer-badge {
            position: absolute;
            top: 15px;
            right: 0;
            background: #e50914;
            color: white;
            padding: 5px 15px;
            font-weight: bold;
            font-size: 0.9rem;
            border-radius: 20px 0 0 20px;
            z-index: 10;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        .price-old { text-decoration: line-through; color: #777; font-size: 0.9rem; }
        .price-new { color: #e50914; font-size: 1.4rem; font-weight: bold; }

        .hr-style {
            width: 80px; height: 3px;
            background-color: #e50914;
            opacity: 1;
            margin: 20px auto;
            border: none;
        }

        .offer-item { transition: all 0.4s ease; }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container">

        <div class="text-center mb-5">
            <h2 class="fw-bold text-light">EXCLUSIVE OFFERS</h2>
            <p class="text-light">Grab the best deals on your favorite blockbusters</p>
            <hr class="hr-style">
        </div>
        
        <div class="row justify-content-center search-wrapper-main">
            <div class="col-md-6">
                <div class="input-group shadow-lg">
                    <input type="text" class="form-control search-input shadow-none" 
                           placeholder="Search for discounts (e.g. 50% off, Free)..." id="offerSearch">
                    <button class="btn search-btn" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5" id="offerGrid">
            
            <?php
            // Database se movies fetch karein jinka discount 0 se zyada ho
            $sql = "SELECT * FROM movie_offers ORDER BY id DESC";
            $res = mysqli_query($con, $sql);

            if ($res && mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
            ?>
            <div class="col-6 col-md-4 col-lg-3 offer-item" 
                 data-title="<?php echo strtolower($row['movie_name'] . " " . $row['offer_tag']); ?>">
                
                <div class="card shadow rounded-4">
                    <div class="offer-badge">
                        <?php echo $row['offer_tag']; ?>
                    </div>

                    <img src="<?php echo $row['movie_image']; ?>" class="card-img-top cat-img" alt="Movie">
                    
                    <div class="card-body p-3 text-center d-flex flex-column">
                        <h6 class="card-title text-light text-truncate"><?php echo $row['movie_name']; ?></h6>
                        
                        <div class="mb-2">
                            <span class="price-new">₹<?php echo number_format($row['discount_price'], 0); ?></span>
                            <span class="price-old ms-2">₹<?php echo number_format($row['original_price'], 0); ?></span>
                        </div>

                        <p class="text-secondary small mb-3">
                            <i class="bi bi-clock-history"></i> Valid until: <?php echo date('d M', strtotime($row['expiry_date'])); ?>
                        </p>

                        <a href="time.php?id=<?php echo $row['id']; ?>" class="btn btn-danger w-100 py-2 mt-auto rounded-pill fw-bold">
                            Watch Now
                        </a>
                    </div>
                </div>
            </div>
            <?php 
                }
            } else {
                echo "<h4 class='text-center text-muted'>No active offers right now!</h4>";
            }
            ?>

        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Filtering Logic (Netflix style fast filtering)
        document.getElementById('offerSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll('.offer-item');

            items.forEach(function(item) {
                let text = item.getAttribute('data-title');
                if (text.includes(filter)) {
                    item.style.display = "block";
                    setTimeout(() => item.style.opacity = "1", 10);
                } else {
                    item.style.opacity = "0";
                    setTimeout(() => item.style.display = "none", 400);
                }
            });
        });
    </script>

</body>
</html>