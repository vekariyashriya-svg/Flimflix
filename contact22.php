<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - FLIMFLIX</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Netflix Style Global */
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

        /* LEFT SIDE: DETAILS (PURE WHITE) */
        .contact-info-section {
            padding-right: 60px;
            color: #ffffff !important;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.8);
        }
        .contact-info-section h1 {
            font-size: 4rem;
            font-weight: 900;
            color: #e50914; /* Netflix Red */
            margin-bottom: 10px;
        }
        .contact-info-section h2 { font-size: 2.2rem; margin-bottom: 30px; font-weight: bold; color: #fff; }

        .info-card {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 12px;
            border-left: 6px solid #e50914;
            transition: 0.3s;
        }
        .info-card:hover { background: rgba(255, 255, 255, 0.15); transform: scale(1.02); }
        .info-icon { font-size: 2rem; color: #fff; margin-right: 25px; }
        .info-text h5 { margin-bottom: 2px; font-weight: bold; color: #fff; }
        .info-text p { margin-bottom: 0; color: #ffffff !important; font-size: 1rem; }

        /* RIGHT SIDE: CONTACT BOX */
        .contact-box {
            background-color: rgba(0, 0, 0, 0.8) !important;
            border-radius: 10px;
            padding: 45px;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .form-label { color: #ffffff !important; font-weight: 500; }
        .form-control {
            background: #333 !important;
            border: none;
            color: white !important;
            padding: 12px;
            border-radius: 5px;
        }
        .form-control:focus {
            box-shadow: none;
            background: #454545 !important;
            border-bottom: 3px solid #e50914;
        }

        .btn-danger {
            background-color: #e50914;
            border: none;
            height: 55px;
            font-weight: bold;
            font-size: 1.2rem;
            transition: 0.2s;
        }
        .btn-danger:hover { background-color: #b20710; }

        /* Validation Colors */
        .error { color: #ffc107 !important; font-size: 0.85rem; font-weight: bold; display: block; margin-top: 5px; }
        .is-invalid { border: 1px solid #ffc107 !important; }

        @media (max-width: 991px) {
            .contact-info-section { text-align: center; padding-right: 0; margin-bottom: 40px; }
            .contact-info-section h1 { font-size: 3rem; }
            .info-card { text-align: left; }
        }
    </style>
</head>

<body>

<div class="page-wrapper">

    <?php include 'hhh.php'; ?>

    <div class="container main-wrapper">
        <div class="row w-100 g-5 align-items-center">
            
            <div class="col-lg-7 contact-info-section">
                <h1>CONTACT US</h1>
                <h2>Questions? We're here to help.</h2>
                
                <div class="info-card">
                    <i class="fas fa-envelope info-icon"></i>
                    <div class="info-text">
                        <h5>Email Support</h5>
                        <p>support@flimflix.com</p>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-map-marker-alt info-icon"></i>
                    <div class="info-text">
                        <h5>Headquarters</h5>
                        <p>123 Cinema Drive, Hollywood, CA</p>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-clock info-icon"></i>
                    <div class="info-text">
                        <h5>Working Hours</h5>
                        <p>Available 24/7 for our members.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="contact-box">
                    <h3 class="mb-4 fw-bold">Send a Message</h3>
                    <form action="contact2.php" method="POST" id="contactForm">

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="FullName" class="form-control" placeholder="Your Name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">How can we help?</label>
                            <textarea name="Message" rows="4" class="form-control" placeholder="Describe your issue..."></textarea>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-danger btn-lg fw-bold">
                                Send Message
                            </button>
                        </div>
                    </form>
                    <p class="text-muted mt-4 small" style="font-size: 0.75rem;">
                        We usually respond within 24 hours. Your privacy is our priority.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>

<script>
$(document).ready(function() {
    $("#contactForm").validate({
        rules: {
            FullName: { required: true, minlength: 3 },
            email: { required: true, email: true },
            Message: { required: true, minlength: 10 }
        },
        messages: {
            FullName: {
                required: "Please enter your full name.",
                minlength: "Name kam se kam 3 characters ka ho."
            },
            email: {
                required: "Please enter email address.",
                email: "Valid email enter karein."
            },
            Message: {
                required: "Please enter your message.",
                minlength: "Message kam se kam 10 characters ka ho."
            }
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            error.addClass('error');
            element.closest('.mb-3').append(error);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>

</body>
</html>