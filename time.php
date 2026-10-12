<?php
include 'config.php';

// Get movie name from URL
$movie_title = $_GET['movie'] ?? 'Now Showing';
$movie_title_display = htmlspecialchars($movie_title);

// Database se booked seats nikalne ke liye query
$booked_seats = [];
$query = "SELECT seats_booked FROM bookings WHERE movie_title = '$movie_title_display' AND booking_status = 'Confirmed'";
$result = mysqli_query($con, $query);

while($row = mysqli_fetch_assoc($result)) {
    $seats_array = explode(',', $row['seats_booked']);
    $booked_seats = array_merge($booked_seats, $seats_array);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Tickets - <?php echo $movie_title_display; ?> | FILMFLIX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            background: linear-gradient(135deg, #0a0a0a 0%, #000000 100%);
            color: #ffffff; 
            font-family: 'Poppins', 'Segoe UI', Roboto, sans-serif; 
            margin: 0; 
            padding: 0; 
        }
        
        .main-wrapper { 
            padding-top: 100px; 
            padding-bottom: 150px; 
        }
        
        /* Movie Title Section */
        .movie-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .movie-header h1 {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ffffff, #e50914, #ff6b6b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 10px rgba(229,9,20,0.3);
            letter-spacing: 1px;
        }
        .movie-meta {
            display: inline-flex;
            gap: 20px;
            background: rgba(255,255,255,0.08);
            padding: 10px 25px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            margin-top: 15px;
        }
        .movie-meta span {
            color: #ddd;
            font-size: 0.85rem;
        }
        .movie-meta i {
            color: #e50914;
            margin-right: 6px;
        }
        
        /* Time Wrapper */
        .time-wrapper { 
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px; 
            padding: 30px; 
            margin-bottom: 50px; 
            border: 1px solid rgba(229,9,14,0.2);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        
        /* Time Slot Styling */
        .time-slot {
            display: inline-block; 
            padding: 12px 32px; 
            margin: 8px;
            border: 1.5px solid #e50914; 
            color: #e50914;
            text-decoration: none; 
            border-radius: 50px; 
            font-weight: 600;
            transition: all 0.3s ease; 
            background: transparent; 
            cursor: pointer;
            font-size: 0.9rem;
        }
        .time-slot:hover {
            background: rgba(229,9,20,0.1);
            transform: translateY(-2px);
        }
        .time-slot.active {
            background: #e50914 !important;
            color: #fff !important;
            box-shadow: 0 0 20px rgba(229, 9, 20, 0.5);
            transform: translateY(-3px);
        }
        
        /* Screen */
        .screen-container { 
            perspective: 1000px; 
            margin-bottom: 50px; 
        }
        .cinema-screen { 
            height: 8px; 
            width: 60%; 
            margin: 0 auto; 
            background: linear-gradient(90deg, transparent, #e50914, #ff6b6b, #e50914, transparent);
            transform: rotateX(-35deg); 
            box-shadow: 0 10px 30px rgba(229,9,20,0.3);
            border-radius: 50%; 
        }
        .screen-label {
            text-align: center;
            margin-top: 15px;
            color: #888;
            font-size: 0.7rem;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        
        /* Seat Sections */
        .seat-section {
            background: rgba(10, 10, 10, 0.6);
            backdrop-filter: blur(5px);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s ease;
        }
        .seat-section:hover {
            border-color: rgba(229,9,14,0.3);
            box-shadow: 0 5px 20px rgba(229,9,14,0.1);
        }
        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(229,9,14,0.5);
            display: inline-block;
            color: #ffffff;
        }
        .section-title i {
            color: #e50914;
            margin-right: 10px;
        }
        .price-tag {
            font-size: 0.8rem;
            background: #e50914;
            padding: 3px 10px;
            border-radius: 20px;
            margin-left: 12px;
            color: #fff;
            font-weight: 500;
        }
        
        /* Seat Grid - Professional Layout */
        .seats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            justify-items: center;
            align-items: center;
        }
        
        @media (min-width: 768px) {
            .seats-grid {
                grid-template-columns: repeat(10, 1fr);
            }
        }
        
        /* Seat Styling */
        .seat { 
            width: 100%;
            max-width: 55px;
            height: 48px;
            background: linear-gradient(145deg, #1e1e1e, #141414);
            border-radius: 12px 12px 6px 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            transition: all 0.25s ease;
            border: 1px solid #2a2a2a;
            color: #aaa;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        .seat:hover:not(.occupied) { 
            border-color: #e50914; 
            color: #fff; 
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 5px 15px rgba(229,9,20,0.3);
            background: linear-gradient(145deg, #2a2a2a, #1e1e1e);
        }
        .seat.selected { 
            background: linear-gradient(145deg, #e50914, #b00710);
            color: #fff !important; 
            border-color: #ff4d4d;
            box-shadow: 0 0 15px rgba(229,9,20,0.6);
            transform: scale(1.02);
        }
        .seat.occupied { 
            background: linear-gradient(145deg, #0a0a0a, #050505);
            opacity: 0.4;
            cursor: not-allowed; 
            border-color: #1a1a1a;
            transform: none;
        }
        .seat.occupied:hover {
            transform: none;
            box-shadow: none;
        }
        
        /* Legend */
        .seat-legend {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 30px;
            padding: 20px;
            background: rgba(10,10,10,0.5);
            border-radius: 50px;
            flex-wrap: wrap;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.8rem;
            color: #ccc;
        }
        .legend-box {
            width: 30px;
            height: 26px;
            border-radius: 8px 8px 4px 4px;
        }
        .legend-box.available { background: linear-gradient(145deg, #1e1e1e, #141414); border: 1px solid #2a2a2a; }
        .legend-box.selected { background: linear-gradient(145deg, #e50914, #b00710); }
        .legend-box.occupied { background: #0a0a0a; opacity: 0.4; border: 1px solid #1a1a1a; }
        
        /* Booking Bar */
        .booking-bar { 
            position: fixed; 
            bottom: 0; 
            left: 0; 
            width: 100%; 
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(229,9,14,0.3);
            padding: 18px 0; 
            z-index: 1000; 
            box-shadow: 0 -5px 20px rgba(0,0,0,0.5);
        }
        .btn-confirm { 
            background: linear-gradient(135deg, #e50914, #b00710);
            border: none; 
            padding: 14px 55px; 
            font-weight: 800; 
            letter-spacing: 1.5px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            cursor: pointer;
            border-radius: 50px;
            font-size: 1rem;
            text-transform: uppercase;
        }
        .btn-confirm:hover:not(:disabled) { 
            background: linear-gradient(135deg, #ff1a2a, #e50914);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 25px rgba(229, 9, 20, 0.5);
        }
        .btn-confirm:disabled { 
            background: #2a2a2a; 
            opacity: 0.5; 
            cursor: not-allowed;
            transform: none;
        }
        
        .seat-summary {
            font-size: 1rem;
        }
        .seat-summary span {
            color: #e50914;
            font-weight: 700;
        }
        .total-price {
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
        }
        
        @media (max-width: 768px) {
            .seat { height: 40px; font-size: 10px; max-width: 42px; }
            .time-slot { padding: 8px 20px; font-size: 0.8rem; }
            .section-title { font-size: 1rem; }
            .movie-header h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="main-wrapper">
        <div class="container">
            
            <!-- Movie Header - Professional -->
            <div class="movie-header">
                <h1>
                    <i class="fas fa-film me-2" style="background: none; -webkit-text-fill-color: #e50914;"></i>
                    <?php echo $movie_title_display; ?>
                </h1>
                <div class="movie-meta">
                    <span><i class="fas fa-clock"></i> 2h 30m</span>
                    <span><i class="fas fa-language"></i> Multi Language</span>
                    <span><i class="fas fa-tag"></i> 2D • DOLBY ATMOS</span>
                    <span><i class="fas fa-certificate"></i> U/A</span>
                </div>
            </div>

            <!-- Showtime Selection -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="time-wrapper text-center">
                        <p class="small text-uppercase fw-bold mb-4" style="color: #e50914; letter-spacing: 4px;">
                            <i class="fas fa-calendar-alt me-2"></i> SELECT SHOWTIME
                        </p>
                        <div class="d-flex flex-wrap justify-content-center" id="time-container">
                            <div class="time-slot active">10:10 AM</div>
                            <div class="time-slot">08:00 PM</div>
                            <div class="time-slot">11:15 PM</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seat Layout -->
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    
                    <!-- Screen -->
                    <div class="screen-container">
                        <div class="cinema-screen"></div>
                        <div class="screen-label"><i class="fas fa-tv"></i> S C R E E N</div>
                    </div>
                    
                    <!-- Premium Section - 20 Seats -->
                    <div class="seat-section">
                        <div class="section-title">
                            <i class="fas fa-crown"></i> PREMIUM
                            <span class="price-tag">₹210</span>
                        </div>
                        <div id="premium-seats" class="seats-grid"></div>
                    </div>
                    
                    <!-- Executive Section - 20 Seats -->
                    <div class="seat-section">
                        <div class="section-title">
                            <i class="fas fa-star"></i> EXECUTIVE
                            <span class="price-tag">₹170</span>
                        </div>
                        <div id="executive-seats" class="seats-grid"></div>
                    </div>
                    
                    <!-- Normal Section - 20 Seats -->
                    <div class="seat-section">
                        <div class="section-title">
                            <i class="fas fa-chair"></i> NORMAL
                            <span class="price-tag">₹170</span>
                        </div>
                        <div id="normal-seats" class="seats-grid"></div>
                    </div>
                    
                    <!-- Legend -->
                    <div class="seat-legend">
                        <div class="legend-item"><div class="legend-box available"></div> Available</div>
                        <div class="legend-item"><div class="legend-box selected"></div> Selected</div>
                        <div class="legend-item"><div class="legend-box occupied"></div> Booked</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Bar -->
    <div class="booking-bar">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="seat-summary">
                <i class="fas fa-ticket-alt me-2 text-danger"></i>
                Selected Seats: <span id="seat-list" class="fw-bold">None</span>
            </div>
            <div>
                <span class="text-secondary me-2">Total Amount:</span>
                <span class="total-price">₹<span id="price">0</span></span>
            </div>
            <button class="btn-confirm text-white" id="confirmBtn" disabled>
                <i class="fas fa-credit-card me-2"></i> PROCEED TO PAY
            </button>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>

    <script>
        const seatListDisplay = document.getElementById('seat-list');
        const priceDisplay = document.getElementById('price');
        const confirmBtn = document.getElementById('confirmBtn');
        const timeSlots = document.querySelectorAll('.time-slot');

        let selectedSeats = [];
        
        // Booked seats from database
        const occupiedSeats = <?php echo json_encode($booked_seats); ?>;
        
        // Seat prices
        const seatPrices = {
            premium: 210,
            executive: 170,
            normal: 170
        };
        
        function createSeat(seatNum, section, price) {
            const seat = document.createElement('div');
            seat.className = 'seat';
            seat.innerText = seatNum;
            seat.setAttribute('data-seat', seatNum);
            seat.setAttribute('data-price', price);
            seat.setAttribute('data-section', section);
            
            if (occupiedSeats.includes(seatNum.toString())) {
                seat.classList.add('occupied');
            } else {
                seat.onclick = () => {
                    if (seat.classList.contains('selected')) {
                        seat.classList.remove('selected');
                        selectedSeats = selectedSeats.filter(s => s.number !== seatNum);
                    } else {
                        seat.classList.add('selected');
                        selectedSeats.push({ number: seatNum, price: price, section: section });
                    }
                    updateBookingSummary();
                };
            }
            return seat;
        }
        
        function updateBookingSummary() {
            const totalAmount = selectedSeats.reduce((sum, seat) => sum + seat.price, 0);
            const seatNumbers = selectedSeats.map(s => s.number).sort((a,b) => a-b).join(', ');
            
            seatListDisplay.innerText = selectedSeats.length ? seatNumbers : "None";
            priceDisplay.innerText = totalAmount;
            confirmBtn.disabled = selectedSeats.length === 0;
        }
        
        // Premium Seats (1-20)
        const premiumContainer = document.getElementById('premium-seats');
        for (let i = 1; i <= 20; i++) {
            premiumContainer.appendChild(createSeat(i, 'premium', seatPrices.premium));
        }
        
        // Executive Seats (21-40)
        const executiveContainer = document.getElementById('executive-seats');
        for (let i = 21; i <= 40; i++) {
            executiveContainer.appendChild(createSeat(i, 'executive', seatPrices.executive));
        }
        
        // Normal Seats (41-60)
        const normalContainer = document.getElementById('normal-seats');
        for (let i = 41; i <= 60; i++) {
            normalContainer.appendChild(createSeat(i, 'normal', seatPrices.normal));
        }

        // Time Selection
        timeSlots.forEach(slot => {
            slot.onclick = () => {
                timeSlots.forEach(s => s.classList.remove('active'));
                slot.classList.add('active');
            };
        });

        // Confirm Button
        confirmBtn.onclick = () => {
            const selectedTime = document.querySelector('.time-slot.active').innerText;
            const movieTitle = "<?php echo $movie_title_display; ?>";
            if (selectedSeats.length > 0) {
                const seatNumbers = selectedSeats.map(s => s.number).join(',');
                const totalAmount = selectedSeats.reduce((sum, seat) => sum + seat.price, 0);
                window.location.href = `payment.php?movie=${encodeURIComponent(movieTitle)}&seats=${seatNumbers}&amount=${totalAmount}&time=${encodeURIComponent(selectedTime)}`;
            }
        };
    </script>
</body>
</html>