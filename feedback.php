<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FILMFLIX - Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #0d0d0d;
            background-image: radial-gradient(circle at 50% -20%, #3d0000 0%, #000000 80%);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .card {
            background: rgba(20, 20, 20, 0.95);
            border: 1px solid #333;
            border-radius: 15px;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(229, 9, 20, 0.2);
            backdrop-filter: blur(10px);
        }

        .card-header {
            font-size: 1.8rem;
            font-weight: 800;
            text-align: center;
            background: linear-gradient(to right, #ff4d4d, #e50914);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            padding: 20px 0 10px 0;
        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 10px;
        }
        
        .rating input { 
            display: none; 
        }
        
        .rating label {
            cursor: pointer;
            width: 40px;
            height: 40px;
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" fill="%23333" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 30px;
            transition: .3s;
        }
        
        .rating input:checked ~ label,
        .rating label:hover,
        .rating label:hover ~ label {
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" fill="%23e50914" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>');
        }

        .form-control {
            background: #1a1a1a !important;
            border: 1px solid #333;
            color: #fff !important;
            border-radius: 10px;
        }
        
        .form-control:focus {
            border-color: #e50914;
            box-shadow: 0 0 10px rgba(229, 9, 20, 0.5);
            background: #1a1a1a;
        }

        .btn-submit {
            background: #e50914;
            border: none;
            color: #fff;
            font-weight: bold;
            padding: 12px;
            border-radius: 10px;
            transition: 0.3s;
            width: 100%;
        }
        
        .btn-submit:hover {
            background: #ff0f1b;
            transform: scale(1.02);
        }

        /* Error messages */
        .error {
            color: #ff4d4d;
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }
        
        /* Alert messages */
        .alert-custom {
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 12px;
        }
        
        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
            color: #28a745;
        }
        
        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid #dc3545;
            color: #dc3545;
        }
        
        .rating-error {
            text-align: center;
        }
        
        /* Loading spinner */
        .loading {
            display: none;
            text-align: center;
            margin-top: 10px;
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
        
        /* Character counter */
        .char-counter {
            display: block;
            margin-top: 5px;
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        /* Valid/invalid styles */
        .is-valid {
            border-color: #28a745 !important;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }
    </style>
</head>
<body>

<?php 
// Include header if exists
if(file_exists('header.php')) {
    include 'header.php'; 
}
?>

<div class="main-container">
    <div class="card shadow">
        <div class="card-header">🎬 Give Feedback</div>
        <div class="card-body px-4 pb-4">
            
            <!-- Alert container for messages -->
            <div id="alertContainer" style="display: none;"></div>
            
            <form id="feedbackForm" method="POST">
                
                <div class="mb-4 text-center">
                    <label class="form-label d-block mb-3 fw-bold">How was your experience?</label>
                    <div class="rating" id="ratingGroup">
                        <input type="radio" name="star" value="5" id="star5"><label for="star5" title="Excellent"></label>
                        <input type="radio" name="star" value="4" id="star4"><label for="star4" title="Good"></label>
                        <input type="radio" name="star" value="3" id="star3"><label for="star3" title="Average"></label>
                        <input type="radio" name="star" value="2" id="star2"><label for="star2" title="Poor"></label>
                        <input type="radio" name="star" value="1" id="star1"><label for="star1" title="Terrible"></label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Subject</label>
                    <input type="text" name="subject" id="subject" class="form-control" placeholder="E.g. Streaming quality, New Movies">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Your Message</label>
                    <textarea name="message" id="message" class="form-control" rows="4" placeholder="Write your thoughts here..."></textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span id="btnText">Send Feedback</span>
                        <span id="btnSpinner" class="spinner-border spinner-border-sm" style="display: none;"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery & Validation -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    
    // Custom validation method for rating
    $.validator.addMethod("ratingRequired", function(value, element) {
        return $('input[name="star"]:checked').length > 0;
    }, "⭐ Please select a rating.");
    
    // Initialize validation
    $("#feedbackForm").validate({
        rules: {
            star: {
                ratingRequired: true
            },
            subject: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            message: {
                required: true,
                minlength: 10,
                maxlength: 500
            }
        },
        messages: {
            star: {
                ratingRequired: "Please select a rating."
            },
            subject: {
                required: "Please enter a subject.",
                minlength: "Subject must be at least 3 characters.",
                maxlength: "Subject cannot exceed 100 characters."
            },
            message: {
                required: "Please enter your message.",
                minlength: "Message must be at least 10 characters.",
                maxlength: "Message cannot exceed 500 characters."
            }
        },
        errorClass: "error",
        errorElement: "span",
        errorPlacement: function(error, element) {
            if (element.attr("name") == "star") {
                error.insertAfter("#ratingGroup");
                error.addClass("text-center rating-error");
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid").addClass("is-valid");
        },
        submitHandler: function(form) {
            // Disable submit button and show spinner
            $("#submitBtn").prop("disabled", true);
            $("#btnText").text("Sending...");
            $("#btnSpinner").show();
            
            // Collect form data
            var formData = {
                star: $('input[name="star"]:checked').val(),
                subject: $("#subject").val(),
                message: $("#message").val()
            };
            
            // Send AJAX request to your save_feedback.php
            $.ajax({
                url: "save_feedback.php",
                type: "POST",
                data: formData,
                success: function(response) {
                    console.log("Response:", response); // For debugging
                    
                    // Check if response is "success"
                    if(response.trim() === "success") {
                        // Show success message
                        showAlert("success", "✅ Thank you for your feedback! 🎉");
                        
                        // Reset form
                        $("#feedbackForm")[0].reset();
                        $("#feedbackForm").find(".is-valid").removeClass("is-valid");
                        $("#feedbackForm").find(".is-invalid").removeClass("is-invalid");
                        
                        // Reset star ratings visually
                        $('input[name="star"]').prop("checked", false);
                        
                        // Redirect after 2 seconds
                        setTimeout(function() {
                            window.location.href = "c.php";
                        }, 2000);
                    } else {
                        // Show error message from server
                        showAlert("error", "❌ Error: " + response);
                        $("#submitBtn").prop("disabled", false);
                        $("#btnText").text("Send Feedback");
                        $("#btnSpinner").hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.log("Response Text:", xhr.responseText);
                    showAlert("error", "❌ Network error. Please check your connection and try again.");
                    $("#submitBtn").prop("disabled", false);
                    $("#btnText").text("Send Feedback");
                    $("#btnSpinner").hide();
                }
            });
            
            return false;
        }
    });
    
    // Function to show alerts
    function showAlert(type, message) {
        var alertClass = type === "success" ? "alert-success" : "alert-danger";
        var alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show alert-custom" role="alert">
                ${message}
                <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                <div style="clear: both;"></div>
            </div>
        `;
        
        $("#alertContainer").html(alertHtml).fadeIn();
        
        // Auto hide after 5 seconds
        setTimeout(function() {
            $("#alertContainer").fadeOut();
        }, 5000);
    }
    
    // Real-time character counter for message
    $("#message").on("keyup", function() {
        var length = $(this).val().length;
        var remaining = 500 - length;
        
        // Remove existing counter if any
        $(this).next(".char-counter").remove();
        
        if(remaining >= 0 && length > 0) {
            $(this).after(`<small class="char-counter">${remaining} characters remaining</small>`);
        }
        
        if(remaining < 50 && remaining >= 0) {
            $(this).next(".char-counter").css("color", "#ffaa00");
        }
        
        if(remaining < 0) {
            $(this).next(".char-counter").css("color", "#ff4d4d").text("Message too long!");
        }
    });
    
    // Add hover effect for rating labels
    $(".rating label").hover(
        function() {
            $(this).css("transform", "scale(1.1)");
        },
        function() {
            $(this).css("transform", "scale(1)");
        }
    );
    
    // Prevent multiple form submissions
    var isSubmitting = false;
    $("#feedbackForm").on("submit", function(e) {
        if(isSubmitting) {
            e.preventDefault();
            return false;
        }
        isSubmitting = true;
        setTimeout(function() {
            isSubmitting = false;
        }, 3000);
    });
    
    // Auto-focus on subject field
    $("#subject").focus();
    
});
</script>

</body>
</html>