<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FLIMFLIX - Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Global Styles */
        body { 
            background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), url('all 1.jpg') no-repeat center center fixed !important; 
            background-size: cover !important; 
            color: #fff;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        .main-wrapper {
            padding-top: 100px;
            padding-bottom: 50px;
        }

        /* Left Side Details */
        .reg-benefits {
            padding-right: 50px;
            color: #ffffff;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.8);
        }
        .reg-benefits h1 { font-size: 3.5rem; font-weight: 900; color: #e50914; margin-bottom: 10px; }
        .reg-benefits h2 { font-size: 1.8rem; margin-bottom: 30px; font-weight: bold; }
        
        .benefit-card {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 12px;
            border-left: 5px solid #e50914;
        }
        .benefit-icon { font-size: 1.5rem; color: #fff; margin-right: 15px; }
        .benefit-text p { margin-bottom: 0; font-weight: 500; font-size: 0.95rem; }

        /* Right Side: Registration Card */
        .reg-card {
            background-color: rgba(0, 0, 0, 0.8) !important;
            border-radius: 10px;
            padding: 40px;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .form-label { color: #ffffff !important; font-weight: 500; font-size: 0.9rem; }
        .form-control, .form-select {
            background: #333 !important;
            border: none;
            color: white !important;
            padding: 10px;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-bottom: 2px solid #e50914;
        }

        /* Profile Upload Styling */
        .profile-upload-vh { position: relative; width: 100px; height: 100px; margin: 0 auto 10px; }
        #preview { width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #e50914; background-color: #333; }
        .upload-btn-wrapper { position: absolute; bottom: 0; right: 0; background: #e50914; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid white; font-weight: bold; }

        .btn-danger {
            background-color: #e50914;
            border: none;
            height: 50px;
            font-weight: bold;
            font-size: 1.1rem;
            margin-top: 20px;
        }

        /* Validation Colors */
        .error { color: #ffc107 !important; font-size: 0.8rem; font-weight: bold; display: block; margin-top: 5px; }
        .is-invalid { border: 1px solid #ffc107 !important; }

        @media (max-width: 991px) {
            .reg-benefits { text-align: center; padding-right: 0; margin-bottom: 40px; }
            .reg-benefits h1 { font-size: 2.5rem; }
        }
    </style>
</head>
<body>
    <?php include 'hhh.php'; ?>

    <div class="container main-wrapper">
        <div class="row align-items-center">
            
            <div class="col-lg-6 reg-benefits d-none d-lg-block">
                <h1>JOIN FLIMFLIX</h1>
                <h2>Ready to watch? Enter your details to create your account.</h2>
                
                <div class="benefit-card">
                    <i class="fas fa-check-circle benefit-icon"></i>
                    <div class="benefit-text"><p>Watch everything you want. Ad-free.</p></div>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-check-circle benefit-icon"></i>
                    <div class="benefit-text"><p>Recommendations just for you.</p></div>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-check-circle benefit-icon"></i>
                    <div class="benefit-text"><p>Change or cancel your plan anytime.</p></div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="reg-card shadow-lg">
                    <h3 class="text-center mb-4 fw-bold">Create Account</h3>
                    
                    <form id="registrationForm" action="r2.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="text-center mb-4">
                            <div class="profile-upload-vh">
                                <img id="preview" src="https://via.placeholder.com/110?text=User" alt="Profile Preview">
                                <label for="profile_photo" class="upload-btn-wrapper"><span>+</span></label>
                                <input type="file" id="profile_photo" name="profile_photo" class="d-none" accept="image/*" onchange="previewImage(this)">
                            </div>
                            <label class="form-label d-block small">Profile Photo (Required)</label>
                            <div id="photo-error"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="FullName" class="form-control" placeholder="Min 10 characters">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="email@example.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact No</label>
                                <input type="text" name="number" class="form-control" placeholder="10 Digits">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Min 8 chars">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Birthdate</label>
                                <input type="date" name="Birthdate" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Favorite Movie Genres</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobbies[]" id="h1" value="Action">
                                <label class="form-check-label text-white" for="h1">Action</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobbies[]" id="h2" value="Horror">
                                <label class="form-check-label text-white" for="h2">Horror</label>
                            </div>
                            <div id="hobby-error"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select City</label>
                            <select name="City" class="form-select">
                                <option value="">-- Select City --</option>
                                <option value="Rajkot">Rajkot</option>
                                <option value="Bhavnagar">Bhavnagar</option>
                            </select>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" name="save_user" class="btn btn-danger btn-lg">Register Now</button>
                        </div>

                        <div class="text-center mt-3">
                            <span class="text-muted">Already have an account?</span> 
                            <a href="login.php" class="text-white fw-bold text-decoration-none"> Sign In.</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

    <script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) { $('#preview').attr('src', e.target.result); }
            reader.readAsDataURL(input.files[0]);
            $("#registrationForm").validate().element("#profile_photo");
        }
    }

    $(document).ready(function() {
        $("#registrationForm").validate({
            rules: {
                profile_photo: { required: true, extension: "jpg|jpeg|png" },
                FullName: { required: true, minlength: 10 },
                email: { required: true, email: true },
                number: { required: true, digits: true, minlength: 10, maxlength: 10 },
                password: { required: true, minlength: 8 },
                Birthdate: { required: true },
                "hobbies[]": { required: true },
                City: { required: true }
            },
            messages: {
                profile_photo: "Profile photo zaroori hai (JPG/PNG).",
                FullName: "Full name (Min 10 chars) zaroori hai.",
                email: "Sahi email format enter karein.",
                number: "10-digit number enter karein.",
                password: "Min 8 characters ka password banayein.",
                Birthdate: "Birthdate chunein.",
                "hobbies[]": "Kam se kam ek genre chunein.",
                City: "City select karein."
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass('error');
                if (element.attr("name") == "hobbies[]") { error.appendTo("#hobby-error"); }
                else if (element.attr("name") == "profile_photo") { error.appendTo("#photo-error"); }
                else { error.insertAfter(element); }
            },
            highlight: function(element) { $(element).addClass('is-invalid'); },
            unhighlight: function(element) { $(element).removeClass('is-invalid'); }
        });
    });
    </script>
</body>
</html>