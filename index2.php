<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Modal Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .feedback-list {
            max-height: 300px; /* Limit height of feedback list */
            overflow-y: auto; /* Enable scrolling if content exceeds height */
        }
        .emoji-select {
            cursor: pointer;
            font-size: 2rem;
            transition: transform 0.2s;
        }
        .emoji-select:hover {
            transform: scale(1.2);
        }
        .selected {
    color: gold; /* Change color to indicate selection */
    transform: scale(1.5); /* Scale up the selected emoji for emphasis */
}
.avatar {
        width: 30px; /* Set the width */
        height: 30px; /* Set the height */
        object-fit: cover; /* Cover ensures the image fills the circle without distorting */
        border-radius: 50%; /* Make it circular */
    }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Heading -->
    <h2 class="section-heading text-center mb-4">Give Us Your Feedback</h2>

    <!-- Feedback Display Section -->
    <div class="row d-flex justify-content-center mt-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                <div class="card-body p-7">
                     <!-- Button to trigger modal aligned to the right -->
         

                        <!-- Button Wrapper with Border -->
                        <div class="text-end mb-4 border-bottom pb-3">
                        <button type="button" class="btn btn-modern border" data-bs-toggle="modal" data-bs-target="#feedbackModal" style="border: 1px solid #ccc; border-radius: 5px;">
                            <i class="fas fa-comments me-2"></i>Add Your Feedback
                        </button>

                        </div>
                        <h5 class="card-title text-center mb-3">Recent Feedback</h5>
                        <div id="feedbackList" class="feedback-list mb-4">
                            <!-- Dynamically filled feedback items will go here -->
                        </div>

                        <!-- Average Ratings -->
                        <div class="total-ratings">
                            <h6>Average Rating:</h6>
                            <small class="text-muted" id="averageRatingText">No Ratings Yet</small>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal for feedback -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feedbackModalLabel">Feedback Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="feedbackForm" enctype="multipart/form-data">
                    <!-- Step 1: Emoji Rating -->
                    <div class="step" id="step1">
                        <h4>Rate Your Experience</h4>
                        <div class="d-flex justify-content-around my-4">
                            <span class="emoji-select" data-value="1">😠</span>
                            <span class="emoji-select" data-value="2">😞</span>
                            <span class="emoji-select" data-value="3">😐</span>
                            <span class="emoji-select" data-value="4">😊</span>
                            <span class="emoji-select" data-value="5">😍</span>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>

                    <!-- Step 2: Personal Information -->
                    <div class="step" id="step2" style="display:none;">
                        <h4>Provide Your Information</h4>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address (required)</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name (optional)</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address (optional)</label>
                            <input type="text" class="form-control" id="address">
                        </div>
                        <div class="mb-3">
                        <label class="form-label">Course</label><br>
                        <div>
                            <input type="radio" id="college1" name="college" value="Information Systems " required>
                            <label for="college1">Information Systems </label>
                        </div>
                        <div>
                            <input type="radio" id="college2" name="college" value="Information Technology">
                            <label for="college2">Information Technology</label>
                        </div>
                        <div>
                            <input type="radio" id="college3" name="college" value="Computer Science">
                            <label for="college3">Computer Science</label>
                        </div>
                        <div>
                            <input type="radio" id="college4" name="college" value="other">
                            <label for="college3">Other / From Other College</label>
                        </div>
                        <!-- Add more colleges as needed -->
                    </div>
                    <div class="mb-3">
        <label class="form-label">Year (required)</label><br>
        <div>
            <input type="radio" id="year1" name="year" value="1" required>
            <label for="year1">1st Year</label>
        </div>
        <div>
            <input type="radio" id="year2" name="year" value="2">
            <label for="year2">2nd Year</label>
        </div>
        <div>
            <input type="radio" id="year3" name="year" value="3">
            <label for="year3">3rd Year</label>
        </div>
        <div>
            <input type="radio" id="year4" name="year" value="4">
            <label for="year4">4th Year</label>
        </div>
    </div>

                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>

                    <!-- Step 3: Feedback and Image Upload -->
                    <div class="step" id="step3" style="display:none;">
                        <h4>Leave Your Feedback</h4>
                        <div class="mb-3">
                            <label for="feedback" class="form-label">Your feedback</label>
                            <textarea class="form-control" id="feedback" rows="3" placeholder="Tell us more about your experience"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload an Profile Image (optional)</label>
                            <input class="form-control" type="file" id="image">
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let selectedRating; // To hold the selected rating
    let feedbackCount = 0; // To track the number of feedback submissions

    // Handle emoji selection
    document.querySelectorAll('.emoji-select').forEach(item => {
    item.addEventListener('click', function() {
        // Remove selected class from all emojis
        document.querySelectorAll('.emoji-select').forEach(emoji => {
            emoji.classList.remove('selected');
        });
        // Add selected class to the clicked emoji
        this.classList.add('selected');
        selectedRating = this; // Store the selected rating
    });
});

function nextStep() {
    const currentStep = document.querySelector('.step:not([style*="display: none"])');

    // Check required fields in the current step
    if (currentStep.id === "step1") {
        // Check if a rating is selected
        if (!selectedRating) {
            alert("Please select a rating before proceeding.");
            return;
        }
    } else if (currentStep.id === "step2") {
        // Validate required fields in Step 2
        const emailInput = document.getElementById('email').value.trim();
        
        // Get selected college
        const collegeInput = document.querySelector('input[name="college"]:checked');
        const collegeValue = collegeInput ? collegeInput.value : '';

        // Get selected year
        const yearInput = document.querySelector('input[name="year"]:checked');
        const yearValue = yearInput ? yearInput.value : '';

        if (!emailInput || !collegeValue || !yearValue) {
            alert("Please fill in all required fields before proceeding.");
            return;
        }
    }

    // Proceed to the next step if all validations pass
    if (currentStep.nextElementSibling) {
        currentStep.style.display = 'none';
        currentStep.nextElementSibling.style.display = 'block';
    }
}


    // Function to go to the previous step
    function prevStep() {
        const currentStep = document.querySelector('.step:not([style*="display: none"])');
        if (currentStep.previousElementSibling) {
            currentStep.style.display = 'none';
            currentStep.previousElementSibling.style.display = 'block';
        }
    }

    let totalScore = 0; // To accumulate the total score
    let averageRatingText = document.getElementById('averageRatingText'); // Reference to average rating display
// Event listener for feedback submission
document.getElementById('feedbackForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    const feedbackInput = document.getElementById('feedback').value.trim();
    const emailInput = document.getElementById('email').value.trim();
    const nameInput = document.getElementById('name').value.trim();
    const addressInput = document.getElementById('address').value.trim();

    // Retrieve selected college
    const collegeInput = document.querySelector('input[name="college"]:checked');
    const collegeValue = collegeInput ? collegeInput.value : '';

    // Retrieve selected year
    const yearInput = document.querySelector('input[name="year"]:checked');
    const yearValue = yearInput ? yearInput.value : '';

    const imageInput = document.getElementById('image').files[0];

    if (feedbackInput && selectedRating && collegeValue && yearValue) {
        const formData = new FormData();
        formData.append('rating', selectedRating.getAttribute('data-value'));
        formData.append('feedback', feedbackInput);
        formData.append('email', emailInput);
        formData.append('name', nameInput);
        formData.append('address', addressInput);
        formData.append('college', collegeValue);
        formData.append('year', yearValue);
        if (imageInput) {
            formData.append('image', imageInput);
        }

        // Show loading alert
        Swal.fire({
            title: 'Submitting your feedback',
            text: 'Please wait...',
            allowOutsideClick: false,
            onOpen: () => {
                Swal.showLoading();
            }
        });

        // Send data to PHP script via fetch
        fetch('ajax/submit_feedback.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response:', response); // Log the response
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json(); // Parse response as JSON
        })
        .then(data => {
            // Close the loading alert
            Swal.close();

            if (data.success) {
                // Show Toast notification for success
                Toast.fire({
                    icon: 'success',
                    title: 'Feedback submitted successfully!'
                }).then(() => {
                    // Reload the page after showing the toast
                    location.reload();
                });
            } else {
                console.error('Submission failed:', data.message);
                // Show Toast notification for error
                Toast.fire({
                    icon: 'error',
                    title: data.message || 'An error occurred while submitting your feedback.'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Close the loading alert
            Swal.close();
            // Show Toast notification for unexpected error
            Toast.fire({
                icon: 'error',
                title: 'An unexpected error occurred. Please try again later.'
            });
        });

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('feedbackModal'));
        modal.hide();
    } else {
        alert('Please select a rating and provide feedback.');
    }
});

// Toast configuration
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

   // Load feedback when the page loads
function loadFeedback() {
    fetch('ajax/fetch_feedback.php') // Point to your PHP script
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const feedbackList = document.getElementById('feedbackList');
            feedbackList.innerHTML = ''; // Clear existing feedback
            let totalScore = 0; // Initialize total score
            let feedbackCount = data.length; // Get feedback count

            if (feedbackCount > 0) {
                data.forEach(feedback => {
                    const newFeedback = document.createElement('div');
                    newFeedback.className = 'card mb-4'; // Add card styling
                       // Use a default image if no image is uploaded
                       const imageUrl = feedback.image; // Set your default image path here
                    newFeedback.innerHTML = `
                     
                        <div class="card-body">
                            <img src="${imageUrl}" class="avatar" alt="Avatar" />
                            <h5 class="card-title">${feedback.name || 'Anonymous'} (${feedback.email})</h5>
                            <p class="card-text">Rating: ${getEmojiForRating(feedback.rating)}</p>
                            <p class="card-text" style="border: 1px solid #ccc; max-height: 150px; overflow-y: auto;">
                                FeedBack: ${feedback.feedback_text}
                            </p>
                            <p class="card-text"><small class="text-muted">
                                Course: ${feedback.college || 'N/A'} | ${getYearWithSuffix(feedback.year) || 'N/A'}
                            </small>
                        </div>`;
                    feedbackList.appendChild(newFeedback);

                    // Sum the ratings for average calculation
                    totalScore += parseInt(feedback.rating);
                });

                // Calculate average rating
                const averageRating = (totalScore / feedbackCount).toFixed(2);
                document.getElementById('averageRatingText').textContent = `${averageRating} ${getEmojiForRating(averageRating)}`;
            } else {
                feedbackList.innerText = 'No feedback available.';
            }
        })
        .catch(error => {
            console.error('Error during fetch:', error);
        });
}
function getYearWithSuffix(year) {
  if (!year) return ''; // Handle case where year is undefined or null

  const ordinalSuffix = (n) => {
    const suffixes = ["th", "st", "nd", "rd", "th"];
    return n % 100 >= 11 && n % 100 <= 13 ? suffixes[0] : suffixes[(n % 10) > 4 ? 0 : n % 10];
  };

  return `${year}${ordinalSuffix(year)} year`;
}
// Function to get emoji for a given rating
function getEmojiForRating(rating) {
    switch (parseInt(rating)) {
        case 1: return '😠';
        case 2: return '😞';
        case 3: return '😐';
        case 4: return '😊';
        case 5: return '😍';
        default: return '';
    }
}

// Load feedback when the page loads
window.onload = loadFeedback;

</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
