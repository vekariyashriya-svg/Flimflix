<?php
session_start();
include_once 'config.php';

// Login check
if (!isset($_SESSION['user_id'])) {
    setcookie("error", "Please login to complete payment!", time() + 5, "/");
    header("Location: login22.php");
    exit();
}

$u_id = $_SESSION['user_id'];

// ✅ Time conversion function
function convertTo24Hour($time12hr) {
    $dateTime = DateTime::createFromFormat('h:i A', trim($time12hr));
    if ($dateTime) {
        return $dateTime->format('H:i:s');
    }
    return '16:30:00';
}

// Agar AJAX se request aayi hai to booking update karo (Pending to Paid)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    
    $booking_id = mysqli_real_escape_string($con, $_POST['booking_id']);
    $seats = mysqli_real_escape_string($con, $_POST['seats']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $show_time = mysqli_real_escape_string($con, $_POST['time']);
    $method = mysqli_real_escape_string($con, $_POST['method']);
    $movie_title = mysqli_real_escape_string($con, $_POST['movie_title']);
    
    // Convert time for database
    $show_time_24hr = convertTo24Hour($show_time);
    
    // Update existing booking (Pending to Paid)
    $query = "UPDATE bookings SET 
              payment_method = '$method', 
              payment_status = 'Paid', 
              booking_status = 'Confirmed',
              show_time = '$show_time_24hr',
              seats_booked = '$seats',
              total_amount = '$amount'
              WHERE id = '$booking_id' AND user_id = '$u_id'";
    
    if (mysqli_query($con, $query)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($con);
    }
    exit();
}

// Get booking details from URL
$booking_id = $_GET['booking_id'] ?? 0;
$movie_title = $_GET['movie'] ?? 'Evil Dead Rise';
$seats = $_GET['seats'] ?? '';
$amount = $_GET['amount'] ?? 0;
$show_time = $_GET['time'] ?? '10:30 AM';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout - FILMFLIX</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
            background-color: #000000 !important;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 20px;
        }

        .payment-card {
            width: 100%;
            max-width: 450px;
            background: #0a0a0a;
            border: 1px solid #1a1a1a;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.9);
        }

        .movie-header { text-align: center; margin-bottom: 25px; border-bottom: 1px dashed #222; padding-bottom: 15px; }
        
        .method-selector { 
            background: #111; 
            border: 1px solid #222; 
            padding: 15px; 
            border-radius: 12px; 
            cursor: pointer; 
            display: flex; 
            align-items: center; 
            margin-bottom: 12px; 
            transition: 0.3s;
            color: #ffffff !important; 
        }

        .method-selector.active { 
            border-color: #e50914; 
            background: rgba(229, 9, 20, 0.08); 
        }

        .method-selector i:not(.check-icon) { color: #ffffff !important; }
        .method-selector i.check-icon { margin-left: auto; color: #e50914; display: none; }
        .method-selector.active i.check-icon { display: block; }

        .payment-form-section { display: none; margin-top: 20px; }
        .payment-form-section.show { display: block; }

        .form-control { 
            background: #161616 !important; 
            border: 1px solid #333 !important; 
            color: #ffffff !important; 
            padding: 12px; 
            border-radius: 8px; 
            margin-bottom: 5px; 
        }

        .form-control::placeholder { 
            color: rgba(255, 255, 255, 0.5) !important; 
        }

        .form-control:focus { 
            border-color: #e50914 !important; 
            box-shadow: none !important; 
        }

        .btn-pay { 
            background: #e50914; 
            color: white; 
            border: none; 
            width: 100%; 
            padding: 15px; 
            border-radius: 50px; 
            font-weight: 800; 
            margin-top: 20px; 
            transition: 0.3s;
            cursor: pointer;
        }

        .btn-pay:hover { background: #ff0f1b; transform: translateY(-2px); }
        
        .gpay-brand { background: white; border-radius: 5px; padding: 2px 8px; display: inline-block; }
    </style>
</head>
<body>

    <div class="main-content">
        <div class="payment-card">
            <div class="movie-header">
                <h4 class="fw-bold mb-1" style="color: white;"><?php echo htmlspecialchars($movie_title); ?></h4>
                <p class="small mb-1" style="color: #bbb;">
                    Time: <span style="color: white;"><?php echo htmlspecialchars($show_time); ?></span> | 
                    Seats: <span style="color: white;"><?php echo htmlspecialchars($seats); ?></span>
                </p>
                <p class="text-danger fw-bold m-0 fs-5">Payable: ₹<?php echo htmlspecialchars($amount); ?></p>
            </div>

            <div class="method-selector active" onclick="switchTab('upi')">
                <i class="fas fa-mobile-alt me-3"></i>
                <span class="fw-bold">Google Pay / UPI</span>
                <i class="fas fa-check-circle check-icon"></i>
            </div>

            <div class="method-selector" onclick="switchTab('card')">
                <i class="fas fa-credit-card me-3"></i>
                <span class="fw-bold">Credit / Debit Card</span>
                <i class="fas fa-check-circle check-icon"></i>
            </div>

            <hr class="border-secondary my-4">

            <form id="upiForm" class="payment-form-section show">
                <div class="mb-3 text-center">
                    <div class="gpay-brand mb-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/f2/Google_Pay_Logo.svg" width="50">
                    </div>
                    <input type="text" name="upiID" class="form-control" placeholder="Enter UPI ID (e.g. name@okaxis)">
                </div>
                <button type="submit" class="btn-pay">PAY VIA GPAY</button>
            </form>

            <form id="cardForm" class="payment-form-section">
                <div class="mb-3">
                    <input type="text" name="cardHolder" class="form-control" placeholder="Card Holder Name">
                </div>
                <div class="mb-3">
                    <input type="text" name="cardNum" id="cardNumInput" class="form-control" placeholder="Card Number" maxlength="19">
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <input type="text" name="expiry" class="form-control" placeholder="MM/YY" maxlength="5">
                    </div>
                    <div class="col-6">
                        <input type="password" name="cvv" class="form-control" placeholder="CVV" maxlength="3">
                    </div>
                </div>
                <button type="submit" class="btn-pay">SECURE PAYMENT</button>
            </form>

            <div class="text-center mt-4">
                <small class="text-secondary"><i class="fas fa-lock me-1"></i> SSL Encrypted Transaction</small>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>
        const bookingId = <?php echo $booking_id; ?>;
        const movieTitle = "<?php echo addslashes($movie_title); ?>";
        const seats = "<?php echo $seats; ?>";
        const amount = "<?php echo $amount; ?>";
        const showTime = "<?php echo $show_time; ?>";

        function switchTab(type) {
            $('.method-selector').removeClass('active');
            $('.payment-form-section').removeClass('show');
            
            if(type === 'upi') {
                $('.method-selector').first().addClass('active');
                $('#upiForm').addClass('show');
            } else {
                $('.method-selector').last().addClass('active');
                $('#cardForm').addClass('show');
            }
        }

        $('#cardNumInput').on('input', function () {
            let val = $(this).val().replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formatted = val.match(/.{1,4}/g)?.join(' ') || '';
            $(this).val(formatted);
        });

        $(document).ready(function() {
            $("#upiForm").validate({
                rules: { upiID: { required: true, minlength: 3 } },
                messages: { upiID: "Please enter a valid UPI ID" },
                submitHandler: function(form) { processFinalPayment("UPI"); }
            });

            $("#cardForm").validate({
                rules: {
                    cardHolder: "required",
                    cardNum: { required: true, minlength: 19 },
                    expiry: { required: true, minlength: 5 },
                    cvv: { required: true, digits: true, minlength: 3 }
                },
                submitHandler: function(form) { processFinalPayment("Card"); }
            });
        });

        function processFinalPayment(method) {
            const btn = $('.show .btn-pay');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> PROCESSING...');
            
            $.ajax({
                url: window.location.href,
                method: 'POST',
                data: {
                    booking_id: bookingId,
                    seats: seats,
                    amount: amount,
                    time: showTime,
                    method: method,
                    movie_title: movieTitle
                },
                success: function(response) {
                    console.log("Response:", response);
                    if(response.trim() === "Success") {
                        btn.css('background-color', '#28a745').html('<i class="fas fa-check-circle me-2"></i> BOOKED!');
                        setTimeout(() => { 
                            window.location.href = "feedback.php?status=success&movie=" + encodeURIComponent(movieTitle);
                        }, 1500);
                    } else {
                        alert("Payment Error: " + response);
                        btn.prop('disabled', false).html('PAY VIA ' + method);
                    }
                },
                error: function(xhr, status, error) {
                    alert("Connection Error: " + error + "\nPlease try again.");
                    btn.prop('disabled', false).html('PAY VIA ' + method);
                }
            });
        }
    </script>
</body>
</html>